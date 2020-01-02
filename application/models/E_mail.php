<?php

class E_mail extends CI_Model
{
	
	public function get_data_email($mode,$params){
		$this->db->select('a.*');
		$this->db->order_by('a.id','ASC');

		if($params['search_phone']!=""){
			$this->db->where('a.phone_number',$params['search_phone']);
		}

		if($params['search_status']!=""){
			$this->db->where('a.status',$params['search_status']);
		}

		switch ($mode) {
			case 'get':
				return $this->db->get('email as a',10,$params['offset'])->result_array();
			case 'count':
				return $this->db->get('email as a')->num_rows();
		}
	}

	public function get_user($user_id){
		$this->db->select('b.first_name');
		$this->db->join('users as b','b.id=a.user_id');
		$this->db->where('b.id',$user_id);
		return $this->db->get('email as a')->result_array();
	}

	public function input_data($params){
    	$phone_number = $params['phone_number'];
    	$email = $params['emails'];
    	$password = $params['pass'];
    	$created_date = $params['created_date'];
    	$birth_day = $params['birth_day'];
    	$status = 0;

	    	if($status=="2"){
	    		$info = "Blocked";  
	    	}else{
	    		$info = "";
	    	}

    	$user_id = $params['user_id'];

        $hasil=$this->db->query("INSERT INTO email (phone_number,email,password,created_date,birth_day,status,info,user_id) VALUES ('$phone_number','$email','$password','$created_date','$birth_day','$status','$info','$user_id')");
        
        if($hasil){
        	 return $hasil;    
        }else{
        	return false;
        }

    }

    public function update_data($params){
    	$id = $params['id_email'];
    	$phone_number = $params['phone_number'];
    	$email = $params['email'];
    	$birth = $params['birth_day'];
    	$stat = $params['statuss'];

        if($stat==2){
            $info = "Blocked";
        }else{
            $info = "";
        }

        $hasil=$this->db->query("UPDATE email SET phone_number='$phone_number',email='$email',birth_day='$birth',status='$stat', info='$info' WHERE id='$id'");
        if($hasil){
        	 return $hasil;    
        }else{
        	return false;
        }
    }

    public function change_passwords($params){
    	$id = $params['id'];
    	$password = $params['password'];

    	$hasil=$this->db->query("UPDATE email SET password='$password' WHERE id='$id'");
        if($hasil){
        	 return $hasil;    
        }else{
        	return false;
        }
    }

	public function delete_data($email_id){
        $hasil=$this->db->query("DELETE FROM email WHERE id='$email_id'");
        if($hasil){
        	return $hasil;
        }else{
        	return false;
        }
    }
}
?>