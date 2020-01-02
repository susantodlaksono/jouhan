<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Validation_provider{

   public function __construct() {
      $this->_ci = & get_instance();
      $this->_ci->load->library('form_validation');
      $this->_ci->load->database();
   }

   public function create($params){
      $this->_ci->form_validation->set_rules('product', 'Product', 'required|is_unique[provider.product]');
      $this->_ci->form_validation->set_rules('provider', 'Provider', 'required');
      return $this->_ci->form_validation->run();
   }

   public function change($params){
      if($params['product'] != $params['product_before']){
         $this->_ci->form_validation->set_rules('product', 'Product', 'required|is_unique[provider.product]');
      }else{
         $this->_ci->form_validation->set_rules('product', 'Product', 'required');
      }
      $this->_ci->form_validation->set_rules('provider', 'Provider', 'required');
      return $this->_ci->form_validation->run();
   }

}