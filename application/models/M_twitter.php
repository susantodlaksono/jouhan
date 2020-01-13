<?php

class M_twitter extends CI_Model{

   public function get($mode,$params){
      $itemspage = $params['filter_rows'] == '' ? 10 : $params['filter_rows'];

      $this->db->select('a.*, b.status as status_phone_number, b.expired_date,
                        c.name as status_name, c.parent, d.name as client_name, 
                        e.ip_address, e.status as status_ip_address, e.port, 
                        f.first_name as pic, g.first_name as pic_updated');
      $this->db->join('simcard as b','a.phone_number = b.phone_number', 'left');
      $this->db->join('twitter_status_detail as c','a.status = c.id', 'left');
      $this->db->join('client as d','a.client_id = d.id', 'left');
      $this->db->join('proxy as e','a.proxy_id = e.id', 'left');
      $this->db->join('users as f','a.user_id = f.id', 'left');
      $this->db->join('users as g','a.updated_user_id = g.id', 'left');

      if($params['filter_keyword'] != ""){
         $this->db->group_start();
         $this->db->like('a.phone_number', $params['filter_keyword']);
         $this->db->or_like('a.display_name', $params['filter_keyword']);
         $this->db->or_like('a.screen_name', $params['filter_keyword']);
         $this->db->or_like('a.password', $params['filter_keyword']);
         $this->db->or_like('a.cookies', $params['filter_keyword']);
         $this->db->or_like('a.twitter_id', $params['filter_keyword']);
         $this->db->or_like('a.followers', $params['filter_keyword']);
         $this->db->or_like('a.apps_id', $params['filter_keyword']);
         $this->db->or_like('a.apps_name', $params['filter_keyword']);
         $this->db->or_like('a.consumer_key', $params['filter_keyword']);
         $this->db->or_like('a.consumer_secret', $params['filter_keyword']);
         $this->db->or_like('a.access_token', $params['filter_keyword']);
         $this->db->or_like('a.access_token_secret', $params['filter_keyword']);
         $this->db->or_like('d.name', $params['filter_keyword']);
         $this->db->or_like('e.ip_address', $params['filter_keyword']);
         $this->db->or_like('f.first_name', $params['filter_keyword']);
         $this->db->group_end();
      }

      if($params['filter_status']){
         $this->db->where_in('a.status', $params['filter_status']);
      }
      if($params['filter_client']){
         if(in_array(0, $params['filter_client'])){
            $this->db->where('a.client_id IS NULL');
         }else{
            $this->db->where_in('a.client_id', $params['filter_client']);
         }
      }

      if($params['filter_expireddate_sdate'] !== '' && $params['filter_expireddate_edate'] !== ''){
         $this->db->where('date(b.expired_date) between "'.$params['filter_expireddate_sdate'].'" and "'.$params['filter_expireddate_edate'].'"');
      }
      if($params['filter_createddate_sdate'] !== '' && $params['filter_createddate_edate'] !== ''){
         $this->db->where('date(a.created_twitter) between "'.$params['filter_createddate_sdate'].'" and "'.$params['filter_createddate_edate'].'"');
      }
      
      $this->db->order_by($params['filter_sort'], $params['filter_sort_type']);
      switch ($mode) {
         case 'get':
            return $this->db->get('twitter as a', $itemspage, $params['offset'])->result_array();
         case 'count':
            return $this->db->get('twitter as a')->num_rows();
      }
   }

	public function get_phone_number($params){
      $this->db->select('a.phone_number, a.email, a.display_name, a.birth_day');
      $this->db->join('simcard as b', 'a.phone_number = b.phone_number', 'left');
      $this->db->where('b.registered_twitter', 0);
      $this->db->where('a.status', 1);
      $this->db->where('b.status', 1);
      $this->db->where('b.rak_id IS NOT NULL');
      $this->db->order_by('a.id', 'desc');

      if($params['with_choosed']){
         $this->db->or_where('a.phone_number', $params['with_choosed']);
      }
      return $this->db->get('email as a')->result_array();
	}

	public function create($params){
      $obj = array(
         'phone_number' => $params['phone_number'],
         'display_name' => $params['display_name'],
         'screen_name' => strtolower($params['screen_name']),
         'password' => $params['password'],
         'created_date' => date('Y-m-d H:i:s'),
         'created_twitter' => $params['created_twitter'] ? $params['created_twitter'] : NULL,
         'birth_date' => $params['birth_date'] ? $params['birth_date'] : NULL,
         'cookies' => $params['cookies'] ? $params['cookies'] : NULL,
         'twitter_id' => $params['twitter_id'] ? $params['twitter_id'] : NULL,
         'followers' => $params['followers'] ? $params['followers'] : NULL,
         'status' => $params['status'] ? $params['status'] : NULL,
         'apps_id' => $params['apps_id'] ? $params['apps_id'] : NULL,
         'apps_name' => $params['apps_name'] ? $params['apps_name'] : NULL,
         'consumer_key' => $params['consumer_key'] ? $params['consumer_key'] : NULL,
         'consumer_secret' => $params['consumer_secret'] ? $params['consumer_secret'] : NULL,
         'access_token' => $params['access_token'] ? $params['access_token'] : NULL,
         'access_token_secret' => $params['access_token_secret'] ? $params['access_token_secret'] : NULL,
         'client_id' => $params['client_id'] ? $params['client_id'] : NULL,
         'proxy_id' => $params['proxy_id'] ? $params['proxy_id'] : NULL,
         'user_id' => $params['user_id'],
         'info' => $params['info'] ? $params['info'] : NULL
      );
      $rs = $this->db->insert('twitter', $obj);
      if($rs){
         $this->_logging('twitter', 'create', $this->get_id($params['phone_number']), $params['user_id']);
         $registered = array(
            'registered_twitter' => 1
         );
         $rs_registered = $this->db->update('simcard', $registered, array('phone_number' => $params['phone_number']));
         return $rs_registered ? TRUE : FALSE;
      }else{
         return FALSE;
      }
   }

   public function change($params){
      $obj = array(
         'phone_number' => $params['phone_number'],
         'display_name' => $params['display_name'],
         'screen_name' => strtolower($params['screen_name']),
         'password' => $params['password'],
         'created_twitter' => $params['created_twitter'] ? $params['created_twitter'] : NULL,
         'birth_date' => $params['birth_date'] ? $params['birth_date'] : NULL,
         'cookies' => $params['cookies'] ? $params['cookies'] : NULL,
         'twitter_id' => $params['twitter_id'] ? $params['twitter_id'] : NULL,
         'followers' => $params['followers'] ? $params['followers'] : NULL,
         'status' => $params['status'] ? $params['status'] : NULL,
         'apps_id' => $params['apps_id'] ? $params['apps_id'] : NULL,
         'apps_name' => $params['apps_name'] ? $params['apps_name'] : NULL,
         'consumer_key' => $params['consumer_key'] ? $params['consumer_key'] : NULL,
         'consumer_secret' => $params['consumer_secret'] ? $params['consumer_secret'] : NULL,
         'access_token' => $params['access_token'] ? $params['access_token'] : NULL,
         'access_token_secret' => $params['access_token_secret'] ? $params['access_token_secret'] : NULL,
         'client_id' => $params['client_id'] ? $params['client_id'] : NULL,   
         'proxy_id' => $params['proxy_id'] ? $params['proxy_id'] : NULL,
         'info' => $params['info'] ? $params['info'] : NULL,
         'updated_user_id' => $params['user_id'],
         'updated_date' => date('Y-m-d H:i:s')
      );
      $rs = $this->db->update('twitter', $obj, array('id' => $params['id']));
      if($rs){
         if($params['phone_number'] != $params['phone_number_before']){
            $this->db->update('simcard', array('registered_twitter' => 0), array('phone_number' => $params['phone_number_before']));
         }
         $obj_phone_number = array(
            'registered_twitter' => 1
         );
         $rs_registered = $this->db->update('simcard', $obj_phone_number, array('phone_number' => $params['phone_number']));
         return $rs_registered ? TRUE : FALSE;
      }else{
         return FALSE;
      }
   }

   public function delete($params){
      $where = array(
         'id' => $params['id']
      );
      if($params['phone_number'] != ''){
         $this->db->update('simcard', array('registered_twitter' => 0), array('phone_number' => $params['phone_number']));
         
         if(in_array(2, $params['mode'])){
            $this->db->delete('email', array('phone_number' => $params['phone_number']));
            $this->db->update('simcard', array('registered' => 0), array('phone_number' => $params['phone_number']));
         }
         if(in_array(3, $params['mode'])){
            $this->db->delete('simcard', array('phone_number' => $params['phone_number']));
         }
      }

      return $this->db->delete('twitter', array('id' => $params['id']));
   }

   public function get_id($phone_number){
   	$this->db->select('id');
   	$this->db->where('phone_number', $phone_number);
   	$rs = $this->db->get('twitter')->row_array();
   	return $rs['id'];
   }

   public function _logging($module, $action, $id, $user_id){
      $obj = array(
         'log_module' => $module,
         'log_action' => $action,
         'log_module_id' => $id,
         'log_user_id' => $user_id
      );
      $this->db->insert('log', $obj);
   }

   public function bulk_action($params){
      $count = 0;
      if($params['mode'] == 'status'){
         foreach ($params['data'] as $v) {
            $obj = array(
               'status' => $params['value']
            );
            $this->db->where('id', $v);
            $rs = $this->db->update('twitter', $obj);
            $rs ? $count++ : FALSE;
         }
      }
      return $count;
   }

   public function assign_client($params){
      $count = 0;
      foreach ($params['data'] as $v) {
         $obj = array(
            'client_id' => $params['assign_client']
         );
         $this->db->where('id', $v);
         $rs = $this->db->update('twitter', $obj);
         $rs ? $count++ : FALSE;
      }
      return $count;
   }

   public function find_phone($params){
      $this->db->select('b.display_name, b.birth_day, b.email, a.registered_twitter as registered_twitter, a.registered as registered, a.phone_number, a.phone_number_type, a.expired_date');
      $this->db->join('email as b', 'a.phone_number = b.phone_number', 'left');
      $this->db->where('a.phone_number', $params['phone']);
      return $this->db->get('simcard as a')->row_array();
   }

}