<?php
if (!defined('BASEPATH'))
   exit('No direct script access allowed');

class Migration extends MY_Controller {
   public function __construct() {
      parent::__construct();
      $this->load->library('PHPExcel');
      $this->load->config('service');
      $this->load->library('curl');
      $this->load->library('excel_reader');
      if (!$this->ion_auth->logged_in() && php_sapi_name() != 'cli') {
         redirect('security?_redirect=' . urlencode(uri_string()));
      }
   }

   public function index() {
      $obj = array(
         'result_view' => 'superadmin/migration',
      );
      $this->rendering_page($obj);
   }

   public function test(){
      $count = 0;
      $rs = $this->db->select('phone_number, active_period')->where('date(created_date) between "2018-09-01" and "2018-09-21"')->order_by('created_date', 'desc')->get('simcard')->result_array();
      if($rs){
         foreach ($rs as $v) {
            if($v['active_period']){   
               $expired_date = date('Y-m-d', strtotime($v['active_period']. ' + 25 days'));
               // echo $v['phone_number'].' - '.$v['active_period'].' - '.$expired_date;
               // echo '<br>';
               $update = $this->db->update('simcard', array('expired_date' => $expired_date), array('phone_number' => $v['phone_number']));
               $update ? $count++ : FALSE;
            }
         }
         echo $count.' Data Updated';
      }
   }

   public function update_phone_email(){
      $excel_reader = $this->excel_reader->read(NULL, './migration/', 'phone_email.xlsx');
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
               $data[$i]['display_name'] = isset($value['A']) ? $value['A'] : NULL;
               $data[$i]['phone_number'] = isset($value['B']) ? '0'.$value['B'] : NULL;
            }
            $row++;
            $i++;
         }
         if($data){
            foreach ($data as $v) {
                $tmp = array(
                  'phone_number' => $v['phone_number'],
               );
               $insert = $this->db->update('email', $tmp, array('display_name' => $v['display_name']));
               $insert ? $count++ : FALSE;
            }
            echo $count.' Data Updated';
         }
      }else{
         echo json_encode($excel_reader);
      }
   }

   public function update_status_twitter(){
      $excel_reader = $this->excel_reader->read(NULL, './migration/', 'twitter-status-20181205.xlsx');
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
               $data[$i]['display_name'] = isset($value['A']) ? $value['A'] : NULL;
               $data[$i]['status'] = isset($value['B']) ? $value['B'] : NULL;
            }
            $row++;
            $i++;
         }
         if($data){
            foreach ($data as $v) {
                $tmp = array(
                  'status' => $v['status'],
               );
               $insert = $this->db->update('twitter', $tmp, array('display_name' => $v['display_name']));
               $insert ? $count++ : FALSE;
            }
            echo $count.' Data Updated';
         }
      }else{
         echo json_encode($excel_reader);
      }
   }

   public function migration_master_rak(){
      $excel_reader = $this->excel_reader->read(NULL, './migration/', 'master_rak.xlsx');
      if ($excel_reader['status']) {
         $objPHPExcel = $excel_reader['result'];
         $count = 0;
         $i = 0;
         $row = 1;
         $data = array();
         $objPHPExcel->setActiveSheetIndex(1);   
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
               if($v['no']){
                   $tmp = array(
                     'no' => $v['no'],
                     'nama_rak' => $v['nama_rak']
                  );
                  $insert = $this->on_duplicate('rak', array_filter($tmp));
                  $insert ? $count++ : FALSE;
               }
            }
            echo $count.' Data Updated';
         }
      }else{
         echo json_encode($excel_reader);
      }
   }

   public function migration_proxy(){
      $excel_reader = $this->excel_reader->read(NULL, './migration/', 'proxy.xlsx');
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
               $data[$i]['network'] = isset($value['A']) ? $value['A'] : NULL;
               $data[$i]['ip_address'] = isset($value['B']) ? $value['B'] : NULL;
               $data[$i]['port'] = isset($value['C']) ? $value['C'] : NULL;
               $data[$i]['username'] = isset($value['D']) ? $value['D'] : NULL;
               $data[$i]['password'] = isset($value['E']) ? $value['E'] : NULL;
               $data[$i]['location'] = isset($value['F']) ? $value['F'] : NULL;
               $data[$i]['status'] = isset($value['G']) ? $value['G'] : NULL;
            }
            $row++;
            $i++;
         }
         if($data){
            foreach ($data as $v) {
               if($v['ip_address']){
                  $tmp = array(
                     'network' => $v['network'],
                     'ip_address' => $v['ip_address'],
                     'port' => $v['port'],
                     'username' => $v['username'],
                     'password' => $v['password'],
                     'location' => $v['location'],
                     'status' => $v['status'],
                     'user_id' => 8,
                  );
                  $insert = $this->on_duplicate('proxy', array_filter($tmp));
                  $insert ? $count++ : FALSE;
               }
            }
            echo $count.' Data Updated';
         }
      }else{
         echo json_encode($excel_reader);
      }
   }

   public function active_period(){
      $excel_reader = $this->excel_reader->read(NULL, './migration/', 'active_period.xlsx');
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
               $data[$i]['phone_number'] = isset($value['A']) ? $this->check_character($value['A']) : NULL;
               $data[$i]['active_period'] = isset($value['B']) ? date('Y-m-d', strtotime($value['B'])) : NULL;
               $data[$i]['expired_date'] = isset($value['C']) ? date('Y-m-d', strtotime($value['C'])) : NULL;
            }
            $row++;
            $i++;
         }
         if($data){
            // echo json_encode($data);
            foreach ($data as $v) {
               if($v['phone_number']){
                  $tmp = array(
                     'phone_number' => $v['phone_number'],
                     'active_period' => $v['active_period'],
                     'expired_date' => $v['expired_date']
                  );
                  $insert = $this->on_duplicate('simcard', array_filter($tmp));
                  $insert ? $count++ : FALSE;
               }
            }
            echo $count.' Data Updated';
         }
      }else{
         echo json_encode($excel_reader);
      }
   }

   public function assign_client($filename, $client_id){
      $excel_reader = $this->excel_reader->read(NULL, './migration/', ''.$filename.'.xlsx');
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
            // echo json_encode($data);
            foreach ($data as $v) {
               if($v['screen_name']){
                  $tmp = array(
                     'client_id' => $client_id
                  );
                  $where = array(
                     'screen_name' => $v['screen_name']
                  );
                  $insert = $this->db->update('twitter', $tmp, $where);
                  $insert ? $count++ : FALSE;
               }
            }
            echo $count.' Data Updated';
         }
      }else{
         echo json_encode($excel_reader);
      }
   }

   public function check_provider($phone_number){
      $phone = substr($phone_number, 0, 4);
      $this->db->select('id');
      $this->db->where('MATCH(code_number) AGAINST ("'.$phone.'")');
      $rs = $this->db->get('provider');
      if($rs->num_rows() > 0){
         $row = $rs->row_array();
         return $row['id'];
      }else{
         return NULL;
      }
   }  

   public function check_character($phone_number){
      $phone = substr($phone_number, 0, 1);
      if($phone == 0){
         return $phone_number;
      }else{
         return '0'.$phone_number;
      }
   }

   public function check_number($phone_number){
      if(isset($phone_number)){
         $this->db->where('phone_number', $phone_number);
         $rs = $this->db->count_all_results('simcard');
         if($rs > 0){
            return $phone_number;
         }else{
            return NULL;
         }
      }else{
         return NULL;
      }
   }

   public function migration_email(){
      ini_set('memory_limit', '1G');
      $excel_reader = $this->excel_reader->read(NULL, './migration/module/', 'email-20190102.xlsx');
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
                  $count = $this->db->where('phone_number', $phone_number)->get('simcard')->num_rows();
                  if($count > 0){
                     $data[$i]['phone_number'] = isset($value['A']) ? $value['A'] : NULL;
                     $data[$i]['email'] = isset($value['B']) ? $value['B'] : NULL;
                     $data[$i]['password'] = isset($value['C']) ? $value['C'] : NULL;
                     $data[$i]['display_name'] = isset($value['E']) ? $value['E'] : NULL;
                     $data[$i]['birth_day'] = isset($value['D']) ? date('Y-m-d', strtotime($value['D'])) : NULL;
                     $data[$i]['status'] = isset($value['G']) ? $value['G'] : NULL;
                     $data[$i]['user_id'] = isset($value['F']) || $value['F'] !== '' ? $value['F'] : NULL;
                  }
               }
            }
            $row++;
            $i++;
         }
         if($data){      
            foreach ($data as $v) {
               $tmp = array(
                  'phone_number_type' => 1,
                  'phone_number' => $v['phone_number'] ? $this->check_number($v['phone_number']) : NULL,
                  'email' => $v['email'],
                  'password' => $v['password'] ? $v['password'] : NULL,
                  'display_name' => $v['display_name'] ? $v['display_name'] : NULL,
                  'birth_day' => $v['birth_day'] ? $v['birth_day'] : NULL,
                  'status' => $v['status'] ? $v['status'] : NULL,
                  'user_id' => $v['user_id'],
               );
               $insert = $this->on_duplicate('email', array_filter($tmp));
               $insert ? $count++ : false;
            }
            echo $count.' Data Updated';
         }
      }else{
         echo json_encode($excel_reader);
      }
   }

   public function migration_simcard(){
		ini_set('memory_limit', '1G');
      $excel_reader = $this->excel_reader->read(NULL, './migration/module/', 'simcard-20181115.xlsx');
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
            	if($value['A'] != ''){
        				$data[$i]['phone_number'] = isset($value['A']) ? $this->check_character($value['A']) : NULL;
            		$data[$i]['active_period'] = isset($value['B']) ? date('Y-m-d', strtotime($value['B'])) : NULL;
	               $data[$i]['expired_date'] = isset($value['B']) ? date('Y-m-d', strtotime($value['B']. ' + 25 days')) : NULL;
	               $data[$i]['nik'] = isset($value['D']) ? $value['D'] : NULL;
	               $data[$i]['nkk'] = isset($value['E']) ? $value['E'] : NULL;
	               $data[$i]['saldo'] = isset($value['F']) ? $value['F'] : NULL;
	               $data[$i]['provider_id'] = isset($value['G']) ? $value['G'] : NULL;
	               $data[$i]['rak_id'] = isset($value['H']) ? $value['H'] : NULL;
	               $data[$i]['user_id'] = isset($value['I']) && $value !== '' ? $value['I'] : NULL;
	               $data[$i]['status'] = isset($value['J']) ? $value['J'] : NULL;
            	}
            }
            $row++;
            $i++;
         }
         if($data){      
         	// echo json_encode($data);
            $failed = array();

            foreach ($data as $v) {
               if($v['phone_number']){
               	if($this->compare_left_days(date('Y-m-d'), $v['expired_date']) == "+"){
               		$status = 1;
               	}else{
               		$status = 0;
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
                  );
                  if($this->db->where('phone_number', $v['phone_number'])->get('simcard')->num_rows() > 0){
                  	$update = $this->db->update('simcard', $tmp, array('phone_number' => $v['phone_number']));
                     if($update){
                        $update ? $count_update++ : false;
                     }else{
                        $failed[] = $v['phone_number'];
                     }
                  }else{
                  	$insert = $this->db->insert('simcard', $tmp);
                     if($insert){
                  	  $insert ? $count_insert++ : false;
                     }else{
                        $failed[] = $v['phone_number'];  
                     }
                  }
               }
            }
            echo $count_update.' Data Updated<br>';
            echo $count_insert.' Data Inserted<br>';
            if($failed){
               echo '<hr>';
               echo 'Data Failed : <br>';
               foreach ($failed as $key => $value) {
                  echo '- '.$value.'<br>';
               }
            }
         }
      }else{
         echo json_encode($excel_reader);
      }
   }

   public function compare_left_days($sdate, $edate){
      $datetime1 = new DateTime($sdate);
      $datetime2 = new DateTime($edate);
      $interval = $datetime1->diff($datetime2);
      return $interval->format('%R%');
   }

   public function migration_twitter(){
      ini_set('memory_limit', '1G');
      $excel_reader = $this->excel_reader->read(NULL, './migration/module/', 'twitter-20181115.xlsx');
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
                  $count = $this->db->where('phone_number', $phone_number)->get('simcard')->num_rows();
                  if($count > 0){
                     $data[$i]['created_twitter'] = isset($value['D']) ? $this->check_type_date($value['D']) : NULL;
                     $data[$i]['phone_number'] = isset($value['A']) ? $this->check_character($value['A']) : NULL;
                     $data[$i]['display_name'] = isset($value['B']) ? $value['B'] : NULL;
                     $data[$i]['screen_name'] = isset($value['C']) ? $value['C'] : NULL;
                     $data[$i]['password'] = isset($value['E']) ? $value['E'] : NULL;
                     $data[$i]['cookies'] = isset($value['F']) ? $value['F'] : NULL;
                     $data[$i]['twitter_id'] = isset($value['G']) ? $value['G'] : NULL;
                     $data[$i]['followers'] = isset($value['H']) ? $value['H'] : NULL;
                     $data[$i]['apps_id'] = isset($value['I']) ? $value['I'] : NULL;
                     $data[$i]['apps_name'] = isset($value['J']) ? $value['J'] : NULL;
                     $data[$i]['consumer_key'] = isset($value['K']) ? $value['K'] : NULL;
                     $data[$i]['consumer_secret'] = isset($value['L']) ? $value['L'] : NULL;
                     $data[$i]['access_token'] = isset($value['M']) ? $value['M'] : NULL;
                     $data[$i]['access_token_secret'] = isset($value['N']) ? $value['N'] : NULL;
                     $data[$i]['client_id'] = isset($value['O']) ? $value['O'] : NULL;
                     $data[$i]['proxy_id'] = isset($value['P']) ? $value['P'] : NULL;
                     $data[$i]['user_id'] = isset($value['Q']) ? $value['Q'] : NULL;
                     $data[$i]['status'] = isset($value['R']) ? $value['R'] : NULL;
                  }
               }
            }
            $row++;
            $i++;
         }
         if($data){      
            // echo json_encode($data);      
            $failed = array();

            foreach ($data as $v) {
               $tmp = array(
                  'phone_number' => $v['phone_number'],
                  'display_name' => $v['display_name'],
                  'screen_name' => $v['screen_name'],
                  'created_twitter' => $v['created_twitter'],
                  'password' => $v['password'],
                  'cookies' => $v['cookies'],
                  'twitter_id' => $v['twitter_id'],
                  'followers' => $v['followers'],
                  'status' => $v['status'],
                  'apps_id' => $v['apps_id'],
                  'apps_name' => $v['apps_name'],
                  'consumer_key' => $v['consumer_key'],
                  'consumer_secret' => $v['consumer_secret'],
                  'access_token' => $v['access_token'],
                  'access_token_secret' => $v['access_token_secret'],
                  'client_id' => $v['client_id'],
                  'proxy_id' => $v['proxy_id'],
                  'user_id' => $v['user_id'] ? $v['user_id'] : NULL,
               );
               if($this->db->where('phone_number', $v['phone_number'])->get('twitter')->num_rows() > 0){
                  $update = $this->db->update('twitter', $tmp, array('phone_number' => $v['phone_number']));
                  if($update){
                     $this->db->update('simcard', array('registered_twitter' => 1), array('phone_number' => $v['phone_number']));
                     $update ? $count_update++ : false;
                  }else{
                     $failed[] = $v['phone_number'];
                  }
               }else{
                  $insert = $this->db->insert('twitter', $tmp);
                  if($insert){
                     $this->db->update('simcard', array('registered_twitter' => 1), array('phone_number' => $v['phone_number']));
                     $insert ? $count_insert++ : false;
                  }else{
                     $failed[] = $v['phone_number'];  
                  }
               }
            }
            echo $count_insert.' Data Inserted';
            echo $count_update.' Data Updated';
            if($failed){
               echo '<hr>';
               echo 'Data Failed : <br>';
               foreach ($failed as $key => $value) {
                  echo '- '.$value.'<br>';
               }
            }
         }
      }else{
         echo json_encode($excel_reader);
      }
   }

   public function check_type_date($date){
      if (strpos($date, '/')){
         $explode = explode('/', $date);
         return date('Y-m-d', strtotime($explode[2].'-'.$explode[1].'-'.$explode[0]));
      }else{
         return date('Y-m-d', strtotime($date));
      }
   }
   public function rak_by_phone(){
      ini_set('memory_limit', '1G');
      $excel_reader = $this->excel_reader->read(NULL, './migration/', 'rak_by_phone_12092018.xlsx');
      if ($excel_reader['status']) {
         $objPHPExcel = $excel_reader['result'];
         $count = 0;
         $i = 0;
         $row = 1;
         $data = array();
         $objPHPExcel->setActiveSheetIndex(2);   
         $worksheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
         foreach ($worksheet as $value) {
            if ($row != 1) {
               $phone_number = isset($value['B']) ? $this->check_character($value['B']) : NULL;
               if($phone_number){
                  $count = $this->db->where('phone_number', $phone_number)->get('simcard')->num_rows();
                  if($count > 0){
                     $data[$i]['phone_number'] = isset($value['A']) ? $this->check_character($value['A']) : NULL;
                     $data[$i]['rak_id'] = isset($value['C']) ? $value['C'] : NULL;
                     $data[$i]['screen_name'] = isset($value['D']) ? $value['D'] : NULL;
                     $data[$i]['password'] = isset($value['E']) ? $value['E'] : NULL;
                     $data[$i]['cookies'] = isset($value['F']) ? $value['F'] : NULL;
                     $data[$i]['twitter_id'] = isset($value['G']) ? $value['G'] : NULL;
                     $data[$i]['followers'] = isset($value['H']) ? $value['H'] : NULL;
                     $data[$i]['apps_id'] = isset($value['I']) ? $value['I'] : NULL;
                     $data[$i]['apps_name'] = isset($value['J']) ? $value['J'] : NULL;
                     $data[$i]['consumer_key'] = isset($value['K']) ? $value['K'] : NULL;
                     $data[$i]['consumer_secret'] = isset($value['L']) ? $value['L'] : NULL;
                     $data[$i]['access_token'] = isset($value['M']) ? $value['M'] : NULL;
                     $data[$i]['access_token_secret'] = isset($value['N']) ? $value['N'] : NULL;
                     $data[$i]['client_id'] = isset($value['O']) ? $value['O'] : NULL;
                     $data[$i]['proxy_id'] = isset($value['P']) ? $value['P'] : NULL;
                     $data[$i]['user_id'] = isset($value['Q']) ? $value['Q'] : NULL;
                     $data[$i]['status'] = isset($value['S']) ? $value['S'] : NULL;
                  }
               }
            }
            $row++;
            $i++;
         }
         if($data){      
            // echo json_encode($data);      
            foreach ($data as $v) {
               $tmp = array(
                  'phone_number' => $v['phone_number'],
                  'display_name' => $v['display_name'],
                  'screen_name' => $v['screen_name'],
                  'created_twitter' => $v['created_twitter'],
                  'password' => $v['password'],
                  'cookies' => $v['cookies'],
                  'twitter_id' => $v['twitter_id'],
                  'followers' => $v['followers'],
                  'status' => $v['status'],
                  'apps_id' => $v['apps_id'],
                  'apps_name' => $v['apps_name'],
                  'consumer_key' => $v['consumer_key'],
                  'consumer_secret' => $v['consumer_secret'],
                  'access_token' => $v['access_token'],
                  'access_token_secret' => $v['access_token_secret'],
                  'client_id' => $v['client_id'],
                  'proxy_id' => $v['proxy_id'],
                  'user_id' => $v['user_id'] ? $v['user_id'] : NULL,
               );
               $insert = $this->on_duplicate('twitter', array_filter($tmp));
               $insert ? $count++ : false;
               $this->db->update('simcard', array('registered_twitter' => 1), array('phone_number' => $v['phone_number']));
            }
            echo $count.' Data Updated';
         }
      }else{
         echo json_encode($excel_reader);
      }
   }

   public function sync_twitter_status(){
      $count = 0;
      $rs = $this->db->select('screen_name')->where('date(created_twitter) between "2018-09-01" and "2018-09-30"')->get('twitter')->result_array();
      foreach ($rs as $v) {
         $tmp = array(
            'production_status' => $this->twitter_api($v['screen_name'])
         );
         $insert = $this->db->update('twitter', $tmp, array('screen_name' => $v['screen_name']));
         $insert ? $count++ : false;
      }     
      echo $count.' Data Updated';
   }

   public function twitter_api($screen_name){
      $url = config_item('isr_api') . 'get_all_robot?';
      $params = array(
         "screen_name" => $screen_name,
      );
      $url .= http_build_query($params);
      $rs = $this->curl->_get_response($url);
      return $rs['data']['count'] > 0 ? $rs['data']['items'][0]['robot_status'] : NULL;
   }

   public function dump_failed_simcard($phone_number){
      $this->db->insert('dump_migration_simcard', array('phone_number' => $phone_number));
   }

   public function format_download() {
      $params = $this->input->get();
      switch ($params['mode']) {
         case 'rak':
            $this->load->view('migration_format/master_rak');
            break;
      }
   }

   public function simulasi_proxy(){
      $proxy = $this->db->where('username !=', NULL)->where('password !=', NULL)->get('proxy', 15, 0)->result_array();
      foreach ($proxy as $key => $value) {
         echo $value['username'].':'.$value['password'].'@'.$value['ip_address'].':'.$value['port'].' | '.$this->proxy($value['ip_address'], $value['port'], $value['username'], $value['password']);
         echo '<br>';
      }
      echo 'zuhad:q1w2e3r4@1.56.206.5:2017 | '.$this->proxy('1.56.206.5', '2017', 'zuhad', 'q1w2e3r4');
      echo '<br>';
   }

   public function proxy($ip_address, $port, $username, $password){
      $url = 'https://www.iplocation.net/';
      $proxy = ''.$ip_address.':'.$port.'';
      $proxyauth = ''.$username.':'.$password.'';

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL,$url);
      curl_setopt($ch, CURLOPT_PROXY, $proxy);
      curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyauth);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_HEADER, 1);
      curl_setopt($ch, CURLOPT_TIMEOUT, 10);
      $curl_scraped_page = curl_exec($ch);
      $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
      curl_close($ch);
      if($httpcode == 200){
         return 'berhasil';
      }else{
         return 'gagal';
      }
      
   }

   public function test_proxy(){
      $url = 'https://www.iplocation.net/';
      $proxy = '103.115.164.6:3128';
      $proxyauth = 'teja:q1w2e3r4';

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL,$url);
      curl_setopt($ch, CURLOPT_PROXY, $proxy);
      curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyauth);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_HEADER, 1);
      // curl_setopt($ch, CURLOPT_TIMEOUT, 10);
      $curl_scraped_page = curl_exec($ch);
      $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
      curl_close($ch);
      echo $curl_scraped_page;
      echo $httpcode;
      
   }

}