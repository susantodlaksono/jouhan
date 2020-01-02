<?php

class Simcard extends CI_Model
{
	public function get_data_simcard($mode,$params){
		$this->db->select('a.*,c.id,b.id,u.first_name');
		$this->db->join('users as u','u.id=a.user_id', 'left');
        $this->db->join('rak as c','c.id=a.rak_id', 'left');
        $this->db->join('provider as b','b.id=a.provider_id', 'left');
		$this->db->order_by('a.phone_number','ASC');

		if($params['search_provider']!=""){
			$this->db->where('b.id',$params['search_provider']);
		}

		if($params['search_rak']!=""){
			$this->db->where('c.id',$params['search_rak']);
		}

		if($params['search_status']!=""){
			$this->db->where('a.status',$params['search_status']);
		}



		switch ($mode) {
			case 'get':
				return $this->db->get('simcard as a',10,$params['offset'])->result_array();
			case 'count':
				return $this->db->get('simcard as a')->num_rows();
		}
	}

	public function get_provider($provider_id){
		$this->db->select('b.name');
		$this->db->join('provider as b','b.id=a.provider_id');
		$this->db->where('b.id',$provider_id);
		return $this->db->get('simcard as a')->result_array();
	}

	public function get_rak($rak_id){
		$this->db->select('b.nama_rak,b.no');
		$this->db->join('rak as b','b.id=a.rak_id');
		$this->db->where('b.id',$rak_id);
		return $this->db->get('simcard as a')->result_array();
	}

    public function input_data($params){
    	$phone_number = $params['no_handphone'];
    	$provider_id = $params['provider'];
    	$expired_date = $params['masa_aktif'];
    	$nik = $params['nik'];
    	$nkk = $params['kk'];
    	$saldo = $params['saldo'];
    	$status = $params['status'];
    	$user_id = $params['user_id'];
    	$rak_id = $params['rak'];

        $hasil=$this->db->query("INSERT INTO simcard (phone_number,provider_id,expired_date,nik,nkk,saldo,status,user_id,rak_id) VALUES ('$phone_number','$provider_id','$expired_date','$nik','$nkk','$saldo','$status','$user_id','$rak_id')");
        
        if($hasil){
        	 return $hasil;    
        }else{
        	return false;
        }

    }

    public function update_data($params){
        $provider_id = $params['provider'];
        $nik = $params['nik'];
        $nkk = $params['nkk'];
        $user_id = $params['user'];
    	$phone_number = $params['no_handphone'];
    	$expired_date = $params['masa_aktif'];
    	$saldo = $params['saldo'];
    	$status = $params['status'];
    	$rak_id = $params['rak'];

        $hasil=$this->db->query("UPDATE simcard SET provider_id='$provider_id',nik='$nik',nkk='$nkk',user_id='$user_id',expired_date='$expired_date',saldo='$saldo',status='$status',rak_id='$rak_id' WHERE phone_number='$phone_number'");
        if($hasil){
        	 return $hasil;    
        }else{
        	return false;
        }
    }

    public function delete_data($nope){
        $hasil=$this->db->query("DELETE FROM simcard WHERE phone_number='$nope'");
        if($hasil){
        	return $hasil;
        }else{
        	return false;
        }
    }

}
?>