<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Validation_simcard{

   public function __construct() {
      $this->_ci = & get_instance();
      $this->_ci->load->library('form_validation');
   }

   public function create($params){
      $this->_ci->form_validation->set_rules('phone_number', 'Phone Number', 'required|is_numeric|is_unique[simcard.phone_number]');
      $this->_ci->form_validation->set_rules('active_period', 'Active Period', 'required');
      $this->_ci->form_validation->set_rules('expired_date', 'Expired Date', 'required');
      $this->_ci->form_validation->set_rules('rak', 'Rak', 'required');
      return $this->_ci->form_validation->run();
   }

   public function change($params){
      if($params['phone_number'] != $params['phone_number_before'])  {
         $this->_ci->form_validation->set_rules('phone_number', 'Phone Number', 'required|is_numeric|is_unique[simcard.phone_number]');
      }else{
         $this->_ci->form_validation->set_rules('phone_number', 'Phone Number', 'required|is_numeric');
      }
      $this->_ci->form_validation->set_rules('active_period', 'Active Period', 'required');
      $this->_ci->form_validation->set_rules('expired_date', 'Expired Date', 'required');
      $this->_ci->form_validation->set_rules('rak', 'Rak', 'required');
      return $this->_ci->form_validation->run();
   }

}