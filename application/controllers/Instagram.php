<?php

if (!defined('BASEPATH'))
   exit('No direct script access allowed');

class Instagram extends MY_Controller {

   public function __construct() {
      parent::__construct();
      $this->load->model('m_instagram');
      $this->load->library('validation_instagram');
      $this->load->library('bulk_uploader');
      if (!$this->ion_auth->logged_in() && php_sapi_name() != 'cli') {
         redirect('security?_redirect=' . urlencode(uri_string()));
      }
   }

  public function index() {
      $this->load->config('fields');
      $obj = array(
         '_css' => array(
            'assets/plugins/simplepagination/simplePagination.css'
         ),
         '_js' => array(
          'assets/plugins/simplepagination/jquery.simplePagination.js"',
         ),
      'field' => config_item('field'),
      'title'=>'- List Instagram Account',
      'result_view' => 'operator/instagram',
      );
      $this->rendering_page($obj);
   }

   public function get(){
      $params = $this->input->get();
      $list = array();
      $data = $this->m_instagram->get('get', $params);
      if($data){
         foreach ($data as $value) {
            $list[] = array(
               'id' => $value['id'],
               'status_phone_number' => $value['status_phone_number'],
               'phone_number' => $value['phone_number'],
               'display_name' => $value['display_name'],
               'username' => $value['username'],
               'password' => $value['password'],
               'client_name' => $value['client_name'],
               'ip_address' => $value['ip_address'],
               'port' => $value['port'],
               'info' => $value['info'],
               'status_ip_address' => $this->status_ip_address($value['status_ip_address']),
               'expired_date' => $value['expired_date'] ? date('d M Y', strtotime($value['expired_date'])) : '',
               'created_instagram' => $value['created_instagram'] ? date('d M Y', strtotime($value['created_instagram'])) : '',
               'status' => $this->status($value['status']),
               'created_date' => date('d M Y', strtotime($value['created_date'])),
               'pic' => $value['pic'] ? $value['pic'] : '<span style="color:red;">None</span>',
               'pic_updated' => $value['pic_updated'],
               'updated_date' => $value['updated_date'] ? date('d M Y H:i:s', strtotime($value['updated_date'])) : 'None'
            );
         }
         $response['data'] = $list;
         $response['total'] = $this->m_instagram->get('count', $params);
      }else{
         $response['total'] = 0;
      }
      $this->json_result($response);
   }

   public function create(){
      $params = $this->input->post();
      $response['success'] = FALSE;
      $params['user_id'] = $this->_user->id;
      
      if($this->validation_instagram->create($params)){
         $result = $this->m_instagram->create($params);
         if($result){
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

      if($this->validation_instagram->change($params)){
         $result = $this->m_instagram->change($params);
         if($result){
            $this->_logging('instagram', 'change', $params['id'], $this->_user->id);
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

   // public function edit(){
   //    $params = $this->input->get();
   //    $response['response'] = $this->db->get_where('instagram', array('id' => $params['id']))->row_array();
   //    $this->json_result($response);
   // }

   public function edit(){
      $params = $this->input->get();
      $response['response'] = $this->db->select('a.*, b.expired_date, c.email')
                                       ->join('simcard as b', 'a.phone_number = b.phone_number', 'left')
                                       ->join('email as c', 'a.phone_number = c.phone_number', 'left')
                                       ->where('a.id', $params['id'])
                                       ->get('instagram as a')->row_array();
      $this->json_result($response);
   }

   public function get_phone_number(){
      $params = $this->input->get();
      $response['response'] = $this->m_instagram->get_phone_number($params);
      $this->json_result($response);
   }

   public function bulk_action(){
      $params = $this->input->post();
      $result = $this->m_instagram->bulk_action($params);
      if($result > 0){
         $response['success'] = TRUE;
         $response['msg'] = 'Data Updated';
      }else{
         $response['msg'] = 'Function Failed';
      }
      $response['success'] = TRUE;
      $this->json_result($response);
   }

   public function delete(){
      $params = $this->input->post();
      $response['success'] = FALSE;
      if(isset($params['mode'])){
         $result = $this->m_instagram->delete($params);
         if($result){
            $this->_logging('instagram', 'delete', $params['id'], $this->_user->id);
            $response['success'] = TRUE;
            $response['msg'] = 'Data Updated';
         }else{
            $response['msg'] = 'Function Failed';
         }
      }else{
         $response['msg'] = 'No Mode Selected';
      }
      $this->json_result($response);
   }

   public function status($status){
      switch ($status) {
         case '2':
            return '<span class="label label-danger bold">Blocked</span>';
            break;
         case '1':
            return '<span class="label label-success bold">Active</span>';
            break;
         case '0':
            return '<span class="label label-default bold">No Action</span>';
            break;
         default:
            return '';
            break;
      }
   }

   public function status_ip_address($status_ip_address){
      switch ($status_ip_address) {
         case '0':
            return '<span class="text-danger bold"><i class="fa fa-remove"></i> Not Connected</span>';
            break;
         case '1':
            return '<span class="text-success bold"><i class="fa fa-check"></i> Connected</span>';
            break;
         default:
            return '';
            break;
      }
   }

   public function bulkFormat($mode){
      $data['mode'] = $mode;
      $data['client'] = $this->db->get('client');
      $data['proxy'] = $this->db->get('proxy');
      $data['status'] = array(
         '1' => 'Active',
         '2' => 'Blocked',
      );
      return $this->load->view('bulk_format/instagram', $data);
   }

   public function bulkInstagram(){
      $params = $this->input->post();
      $response['success'] = FALSE;
      $filename = $this->_user->username.'-'.uniqid(date("hisu"));
      $params['user_id'] = $this->_user->id;

      if($_FILES) {
         $config['upload_path'] = './upload/';
         $config['allowed_types'] = 'xls|xlsx';
         $config['max_size'] = 0;
         $config['file_name'] = $filename;

         $this->load->library('upload', $config);
         if($this->upload->do_upload('userfile')) {
            $data = $this->upload->data();
            $read = $this->bulk_uploader->bulkInstagram($data['file_name'], $params);
            if($read['success']){
               $response['success'] = $read['success'];
               $response['msg'] = $read['msg'];
            }else{
               $response['msg'] = $read['msg'];
            }
         }else{
            $response['msg'] = $this->upload->display_errors();
         }
      }else{
         $response['msg'] = 'File Format Dibutuhkan';
      }
      $this->json_result($response);
   }

   public function bulk_migration(){
      $params = $this->input->post();
      $response['success'] = FALSE;
      $filename = $this->_user->username.'-'.uniqid(date("hisu"));

      if($_FILES) {
         if(isset($params['tags_assign_client']) || isset($params['tags_assign_status'])){
            $config['upload_path'] = './upload/';
            $config['allowed_types'] = 'xls|xlsx';
            $config['max_size'] = 0;
            $config['file_name'] = $filename;

            $this->load->library('upload', $config);
            if ($this->upload->do_upload('userfile')) {
               $data = $this->upload->data();
               $read = $this->read_bulk($data['file_name'], $params);
               if($read){
                  $response['success'] = TRUE;
                  $response['msg'] = 'Data Updated'; 
               }else{
                  $response['msg'] = 'Failed Reading File';
               }
            }else{
               $response['msg'] = $this->upload->display_errors();
            }
         }else{
            $response['msg'] = 'No Action Choosed';
         }
         // }
      }else{
         $response['msg'] = 'File Format Required';
      }

      $this->json_result($response);
   }

   public function read_bulk($filename, $params){
      $this->load->library('PHPExcel');
      $this->load->library('excel_reader');
      $excel_reader = $this->excel_reader->read(NULL, './upload/', ''.$filename);
      if ($excel_reader['status']) {
         $objPHPExcel = $excel_reader['result'];
         $count = 0;
         $i = 0;
         $row = 1;
         $data = array();
         $objPHPExcel->setActiveSheetIndex(0);   
         $worksheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
         foreach ($worksheet as $value) {
            if ($row != 1) {
               $data[$i]['instagram_id'] = isset($value['A']) ? $value['A'] : NULL;
            }
            $row++;
            $i++;
         }
         if($data){
            foreach ($data as $v) {
               if($v['instagram_id']){
                  if(isset($params['tags_assign_client'])){
                     $tmp['client_id'] = $params['assign_client'] != '' ? $params['assign_client'] : NULL;
                  }
                  if(isset($params['tags_assign_status'])){
                     $tmp['status'] = $params['assign_status'] != '' ? $params['assign_status'] : NULL;
                  }
                  $where = array(
                     'username' => $v['instagram_id']
                  );
                  $insert = $this->db->update('instagram', $tmp, $where);
                  $insert ? $count++ : FALSE;
               }
            }
            return TRUE;
         }
      }else{
         return FALSE;
      }
   }

   public function download_format(){
      $data['client'] = $this->db->select('id,name')->get('client');
      $data['users'] = $this->db->select('id,username')->get('users');
      $data['proxy'] = $this->db->get('proxy');
      $data['status'] = array(
         '1' => 'Active',
         '2' => 'Blocked',
      );
      return $this->load->view('migration_format/instagram', $data);
   }


   public function migration_all(){
      $params = $this->input->post();
      $response['success'] = FALSE;
      $filename = $this->_user->username.'-'.uniqid(date("hisu"));
      $params['user_id'] = $this->_user->id;

      if($_FILES) {
         $config['upload_path'] = './upload/';
         $config['allowed_types'] = 'xls|xlsx';
         $config['max_size'] = 0;
         $config['file_name'] = $filename;

         $this->load->library('upload', $config);
         if($this->upload->do_upload('userfile')) {
            $data = $this->upload->data();
            $read = $this->bulk_uploader->migrationInstagram($data['file_name'], $params);
            if($read['success']){
               $response['success'] = $read['success'];
               $response['msg'] = $read['msg'];
            }else{
               $response['msg'] = $read['msg'];
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
               $phone_number = isset($value['A']) ? $this->check_character($value['A']) : NULL;
               if($phone_number){
                  $count = $this->db->where('phone_number', $phone_number)->where('registered', 1)->get('simcard')->num_rows();
                  if($count > 0){
                     $data[$i]['phone_number'] = $phone_number;
                     $data[$i]['display_name'] = isset($value['B']) ? $value['B'] : NULL;
                     $data[$i]['username'] = isset($value['C']) ? $value['C'] : NULL;
                     $data[$i]['created_instagram'] = isset($value['D']) ? date('Y-m-d', strtotime($value['D'])) : NULL;
                     $data[$i]['password'] = isset($value['E']) ? $value['E'] : NULL;
                     $data[$i]['cookies'] = isset($value['F']) ? $value['F'] : NULL;
                     $data[$i]['info'] = isset($value['H']) ? $value['H'] : NULL;
                     $data[$i]['followers'] = isset($value['G']) && is_numeric($value['G']) ? $value['G'] : NULL;
                     $data[$i]['client_id'] = isset($value['I']) && is_numeric($value['I']) ? $value['I'] : NULL;
                     $data[$i]['proxy_id'] = isset($value['J']) && is_numeric($value['J']) ? $value['J'] : NULL;
                     $data[$i]['user_id'] = isset($value['K']) && is_numeric($value['K']) ? $value['K'] : NULL;
                     $data[$i]['status'] = isset($value['L']) ? $value['L'] : NULL;
                  }
               }
            }
            $row++;
            $i++;
         }
         
         if($data){
            foreach ($data as $v) {
               $tmp = array(
                  'phone_number' => $v['phone_number'] ? $v['phone_number'] : NULL,
                  'display_name' => $v['display_name'] ? $v['display_name'] : NULL,
                  'username' => $v['username'] ? $v['username'] : NULL,
                  'birth_date' => $this->get_from_email($v['phone_number'], 'birth_day'),
                  'created_instagram' => $v['created_instagram'] ? $v['created_instagram'] : NULL,
                  'password' => $v['password'] ? $v['password'] : NULL,
                  'info' => $v['info'] ? $v['info'] : NULL,
                  'cookies' => $v['cookies'] ? $v['cookies'] : NULL,
                  'followers' => is_numeric($v['followers']) ? $v['followers'] : NULL,
                  'status' => is_numeric($v['status']) ? $v['status'] : NULL,
                  'user_id' => $v['user_id'] ? $this->check_migration_master('users', 'id', $v['user_id']) : NULL,
                  'client_id' => $v['client_id'] ? $this->check_migration_master('client', 'id', $v['client_id']) : NULL,
                  'proxy_id' => $v['proxy_id'] ? $this->check_migration_master('proxy', 'id', $v['proxy_id']) : NULL,
               );
               if($this->db->where('phone_number', $v['phone_number'])->get('instagram')->num_rows() > 0){
                  $update = $this->db->update('instagram', $tmp, array('phone_number' => $v['phone_number']));
                  if($update){
                     $this->db->update('simcard', array('registered_instagram' => 1), array('phone_number' => $v['phone_number']));
                     $update ? $count_update++ : false;
                  }
               }else{
                  $insert = $this->db->insert('instagram', $tmp);
                  if($insert){
                     $this->db->update('simcard', array('registered_instagram' => 1), array('phone_number' => $v['phone_number']));
                     $insert ? $count_insert++ : false;
                  }
               }
            }
         }
         $result = array(
            'status' => TRUE,
            'message' => $count_insert.' Data Inserted and '.$count_update.' Data Updated'
         );
      }else{
         $result = array(
            'status' => FALSE,
            'message' => $excel_reader
         );
      }
      return $result;
   }

   public function check_migration_master($table, $field, $value){
      $this->db->where($field, $value);
      $rs = $this->db->count_all_results($table);
      return $rs > 0 ? $value : NULL;
   }

   public function get_from_email($phone_number, $field){
      $this->db->select($field);
      $this->db->where('phone_number', $phone_number);
      $rs = $this->db->get('email')->row();
      return $rs ? $rs->$field : NULL;
   }

   public function check_character($phone_number){
      $phone = substr($phone_number, 0, 1);
      if($phone == 0){
         return $phone_number;
      }else{
         return '0'.$phone_number;
      }
   }

   public function find_phone(){
      $params = $this->input->get();
      $response['response'] = $this->m_instagram->find_phone($params);
      $this->json_result($response);
   }

   public function assign_client(){
      $files = glob('./download/*'); 
      foreach($files as $file){
         if(is_file($file))
         unlink($file);
      }

      $params = $this->input->post();
      $this->load->library('mapping_report');
      $filename = uniqid();
      $response['success'] = FALSE;

      if(isset($params['data']) && isset($params['assign_client'])){
         $result = $this->m_instagram->assign_client($params);
         if($result > 0){
            if(isset($params['with_download_mode']) && $params['with_download_mode'] == 1){
               $this->mapping_report->get($params['module'], NULL, NULL, $params['data'], $filename, 'save');
               $response['with_download_mode'] = $params['with_download_mode'];
            }else{
               $response['with_download_mode'] = NULL;
            }
            $response['success'] = TRUE;
            $response['filename'] = $filename;
            $response['msg'] = 'Data Updated';
         }else{
            $response['msg'] = 'Function Failed';
         }
         $response['params'] = $params;
      }else{
         $response['msg'] = 'No Data Selected';
      }
      $this->json_result($response);
   }


}