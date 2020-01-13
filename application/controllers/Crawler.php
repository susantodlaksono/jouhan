<?php
error_reporting(0);
ini_set('memory_limit', '1G');
set_time_limit(0);	

if (!defined('BASEPATH'))
   exit('No direct script access allowed');

class Crawler extends MY_Controller {

	public function __construct() {
      parent::__construct();
      if (php_sapi_name() != 'cli') {
      	if (!$this->ion_auth->logged_in()) {
	         redirect('security?_redirect=' . urlencode(uri_string()));
	      }                                                    
   	}                                                             
   }                                      

   private function _redirect($redirect, $data = array()) {
   	$this->log(array(      
            'source' => 'crawler',
            'remark' => json_encode($data)
        ));

     	if (php_sapi_name() == 'cli') {
      	$logs = date('Y-m-d H:i:s') . ' ' . json_encode($data) . "\n";
      	echo $logs;
      	exit();
     	}
     	if ($redirect) {
         if ($redirect != 'DISABLED') {
          	redirect($redirect);
         } else {
          	header('Content-Type: application/json');
          	echo json_encode($data);
          	exit();
         }
     	} else {
         redirect('crawler');
     	}
 	}

   public function expired_date_simcard(){
   	$result['status'] = TRUE;
		$now = date('Y-m-d');
      $weeks = date('Y-m-d', strtotime('-6 Days'));
		$limit_active = date('Y-m-d', strtotime('+7 Days'));

      $_to_active = $this->_to_active($limit_active);
		$_to_topup = $this->_to_topup($limit_active);
		$_to_change_number = $this->_to_change_number($now);

		if($_to_topup > 0 || $_to_change_number > 0){
         $result['message'] = $_to_topup.' Data Changed to top up | '.$_to_change_number.' Data Changed to change number';
         $this->session->set_flashdata('message', array('success' => $result['message']));
		}else{
			$result['message'] = 'No Affected Rows';
		}
   	$this->_redirect($this->input->get('_redirect'), $result);
   }

   public function log($log = array()) {
   	$this->_db = $this->load->database('default', TRUE);
     	$default = array(
         'date' => date('Y-m-d H:i:s'),
         'source' => NULL,
         'activity' => NULL,
         'page' => uri_string(),
         'params' => json_encode($this->input->get()),
         'remark' => NULL,
         'user_id' => 8
     	);
     	return $this->_db->insert('users_activity', array_merge($default, $log));
 	}

   private function _to_active($limit_active){
      $this->_db = $this->load->database('default', TRUE);
      $this->_db->where('expired_date > "'.$limit_active.'"');
      $rs = $this->_db->update('simcard', array('status' => 1));
      return $this->_db->affected_rows();
   }

   private function _to_topup($limit_active){
   	$this->_db = $this->load->database('default', TRUE);
   	$this->_db->where('expired_date <= "'.$limit_active.'"');
   	$rs = $this->_db->update('simcard', array('status' => 0));
   	return $this->_db->affected_rows();
   }

   private function _to_change_number($now){
   	$this->_db = $this->load->database('default', TRUE);
   	$this->_db->where('expired_date < "'.$now.'"');
   	$rs = $this->_db->update('simcard', array('status' => 2));
   	return $this->_db->affected_rows();
   }

}