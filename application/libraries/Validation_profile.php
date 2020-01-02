<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Validation_profile{

   public function __construct() {
      $this->_ci = & get_instance();
      $this->_ci->load->library('form_validation');
   }

   public function update_basic_information($params, $role_id){
      $this->_ci->form_validation->set_rules('nik', 'NIK', 'required|alpha_numeric_spaces');
      if(isset($params['new_nik']) && in_array(1, $role_id)){
         if($params['new_nik'] != $params['nik']){
            $this->_ci->form_validation->set_rules('new_nik', 'NIK', 'required|alpha_numeric_spaces|is_unique[employee.nik]');
         }
      }
      $this->_ci->form_validation->set_rules('fullname', 'Fullname', 'required|alpha_numeric_spaces');
      $this->_ci->form_validation->set_rules('birth_place', 'Birth Place', 'required|alpha_numeric_spaces');
      $this->_ci->form_validation->set_rules('birth_date', 'Birth Date', 'required');
      $this->_ci->form_validation->set_rules('gender', 'Gender', 'required|alpha_numeric_spaces');
      $this->_ci->form_validation->set_rules('religion', 'Religion', 'required|alpha_numeric_spaces');
      $this->_ci->form_validation->set_rules('blood_group', 'Blood Group', 'required|alpha_numeric_spaces');
      $this->_ci->form_validation->set_rules('married_status', 'Marital Status', 'required|alpha_numeric_spaces');
      $this->_ci->form_validation->set_rules('citizenship', 'Citizenship', 'required|alpha_numeric_spaces');
      $this->_ci->form_validation->set_rules('npwp_number', 'No NPWP', 'required');
      $this->_ci->form_validation->set_rules('jamsostek_number', 'No Jamsostek', 'required');
      $this->_ci->form_validation->set_rules('ptkp_status', 'PTKP Status', 'required');
      return $this->_ci->form_validation->run();
   }

   public function update_status(){
      $this->_ci->form_validation->set_rules('nik', 'NIK', 'required|alpha_numeric_spaces');
      $this->_ci->form_validation->set_rules('status', 'Status', 'required|numeric');
      $this->_ci->form_validation->set_rules('location', 'Location', 'required|alpha_numeric_spaces');
      $this->_ci->form_validation->set_rules('work_date', 'Work Date', 'required');
      $this->_ci->form_validation->set_rules('company', 'Company', 'required');
      $this->_ci->form_validation->set_rules('division[]', 'Division', 'required|alpha_numeric_spaces');
      $this->_ci->form_validation->set_rules('position[]', 'Position', 'required|alpha_numeric_spaces');
      return $this->_ci->form_validation->run();
   }

   public function update_employee_card(){
      // $this->_ci->form_validation->set_rules('card_number', 'Card Number', 'required|numeric');
      // $this->_ci->form_validation->set_rules('address', 'Address', 'required');
      // $this->_ci->form_validation->set_rules('pos_code', 'Pos Code', 'required|numeric');
      // $this->_ci->form_validation->set_rules('neighbourhood', 'Neighbourhood', 'required|numeric');
      // $this->_ci->form_validation->set_rules('hamlet', 'Hamlet', 'required|numeric');
      // $this->_ci->form_validation->set_rules('sub_district', 'Sub District', 'required|alpha_numeric_spaces');
      // $this->_ci->form_validation->set_rules('urban_village', 'Urban Village', 'required|alpha_numeric_spaces');
      // $this->_ci->form_validation->set_rules('city', 'City', 'required|alpha_numeric_spaces');
      // $this->_ci->form_validation->set_rules('province', 'Province', 'required|alpha_numeric_spaces');

      $this->_ci->form_validation->set_rules('card_number', 'Card Number', 'numeric');
      // $this->_ci->form_validation->set_rules('address', 'Address', 'required');
      $this->_ci->form_validation->set_rules('pos_code', 'Pos Code', 'numeric');
      $this->_ci->form_validation->set_rules('neighbourhood', 'Neighbourhood', 'numeric');
      $this->_ci->form_validation->set_rules('hamlet', 'Hamlet', 'numeric');
      // $this->_ci->form_validation->set_rules('sub_district', 'Sub District', 'alpha_numeric_spaces');
      // $this->_ci->form_validation->set_rules('urban_village', 'Urban Village', 'alpha_numeric_spaces');
      // $this->_ci->form_validation->set_rules('city', 'City', 'alpha_numeric_spaces');
      // $this->_ci->form_validation->set_rules('province', 'Province', 'alpha_numeric_spaces');
      return $this->_ci->form_validation->run();
   }


   public function update_employee_place(){
      // $this->_ci->form_validation->set_rules('address', 'Address', 'required');
      // $this->_ci->form_validation->set_rules('pos_code', 'Pos Code', 'required|numeric');
      // $this->_ci->form_validation->set_rules('neighbourhood', 'Neighbourhood', 'required|numeric');
      // $this->_ci->form_validation->set_rules('hamlet', 'Hamlet', 'required|numeric');
      // $this->_ci->form_validation->set_rules('sub_district', 'Sub District', 'required|alpha_numeric_spaces');
      // $this->_ci->form_validation->set_rules('urban_village', 'Urban Village', 'required|alpha_numeric_spaces');
      // $this->_ci->form_validation->set_rules('city', 'City', 'required|alpha_numeric_spaces');
      // $this->_ci->form_validation->set_rules('province', 'Province', 'required|alpha_numeric_spaces');

      // $this->_ci->form_validation->set_rules('address', 'Address', 'required');
      $this->_ci->form_validation->set_rules('pos_code', 'Pos Code', 'numeric');
      $this->_ci->form_validation->set_rules('neighbourhood', 'Neighbourhood', 'numeric');
      $this->_ci->form_validation->set_rules('hamlet', 'Hamlet', 'numeric');
      // $this->_ci->form_validation->set_rules('sub_district', 'Sub District', 'alpha_numeric_spaces');
      // $this->_ci->form_validation->set_rules('urban_village', 'Urban Village', 'alpha_numeric_spaces');
      // $this->_ci->form_validation->set_rules('city', 'City', 'alpha_numeric_spaces');
      // $this->_ci->form_validation->set_rules('province', 'Province', 'alpha_numeric_spaces');
      return $this->_ci->form_validation->run();
   }

   public function update_user($params){
      if($params['username'] != $params['username_before']){
         $this->_ci->form_validation->set_rules('username', 'Username', 'required|alpha_numeric_spaces|is_unique[users.username]');
      }
      $this->_ci->form_validation->set_rules('password', 'Password', 'alpha_numeric_spaces');
      $this->_ci->form_validation->set_rules('passconf', 'Password Confirmation', 'alpha_numeric_spaces|matches[password]');
      return $this->_ci->form_validation->run();
   }

}