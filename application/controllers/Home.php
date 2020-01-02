<?php

/**
 * @Author: santo
 * @Date:   2018-04-24 00:39:24
 * @Last Modified by:   santo
 * @Last Modified time: 2018-05-14 14:50:02
 */

if (!defined('BASEPATH'))
   exit('No direct script access allowed');

class Home extends MY_Controller {

   public function __construct() {
      parent::__construct();
      if (!$this->ion_auth->logged_in() && php_sapi_name() != 'cli') {
         redirect('security?_redirect=' . urlencode(uri_string()));
      }
   }

   public function index() {
      $obj = array(
         '_css' => array(
            'assets/css/carousel.css',
            'assets/plugins/fancybox/jquery.fancybox.min.css',
         ),
         '_js' => array(
            'assets/plugins/fancybox/jquery.fancybox.min.js',
         ),
         'company' => $this->db->select('company')->group_by('company')->get('employee_status')->result_array(),
         'nik' => $this->_nik['nik'],
      );
      if(in_array('4', $this->_role_id_list)){
         $this->load->model('master_data');
         $obj['result_view'] = 'employee/home';
         $obj['birthday_employee'] = count($this->master_data->birthday_employee()->result_array());
         $obj['new_employee'] = count($this->master_data->new_employee()->result_array());
         $obj['remaining_leaves'] = $this->master_data->count_remaining_leaves($this->_nik['nik']);
         $obj['leaves'] = $this->master_data->count_leaves($this->_nik['nik']);
      }else{
         $obj['result_view'] = 'management/home';
      }
      $this->rendering_page($obj);
      
   }
}  