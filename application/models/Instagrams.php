<?php

class Instagrams extends CI_Model
{
	
	public function get_data_instagram($mode,$params){
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
				return $this->db->get('instagram as a',10,$params['offset'])->result_array();
			case 'count':
				return $this->db->get('instagram as a')->num_rows();
		}
	}

    public function get_email($email_id){
        $this->db->select('b.email');
        $this->db->join('email as b','b.id=a.email_id');
        $this->db->where('b.id',$email_id);
        return $this->db->get('instagram as a')->result_array();
    }

	public function get_user($user_id){
		$this->db->select('b.first_name');
		$this->db->join('users as b','b.id=a.user_id');
		$this->db->where('b.id',$user_id);
		return $this->db->get('instagram as a')->result_array();
	}

    public function input_data($params){
        $phone_number = $params['phone_number'];
        $username = $params['username'];
        $email = $params['email'];
        $password = $params['pass'];
        $status = 0;
        $created_date = $params['created_date'];
        $user = $params['user_id'];

            if($status=="2"){
                $info = "Blocked";  
            }else{
                $info = "";
            }

        $user_id = $params['user_id'];

        $hasil=$this->db->query("INSERT INTO instagram (phone_number,username,email_id,password,status,created_date,user_id) VALUES ('$phone_number','$username','$email','$password','$status','$created_date','$user_id')");
        
        if($hasil){
             return $hasil;    
        }else{
            return false;
        }

    }

    public function update_data($params){
        $id = $params['id_instagram'];
        $phone_number = $params['phone_number'];
        $username = $params['username'];
        $email = $params['email'];
        $status = $params['status'];
        $user = $params['user'];

        $hasil=$this->db->query("UPDATE instagram SET phone_number='$phone_number',username='$username',email_id='$email',status='$status',user_id='$user' WHERE id='$id'");

        if($hasil){
             return $hasil;    
        }else{
            return false;
        }
    }

    public function change_passwords($params){
        $id = $params['id'];
        $password = $params['password'];

        $hasil=$this->db->query("UPDATE instagram SET password='$password' WHERE id='$id'");
        if($hasil){
             return $hasil;    
        }else{
            return false;
        }
    }

    public function delete_data($no){
        $hasil=$this->db->query("DELETE FROM instagram WHERE id='$no'");
        if($hasil){
            return $hasil;
        }else{
            return false;
        }
    }
	
}
?>