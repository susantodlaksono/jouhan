<?php

if (!defined('BASEPATH'))
   exit('No direct script access allowed');

class Master_rak extends MY_Controller{

   public function __construct() {
      parent::__construct();
      $this->load->model('m_rak');
      $this->load->library('validation_rak');
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
      'title'=>'- Master Rak',
      'result_view' => 'master/rak',
      );
      $this->rendering_page($obj);
   }

   public function get(){
      $params = $this->input->get();
      $list = array();
      $data = $this->m_rak->get('get', $params);
      if($data){
         foreach ($data as $value) {
            $list[] = array(
               'id' => $value['id'],
               'no' => $value['no'],
               'nama_rak' => $value['nama_rak'],
            );
         }
         $response['data'] = $list;
         $response['total'] = $this->m_rak->get('count', $params);
      }else{
         $response['total'] = 0;
      }
      $this->json_result($response);
   }

   public function create(){
      $params = $this->input->post();
      $response['success'] = FALSE;
      $params['user_id'] = $this->_user->id;
      if($this->validation_rak->create($params)){ 
         $result = $this->m_rak->create($params);
         if($result){
            $this->_logging('rak', 'create', $this->db->insert_id(), $this->_user->id);
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

      if($this->validation_rak->change($params)){ 
         $result = $this->m_rak->change($params);
         if($result){
            $this->_logging('proxy', 'change', $params['id'], $this->_user->id);
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

      $result = $this->m_rak->delete($params);
      if($result){
         $this->_logging('rak', 'delete', $params['id'], $this->_user->id);
         $response['success'] = TRUE;
         $response['msg'] = 'Data Updated';
      }else{
         $response['msg'] = 'Function Failed';
      }
      $this->json_result($response);
   }

   public function proxy(){
      $id = $this->input->get('id');
      $this->db->select('a.*,b.id as id_user');
      $this->db->join('users as b','a.user_id=b.id','left');
      $this->db->where('a.id', $id);
      $data['detail_email'] = $this->db->get('email as a')->row_array();
     
      echo json_encode($data);
   }

   public function update(){
      $params = $this->input->post();
      $response['success'] = FALSE;

      if($this->validation_rak->change_proxy($params)){ 
          $hasil=$this->m_rak->update($params['id_edit'],$params['proxy'],$params['descript']);
          if($hasil){
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

   public function remove(){
      $kode = $this->input->get('delete');
      $hasil=$this->m_rak->remove($kode);
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
      $response['response'] = $this->db->get_where('rak', array('id' => $params['id']))->row_array();
      $this->json_result($response);
   }

   public function format(){
      $this->load->helper('download');
      $data = file_get_contents('./migration/MigrationRak.xlsx');
      force_download('MigrationRak.xlsx', $data);
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
               $data[$i]['no'] = isset($value['A']) ? $value['A'] : NULL;
               $data[$i]['nama_rak'] = isset($value['B']) ? $value['B'] : NULL;
            }
            $row++;
            $i++;
         }
         
         if($data){
            foreach ($data as $v) {
               $tmp = array(
                  'no' => $v['no'] ? $v['no'] : NULL,
                  'nama_rak' => $v['nama_rak'] ? $v['nama_rak'] : NULL
               );
               $insert = $this->db->insert('rak', $tmp);
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