<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Validation_proxy{

   public function __construct() {
      $this->_ci = & get_instance();
      $this->_ci->load->library('form_validation');
      $this->_ci->load->database();
   }

   public function create($params){
      $this->_ci->form_validation->set_rules('network', 'Network', 'required');
      $this->_ci->form_validation->set_rules('ip_address', 'IP Address', 'required');
      // $this->_ci->form_validation->set_rules('port', 'Port', 'required|is_numeric');
      // $this->_ci->form_validation->set_rules('username', 'Username', 'required');
      // $this->_ci->form_validation->set_rules('password', 'Password', 'required');
      $this->_ci->form_validation->set_rules('status', 'Status', 'required');
      return $this->_ci->form_validation->run();
   }

   public function change($params){
      $this->_ci->form_validation->set_rules('ip_address', 'IP Address', 'required');
      $this->_ci->form_validation->set_rules('network', 'Network', 'required');
      // $this->_ci->form_validation->set_rules('port', 'Port', 'required|is_numeric');
      // $this->_ci->form_validation->set_rules('username', 'Username', 'required');
      // $this->_ci->form_validation->set_rules('password', 'Password', 'required');
      $this->_ci->form_validation->set_rules('status', 'Status', 'required');
      return $this->_ci->form_validation->run();
   }

}