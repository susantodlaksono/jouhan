<?php

if (!defined('BASEPATH'))
   exit('No direct script access allowed');

class Facebook extends MY_Controller {

   public function __construct() {
      parent::__construct();
      $this->load->model('m_facebook');
      $this->load->library('validation_facebook');
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
         'title'=>'- List Facebook Account',
         'field' => config_item('field'),
         'result_view' => 'operator/facebook',
      );
      $this->rendering_page($obj);
   }

   public function fanspage(){
      $obj = array(
         '_css' => array(
            'assets/plugins/simplepagination/simplePagination.css'
         ),
         '_js' => array(
          'assets/plugins/simplepagination/jquery.simplePagination.js"',
         ),
         'title'=>'- Facebook Fanspage',
         'result_view' => 'operator/facebook_fanspage',
      );
      $this->rendering_page($obj);
   }

   public function get(){
      $params = $this->input->get();
      $list = array();
      $data = $this->m_facebook->get('get', $params);
      if($data){
         foreach ($data as $value) {
            $list[] = array(
               'id' => $value['id'],
               'status_phone_number' => $value['status_phone_number'],
               'phone_number' => $value['phone_number'],
               'display_name' => $value['display_name'],
               'url' => $value['url'],
               'facebook_id' => $value['facebook_id'],
               'password' => $value['password'],
               'client_name' => $value['client_name'],
               'ip_address' => $value['ip_address'],
               'port' => $value['port'],
               'info' => $value['info'],
               'status_ip_address' => $this->status_ip_address($value['status_ip_address']),
               'expired_date' => $value['expired_date'] ? date('d M Y', strtotime($value['expired_date'])) : '',
               'created_facebook' => $value['created_facebook'] ? date('d M Y', strtotime($value['created_facebook'])) : '',
               'status' => $this->status($value['status']),
               'created_date' => date('d M Y', strtotime($value['created_date'])),
               'pic' => $value['pic'] ? $value['pic'] : '<span style="color:red;">None</span>',
               'pic_updated' => $value['pic_updated'],
               'updated_date' => $value['updated_date'] ? date('d M Y H:i:s', strtotime($value['updated_date'])) : 'None'
            );
         }
         $response['data'] = $list;
         $response['total'] = $this->m_facebook->get('count', $params);
      }else{
         $response['total'] = 0;
      }
      $this->json_result($response);
   }

   public function get_fanspage(){
      $params = $this->input->get();
      $list = array();
      $data = $this->m_facebook->get_fanspage('get', $params);
      if($data){
         foreach ($data as $value) {
            $list[] = array(
               'id' => $value['id'],
               'name' => $value['name'],
               'url' => $value['url'],
               'admin' => $this->m_facebook->get_fanspage_admin($value['id']),
               // 'admin_url_id' => $value['admin_url_id'],
               // 'facebook_url' => $value['facebook_url'],
               'followers' => $value['followers'],
               'likes' => $value['likes'],
               'client_name' => $value['client_name'],
               'created_date' => date('d M Y', strtotime($value['created_fanspage'])),
               'pic' => $value['pic'] ? $value['pic'] : '<span style="color:red;">None</span>',
               'pic_updated' => $value['pic_updated'],
               'status' => $this->status_fanspage($value['status']),
               'updated_date' => $value['updated_date'] ? date('d M Y H:i:s', strtotime($value['updated_date'])) : 'None',
               'info' => $value['info']
            );
         }
         $response['data'] = $list;
         $response['total'] = $this->m_facebook->get_fanspage('count', $params);
      }else{
         $response['total'] = 0;
      }
      $this->json_result($response);
   }

   public function create(){
      $params = $this->input->post();
      $response['success'] = FALSE;
      $params['user_id'] = $this->_user->id;
      
      if($this->validation_facebook->create($params)){
         $result = $this->m_facebook->create($params);
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

   public function create_fanspage(){
      $params = $this->input->post();
      $response['success'] = FALSE;
      $params['user_id'] = $this->_user->id;
      
      if($this->validation_facebook->create_fanspage($params)){
         $result = $this->m_facebook->create_fanspage($params);
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

      if($this->validation_facebook->change($params)){
         $result = $this->m_facebook->change($params);
         if($result){
            $this->_logging('facebook', 'change', $params['id'], $this->_user->id);
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

   public function change_fanspage(){
      $params = $this->input->post();
      $response['success'] = FALSE;
      $params['user_id'] = $this->_user->id;

      if($this->validation_facebook->change_fanspage($params)){
         $result = $this->m_facebook->change_fanspage($params);
         if($result){
            $this->_logging('facebook', 'change', $params['id'], $this->_user->id);
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
   //    $response['response'] = $this->db->get_where('facebook', array('id' => $params['id']))->row_array();
   //    $this->json_result($response);
   // }

   public function edit(){
      $params = $this->input->get();
      $response['response'] = $this->db->select('a.*, b.expired_date, c.email')
                                       ->join('simcard as b', 'a.phone_number = b.phone_number', 'left')
                                       ->join('email as c', 'a.phone_number = c.phone_number', 'left')
                                       ->where('a.id', $params['id'])
                                       ->get('facebook as a')->row_array();
      $this->json_result($response);
   }

   public function edit_fanspage(){
      $params = $this->input->get();
      $response['response'] = $this->db->select('a.*')->where('a.id', $params['id'])->get('facebook_fanspage as a')->row_array();
      if($response['response']){
         $get_admin = $this->db->select('facebook_id')->where('fanspage_id', $params['id'])->get('facebook_fanspage_admin')->result_array();
         foreach($get_admin as $v){
            $admin[] = $v['facebook_id'];
         }
      }else{
         $admin = NULL;
      }
      $response['admin'] = $admin;
      $this->json_result($response);
   }

   public function get_phone_number(){
      $params = $this->input->get();
      $response['response'] = $this->m_facebook->get_phone_number($params);
      $this->json_result($response);
   }

   public function bulk_action(){
      $params = $this->input->post();
      $result = $this->m_facebook->bulk_action($params);
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
         $result = $this->m_facebook->delete($params);
         if($result){
            $this->_logging('facebook', 'delete', $params['id'], $this->_user->id);
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

   public function delete_fanspage(){
      $params = $this->input->get();
      $response['success'] = FALSE;
      $result = $this->m_facebook->delete_fanspage($params);
      if($result){
         $response['success'] = TRUE;
         $response['msg'] = 'Data Updated';
      }else{
         $response['msg'] = 'Function Failed';
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

   public function status_fanspage($status){
      switch ($status) {
         case '2':
            return '<span class="label label-danger bold">Un-Published</span>';
            break;
         case '1':
            return '<span class="label label-success bold">Published</span>';
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

   public function format(){
      $this->load->helper('download');
      $data = file_get_contents('./migration/FacebookIDList.xlsx');
      force_download('FacebookIDList.xlsx', $data);
   }

   public function format_fanspage(){
      $this->load->helper('download');
      $data = file_get_contents('./migration/URLFanspageList.xlsx');
      force_download('URLFanspageList.xlsx', $data);
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

   public function bulk_migration_fanspage(){
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
               $read = $this->read_bulk_fanspage($data['file_name'], $params);
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
               $data[$i]['facebook_id'] = isset($value['A']) ? $value['A'] : NULL;
            }
            $row++;
            $i++;
         }
         if($data){
            foreach ($data as $v) {
               if($v['facebook_id']){
                  if(isset($params['tags_assign_client'])){
                     $tmp['client_id'] = $params['assign_client'] != '' ? $params['assign_client'] : NULL;
                  }
                  if(isset($params['tags_assign_status'])){
                     $tmp['status'] = $params['assign_status'] != '' ? $params['assign_status'] : NULL;
                  }
                  $where = array(
                     'facebook_id' => $v['facebook_id']
                  );
                  $insert = $this->db->update('facebook', $tmp, $where);
                  $insert ? $count++ : FALSE;
               }
            }
            return TRUE;
         }
      }else{
         return FALSE;
      }
   }

   public function read_bulk_fanspage($filename, $params){
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
               $data[$i]['url'] = isset($value['A']) ? $value['A'] : NULL;
            }
            $row++;
            $i++;
         }
         if($data){
            foreach ($data as $v) {
               if($v['url']){
                  if(isset($params['tags_assign_client'])){
                     $tmp['client_id'] = $params['assign_client'] != '' ? $params['assign_client'] : NULL;
                  }
                  if(isset($params['tags_assign_status'])){
                     $tmp['status'] = $params['assign_status'] != '' ? $params['assign_status'] : NULL;
                  }
                  $where = array(
                     'url' => $v['url']
                  );
                  $insert = $this->db->update('facebook_fanspage', $tmp, $where);
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
      return $this->load->view('migration_format/facebook', $data);
   }

   public function format_migration_fanspage(){
      $data['client'] = $this->db->select('id,name')->get('client');
      $data['users'] = $this->db->select('id,username')->get('users');
      $data['facebook'] = $this->db->where('status', 1)->get('facebook');
      $data['status'] = array(
         '1' => 'Published',
         '2' => 'Un-Published',
      );
      return $this->load->view('migration_format/facebook_fanspage', $data);
   }

   public function bulkFormat(){
      $data['client'] = $this->db->get('client');
      $data['proxy'] = $this->db->get('proxy');
      $data['status'] = array(
         '1' => 'Active',
         '2' => 'Blocked',
      );
      return $this->load->view('bulk_format/facebook', $data);
   }

   public function bulkFacebook(){
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
            $read = $this->bulk_uploader->bulkFacebook($data['file_name'], $params);
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
            $read = $this->bulk_uploader->migrationFacebook($data['file_name'], $params);
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

   public function migration_all_fanspage(){
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
            $read = $this->migration_fanspage($data['file_name']);
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

   public function migration_fanspage($filename){
      ini_set('memory_limit', '1G');
      $this->load->library('PHPExcel');
      $this->load->library('excel_reader');
      $excel_reader = $this->excel_reader->read(NULL, './upload/', ''.$filename);

      if ($excel_reader['status']) {

         //Tampung tiap kolom excel
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
               if(isset($value['B']) && $value['B'] != ''){
                  $data[$i]['name'] = isset($value['A']) ? $value['A'] : NULL;
                  $data[$i]['url'] = isset($value['B']) ? $value['B'] : NULL;
                  $data[$i]['admin_url_id'] = isset($value['C']) ? $value['C'] : NULL;
                  $data[$i]['followers'] =  isset($value['D']) && is_numeric($value['D']) ? $value['D'] : NULL;
                  $data[$i]['likes'] = isset($value['E']) && is_numeric($value['E']) ? $value['E'] : NULL;
                  $data[$i]['client_id'] = isset($value['F']) && is_numeric($value['F']) ? $value['F'] : NULL;
                  $data[$i]['info'] = isset($value['I']) ? $value['I'] : NULL;
                  $data[$i]['status'] =  isset($value['G']) && is_numeric($value['G']) ? $value['G'] : NULL;
                  $data[$i]['user_id'] = isset($value['H']) && is_numeric($value['H']) ? $value['H'] : NULL;
                  $data[$i]['created_fanspage'] = isset($value['J']) ? date('Y-m-d', strtotime($value['J'])) : NULL;
               }
            }
            $row++;
            $i++;
         }
         
         if($data){
            // Looping data yang telah di tampung variabel
            foreach ($data as $v) {
               if($v['admin_url_id'] && $v['url']){
                  $exp = explode(',', $v['admin_url_id']);
                  $tmp = array(  
                     'name' => $v['name'],
                     'url' => $v['url'],
                     'created_fanspage' => $v['created_fanspage'] ? $v['created_fanspage'] : NULL,
                     'followers' => $v['followers'] ? $v['followers'] : NULL,
                     'likes' => $v['likes'] ? $v['likes'] : NULL,
                     'client_id' => $v['client_id'] ? $this->check_migration_master('client', 'id', $v['client_id']) : NULL,
                     'info' => $v['info'] ? $v['info'] : NULL,
                     'status' => is_numeric($v['status']) ? $v['status'] : NULL,
                     'user_id' => $v['user_id'] ? $this->check_migration_master('users', 'id', $v['user_id']) : NULL
                  );

                  $facebook_fanspage_by_url = $this->db->where('url', $v['url'])->get('facebook_fanspage')->num_rows();
                  //Update data jika di temukan url yang sama di database
                  if($facebook_fanspage_by_url > 0){
                     $update = $this->db->update('facebook_fanspage', $tmp, array('url' => $v['url']));
                     if($update){
                        // Ambil fanspage id
                        $facebook_fanspage_id = $this->db->select('id')->where('url', $v['url'])->get('facebook_fanspage')->row_array();
                        // Hapus dulu semua fanspage admin sebelum di insert kembali
                        $this->db->delete('facebook_fanspage_admin', array('fanspage_id' => $facebook_fanspage_id['id']));
                        
                        foreach ($exp as $v) {
                           //Cek jika facebook id untuk admin ditemukan/terdaftar
                           $facebook_by_id = $this->db->where('id', $v)->get('facebook')->num_rows();
                           if($facebook_by_id > 0){
                              $this->on_duplicate('facebook_fanspage_admin', array('fanspage_id' => $facebook_fanspage_id['id'], 'facebook_id' => $v));
                           }
                        }
                        $update ? $count_update++ : false;
                     }
                  //Insert data jika di temukan url yang sama di database
                  }else{
                     $insert = $this->db->insert('facebook_fanspage', $tmp);
                     $insert_id = $this->db->insert_id();
                     if($insert){
                        foreach ($exp as $v) {
                           //Cek jika facebook id untuk admin ditemukan/terdaftar
                           $facebook_by_id = $this->db->where('id', $v)->get('facebook')->num_rows();
                           if($facebook_by_id > 0){
                              $this->on_duplicate('facebook_fanspage_admin', array('fanspage_id' => $insert_id, 'facebook_id' => $v));
                           }
                        }
                        $insert ? $count_insert++ : false;
                     }
                  }
               }
            }
         }
         $result = array(
            'status' => TRUE,
            'data' => $data,
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
      $response['response'] = $this->m_facebook->find_phone($params);
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
         $result = $this->m_facebook->assign_client($params);
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

   public function get_facebook_list(){
      $params = $this->input->get();
      $response['response'] = $this->m_facebook->get_facebook_list($params);
      $this->json_result($response);
   }

}