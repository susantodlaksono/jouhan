<?php

class Rak extends CI_Model
{
	
	public function get_data_rak($mode,$params){
		$this->db->select('*');
		$this->db->order_by('id','ASC');
		if($params['keyword'] != ""){
         $this->db->like('no', $params['keyword']);
		   $this->db->or_like('nama_rak', $params['keyword']);
		}
		switch ($mode) {
			case 'get':
				return $this->db->get('rak', 10, $params['offset'])->result_array();
			case 'count':
				return $this->db->get('rak')->num_rows();
		}
	}

    public function input_data($params){
    	$nomor_rak = $params['nomor'];
    	$nama_rak = $params['nama'];

        $hasil=$this->db->query("INSERT INTO rak (no,nama_rak)VALUES('$nomor_rak','$nama_rak')");

        if($hasil){
        	return $hasil;
        }else{
        	return false;
        }    
    }

    public function update_data($params){
    	$nama = $params['name'];
    	$nomor = $params['no'];
    	$id = $params['id'];

        $hasil=$this->db->query("UPDATE rak SET nama_rak='$nama',no='$nomor' WHERE id='$id'");
        
        if($hasil){
        	return $hasil;	
        }else{
        	return false;
        }
        
    }

    public function delete_data($id){
        $hasil=$this->db->query("DELETE FROM rak WHERE id='$id'");

        if($hasil){
        	return $hasil;
        }else{
        	return false;
        }
    }
    
}

?>