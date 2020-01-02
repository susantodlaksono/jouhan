<?php

if (!defined('BASEPATH'))
   exit('No direct script access allowed');

class Email extends MY_Controller {

	public function __construct() {
      parent::__construct();
      $this->load->model('m_email');
      $this->load->library('validation_email');
      $this->load->library('bulk_uploader');
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
      'title'=>'- List Email Account',
      'result_view' => 'operator/email',
      );
      $this->rendering_page($obj);
   }

   public function get(){
      $params = $this->input->get();
      $list = array();
      $data = $this->m_email->get('get', $params);
      if($data){
         foreach ($data as $value) {
            $list[] = array(
               'id' => $value['id'],
               'status_phone_number' => $value['status_phone_number'],
               'phone_number' => $value['phone_number'],
               'email' => $value['email'],
               'display_name' => $value['display_name'],
               'password' => $value['password'],
               'info' => $value['info'],
               'birth_day' => $value['birth_day'] ? date('d M Y', strtotime($value['birth_day'])) : '',
               'status' => $this->status($value['status']),
               'created_date' => date('d M Y', strtotime($value['created_date'])),
               'pic' => $value['pic'] ? $value['pic'] : '<span style="color:red;">None</span>',
               'pic_updated' => $value['pic_updated'],
               'updated_date' => $value['updated_date'] ? date('d M Y H:i:s', strtotime($value['updated_date'])) : 'None'
            );
         }
         $response['data'] = $list;
         $response['total'] = $this->m_email->get('count', $params);
      }else{
         $response['total'] = 0;
      }
      $this->json_result($response);
   }

   public function status($status){
      switch ($status) {
         case '2':
            return '<span class="label label-danger bold"><i class="fa fa-remove"></i> Blocked</span>';
            break;
         case '1':
            return '<span class="label label-success bold"><i class="fa fa-check"></i> Active</span>';
            break;
         case '0':
            return '<span class="label label-default bold"><i class="fa fa-minus"></i>  No Action</span>';
            break;
         default:
            return '<span class="label label-default bold"><i class="fa fa-minus"></i>  No Action</span>';
      }
   }

   public function create(){
      $params = $this->input->post();
      $response['success'] = FALSE;
      $params['user_id'] = $this->_user->id;
      $params['phone_number_type'] = $this->check_type_number($params['phone_number'], $params['email'], 'get');

      
      if($this->validation_email->create($params)){
      	if($this->check_type_number($params['phone_number'], $params['email'], 'check')){
	         $result = $this->m_email->create($params);
	         if($result){
	            $response['success'] = TRUE;
	            $response['msg'] = 'Data Update';
	         }else{
	            $response['msg'] = 'Function Failed';
	         }
         }else{
	      	$response['msg'] = 'Has been registered for this email';
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
      $params['phone_number_type'] = $this->check_type_number($params['phone_number'], $params['email'], 'get');
      $validation = $this->validation_change($params['phone_number_before'], $params['phone_number'], $params['email'], $params['email_before'], 'get');

      if($validation['success']){
         if($this->validation_email->change($params)){
            $result = $this->m_email->change($params);
            if($result){
               $this->_logging('email', 'change', $params['id'], $this->_user->id);
               $response['success'] = TRUE;
               $response['msg'] = 'Data Update';
            }else{
               $response['msg'] = 'Function Failed';
            }
         }else{
            $response['msg'] = validation_errors();
         }
      }else{
         $response['msg'] = $validation['msg'];
      }
      $this->json_result($response);
   }

   public function delete(){
      $params = $this->input->get();
      $response['success'] = FALSE;

      $result = $this->m_email->delete($params);
      if($result){
         $this->_logging('email', 'delete', $params['id'], $this->_user->id);
         $response['success'] = TRUE;
         $response['msg'] = 'Data Updated';
      }else{
         $response['msg'] = 'Function Failed';
      }
      $this->json_result($response);
   }

   public function validation_change($phone_number_before, $phone_number, $email, $email_before){
      $type_phone_number_new = $this->phone_number_type($phone_number);
      $type_phone_number_before = $this->phone_number_type($phone_number_before);

      if($email == $email_before){
         if($type_phone_number_new == $type_phone_number_before){
            $response['success'] = TRUE;
         }else{
            $this->db->where('email', $email);
            $this->db->where('phone_number_type', $type_phone_number_new);
            $count = $this->db->count_all_results('email');
            if($count > 0){
               $response['success'] = FALSE;
               $response['msg'] = 'Email has been registered';
            }else{
               $response['success'] = TRUE;
            }
         }
      }else{
         $this->db->where('email', $email);
         $this->db->where('phone_number_type', $type_phone_number_new);
         $count = $this->db->count_all_results('email');
         if($count > 0){
            $response['success'] = FALSE;
            $response['msg'] = 'Email has been registered';
         }else{
            $response['success'] = TRUE;
         }
      }
      return $response;
   }

   public function phone_number_type($phone_number){
      $this->db->select('phone_number_type');
      $this->db->where('phone_number', $phone_number);
      $rs = $this->db->get('simcard')->row_array();
      return $rs['phone_number_type'];
   }


   public function check_type_number($phone_number, $email, $mode){
   	$this->db->select('phone_number_type');
   	$this->db->where('phone_number', $phone_number);
   	if($mode == 'check'){
	   	$rs = $this->db->get('simcard')->row_array();
	   	if($rs['phone_number_type']){
	   		return $this->_check_email($rs['phone_number_type'], $email);
	   	}
   	}
   	if($mode == 'get'){
   		$rs = $this->db->get('simcard')->row_array();
   		return $rs['phone_number_type'];
   	}
   }

   public function _check_email($phone_number_type, $email){
   	$this->db->where('email', $email);
   	$this->db->where('phone_number_type', $phone_number_type);
   	$count = $this->db->count_all_results('email');
   	if($count > 0){
   		return false;
   	}else{
   		return true;
   	}
   }

   public function bulkFormat(){
      $data['status'] = array(
         '1' => 'Active',
         '0' => 'No Action',
         '2' => 'Blocked',
      );
      return $this->load->view('bulk_format/email', $data);
   }

   public function get_phone_number(){
      $params = $this->input->get();
      $response['response'] = $this->m_email->get_phone_number($params);
      $this->json_result($response);
   }

   public function find_phone(){
      $params = $this->input->get();
      $response['response'] = $this->m_email->find_phone($params);
      $this->json_result($response);
   }

   public function edit(){
      $params = $this->input->get();
      $response['response'] = $this->db->select('a.*, b.expired_date')
                                       ->join('simcard as b', 'a.phone_number = b.phone_number', 'left')
                                       ->where('a.id', $params['id'])
                                       ->get('email as a')->row_array();
      $this->json_result($response);
   }

   public function bulk_action(){
      $params = $this->input->post();
      $result = $this->m_email->bulk_action($params);
      if($result > 0){
         $response['success'] = TRUE;
         $response['msg'] = 'Data Updated';
      }else{
         $response['msg'] = 'Function Failed';
      }
      $response['success'] = TRUE;
      $this->json_result($response);
   }

   public function download_format(){
      $data['users'] = $this->db->select('id,username')->get('users');
      $data['status'] = array(
         'No Action',
         'Active',
         'Blocked',
      );
      return $this->load->view('migration_format/email', $data);
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
            $read = $this->bulk_uploader->migrationEmail($data['file_name'], $params);
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
                  if($this->db->where('phone_number', $phone_number)->count_all_results('simcard') > 0){
                     $data[$i]['phone_number'] = $phone_number;
                     $data[$i]['email'] = isset($value['B']) ? $value['B'] : NULL;
                     $data[$i]['password'] = isset($value['C']) ? $value['C'] : NULL;
                     $data[$i]['birth_day'] = isset($value['D']) ? date('Y-m-d', strtotime($value['D'])) : NULL;
                     $data[$i]['display_name'] = isset($value['E']) ? $value['E'] : NULL;
                     $data[$i]['user_id'] = isset($value['F']) || $value['F'] !== '' ? $value['F'] : NULL;
                     $data[$i]['status'] = isset($value['G']) ? $value['G'] : NULL;
                     $data[$i]['info'] = isset($value['H']) ? $value['H'] : NULL;
                  }
               }
            }
            $row++;
            $i++;
         }
         
         if($data){
            foreach ($data as $v) {
               if($v['phone_number']){
                  $tmp = array(
                     'phone_number_type' => 1,
                     'phone_number' => $v['phone_number'] ? $v['phone_number'] : NULL,
                     'email' => $v['email'],
                     'password' => $v['password'] ? $v['password'] : NULL,
                     'birth_day' => $v['birth_day'] ? $v['birth_day'] : NULL,
                     'status' => $v['status'] ? $v['status'] : NULL,
                     'display_name' => $v['display_name'] ? $v['display_name'] : NULL,
                     'user_id' => $v['user_id'],
                     'info' => $v['info']
                  );
                  if($this->db->where('phone_number', $v['phone_number'])->get('email')->num_rows() > 0){
                     $update = $this->db->update('email', $tmp, array('phone_number' => $v['phone_number']));
                     $update_registered = $this->db->update('simcard', array('registered' => 1), array('phone_number' => $v['phone_number']));
                     if($update || $update_registered){
                        $update ? $count_update++ : false;
                     }
                  }else{
                     $insert = $this->db->insert('email', $tmp);
                     $update_registered = $this->db->update('simcard', array('registered' => 1), array('phone_number' => $v['phone_number']));
                     if($insert || $update_registered){
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

   public function check_character($phone_number){
      $phone = substr($phone_number, 0, 1);
      if($phone == 0){
         return $phone_number;
      }else{
         return '0'.$phone_number;
      }
   }

   public function bulk_phone(){
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
            $read = $this->bulk_uploader->bulkEmail($data['file_name'], $params);
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

   public function read_bulk_phone_number($filename, $params){
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
               $phone_number = isset($value['A']) ? $this->check_character($value['A']) : NULL;
               if($phone_number){
                  $data[$i]['phone_number'] = $phone_number;
               }
            }
            $row++;
            $i++;
         }
         if($data){
            foreach ($data as $v) {
               if($v['phone_number']){
                  if(isset($params['tags_assign_status'])){
                     $tmp['status'] = $params['assign_status'] != '' ? $params['assign_status'] : NULL;
                  }
                  $where = array(
                     'phone_number' => $v['phone_number']
                  );
                  $insert = $this->db->update('email', $tmp, $where);
                  $insert ? $count++ : FALSE;
               }
            }
            return TRUE;
         }
      }else{
         return FALSE;
      }
   }

}