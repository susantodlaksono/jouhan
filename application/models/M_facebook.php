<?php

class M_facebook extends CI_Model{

   public function on_duplicate($table, $data, $exclude = array(), $db = 'default') {
      $this->_db = $this->load->database($db, TRUE);
      $updatestr = array();
      foreach ($data as $k => $v) {
         if (!in_array($k, $exclude)) {
            // $updatestr[] = '`' . $k . '`="' . mysql_real_escape_string($v) . '"'; // local
            // $updatestr[] = '`' . $k . '`="' . mysql_escape_string($v) . '"'; // server
            $updatestr[] = '`' . $k . '`="' . $this->db->escape_str($v) . '"'; // local
         }
      }
      $query = $this->_db->insert_string($table, $data);
      $query .= ' ON DUPLICATE KEY UPDATE ' . implode(', ', array_filter($updatestr));
      $this->_db->query($query);
      return $this->_db->affected_rows();
   }

   public function get($mode,$params){
      $itemspage = $params['filter_rows'] == '' ? 10 : $params['filter_rows'];

      $this->db->select('a.*, b.status as status_phone_number, b.expired_date, d.name as client_name, 
                        e.ip_address, e.status as status_ip_address, e.port, 
                        f.first_name as pic, g.first_name as pic_updated');
      $this->db->join('simcard as b','a.phone_number = b.phone_number', 'left');
      $this->db->join('client as d','a.client_id = d.id', 'left');
      $this->db->join('proxy as e','a.proxy_id = e.id', 'left');
      $this->db->join('users as f','a.user_id = f.id', 'left');
      $this->db->join('users as g','a.updated_user_id = g.id', 'left');

      if($params['filter_keyword'] != ""){
         $this->db->group_start();
         $this->db->like('a.phone_number', $params['filter_keyword']);
         $this->db->or_like('a.display_name', $params['filter_keyword']);
         $this->db->or_like('a.url', $params['filter_keyword']);
         $this->db->or_like('a.facebook_id', $params['filter_keyword']);
         $this->db->or_like('a.password', $params['filter_keyword']);
         $this->db->or_like('a.cookies', $params['filter_keyword']);
         $this->db->or_like('a.access_token', $params['filter_keyword']);
         $this->db->or_like('a.friends', $params['filter_keyword']);
         $this->db->or_like('a.info', $params['filter_keyword']);
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
         $this->db->where('date(a.created_facebook) between "'.$params['filter_createddate_sdate'].'" and "'.$params['filter_createddate_edate'].'"');
      }
      
      $this->db->order_by($params['filter_sort'], $params['filter_sort_type']);
      switch ($mode) {
         case 'get':
            return $this->db->get('facebook as a', $itemspage, $params['offset'])->result_array();
         case 'count':
            return $this->db->get('facebook as a')->num_rows();
      }
   }

   public function get_fanspage($mode,$params){
      $itemspage = $params['filter_rows'] == '' ? 10 : $params['filter_rows'];

      $this->db->select('a.*, c.first_name as pic, d.name as client_name, g.first_name as pic_updated');
      // $this->db->join('facebook as b','a.admin_url_id = b.id', 'left');
      // $this->db->join('facebook_fanspage_admin as b','a.id = b.fanspage_id', 'left');
      // $this->db->join('facebook as e','b.facebook_id = e.id', 'left');
      $this->db->join('client as d','a.client_id = d.id', 'left');
      $this->db->join('users as c','a.user_id = c.id', 'left');
      $this->db->join('users as g','a.updated_user_id = g.id', 'left');

      if($params['filter_keyword'] != ""){
         $this->db->group_start();
         $this->db->like('a.name', $params['filter_keyword']);
         $this->db->or_like('a.url', $params['filter_keyword']);
         $this->db->or_like('a.followers', $params['filter_keyword']);
         // $this->db->or_like('e.display_name', $params['filter_keyword']);
         // $this->db->or_like('e.url', $params['filter_keyword']);
         // $this->db->or_like('b.url', $params['filter_keyword']);
         $this->db->or_like('c.first_name', $params['filter_keyword']);
         $this->db->group_end();
      }

      if($params['filter_client']){
         if(in_array(0, $params['filter_client'])){
            $this->db->where('a.client_id IS NULL');
         }else{
            $this->db->where_in('a.client_id', $params['filter_client']);
         }
      }

      if($params['filter_status']){
         if(in_array(0, $params['filter_status'])){
            $this->db->where('a.status IS NULL');
         }else{
            $this->db->where_in('a.status', $params['filter_status']);
         }
      }

      $this->db->order_by($params['filter_sort'], $params['filter_sort_type']);
      switch ($mode) {
         case 'get':
            return $this->db->get('facebook_fanspage as a', $itemspage, $params['offset'])->result_array();
         case 'count':
            return $this->db->get('facebook_fanspage as a')->num_rows();
      }
   }

   public function get_fanspage_admin($fanspage_id) {
      $this->db->select('b.display_name, b.url');
      $this->db->join('facebook as b', 'a.facebook_id = b.id');
      $this->db->where('a.fanspage_id', $fanspage_id);
      return $this->db->get('facebook_fanspage_admin as a')->result_array();
   }

   public function get_facebook_list($params){
      $this->db->select('a.id, a.display_name, a.url');
      $this->db->where('a.registered_admin_fanspage', NULL);
      $this->db->order_by('a.id', 'desc');

      if($params['with_choosed']){
         foreach ($params['with_choosed'] as $v) {
            $this->db->or_where('a.id', $v);
         }
      }
      return $this->db->get('facebook as a')->result_array();
   }

   public function get_phone_number($params){
      $this->db->select('a.phone_number, a.email, a.display_name, a.birth_day');
      $this->db->join('simcard as b', 'a.phone_number = b.phone_number', 'left');
      $this->db->where('b.registered_facebook', 0);
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
         'url' => 'https://www.facebook.com/'.$params['url'],
         'birth_date' => $params['birth_date'],
         'created_facebook' => $params['created_facebook'],
         'facebook_id' => $params['facebook_id'] ? $params['facebook_id'] : NULL,
         'password' => $params['password'],
         'cookies' => $params['cookies'] ? $params['cookies'] : NULL,
         'access_token' => $params['access_token'] ? $params['access_token'] : NULL,
         'friends' => $params['friends'] ? $params['friends'] : NULL,
         'status' => $params['status'] ? $params['status'] : NULL,
         'info' => $params['info'] ? $params['info'] : NULL,
         'client_id' => $params['client_id'] ? $params['client_id'] : NULL,
         'proxy_id' => $params['proxy_id'] ? $params['proxy_id'] : NULL,
         'user_id' => $params['user_id']
      );
      $rs = $this->db->insert('facebook', $obj);
      if($rs){
         $this->_logging('facebook', 'create', $this->get_id($params['phone_number']), $params['user_id']);
         $registered = array(
            'registered_facebook' => 1
         );
         $rs_registered = $this->db->update('simcard', $registered, array('phone_number' => $params['phone_number']));
         return $rs_registered ? TRUE : FALSE;
      }else{
         return FALSE;
      }
   }

   public function create_fanspage($params){
      $reg1 = 0;
      $obj = array(
         'name' => $params['name'],
         'url' => $params['url'],
         'followers' => $params['followers'] ? $params['followers'] : NULL,
         'likes' => $params['likes'] ? $params['likes'] : NULL,
         'status' => $params['status'] ? $params['status'] : NULL,
         'info' => $params['info'] ? $params['info'] : NULL,
         'client_id' => $params['client_id'] ? $params['client_id'] : NULL,
         'created_fanspage' => date('Y-m-d', strtotime($params['created_fanspage'])),
         'user_id' => $params['user_id']
      );
      $rs = $this->db->insert('facebook_fanspage', $obj);
      $insert_id = $this->db->insert_id();
      if($rs){
         foreach ($params['admin_url'] as $v) {
            $tmp = array(
               'fanspage_id' => $insert_id,
               'facebook_id' => $v
            );
            $facebook_fanspage_admin = $this->on_duplicate('facebook_fanspage_admin', array_filter($tmp));
            $facebook_fanspage_admin ? $reg1++ : NULL;
         }
         if($reg1 > 0){
            return TRUE;
         }else{
            return FALSE;
         }
      }else{
         return FALSE;
      }
   }

   public function change($params){
      $obj = array(
         'phone_number' => $params['phone_number'],
         'display_name' => $params['display_name'],
         'url' => $params['url_facebook'],
         'birth_date' => $params['birth_date'],
         'created_facebook' => $params['created_facebook'],
         'facebook_id' => $params['facebook_id'] ? $params['facebook_id'] : NULL,
         'password' => $params['password'],
         'cookies' => $params['cookies'] ? $params['cookies'] : NULL,
         'access_token' => $params['access_token'] ? $params['access_token'] : NULL,
         'friends' => $params['friends'] ? $params['friends'] : NULL,
         'status' => $params['status'] ? $params['status'] : NULL,
         'info' => $params['info'] ? $params['info'] : NULL,
         'client_id' => $params['client_id'] ? $params['client_id'] : NULL,
         'proxy_id' => $params['proxy_id'] ? $params['proxy_id'] : NULL,
         'updated_user_id' => $params['user_id'],
         'updated_date' => date('Y-m-d H:i:s')
      );
      $rs = $this->db->update('facebook', $obj, array('id' => $params['id']));
      if($rs){
         if($params['phone_number'] != $params['phone_number_before']){
            $this->db->update('simcard', array('registered_facebook' => 0), array('phone_number' => $params['phone_number_before']));
         }
         $obj_phone_number = array(
            'registered_facebook' => 1
         );
         $rs_registered = $this->db->update('simcard', $obj_phone_number, array('phone_number' => $params['phone_number']));
         return $rs_registered ? TRUE : FALSE;
      }else{
         return FALSE;
      }
   }

   public function change_fanspage($params){
      $reg1 = 0;
      $obj = array(
         'name' => $params['name'],
         'url' => $params['url'],
         'followers' => $params['followers'] ? $params['followers'] : NULL,
         'likes' => $params['likes'] ? $params['likes'] : NULL,
         'status' => $params['status'] ? $params['status'] : NULL,
         'info' => $params['info'] ? $params['info'] : NULL,
         'client_id' => $params['client_id'] ? $params['client_id'] : NULL,
         'updated_date' => date('Y-m-d H:i:s'),
         'created_fanspage' => date('Y-m-d', strtotime($params['created_fanspage'])),
         'updated_user_id' => $params['user_id']
      );
      $rs = $this->db->update('facebook_fanspage', $obj, array('id' => $params['id']));
      if($rs){
         foreach ($params['fanspage_admin_before'] as $v) {
            $this->db->delete('facebook_fanspage_admin',array('facebook_id' => $v, 'fanspage_id' => $params['id']));
         }
         foreach ($params['admin_url'] as $v) {
            $tmp = array(
               'fanspage_id' => $params['id'],
               'facebook_id' => $v
            );
            $facebook_fanspage_admin = $this->db->insert('facebook_fanspage_admin', $tmp);
            $facebook_fanspage_admin ? $reg1++ : NULL;
         }
         if($reg1 > 0){
            return TRUE;
         }else{
            return FALSE;
         }
      }else{
         return FALSE;
      }
   }

   public function delete($params){
      $where = array(
         'id' => $params['id']
      );
      if($params['phone_number'] != ''){
         $this->db->update('simcard', array('registered_facebook' => 0), array('phone_number' => $params['phone_number']));
         
         if(in_array(2, $params['mode'])){
            $this->db->delete('email', array('phone_number' => $params['phone_number']));
            $this->db->update('simcard', array('registered' => 0), array('phone_number' => $params['phone_number']));
         }
         if(in_array(3, $params['mode'])){
            $this->db->delete('simcard', array('phone_number' => $params['phone_number']));
         }
      }

      return $this->db->delete('facebook', array('id' => $params['id']));
   }

   public function delete_fanspage($params){
      $rs = $this->db->delete('facebook_fanspage', array('id' => $params['id']));
      if($rs){
         return TRUE;
      }else{
         return FALSE;
      }
   }

   public function get_id($phone_number){
      $this->db->select('id');
      $this->db->where('phone_number', $phone_number);
      $rs = $this->db->get('facebook')->row_array();
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
            $rs = $this->db->update('facebook', $obj);
            $rs ? $count++ : FALSE;
         }
      }
      return $count;
   }

   public function find_phone($params){
      $this->db->select('b.display_name, b.birth_day, b.email, a.registered_facebook as registered_facebook, a.registered as registered, a.phone_number, a.phone_number_type, a.expired_date');
      $this->db->join('email as b', 'a.phone_number = b.phone_number', 'left');
      $this->db->where('a.phone_number', $params['phone']);
      return $this->db->get('simcard as a')->row_array();
   }

   public function assign_client($params){
      $count = 0;
      foreach ($params['data'] as $v) {
         $obj = array(
            'client_id' => $params['assign_client']
         );
         $this->db->where('id', $v);
         $rs = $this->db->update('facebook', $obj);
         $rs ? $count++ : FALSE;
      }
      return $count;
   }

}