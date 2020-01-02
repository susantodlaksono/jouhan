<?php

if (!defined('BASEPATH'))
   exit('No direct script access allowed');

class Simulation extends MY_Controller {

	public function __construct() {
      parent::__construct();
      if (!$this->ion_auth->logged_in() && php_sapi_name() != 'cli') {
         redirect('security?_redirect=' . urlencode(uri_string()));
      }
   }

   public function example_report(){
   	$data['twitter'] = $this->db->get('twitter')->result_array();
   	$this->load->view('example_report', $data);
   }

}