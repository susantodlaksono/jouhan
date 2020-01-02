<?php

if (!defined('BASEPATH'))
   exit('No direct script access allowed');

class master_client extends MY_Controller{

   public function __construct() {
      parent::__construct();
      $this->load->model('m_client');
      $this->load->library('validation_client');
      if (!$this->ion_auth->logged_in() && php_sapi_name() != 'cli') {
         redirect('security?_redirect=' . urlencode(uri_string()));
      }
   }

   public function index() {
      $obj = array(
         '_css' => array(
            'assets/plugins/simplepagination/simplePagination.css'
         ),
         '_js' => array(
          'assets/plugins/simplepagination/jquery.simplePagination.js"',
         ),
      'title'=>'- Master Client',
      'result_view' => 'master/client',
      );
      $this->rendering_page($obj);
   }

   public function format(){
      $this->load->helper('download');
      $data = file_get_contents('./migration/MigrationClient.xlsx');
      force_download('MigrationClient.xlsx', $data);
   }

   public function get(){
      $params = $this->input->get();
      $list = array();
      $data = $this->m_client->get('get', $params);
      if($data){
         foreach ($data as $value) {
            $list[] = array(
               'id' => $value['id'],
               'name' => $value['name'],
               'description' => $value['description'],
            );
         }
         $response['data'] = $list;
         $response['total'] = $this->m_client->get('count', $params);
      }else{
         $response['total'] = 0;
      }
      $this->json_result($response);
   }

   public function create(){
      $params = $this->input->post();
      $response['success'] = FALSE;
      $params['user_id'] = $this->_user->id;
      if($this->validation_client->create($params)){ 
         $result = $this->m_client->create($params);
         if($result){
            $this->_logging('client', 'create', $this->db->insert_id(), $this->_user->id);
            $response['success'] = TRUE;
            $response['msg'] = 'Data Update';
         }else{
            $response['msg'] = 'Function Failed';
         }
      }else{
         $response['msg'] = validation_errors();
      }
      $this->json_result($response);
   }

   public function change(){
      $params = $this->input->post();
      $response['success'] = FALSE;
      $params['user_id'] = $this->_user->id;

      if($this->validation_client->change($params)){ 
         $result = $this->m_client->change($params);
         if($result){
            $this->_logging('client', 'change', $params['id'], $this->_user->id);
            $response['success'] = TRUE;
            $response['msg'] = 'Data Update';
         }else{
            $response['msg'] = 'Function Failed';
         }
      }else{
         $response['msg'] = validation_errors();
      }
      $this->json_result($response);
   }

   public function delete(){
      $params = $this->input->get();
      $response['success'] = FALSE;

      $result = $this->m_client->delete($params);
      if($result){
         $this->_logging('client', 'delete', $params['id'], $this->_user->id);
         $response['success'] = TRUE;
         $response['msg'] = 'Data Updated';
      }else{
         $response['msg'] = 'Function Failed';
      }
      $this->json_result($response);
   }

   public function remove(){
      $kode = $this->input->get('delete');
      $hasil=$this->m_client->remove($kode);
      if($hasil){
        $response['success'] = TRUE;
        $response['msg'] = 'Data Update';
      }else{
        $response['msg'] = 'Function Failed';
      }
      $this->json_result($response);
   }

   public function edit(){
      $params = $this->input->get();
      $response['response'] = $this->db->get_where('client', array('id' => $params['id']))->row_array();
      $this->json_result($response);
   }

   public function migration_all(){
      $params = $this->input->post();
      $response['success'] = FALSE;
      $filename = $this->_user->username.'-'.uniqid(date("hisu"));

      if($_FILES) {
         $config['upload_path'] = './upload/';
         $config['allowed_types'] = 'xls|xlsx';
         $config['max_size'] = 0;
         $config['file_name'] = $filename;

         $this->load->library('upload', $config);
         if ($this->upload->do_upload('userfile')) {
            $data = $this->upload->data();
            $read = $this->migration($data['file_name']);
            if($read['status']){
               $response['success'] = TRUE;
               $response['msg'] = $read['message'];
            }else{
               $response['msg'] = $read['message'];
            }
         }else{
            $response['msg'] = $this->upload->display_errors();
         }
      }else{
         $response['msg'] = 'File Format Required';
      }

      $this->json_result($response);
   }

   public function migration($filename){
      ini_set('memory_limit', '1G');
      $this->load->library('PHPExcel');
      $this->load->library('excel_reader');
      $excel_reader = $this->excel_reader->read(NULL, './upload/', ''.$filename);

      if ($excel_reader['status']) {
         $objPHPExcel = $excel_reader['result'];
         $count_insert = 0;
         $i = 0;
         $row = 1;
         $data = array();
         $objPHPExcel->setActiveSheetIndex(0);   
         $worksheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
         foreach ($worksheet as $value) { 
            if ($row != 1) {
               $data[$i]['name'] = isset($value['A']) ? $value['A'] : NULL;
               $data[$i]['description'] = isset($value['B']) ? $value['B'] : NULL;
            }
            $row++;
            $i++;
         }
         
         if($data){
            foreach ($data as $v) {
               $tmp = array(
                  'name' => $v['name'] ? $v['name'] : NULL,
                  'description' => $v['description'] ? $v['description'] : NULL
               );
               $insert = $this->db->insert('client', $tmp);
               if($insert){
                  $insert ? $count_insert++ : false;
               }
            }
         }
         $result = array(
            'status' => TRUE,
            'message' => $count_insert.' Data Inserted'
         );
      }else{
         $result = array(
            'status' => FALSE,
            'message' => $excel_reader
         );
      }
      return $result;
   }

}

?>