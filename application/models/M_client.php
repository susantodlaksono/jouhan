<?php

class M_client extends CI_model{

   public function get($mode, $params){
      if($params['filter_keyword'] != ''){
         $this->db->group_start();
         $this->db->like('a.name', $params['filter_keyword']);
         $this->db->or_like('a.description', $params['filter_keyword']);
         $this->db->group_end();
      }
      $this->db->order_by('a.id', 'desc');
      switch ($mode) {
         case 'get':
            return $this->db->get('client as a', 10, $params['offset'])->result_array();
         case 'count':
            return $this->db->get('client as a')->num_rows();
      }
   }

   public function create($params){
      $obj = array(
         'name' => $params['name'],
         'description' => $params['description']
      );
      return $this->db->insert('client', $obj);
   }

   public function change($params){
      $obj = array(
         'name' => $params['name'],
         'description' => $params['description']
      );
      return $this->db->update('client', $obj, array('id' => $params['id']));
   }

   public function delete($params){
      return $this->db->delete('client', array('id' => $params['id']));
   }

}

?>