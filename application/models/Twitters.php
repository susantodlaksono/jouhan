<?php

class Twitters extends CI_Model
{
	
	public function get_data_twitter($mode,$params){
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
				return $this->db->get('twitter as a',10,$params['offset'])->result_array();
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
	
    public function input_data($params){
        $phone_number = $params['phone_number'];
        $display = $params['display'];
        $screen = $params['screen'];
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

        $hasil=$this->db->query("INSERT INTO twitter (phone_number,display_name,screen_name,email_id,password,followers,status,created_date,user_id) VALUES ('$phone_number','$display','$screen','$email','$password',0,'$status','$created_date','$user_id')");
        
        if($hasil){
             return $hasil;    
        }else{
            return false;
        }

    }

    public function update_data($params){
        $id = $params['id'];
        $phone_number = $params['phone_number'];
        $display_name = $params['display_name'];
        $screen_name = $params['screen_name'];
        $email_id = $params['email'];
        $user = $params['user'];
        $status = $params['status'];

        $hasil=$this->db->query("UPDATE twitter SET phone_number='$phone_number',display_name='$display_name',screen_name='$screen_name',email_id='$email_id',status='$status',user_id='$user' WHERE id='$id'");

        if($hasil){
             return $hasil;    
        }else{
            return false;
        }
    }

    public function change_passwords($params){
        $id = $params['id'];
        $password = $params['password'];

        $hasil=$this->db->query("UPDATE twitter SET password='$password' WHERE id='$id'");
        if($hasil){
             return $hasil;    
        }else{
            return false;
        }
    }

    public function delete_data($no){
        $hasil=$this->db->query("DELETE FROM twitter WHERE id='$no'");
        if($hasil){
            return $hasil;
        }else{
            return false;
        }
    }

}
?>