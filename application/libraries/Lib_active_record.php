<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 *
 * @author SUSANTO DWI LAKSONO
 */


class Lib_active_record{

   public function __construct() {
      $this->ci = & get_instance();
   }

   public function on_duplicate($table, $data, $exclude = array(), $db_section = 'default') {
      $this->db = $this->ci->load->database($db_section, TRUE);
      $updatestr = array();
      foreach ($data as $k => $v) {
         if (!in_array($k, $exclude)) {
            $updatestr[] = '`' . $k . '`="' . $this->db->escape_str($v) . '"';
         }
      }
      $query = $this->db->insert_string($table, $data);
      $query .= ' ON DUPLICATE KEY UPDATE ' . implode(', ', array_filter($updatestr));
      $this->ci->db->query($query);
      return $this->ci->db->affected_rows();
   }

}