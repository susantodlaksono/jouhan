<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Validation_form{

   public function __construct() {
      $this->_ci = & get_instance();
      $this->_ci->load->library('form_validation');
   }

   public function position(){
      $this->_ci->form_validation->set_rules('name', 'Name', 'required|is_unique[employee_position.name]');
      return $this->_ci->form_validation->run();
   }

}