<?php

if (!defined('BASEPATH'))
   exit('No direct script access allowed');

class Master_proxy extends MY_Controller{

   public function __construct() {
      parent::__construct();
      $this->load->model('m_proxy');
      $this->load->library('validation_proxy');
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
      'title'=>'- Master Proxy',
      'result_view' => 'master/proxy',
      );
      $this->rendering_page($obj);
   }

   public function get(){
      $params = $this->input->get();
      $list = array();
      $data = $this->m_proxy->get('get', $params);
      if($data){
         foreach ($data as $value) {
            $list[] = array(
               'id' => $value['id'],
               'network' => $this->network($value['network']),
               'ip_address' => $value['ip_address'],
               'port' => $value['port'],
               'username' => $value['username'],
               'password' => $value['password'],
               'location' => $value['location'],
               'total_twitter' => $value['total_twitter'] ? $value['total_twitter'] : 0,
               'total_facebook' => $value['total_facebook'] ? $value['total_facebook'] : 0,
               'total_instagram' => $value['total_instagram'] ? $value['total_instagram'] : 0,
               'status' => $this->status($value['status']),
               'created_date' => date('d M Y', strtotime($value['created_date'])),
               'pic' => $value['pic'] ? $value['pic'] : '<span style="color:red;">None</span>'
            );
         }
         $response['data'] = $list;
         $response['total'] = $this->m_proxy->get('count', $params);
      }else{
         $response['total'] = 0;
      }
      $this->json_result($response);
   }

   public function create(){
      $params = $this->input->post();
      $response['success'] = FALSE;
      $params['user_id'] = $this->_user->id;

      if($this->validation_proxy->create($params)){ 
         $result = $this->m_proxy->create($params);
         if($result){
            $this->_logging('proxy', 'create', $this->db->insert_id(), $this->_user->id);
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

      if($this->m_proxy->check_duplicate_proxy($params, 'change')){
         if($this->validation_proxy->change($params)){ 
            $result = $this->m_proxy->change($params);
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
      }else{
         $response['msg'] = 'ip address and proxy have been registered';
      }
      $this->json_result($response);
   }

   public function delete(){
      $params = $this->input->get();
      $response['success'] = FALSE;

      $result = $this->m_proxy->delete($params);
      if($result){
         $this->_logging('proxy', 'delete', $params['id'], $this->_user->id);
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

   public function bulk_action(){
      $params = $this->input->post();

      $result = $this->m_proxy->bulk_action($params);
      if($result > 0){
         $response['success'] = TRUE;
         $response['msg'] = 'Data Updated';
      }else{
         $response['msg'] = 'Function Failed';
      }
      $response['success'] = TRUE;
      $this->json_result($response);
   }


   public function status($status){
      switch ($status) {
         case '1':
            return '<span class="label label-success"><i class="fa fa-check"></i> Connected</span>';
            break;
         case '0':
            return '<span class="label label-danger"><i class="fa fa-remove"></i>  Not Connected</span>';
            break;
      }
   }

   public function network($status){
      switch ($status) {
         case '1':
            return 'VPS';
            break;
         case '2':
            return 'Proxy';
            break;
      }
   }

   public function update(){
      $params = $this->input->post();
      $response['success'] = FALSE;

      if($this->validation_proxy->change_proxy($params)){ 
          $hasil=$this->m_proxy->update($params['id_edit'],$params['proxy'],$params['descript']);
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
      $hasil=$this->m_proxy->remove($kode);
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
      $response['response'] = $this->db->get_where('proxy', array('id' => $params['id']))->row_array();
      $this->json_result($response);
   }

   public function download_format(){
      $this->load->helper('download');
      $data = file_get_contents('./migration/MigrationProxy.xlsx');
      force_download('MigrationProxy.xlsx', $data);
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
               $response['data'] = $read['data'];
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
         $count_update = 0;
         $count_insert = 0;
         $i = 0;
         $row = 1;
         $data = array();
         $objPHPExcel->setActiveSheetIndex(0);   
         $worksheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
         foreach ($worksheet as $value) { 
            if ($row != 1) {
               $data[$i]['network'] = isset($value['A']) && is_numeric($value['A']) ? $value['A'] : NULL;
               $data[$i]['ip_address'] = isset($value['B']) ? $value['B'] : NULL;
               $data[$i]['port'] = isset($value['C']) && is_numeric($value['C']) ? $value['C'] : NULL;
               $data[$i]['username'] = isset($value['D']) ? $value['D'] : NULL;
               $data[$i]['password'] = isset($value['E']) ? $value['E'] : NULL;
               $data[$i]['location'] = isset($value['F']) ? $value['F'] : NULL;
               $data[$i]['status'] = isset($value['G']) && is_numeric($value['G']) ? $value['G'] : NULL;
            }
            $row++;
            $i++;
         }
         
         if($data){
            foreach ($data as $v) {
               $tmp = array(
                  'network' => $v['network'],
                  'ip_address' => $v['ip_address'],
                  'port' => $v['port'],
                  'username' => $v['username'],
                  'password' => $v['password'],
                  'location' => $v['location'],
                  'status' => $v['status'],
                  'created_date' => date('Y-m-d H:i:s'),
                  'user_id' => $this->_user->id
               );
               $insert = $this->db->insert('proxy', $tmp);
               $insert ? $count_insert++ : false;
            }
         }
         $result = array(
            'status' => TRUE,
            'data' => count($data),
            'message' => $count_insert.' Data Inserted'
         );
      }else{
         $result = array(
            'status' => FALSE,
            'data' => count($data),
            'message' => $excel_reader
         );
      }
      return $result;
   }


}

?>