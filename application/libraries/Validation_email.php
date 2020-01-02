<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Validation_email{

   public function __construct() {
      $this->_ci = & get_instance();
      $this->_ci->load->library('form_validation');
      $this->_ci->load->database();
   }

   public function create(){
      $this->_ci->form_validation->set_rules('phone_number', 'Phone Number', 'required|is_numeric|is_unique[email.phone_number]');
      $this->_ci->form_validation->set_rules('email', 'email', 'required|valid_email');
      $this->_ci->form_validation->set_rules('password', 'Password', 'required');
      $this->_ci->form_validation->set_rules('display_name', 'Display Name', 'required');
      return $this->_ci->form_validation->run();
   }

   public function change($params){
      if($params['phone_number'] == $params['phone_number_before']){
         $this->_ci->form_validation->set_rules('phone_number', 'Phone Number', 'required|is_numeric');   
      }else{
         $this->_ci->form_validation->set_rules('phone_number', 'Phone Number', 'required|is_numeric|is_unique[email.phone_number]');
      }
      $this->_ci->form_validation->set_rules('email', 'email', 'required|valid_email');
      $this->_ci->form_validation->set_rules('display_name', 'Display Name', 'required');
      $this->_ci->form_validation->set_rules('password', 'Password', 'required');
      return $this->_ci->form_validation->run();
   }

}