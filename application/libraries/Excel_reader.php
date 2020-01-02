<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Library for Assessment result
 *
 * @author SUSANTO DWI LAKSONO
 */

// require_once 'PHPExcel.php';

class Excel_reader{

   public function __construct() {
      $this->ci = & get_instance();
   }

   public function read($url = NULL, $filepath = './migrations/', $filename = '_get_file') {
      set_time_limit(0);
      $fullpath = $filepath . $filename;
      if ($url) {
         $file = file_get_contents($url);
         file_put_contents($fullpath, $file);
      }
      $this->ci->load->library('PHPExcel');
      try {
         $result['status'] = TRUE;
         $result['result'] = PHPExcel_IOFactory::load($fullpath);
      }catch (PHPExcel_Reader_Exception $e) {
         $result['status'] = FALSE;
         $result['result'] = 'Error loading file "' . pathinfo($fullpath, PATHINFO_BASENAME) . '": ' . $e->getMessage();
      }
      return $result;
   }

}