<?php

if (!defined('BASEPATH'))
   exit('No direct script access allowed');

class Simcard extends MY_Controller{

   public function __construct() {
      parent::__construct();
      $this->load->model('m_simcard');
      $this->load->library('validation_simcard');
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
      'title'=>'- List Simcard',
      'result_view' => 'operator/simcard',
      'field' => config_item('field'),
      );
      $this->rendering_page($obj);
   }

   public function get(){
      $params = $this->input->get();
      $list = array();
      $data = $this->m_simcard->get('get', $params);
      if($data){
         foreach ($data as $value) {
            $list[] = array(
               'phone_number' => $value['phone_number'],
               'phone_number_type' => $this->phone_number_type($value['phone_number_type']),
               'provider' => $value['provider_name'],
               'expired_date' => $value['expired_date'] ? date('d M Y', strtotime($value['expired_date'])) : '',
               'active_period' => $value['active_period'] ? date('d M Y', strtotime($value['active_period'])) : '',
               'left_day' => $value['expired_date'] && $value['active_period'] ? $this->compare_left_days(date('Y-m-d'), $value['expired_date']) : '', 
               'saldo' => $value['saldo'] ? number_format($value['saldo'], 0, false, ".") : '',
               'rak' => $value['nama_rak'],
               'no_rak' => $value['no_rak'],
               'status' => $this->status($value['status']),
               'created_date' => date('d M Y', strtotime($value['created_date'])),
               'pic' => $value['pic'] ? $value['pic'] : '<span style="color:red;">None</span>',
               'registered' => $this->registered($value['phone_number'], $value['registered'], 'fa fa-envelope'),
               'registered_facebook' => $this->registered($value['phone_number'], $value['registered_facebook'], 'fa fa-facebook'),
               'registered_twitter' => $this->registered($value['phone_number'], $value['registered_twitter'], 'fa fa-twitter'),
               'registered_instagram' => $this->registered($value['phone_number'], $value['registered_instagram'], 'fa fa-instagram'),
               'created_date' => date('d M Y', strtotime($value['created_date'])),
               'pic_updated' => $value['pic_updated'],
               'info' => $value['info'],
               'updated_date' => $value['updated_date'] ? date('d M Y H:i:s', strtotime($value['updated_date'])) : 'None',
            );
         }
         $response['data'] = $list;
         $response['total'] = $this->m_simcard->get('count', $params);
      }else{
         $response['total'] = 0;
      }
      $this->json_result($response);
   }

   public function create(){
      $params = $this->input->post();
      $response['success'] = FALSE;
      $params['user_id'] = $this->_user->id;
      if($this->check_character($params['phone_number'])){
         if($this->validation_simcard->create($params)){ 
            $result = $this->m_simcard->create($params);
            if($result){
               $this->_logging('simcard', 'create', $params['phone_number'], $this->_user->id);
               $response['insert_id'] = $result['insert_id'];
               $response['success'] = TRUE;
               $response['msg'] = 'Data Update';
            }else{
               $response['msg'] = 'Function Failed';  
            }
         }else{
            $response['msg'] = validation_errors();
         }
      }else{
         $response['msg'] = 'Check your format phone number [phone number must be start with 0]';
      }
      $this->json_result($response);
   }

   public function delete(){
      $params = $this->input->get();
      $response['success'] = FALSE;

      $result = $this->m_simcard->delete($params);
      if($result){
         $this->_logging('simcard', 'delete', $params['id'], $this->_user->id);
         $response['success'] = TRUE;
         $response['msg'] = 'Data Updated';
      }else{
         $response['msg'] = 'Function Failed';
      }
      $this->json_result($response);
   }

   public function check_character($phone_number){
      $phone = substr($phone_number, 0, 1);
      if($phone == 0){
         return $phone_number;
      }
   }

   public function bulk_action(){
      $params = $this->input->post();

      $result = $this->m_simcard->bulk_action($params);
      if($result > 0){
         $response['success'] = TRUE;
         $response['msg'] = 'Data Updated';
      }else{
         $response['msg'] = 'Function Failed';
      }
      $response['success'] = TRUE;
      $this->json_result($response);
   }

   public function assign_rak(){
      $files = glob('./download/*'); 
      foreach($files as $file){
         if(is_file($file))
         unlink($file);
      }

      $params = $this->input->post();
      $this->load->library('mapping_report');
      $filename = uniqid();
      $response['success'] = FALSE;

      if(isset($params['data']) && isset($params['assign_rak'])){
         $result = $this->m_simcard->assign_rak($params);
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


   public function registered($phone_number, $status, $icon){
      switch ($status) {
         case '0':
            return '';
            break;
         case '1':
            if($icon == 'fa fa-facebook'){
               $this->db->select('display_name, url, status');
               $this->db->where('phone_number', $phone_number);
               $rs = $this->db->get('facebook')->row_array();
               if($rs){
                  $status = array(1);
                  if(in_array($rs['status'], $status)){
                     $color = 'color:#7c7ed4;';
                  }else{
                     $color = '';
                  }
                  return '<a href="'.$rs['url'].'" target="_blank"><i class="'.$icon.'" style="font-size:16px;'.$color.'" data-toggle="tooltip" data-original-title="'.$rs['display_name'].'"></i></a>';
               }else{
                  return '<i class="'.$icon.'" style="font-size:16px;"></i>';
               }
            }else if($icon == 'fa fa-twitter'){
               $this->db->select('screen_name, status');
               $this->db->where('phone_number', $phone_number);
               $rs = $this->db->get('twitter')->row_array();
               if($rs){
                  $status = array(3,10);
                  if(in_array($rs['status'], $status)){
                     $color = 'color:#7c7ed4;';
                  }else{
                     $color = '';
                  }
                  return '<a href="http://twitter.com/'.$rs['screen_name'].'" target="_blank"><i class="'.$icon.'" style="font-size:16px;'.$color.'" data-toggle="tooltip" data-original-title="'.$rs['screen_name'].'"></i></a>';
               }else{
                  return '<i class="'.$icon.'" style="font-size:16px;"></i>';
               }
            }else if($icon == 'fa fa-instagram'){
               $this->db->select('username,,status');
               $this->db->where('phone_number', $phone_number);
               $rs = $this->db->get('instagram')->row_array();
               if($rs){
                  $status = array(1);
                  if(in_array($rs['status'], $status)){
                     $color = 'color:#7c7ed4;';
                  }else{
                     $color = '';
                  }
                  return '<a href="http://instagram.com/'.$rs['username'].'" target="_blank"><i class="'.$icon.'" style="font-size:16px;'.$color.'" data-toggle="tooltip" data-original-title="'.$rs['username'].'"></i></a>';
               }else{
                  return '<i class="'.$icon.'" style="font-size:16px;"></i>';
               }
            }else if($icon == 'fa fa-envelope'){
               $this->db->select('email, status');
               $this->db->where('phone_number', $phone_number);
               $rs = $this->db->get('email')->row_array();
               if($rs){
                  $status = array(1);
                  if(in_array($rs['status'], $status)){
                     $color = 'color:#7c7ed4;';
                  }else{
                     $color = '';
                  }
                  return '<i class="'.$icon.'" style="font-size:16px;'.$color.'" data-toggle="tooltip" data-original-title="'.$rs['email'].'"></i>';   
               }else{
                  $color = '';
                  return '<i class="'.$icon.'" style="font-size:16px;'.$color.'" data-toggle="tooltip" data-original-title="None"></i>';
               }
            }else{
               '<i class="'.$icon.'" style="font-size:16px;"></i>';
            }
            break;
      }
   }

   public function phone_number_type($phone_number_type){
      switch ($phone_number_type) {
         case '1':
            return '<span class="text-info bold">- Fisik</span>';
            break;
         case '2':
            return '<span class="text-success bold">- Cloud</span>';
            break;
      }
   }

   public function status($status){
      switch ($status) {
         case '0':
            return '<span class="label label-info bold"><i class="fa fa-exclamation"></i> Need Top-up</span>';
            break;
         case '1':
            return '<span class="label label-success bold"><i class="fa fa-check"></i> Active</span>';
            break;
         case '2':
            return '<span class="label label-danger bold"><i class="fa fa-pencil"></i>  Change Number / Expired</span>';
            break;
         case '3':
            return '<span class="label label-default bold"><i class="fa fa-remove"></i> Removed</span>';
            break;
         default:
      }
   }

   public function change(){
      $params = $this->input->post();
      $response['success'] = FALSE;
      $params['user_id'] = $this->_user->id;

      if($this->check_character($params['phone_number'])){
         if($this->validation_simcard->change($params)){ 
            $result = $this->m_simcard->change($params);
            if($result){
               $this->_logging('simcard', 'change', $params['phone_number'], $this->_user->id);
               $response['success'] = TRUE;
               $response['msg'] = 'Data Update';
            }else{
               $response['msg'] = 'Function Failed';
            }
         }else{
            $response['msg'] = validation_errors();
         }
      }else{
         $response['msg'] = 'Check your format phone number [phone number must be start with 0]';
      }
      $this->json_result($response);
   }

   public function edit(){
      $params = $this->input->get();
      $response['response'] = $this->db->get_where('simcard', array('phone_number' => $params['phone_number']))->row_array();
      $this->json_result($response);
   }

   public function suggest_provider(){
      $params = $this->input->get();
      $response['provider_id'] = $this->m_simcard->suggest_provider($params['phone_number']);
      $this->json_result($response);
   }

   public function compare_left_days($sdate, $edate){
      $datetime1 = new DateTime($sdate);
      $datetime2 = new DateTime($edate);
      $interval = $datetime1->diff($datetime2);
      $data['opr'] = $interval->format('%R');
      $data['digit'] = $interval->format('%a');
      return $data;
   }

   public function simulation(){
      $this->load->library('reporting');
      $field = array(
         'phone_number' => 'Phone Number',
         'phone_number_type' => 'Type'
      );
      $this->reporting->get('simcard', $field);
   }

   public function download_format(){
      $data['rak'] = $this->db->get('rak');
      $data['provider'] = $this->db->get('provider');
      $data['users'] = $this->db->select('id,username')->get('users');
      $data['status'] = array(
         'Need Top Up',
         'Active',
         'Change Number',
         'Deactive'
      );
      return $this->load->view('migration_format/simcard', $data);
   }

   public function bulkFormat(){
      $data['rak'] = $this->db->get('rak');
      $data['status'] = array(
         '0' => 'Need Top-up',
         '1' => 'Active',
         '2' => 'Change Number',
         '3' => 'Removed',
      );
      return $this->load->view('bulk_format/simcard', $data);
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
            $read = $this->bulk_uploader->migrationSimcard($data['file_name'], $params);
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
            $read = $this->bulk_uploader->bulkSimcard($data['file_name'], $params);
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
                  $data[$i]['phone_number'] = isset($value['A']) ? $this->check_character($value['A']) : NULL;
                  $data[$i]['active_period'] = isset($value['B']) ? date('Y-m-d', strtotime($value['B'])) : NULL;
                  $data[$i]['expired_date'] = isset($value['B']) ? date('Y-m-d', strtotime($value['B']. ' + 25 days')) : NULL;
                  $data[$i]['nik'] = isset($value['C']) ? $value['C'] : NULL;
                  $data[$i]['nkk'] = isset($value['D']) ? $value['D'] : NULL;
                  $data[$i]['saldo'] = isset($value['E']) ? $value['E'] : NULL;
                  $data[$i]['provider_id'] = isset($value['F']) ? $value['F'] : NULL;
                  $data[$i]['rak_id'] = isset($value['G']) ? $value['G'] : NULL;
                  $data[$i]['user_id'] = isset($value['H']) && $value !== '' ? $value['H'] : NULL;
                  $data[$i]['info'] = isset($value['I']) && $value !== '' ? $value['I'] : NULL;
               }
            }
            $row++;
            $i++;
         }
         
         if($data){
            foreach ($data as $v) {
               if($v['phone_number']){
                  $compare_left_days = $this->compare_left_days(date('Y-m-d'), $v['expired_date']);
                  if($compare_left_days['opr'] == '+' && $compare_left_days['digit'] <= 7){
                     $status = 0;
                  }
                  if($compare_left_days['opr'] == '+' && $compare_left_days['digit'] > 7){
                     $status = 1;
                  }
                  if($compare_left_days['opr'] == '-'){
                     $status = 2;
                  }
                  $tmp = array(
                     'phone_number_type' => 1,
                     'phone_number' => $v['phone_number'],
                     'active_period' => $v['active_period'] ? $v['active_period'] : NULL,
                     'expired_date' => $v['expired_date'] ? $v['expired_date'] : NULL,
                     'nik' => $v['nik'] ? $v['nik'] : NULL,
                     'nkk' => $v['nkk'] ? $v['nkk'] : NULL,
                     'saldo' => $v['saldo'] ? $v['saldo'] : NULL,
                     'provider_id' => $v['provider_id'],
                     'rak_id' => $v['rak_id'],
                     'user_id' => $v['user_id'] !== 0 ? $v['user_id'] : NULL,
                     'status' => $status,
                     'info' => $v['info']
                  );
                  if($this->db->where('phone_number', $v['phone_number'])->get('simcard')->num_rows() > 0){
                     $update = $this->db->update('simcard', $tmp, array('phone_number' => $v['phone_number']));
                     if($update){
                        $update ? $count_update++ : false;
                     }
                  }else{
                     $insert = $this->db->insert('simcard', $tmp);
                     if($insert){
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

   public function phonenumber_format(){
      $this->load->helper('download');
      $data = file_get_contents('./migration/PhoneNumberList.xlsx');
      force_download('PhoneNumberList.xlsx', $data);
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
               $data[$i]['phone_number']=isset($value['A']) ? $this->check_character($value['A']) : NULL;

               }
               $row++;
               $i++;
            }

            
         if($data){
            foreach ($data as $v) {
               if($v['phone_number']){

                  if(isset($params['tags_assign_rak']) && isset($params['tags_assign_status']) && isset($params['tags_assign_provider']) && isset($params['tags_active_period'])){
                     $tmp[] = array( 
                        'rak_id'=>$params['assign_rak'] != '' ? $params['assign_rak'] : NULL,
                        'status' => $params['assign_status'] != '' ? $params['assign_status'] : NULL,
                        'provider_id' => $params['assign_provider'] != '' ? $params['assign_provider'] : NULL,
                        'active_period' => $params['assign_active_period'] != '' ? $params['assign_active_period'] : NULL,
                        'expired_date' => $params['assign_active_period'] != '' ? date('Y-m-d', strtotime($params['assign_active_period']. ' + 25 days')) : NULL,
                     );
                     if($params['assign_active_period'] != ''){
                        $compare_left_days = $this->compare_left_days(date('Y-m-d'), date('Y-m-d', strtotime($params['assign_active_period']. ' + 25 days')));
                        if($compare_left_days['opr'] == '+' && $compare_left_days['digit'] <= 7){
                           $tmp['status'] = 0;
                        }
                        else if($compare_left_days['opr'] == '+' && $compare_left_days['digit'] > 7){
                           $tmp['status'] = 1;
                        }
                        else if($compare_left_days['opr'] == '-'){
                           $tmp['status'] = 2;
                        }
                     }
                     // $data=$tmp;
                  }
                  
                  $insert = $this->db->insert_batch('simcard',$data);
                  $insert ? $count++: FALSE;
                  // $where = array(
                  //    'phone_number' => $v['phone_number']
                  // );
                  // $insert = $this->db->update('simcard',$tmp, $where);
                  // $insert ? $count++ : FALSE;
               }
            }
             return TRUE;
            
         }
   
          //return TRUE;

      }  
      else{
         return FALSE;
      }

   }



}  

?>