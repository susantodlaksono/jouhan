<?php

if (!defined('BASEPATH'))
   exit('No direct script access allowed');

class Twitter extends MY_Controller {

	public function __construct() {
      parent::__construct();
      $this->load->model('m_twitter');
      $this->load->library('bulk_uploader');
      $this->load->library('validation_twitter');
      $this->load->library('mapping_report');
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
      'title'=>'- List Twitter Account',
      'field' => config_item('field'),
      'result_view' => 'operator/twitter',
      );
      $this->rendering_page($obj);
   }

   public function get(){
      $params = $this->input->get();
      $list = array();
      $data = $this->m_twitter->get('get', $params);
      if($data){
         foreach ($data as $value) {
            $list[] = array(
               'id' => $value['id'],
               'status_phone_number' => $value['status_phone_number'],
               'phone_number' => $value['phone_number'],
               'screen_name' => $value['screen_name'],
               'password' => $value['password'],
               'apps_id' => $value['apps_id'],
               'apps_name' => $value['apps_name'],
               'client_name' => $value['client_name'],
               'ip_address' => $value['ip_address'],
               'port' => $value['port'],
               'info' => $value['info'],
               'status_ip_address' => $this->status_ip_address($value['status_ip_address']),
               'created_twitter' => $value['created_twitter'] ? date('d M Y', strtotime($value['created_twitter'])) : '',
               'expired_date' => $value['expired_date'] ? date('d M Y', strtotime($value['expired_date'])) : '',
               'status' => $this->status($value['status_name'], $value['parent']),
               'production_status' => $this->status_isr($value['production_status']),
               'created_date' => date('d M Y', strtotime($value['created_date'])),
               'pic' => $value['pic'] ? $value['pic'] : '<span style="color:red;">None</span>',
               'pic_updated' => $value['pic_updated'],
               'updated_date' => $value['updated_date'] ? date('d M Y H:i:s', strtotime($value['updated_date'])) : 'None'
            );
         }
         $response['data'] = $list;
         $response['total'] = $this->m_twitter->get('count', $params);
      }else{
         $response['total'] = 0;
      }
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
         $result = $this->m_twitter->assign_client($params);
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

   public function create(){
      $params = $this->input->post();
      $response['success'] = FALSE;
      $params['user_id'] = $this->_user->id;
      
      if($this->validation_twitter->create($params)){
         $result = $this->m_twitter->create($params);
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

      if($this->validation_twitter->change($params)){
         $result = $this->m_twitter->change($params);
         if($result){
            $this->_logging('twitter', 'change', $params['id'], $this->_user->id);
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
   //    $response['response'] = $this->db->get_where('twitter', array('id' => $params['id']))->row_array();
   //    $this->json_result($response);
   // }

   public function edit(){
      $params = $this->input->get();
      $response['response'] = $this->db->select('a.*, b.expired_date, c.email')
                                       ->join('simcard as b', 'a.phone_number = b.phone_number', 'left')
                                       ->join('email as c', 'a.phone_number = c.phone_number', 'left')
                                       ->where('a.id', $params['id'])
                                       ->get('twitter as a')->row_array();
      $this->json_result($response);
   }

   public function get_phone_number(){
      $params = $this->input->get();
      $response['response'] = $this->m_twitter->get_phone_number($params);
      $this->json_result($response);
   }

   public function bulk_action(){
      $params = $this->input->post();
      $result = $this->m_twitter->bulk_action($params);
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
         $result = $this->m_twitter->delete($params);
         if($result){
            $this->_logging('twitter', 'delete', $params['id'], $this->_user->id);
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
               $read = $this->read_bulk_client($data['file_name'], $params);
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
      }else{
         $response['msg'] = 'File Format Required';
      }

      $this->json_result($response);
   }

   public function bulkFormat($mode){
      $data['mode'] = $mode;
      $data['twitter_status_detail'] = $this->db->get('twitter_status_detail');
      $data['client'] = $this->db->get('client');
      $data['proxy'] = $this->db->get('proxy');
      return $this->load->view('bulk_format/twitter', $data);
   }

   public function bulkTwitter(){
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
            $read = $this->bulk_uploader->bulkTwitter($data['file_name'], $params);
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

   public function rawData(){
      $params = $this->input->post();
      $filename = $this->_user->username.'-'.uniqid(date("hisu"));

      if($_FILES) {
         $config['upload_path'] = './upload/';
         $config['allowed_types'] = 'xls|xlsx';
         $config['max_size'] = 0;
         $config['file_name'] = $filename;

         $this->load->library('upload', $config);
         if($this->upload->do_upload('userfile')) {
            $data = $this->upload->data();
            $read = $this->bulk_uploader->rawData($data['file_name']);
            if($read['success']){
               return $this->mapping_report->rawData($read['data'], 'twitter', 'Raw Data Twitter', 'download');
            }else{
               return $this->mapping_report->rawData(NULL, 'twitter', 'Raw Data Twitter', 'download');
            }
         }else{
            return $this->mapping_report->rawData(NULL, 'twitter', 'Raw Data Twitter', 'download');
         }
      }else{
         return $this->mapping_report->rawData(NULL, 'twitter', 'Raw Data Twitter', 'download');
      }
   }

   public function bulkByScreenName(){
      $params = $this->input->post();
      $response['success'] = FALSE;
      $filename = $this->_user->username.'-'.uniqid(date("hisu"));
      $params['user_id'] = $this->_user->id;

      if($_FILES) {
         if(isset($params['tags_assign_client']) || isset($params['tags_assign_status'])){
            $config['upload_path'] = './upload/';
            $config['allowed_types'] = 'xls|xlsx';
            $config['max_size'] = 0;
            $config['file_name'] = $filename;

            $this->load->library('upload', $config);
            if($this->upload->do_upload('userfile')) {
               $data = $this->upload->data();
               $read = $this->bulk_uploader->Bulk($data['file_name'], $params);
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
            $response['msg'] = 'Pilih salah satu aksi yang akan di lakukan';
         }
      }else{
         $response['msg'] = 'File Format Dibutuhkan';
      }
      $this->json_result($response);
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
            $read = $this->bulk_uploader->migrationTwitter($data['file_name'], $params);
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

   public function check_migration_master($table, $field, $value){
      $this->db->where($field, $value);
      $rs = $this->db->count_all_results($table);
      return $rs > 0 ? $value : NULL;
   }

   public function check_character($phone_number){
      $phone = substr($phone_number, 0, 1);
      if($phone == 0){
         return $phone_number;
      }else{
         return '0'.$phone_number;
      }
   }


   public function read_bulk_client($filename, $params){
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
               $data[$i]['screen_name'] = isset($value['A']) ? $value['A'] : NULL;
            }
            $row++;
            $i++;
         }
         if($data){
            foreach ($data as $v) {
               if($v['screen_name']){
                  if(isset($params['tags_assign_client']) && isset($params['tags_assign_status'])){
                     $tmp = array(
                        'client_id' => $params['assign_client'] != '' ? $params['assign_client'] : NULL,
                        'status' => $params['assign_status'] != '' ? $params['assign_status'] : NULL,
                     );
                  }
                  // else if(isset($params['tags_assign_client']) && !isset($params['tags_assign_status'])){
                  //    $tmp = array(
                  //       'client_id' => $params['assign_client'] != '' ? $params['assign_client'] : NULL,
                  //    );
                  // }else if(isset($params['tags_assign_status']) && !isset($params['tags_assign_client'])){
                  //    $tmp = array(
                  //       'status' => $params['assign_status'] != '' ? $params['assign_status'] : NULL,
                  //    );
                  // }
                  $where = array(
                     'screen_name' => preg_replace('/\s+/', ' ', $v['screen_name'])
                  );
                  $insert = $this->db->update('twitter', $tmp, $where);
                  $insert ? $count++ : FALSE;
               }
            }
            return TRUE;
         }
      }else{
         return FALSE;
      }
   }


   public function client_format(){
      $this->load->helper('download');
      $data = file_get_contents('./migration/ScreenNameList.xlsx');
      force_download('ScreenNameList.xlsx', $data);
   }

   public function download_format(){
   	$data['client'] = $this->db->select('id,name')->get('client');
   	$data['users'] = $this->db->select('id,username')->get('users');
      $data['proxy'] = $this->db->get('proxy');
   	$data['status'] = $this->db->get('twitter_status_detail');
      return $this->load->view('migration_format/twitter', $data);
   }

   public function status($name, $parent){
      switch ($parent) {
         case '3':
            return '<span class="label label-danger bold">SUSPENDED <br>'.($name ? $name : '').'</span>';
            break;
         case '2':
            return '<span class="label label-success bold">ACTIVE <br>'.($name ? $name : '').'</span>';
            break;
         case '1':
            return '<span class="label label-default bold">CHECK <br>'.($name ? $name : '').'</span>';
            break;
         case '4':
            return '<span class="label label-danger bold">LOCKED <br>'.($name ? $name : '').'</span>';
            break;
         default:
            return '';
            break;
      }
   }

   public function status_isr($name){
      switch ($name) {
         case '2':
            return '<span class="label label-danger bold">ERROR LOGIN</span>';
            break;
         case '3':
            return '<span class="label label-danger bold">SUSPEND</span>';
            break;
         case '4':
            return '<span class="label label-danger bold">BANNED</span>';
            break;
         case '5':
            return '<span class="label label-danger bold">ERROR APP</span>';
            break;
         case '11':
            return '<span class="label label-danger bold">ERROR PROXY</span>';
            break;
         case '11':
            return '<span class="label label-danger bold">GENERATE NEW TOKEN</span>';
            break;
         case '1':
            return '<span class="label label-success bold">ACTIVE</span>';
            break;
         default:
            return NULL;
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

   public function find_phone(){
      $params = $this->input->get();
      $response['response'] = $this->m_twitter->find_phone($params);
      $this->json_result($response);
   }

}