<?php

class Model_proxy extends CI_model{

	public function get($mode, $params){
      $this->db->select('a.*, b.first_name as pic');
      $this->db->join('users as b', 'a.user_id = b.id', 'left');
      
      if($params['filter_keyword'] != ''){
         $this->db->group_start();
         $this->db->like('a.ip_address', $params['filter_keyword']);
         $this->db->or_like('a.port', $params['filter_keyword']);
         $this->db->or_like('a.username', $params['filter_keyword']);
         $this->db->or_like('a.password', $params['filter_keyword']);
         $this->db->or_like('a.location', $params['filter_keyword']);
         $this->db->or_like('b.first_name', $params['filter_keyword']);
         $this->db->group_end();
      }
      if($params['filter_status'] != ''){
         $this->db->where('a.status', $params['filter_status']);
      }
      if($params['filter_network'] != ''){
         $this->db->where('a.network', $params['filter_network']);
      }
      $this->db->order_by('id', 'desc');
      switch ($mode) {
         case 'get':
            return $this->db->get('proxy as a', 10, $params['offset'])->result_array();
         case 'count':
            return $this->db->get('proxy as a')->num_rows();
      }
   }

   public function create($params){
      $obj = array(
         'network' => $params['network'],
         'ip_address' => $params['ip_address'],
         'port' => $params['port'] ? $params['port'] : NULL,
         'username' => $params['username'] ? $params['username'] : NULL,
         'password' => $params['password'] ? $params['password'] : NULL,
         'location' => $params['location'] ? $params['location'] : NULL,
         'status' => $params['status'],
         'user_id' => $params['user_id']
      );
      return $this->db->insert('proxy', $obj);
   }

   public function change($params){
      $obj = array(
         'network' => $params['network'],
         'ip_address' => $params['ip_address'],
         'port' => $params['port'] ? $params['port'] : NULL,
         'username' => $params['username'] ? $params['username'] : NULL,
         'password' => $params['password'] ? $params['password'] : NULL,
         'location' => $params['location'] ? $params['location'] : NULL,
         'status' => $params['status'],
         'user_id' => $params['user_id']
      );
      return $this->db->update('proxy', $obj, array('id' => $params['id']));
   }

   public function bulk_action($params){
      $count = 0;
      if($params['mode'] == 'status'){
         foreach ($params['data'] as $v) {
            $obj = array(
               'status' => $params['value']
            );
            $this->db->where('id', $v);
            $rs = $this->db->update('proxy', $obj);
            $rs ? $count++ : FALSE;
         }
      }
      return $count;
   }

   public function delete($params){
      return $this->db->delete('proxy', array('id' => $params['id']));
   }

   public function check_duplicate_proxy($params, $mode){
      if($mode == 'create'){
         $this->db->where('ip_address', $params['ip_address']);
         $this->db->where('port', $params['port']);
         $rs = $this->db->count_all_results('proxy');
         return $rs > 0 ? FALSE : TRUE;
      }
      if($mode == 'change'){
         if($params['ip_address'] != $params['ip_address_before'] && $params['port'] != $params['port_before']){
            $this->db->where('ip_address', $params['ip_address']);
            $this->db->where('port', $params['port']);
            $rs = $this->db->count_all_results('proxy');
            return $rs > 0 ? FALSE : TRUE;
         }else{
            return TRUE;
         }
      }
   }
}

?>