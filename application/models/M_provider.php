<?php

class M_provider extends CI_model{

   public function get($mode, $params){      
      if($params['filter_keyword'] != ''){
         $this->db->group_start();
         $this->db->like('a.product', $params['filter_keyword']);
         $this->db->or_like('a.provider', $params['filter_keyword']);
         $this->db->or_like('a.code_number', $params['filter_keyword']);
         $this->db->group_end();
      }
      $this->db->order_by('a.id', 'desc');
      switch ($mode) {
         case 'get':
            return $this->db->get('provider as a', 10, $params['offset'])->result_array();
         case 'count':
            return $this->db->get('provider as a')->num_rows();
      }
   }

   public function check_code_number($params){
      $this->db->where('MATCH(code_number) AGAINST ("'.$params['item'].'")');
      return $this->db->count_all_results('provider');
   }

   public function create($params){
      $obj = array(
         'product' => $params['product'],
         'provider' => $params['provider'],
         'code_number' => $params['code_number'] ? json_encode($params['code_number']) : NULL,
      );
      return $this->db->insert('provider', $obj);
   }

   public function change($params){
      $obj = array(
         'product' => $params['product'],
         'provider' => $params['provider'],
         'code_number' => $params['code_number'] ? json_encode($params['code_number']) : NULL,
      );
      return $this->db->update('provider', $obj, array('id' => $params['id']));
   }

   public function delete($params){
      return $this->db->delete('provider', array('id' => $params['id']));
   }

   public function check_code_number_change($item, $code_number_before){
      if(in_array($item, $code_number_before)){
         return FALSE;
      }else{
         $this->db->where('MATCH(code_number) AGAINST ("'.$item.'")');
         $count = $this->db->count_all_results('provider');
         if($count > 0){
            return TRUE;
         }else{
            return FALSE;
         }
      }
   }

   public function check_duplicate_provider($params, $code_number){
      $code_number_before = explode(',', $params['code_number_before']);
      foreach ($code_number as $v) {
         $check = $this->check_code_number_change($v, $code_number_before);
         if($check){
            return FALSE;
         }else{
            return TRUE;
         }
      }
   }

}

?>