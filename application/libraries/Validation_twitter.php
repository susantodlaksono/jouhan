<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Validation_twitter{

   public function __construct() {
      $this->_ci = & get_instance();
      $this->_ci->load->library('form_validation');
      $this->_ci->load->database();
   }

   public function create($params){
      $this->_ci->form_validation->set_rules('phone_number', 'Phone Number', 'required|is_unique[twitter.phone_number]');
      $this->_ci->form_validation->set_rules('screen_name', 'Screen Name', 'required|is_unique[twitter.screen_name]');
      $this->_ci->form_validation->set_rules('password', 'Password', 'required');
      return $this->_ci->form_validation->run();
   }   

   public function change($params){
      if($params['phone_number'] != $params['phone_number_before']){
         $this->_ci->form_validation->set_rules('phone_number', 'Phone Number', 'required|is_unique[twitter.phone_number]');
      }else{
         $this->_ci->form_validation->set_rules('phone_number', 'Phone Number', 'required');
      }
      if($params['screen_name'] != $params['screen_name_before']){
         $this->_ci->form_validation->set_rules('screen_name', 'Screen Name', 'required|is_unique[twitter.screen_name]');
      }else{
         $this->_ci->form_validation->set_rules('screen_name', 'Screen Name', 'required');
      }
      $this->_ci->form_validation->set_rules('password', 'Password', 'required');
      return $this->_ci->form_validation->run();
   }   

}