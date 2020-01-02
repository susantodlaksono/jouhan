<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Validation_instagram{

   public function __construct() {
      $this->_ci = & get_instance();
      $this->_ci->load->library('form_validation');
      $this->_ci->load->database();
   }

   public function create($params){
      $this->_ci->form_validation->set_rules('phone_number', 'Phone Number', 'required|is_unique[instagram.phone_number]');
      $this->_ci->form_validation->set_rules('username', 'Username', 'required|is_unique[instagram.username]');
      $this->_ci->form_validation->set_rules('display_name', 'Display Name', 'required');
      $this->_ci->form_validation->set_rules('password', 'Password', 'required');
      // $this->_ci->form_validation->set_rules('birth_date', 'Birth Date', 'required');
      $this->_ci->form_validation->set_rules('created_instagram', 'Create Date', 'required');
      return $this->_ci->form_validation->run();
   }   

   public function change($params){
      if($params['phone_number'] != $params['phone_number_before']){
         $this->_ci->form_validation->set_rules('phone_number', 'Phone Number', 'required|is_unique[instagram.phone_number]');
      }else{
         $this->_ci->form_validation->set_rules('phone_number', 'Phone Number', 'required');
      }
      if($params['username'] != $params['username_before']){
         $this->_ci->form_validation->set_rules('username', 'Username', 'required|is_unique[instagram.username]');
      }else{
         $this->_ci->form_validation->set_rules('username', 'Username', 'required');
      }
      $this->_ci->form_validation->set_rules('display_name', 'Display Name', 'required');
      $this->_ci->form_validation->set_rules('password', 'Password', 'required');
      // $this->_ci->form_validation->set_rules('birth_date', 'Birth Date', 'required');
      $this->_ci->form_validation->set_rules('created_instagram', 'Create Date', 'required');
      return $this->_ci->form_validation->run();
   }   

}