<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Validation_facebook{

   public function __construct() {
      $this->_ci = & get_instance();
      $this->_ci->load->library('form_validation');
      $this->_ci->load->database();
   }

   public function create($params){
      $this->_ci->form_validation->set_rules('phone_number', 'Phone Number', 'required|is_unique[facebook.phone_number]');
      $this->_ci->form_validation->set_rules('display_name', 'url', 'required');
      $this->_ci->form_validation->set_rules('url', 'URL', 'required|is_unique[facebook.url]');
      $this->_ci->form_validation->set_rules('password', 'Password', 'required');
      $this->_ci->form_validation->set_rules('facebook_id', 'Facebook ID', 'required|is_unique[facebook.facebook_id]');
      $this->_ci->form_validation->set_rules('birth_date', 'Birth Date', 'required');
      $this->_ci->form_validation->set_rules('created_facebook', 'Create Date', 'required');
      return $this->_ci->form_validation->run();
   } 

   public function create_fanspage($params){
      $this->_ci->form_validation->set_rules('url', 'Fanspage URL', 'required|is_unique[facebook_fanspage.url]');
      $this->_ci->form_validation->set_rules('name', ' Fanspage Name', 'required');
      $this->_ci->form_validation->set_rules('created_fanspage', ' Created Date', 'required');
      $this->_ci->form_validation->set_rules('admin_url[]', 'Admin URL', 'required');
      return $this->_ci->form_validation->run();
   }   

   public function change($params){
      if($params['phone_number'] != $params['phone_number_before']){
         $this->_ci->form_validation->set_rules('phone_number', 'Phone Number', 'required|is_unique[facebook.phone_number]');
      }else{
         $this->_ci->form_validation->set_rules('phone_number', 'Phone Number', 'required');
      }
      if($params['url_facebook'] != $params['url_facebook_before']){
         $this->_ci->form_validation->set_rules('url_facebook', 'URL', 'required|is_unique[facebook.url]');
      }else{
         $this->_ci->form_validation->set_rules('url_facebook', 'URL', 'required');
      }
      if($params['facebook_id'] != $params['facebook_id_before']){
         $this->_ci->form_validation->set_rules('facebook_id', 'Facebook ID', 'required|is_unique[facebook.facebook_id]');
      }else{
         $this->_ci->form_validation->set_rules('facebook_id', 'Facebook ID', 'required');
      }

      $this->_ci->form_validation->set_rules('display_name', 'Display Name', 'required');
      $this->_ci->form_validation->set_rules('password', 'Password', 'required');
      $this->_ci->form_validation->set_rules('birth_date', 'Birth Date', 'required');
      $this->_ci->form_validation->set_rules('created_facebook', 'Create Date', 'required');
      return $this->_ci->form_validation->run();
   }   

   public function change_fanspage($params){
      if($params['url'] != $params['url_before']){
         $this->_ci->form_validation->set_rules('url', 'Fanspage URL', 'required|is_unique[facebook_fanspage.url]');
      }else{
         $this->_ci->form_validation->set_rules('url', 'Fanspage URL', 'required');
      }
      $this->_ci->form_validation->set_rules('created_fanspage', ' Created Date', 'required');
      $this->_ci->form_validation->set_rules('admin_url[]', 'Admin URL', 'required');
      $this->_ci->form_validation->set_rules('name', 'Fanspage Name', 'required');
      return $this->_ci->form_validation->run();
   }   

}