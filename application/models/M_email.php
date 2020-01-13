<?php

class M_email extends CI_Model{
   
   public function _logging($module, $action, $phone_number, $user_id){
      $id = $this->db->select('id')->where('phone_number', $phone_number)->get('email')->row_array();
      $obj = array(
         'log_module' => $module,
         'log_action' => $action,
         'log_module_id' => $id['id'],
         'log_user_id' => $user_id
      );
      $this->db->insert('log', $obj);
   }

   public function get($mode,$params){
      $itemspage = $params['filter_rows'] == '' ? 10 : $params['filter_rows'];

      $this->db->select('a.*, b.status as status_phone_number, u.first_name as pic, g.first_name as pic_updated');
      $this->db->join('simcard as b','a.phone_number = b.phone_number', 'left');
      $this->db->join('users as u','u.id = a.user_id', 'left');
      $this->db->join('users as g','a.updated_user_id = g.id', 'left');

      if($params['filter_keyword'] != ""){
         $this->db->group_start();
         $this->db->like('a.phone_number', $params['filter_keyword']);
         $this->db->or_like('a.email', $params['filter_keyword']);
         $this->db->or_like('a.password', $params['filter_keyword']);
         $this->db->or_like('a.status', $params['filter_keyword']);
         $this->db->or_like('a.info', $params['filter_keyword']);
         $this->db->or_like('u.first_name', $params['filter_keyword']);
         $this->db->group_end();
      }

      if($params['filter_status'] != ""){
         $this->db->where('a.status', $params['filter_status']);
      }
      if($params['filter_status_simcard'] != ""){
         $this->db->where('b.status', $params['filter_status_simcard']);
      }

      if($params['filter_type'] != ""){
         $this->db->where('b.phone_number_type', $params['filter_type']);
      }

      $this->db->order_by('a.created_date', 'desc');
      switch ($mode) {
         case 'get':
            return $this->db->get('email as a', $itemspage, $params['offset'])->result_array();
         case 'count':
            return $this->db->get('email as a')->num_rows();
      }
   }

   public function get_phone_number($params){
      $this->db->select('a.phone_number, a.phone_number_type, b.product as provider_name');
      $this->db->join('provider as b', 'a.provider_id = b.id');
      $this->db->where('a.registered', 0);
      $this->db->where('a.status', 1);
      $this->db->where('a.rak_id IS NOT NULL');
      $this->db->order_by('a.created_date', 'desc');
      if($params['with_choosed']){
         $this->db->or_where('a.phone_number', $params['with_choosed']);
      }
      return $this->db->get('simcard as a')->result_array();
   }

   public function find_phone($params){
      $this->db->select('a.registered, a.phone_number, a.phone_number_type, a.expired_date, b.product as provider_name');
      $this->db->join('provider as b', 'a.provider_id = b.id', 'left');
      $this->db->where('a.phone_number', $params['phone']);
      return $this->db->get('simcard as a')->row_array();
   }

   public function create($params){
      $obj = array(
         'phone_number' => $params['phone_number'],
         'phone_number_type' => $params['phone_number_type'],
         'email' => $params['email'],
         'created_date' => date('Y-m-d H:i:s'),
         'display_name' => $params['display_name'],
         'password' => $params['password'],
         'birth_day' => $params['birth_day'] ? $params['birth_day'] : NULL,
         'status' => $params['status'],
         'info' => $params['info'] != '' ? $params['info'] : NULL,
         'user_id' => $params['user_id'],
      );
      $rs = $this->db->insert('email', $obj);
      if($rs){
         $this->_logging('email', 'create', $params['phone_number'], $params['user_id']);
         $obj_phone_number = array(
            'registered' => 1
         );
         $rs_registered = $this->db->update('simcard', $obj_phone_number, array('phone_number' => $params['phone_number']));
         return $rs_registered ? TRUE : FALSE;
      }else{
         return FALSE;
      }
   }

   public function change($params){
      $obj = array(
         'phone_number' => $params['phone_number'],
         'phone_number_type' => $params['phone_number_type'],
         'email' => $params['email'],
         'display_name' => $params['display_name'],
         'password' => $params['password'],
         'birth_day' => $params['birth_day'] ? $params['birth_day'] : NULL,
         'status' => $params['status'],
         'info' => $params['info'] != '' ? $params['info'] : NULL,
         'updated_user_id' => $params['user_id'],
         'updated_date' => date('Y-m-d H:i:s')
      );
      $rs = $this->db->update('email', $obj, array('id' => $params['id']));
      if($rs){
         if($params['phone_number'] != $params['phone_number_before']){
            $this->db->update('simcard', array('registered' => 0), array('phone_number' => $params['phone_number_before']));
         }
         $obj_phone_number = array(
            'registered' => 1
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
         $this->db->update('simcard', array('registered' => 0), array('phone_number' => $params['phone_number']));
      }
      return $this->db->delete('email', array('id' => $params['id']));
   }

   public function bulk_action($params){
      $count = 0;
      if($params['mode'] == 'status'){
         foreach ($params['data'] as $v) {
            $obj = array(
               'status' => $params['value']
            );
            $this->db->where('id', $v);
            $rs = $this->db->update('email', $obj);
            $rs ? $count++ : FALSE;
         }
      }
      // if($params['mode'] == 'type'){
      //    foreach ($params['data'] as $v) {
      //       $obj = array(
      //          'phone_number_type' => $params['value']
      //       );
      //       $this->db->where('phone_number', $v);
      //       $rs = $this->db->update('simcard', $obj);
      //       $rs ? $count++ : FALSE;
      //    }
      // }
      return $count;
   }



	// public function get_data_email($mode,$params){
	// 	$this->db->select('a.*, b.username as username_pembuat, c.status as status_phone');
 //      $this->db->join('users as b', 'a.user_id = b.id', 'left');
 //      $this->db->join('simcard as c', 'a.phone_number = c.phone_number', 'left');

 //      if($params['search_name'] != ""){
 //         $this->db->group_start();
 //         $this->db->like('a.phone_number', $params['search_name']);
 //         $this->db->or_like('a.password', $params['search_name']);
 //         $this->db->or_like('a.email', $params['search_name']);
 //         $this->db->or_like('b.username', $params['search_name']);
 //         $this->db->group_end();
 //      }

 //      if($params['search_status']!=""){
 //         $this->db->where('a.status', $params['search_status']);
 //      }

	// 	$this->db->order_by('a.id','ASC');
	// 	switch ($mode) {
	// 		case 'get':
	// 			return $this->db->get('email as a', 10, $params['offset'])->result_array();
	// 		case 'count':
	// 			return $this->db->get('email as a')->num_rows();
	// 	}
	// }

	// public function input_data($params){
 //      $obj = array(
 //         'phone_number' => $params['phone_number'],
 //         'email' => $params['emails'],
 //         'password' => $params['pass'],
 //         'created_date' => $params['created_date'],
 //         'birth_day' => $params['birth_day'],
 //         'status' => $params['status'],
 //         'info' => $params['status'] == 2 ? 'Blocked' : NULL,
 //         'user_id' => $params['user_id'],
            
 //      );
 //      $hasil = $this->db->insert('email', $obj);
 //      if($hasil){
 //         if($params['status'] != 0){
 //            $obj_phone_number = array(
 //               'registered' => 1
 //            );
 //            $rs_registered = $this->db->update('simcard', $obj_phone_number, array('phone_number' => $params['phone_number']));
 //            return $rs_registered ? TRUE : FALSE;
 //         }else{
 //            return $hasil;
 //         }
 //      }else{
 //     	   return FALSE;
 //      }

 //   }

 //   public function update_data($params){
 //      $obj = array(
 //         'phone_number' => $params['phone_number'],
 //         'email' => $params['email'],
 //         'password' => $params['password'],
 //         'birth_day' => $params['birth_day'],
 //         'status' => $params['status'],
 //         'user_id' => $params['user_id'],
 //         'info' => $params['status'] == 2 ? 'Blocked' : NULL
 //      );

 //      $where = array(
 //         'id' => $params['id_email']
 //      );

 //      $hasil = $this->db->update('email', $obj, $where);

 //      if($hasil){
 //         $this->db->update('simcard', array('registered' => 0), array('phone_number' => $params['phone_number_before']));  
 //         if($params['status'] != 0){
 //            $this->db->update('simcard', array('registered' => 1), array('phone_number' => $params['phone_number']));   
 //         }
 //         return $hasil; 
 //      }else{
 //     	   return false;
 //      }
 //    }

	// public function delete_data($params){

 //      $where = array(
 //         'id' => $params['no']
 //      );

 //      $this->db->update('simcard', array('registered' => 0), array('phone_number' => $params['phone_number']));
 //      $hasil = $this->db->delete('email', $where);

 //      if($hasil){
 //     	   return $hasil;
 //      }else{
 //     	   return false;
 //      }
 //   }
}
?>