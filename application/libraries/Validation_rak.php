<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Validation_rak{

   public function __construct() {
      $this->_ci = & get_instance();
      $this->_ci->load->library('form_validation');
      $this->_ci->load->database();
   }

   public function create($params){
      $this->_ci->form_validation->set_rules('no', 'No', 'required');
      $this->_ci->form_validation->set_rules('nama_rak', 'Rak Name', 'required');
      return $this->_ci->form_validation->run();
   }

   public function change($params){
      $this->_ci->form_validation->set_rules('no', 'No', 'required');
      $this->_ci->form_validation->set_rules('nama_rak', 'Rak Name', 'required');
      return $this->_ci->form_validation->run();
   }

}