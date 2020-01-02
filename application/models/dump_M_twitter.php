<?php

class M_twitter extends CI_Model{
	
	public function get_phone_number($params){
      $this->db->select('a.phone_number, b.email');
      $this->db->join('email as b', 'a.phone_number = b.phone_number');
      $this->db->where('a.registered_twitter', 0);
      $this->db->where('a.status', 1);
      $this->db->where('b.status', 1);
      if($params['with_choosed']){
         $this->db->or_where('a.phone_number', $params['with_choosed']);
      }
      return $this->db->get('simcard as a')->result_array();
   }

	public function get_data_twitter($mode,$params){
		$this->db->select('a.*, d.email as email_name, d.status as status_email, c.first_name as pic, b.status as status_phone');
		$this->db->join('simcard as b', 'a.phone_number = b.phone_number', 'left');
      $this->db->join('email as d', 'b.phone_number = d.phone_number', 'left');
      $this->db->join('users as c', 'a.user_id = c.id', 'left');
		if($params['filter_keyword'] != ""){
         $this->db->group_start();
         $this->db->like('a.phone_number', $params['filter_keyword']);
         $this->db->or_like('a.display_name', $params['filter_keyword']);
         $this->db->or_like('a.screen_name', $params['filter_keyword']);
         $this->db->or_like('a.password', $params['filter_keyword']);
         $this->db->or_like('a.cookies', $params['filter_keyword']);
         $this->db->or_like('a.twitter_id', $params['filter_keyword']);
         $this->db->or_like('a.followers', $params['filter_keyword']);
         $this->db->or_like('a.consumer_key', $params['filter_keyword']);
         $this->db->or_like('a.access_token', $params['filter_keyword']);
         $this->db->or_like('a.access_token_secret', $params['filter_keyword']);
         $this->db->or_like('a.ip_proxy', $params['filter_keyword']);
         $this->db->or_like('c.first_name', $params['filter_keyword']);
         $this->db->or_like('b.email', $params['filter_keyword']);
         $this->db->group_end();
      }
		if($params['filter_status']!=""){
			$this->db->where('a.status', $params['filter_status']);
		}
		$this->db->order_by('a.id', 'desc');
		switch ($mode) {
			case 'get':
				return $this->db->get('twitter as a', 10, $params['offset'])->result_array();
			case 'count':
				return $this->db->get('twitter as a')->num_rows();
		}
	}

    public function get_email($email_id){
        $this->db->select('b.email');
        $this->db->join('email as b','b.id=a.email_id');
        $this->db->where('b.id',$email_id);
        return $this->db->get('twitter as a')->result_array();
    }

	public function get_user($user_id){
		$this->db->select('b.first_name');
		$this->db->join('users as b','b.id=a.user_id');
		$this->db->where('b.id',$user_id);
		return $this->db->get('twitter as a')->result_array();
	}
	
	public function checking($params){
		$phone_number = $this->db->select('status')->where('phone_number', $params['phone_number'])->get('simcard')->row_array();
		if($phone_number['status'] == 1){
			$email = $this->db->select('status')->where('phone_number', $params['phone_number'])->get('email')->row_array();
			if($email['status'] == 1){
				return TRUE;
			}else{
				return FALSE;	
			}
		}else{
			return FALSE;
		}
	}
   
   public function input_data($params){
      $obj = array(
         'phone_number' => $params['phone_number'],
         'display_name' => $params['display_name'],
         'screen_name' => $params['screen_name'],
         'password' => $params['password'],
         'cookies' => $params['cookies'] ? $params['cookies'] : NULL,
         'twitter_id' => $params['twitter_id'],
         'followers' => $params['followers'] ? $params['followers'] : NULL,
         'status' => $params['status'],
         'consumer_key' => $params['consumer_key'] ? $params['consumer_key'] : NULL,
         'access_token' => $params['access_token'] ? $params['access_token'] : NULL,
         'access_token_secret' => $params['access_token_secret'] ? $params['access_token_secret'] : NULL,
         'ip_proxy' => $params['ip_proxy'] ? $params['ip_proxy'] : NULL,
         'apps_id' => $params['apps_id'] ? $params['apps_id'] : NULL,
         'apps_name' => $params['apps_name'] ? $params['apps_name'] : NULL,
         'consumer_secret' => $params['consumer_secret'] ? $params['consumer_secret'] : NULL,
         'user_id' => $params['user_id'],
            
      );
      $result = $this->db->insert('twitter', $obj);
      if($result){
         if($params['status'] != 0){
            $obj_phone_number = array(
               'registered_twitter' => 1
            );
            $rs_registered = $this->db->update('simcard', $obj_phone_number, array('phone_number' => $params['phone_number']));
            return $rs_registered ? TRUE : FALSE;
         }else{
            return $result;
         }
      }else{
     	   return FALSE;
      }
   }

   // public function get_email_id($phone_number){
   // 	$this->db->select('id');
   // 	$this->db->where('phone_number', $phone_number);
   // 	$rs = $this->db->get('email')->row_array();
   // 	return $rs['id'];
   // }

   public function update_data($params){
      $obj = array(
         'phone_number' => $params['phone_number'],
         'display_name' => $params['display_name'],
         'screen_name' => $params['screen_name'],
         'password' => $params['password'],
         'cookies' => $params['cookies'] ? $params['cookies'] : NULL,
         'twitter_id' => $params['twitter_id'],
         'followers' => $params['followers'] ? $params['followers'] : NULL,
         'status' => $params['status'],
         'consumer_key' => $params['consumer_key'] ? $params['consumer_key'] : NULL,
         'access_token' => $params['access_token'] ? $params['access_token'] : NULL,
         'access_token_secret' => $params['access_token_secret'] ? $params['access_token_secret'] : NULL,
         'ip_proxy' => $params['ip_proxy'] ? $params['ip_proxy'] : NULL,
         'apps_id' => $params['apps_id'] ? $params['apps_id'] : NULL,
         'apps_name' => $params['apps_name'] ? $params['apps_name'] : NULL,
         'consumer_secret' => $params['consumer_secret'] ? $params['consumer_secret'] : NULL,
         'user_id' => $params['user_id'],
            
      );
      $result = $this->db->update('twitter', $obj, array('id' => $params['id']));
      if($result){
      	$this->db->update('simcard', array('registered_twitter' => 0), array('phone_number' => $params['phone_number_before']));  
         if($params['status'] != 0){
            $obj_phone_number = array(
               'registered_twitter' => 1
            );
            $rs_registered = $this->db->update('simcard', $obj_phone_number, array('phone_number' => $params['phone_number']));
            return $rs_registered ? TRUE : FALSE;
         }else{
            return $result;
         }
      }else{
     	   return FALSE;
      }
   }

 	public function delete_data($params){
     	$hasil = $this->db->delete('twitter', array('id' => $params['id']));
     	if($params['phone_number']){
     		$this->db->update('simcard', array('registered_twitter' => 0), array('phone_number' => $params['phone_number']));
     	}
     	if($hasil){
         return $hasil;
     	}else{
         return false;	
     	}
 	}

}
?>