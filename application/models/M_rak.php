<?php

class M_rak extends CI_model{

   public function get($mode, $params){
      if($params['filter_keyword'] != ''){
         $this->db->group_start();
         $this->db->like('a.no', $params['filter_keyword']);
         $this->db->or_like('a.nama_rak', $params['filter_keyword']);
         $this->db->group_end();
      }
      $this->db->order_by('a.id', 'desc');
      switch ($mode) {
         case 'get':
            return $this->db->get('rak as a', 10, $params['offset'])->result_array();
         case 'count':
            return $this->db->get('rak as a')->num_rows();
      }
   }

   public function create($params){
      $obj = array(
         'no' => $params['no'],
         'nama_rak' => $params['nama_rak']
      );
      return $this->db->insert('rak', $obj);
   }

   public function change($params){
      $obj = array(
         'no' => $params['no'],
         'nama_rak' => $params['nama_rak']
      );
      return $this->db->update('rak', $obj, array('id' => $params['id']));
   }

   public function delete($params){
      return $this->db->delete('rak', array('id' => $params['id']));
   }

}

?>