<?php

class Facebooks extends CI_Model
{
	public function get_data($mode,$params){
		$this->db->select('a.*');
		$this->db->order_by('a.id','ASC');

		if($params['search_phone']!=""){
			$this->db->where('a.phone_number',$params['search_phone']);
		}

		if($params['search_status']!=""){
			$this->db->where('a.status',$params['search_status']);
		}

		if($params['search_name']!=""){
			$this->db->like('a.name',$params['search_name']);
		}

		if($params['search_username']!=""){
			$this->db->like('a.username',$params['search_username']);
		}

		switch ($mode) {
			case 'get':
				return $this->db->get('facebook as a',10,$params['offset'])->result_array();
			case 'count':
				return $this->db->get('facebook as a')->num_rows();
		}
	}

	public function get_email($email_id){
		$this->db->select('b.email');
		$this->db->join('email as b','b.id=a.email_id');
		$this->db->where('b.id',$email_id);
		return $this->db->get('facebook as a')->result_array();
	}

	public function get_user($user_id){
		$this->db->select('b.first_name');
		$this->db->join('users as b','b.id=a.user_id');
		$this->db->where('b.id',$user_id);
		return $this->db->get('facebook as a')->result_array();
	}

	public function input_data($params){
    	$phone_number = $params['phone_number'];
    	$name = $params['name'];
    	$name = $params['username'];
    	$email_id = $params['emails'];
    	$password = $params['password'];
    	$cookies = "";
    	$access_token = "";
    	$friends = 0;
    	$status = 0;
    	$created_date = $params['created_date'];
    	$user_id = $params['user_id'];

        $hasil=$this->db->query("INSERT INTO facebook (phone_number,name,username,email_id,password,cookies,access_token,friends,status,created_date,user_id) VALUES ('$phone_number','$name','$name','$email_id','$password','$cookies','$access_token','$friends','$status','$created_date','$user_id')");
        
        if($hasil){
        	 return $hasil;    
        }else{
        	return false;
        }

    }

    public function cek_email($email){
        $this->db->select('id');
        $this->db->where('email',$email);
        return $this->db->get('email')->row_array();
    }

    public function update_data($params){
    	$id = $params['id_facebook'];
    	$phone_number = $params['phone_number'];
    	$email = $params['emails'];
    	$name = $params['name'];
    	$username = $params['username'];
    	$status = $params['status'];
        $user = $params['user'];

        $hasil=$this->db->query("UPDATE facebook SET phone_number='$phone_number',name='$name',username='$username',email_id='$email',status='$status',user_id='$user' WHERE id='$id'");
        if($hasil){
        	 return $hasil;    
        }else{
        	return false;
        }
    }

    public function delete_data($id){
        $hasil=$this->db->query("DELETE FROM facebook WHERE id='$id'");
        if($hasil){
        	return $hasil;
        }else{
        	return false;
        }
    }

    public function change_passwords($params){
    	$id = $params['id'];
    	$password = $params['password'];

    	$hasil=$this->db->query("UPDATE facebook SET password='$password' WHERE id='$id'");
        if($hasil){
        	 return $hasil;    
        }else{
        	return false;
        }
    }

}
?>