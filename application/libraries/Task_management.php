<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Library for Task Management API
 *
 * @author SUSANTO DWI LAKSONO
 */

require_once 'Curl.php';

class Task_management extends Curl {

   private $ci;

   public function __construct() {
      $this->ci = & get_instance();
      $this->ci->load->config('service');
   }

   public function rest_project_information($nik){
      $url = config_item('task_management').'rest/skillset?';
      $params = array(
         'nik' => $nik
      );
      $url .= http_build_query($params);
      $response = $this->_get_response($url);
      return json_decode($response['data'], TRUE);
   }

}