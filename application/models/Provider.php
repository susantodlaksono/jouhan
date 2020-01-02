<?php

class Provider extends CI_model{

	public function get_provider($mode, $params){
        $this->db->select('*');
        if($params['search']!=''){
          $this->db->where('name',$params['search']);
        }
        switch ($mode) {
            case 'get':
               return $this->db->get('provider', 10, $params['offset'])->result_array();
            case 'count':
               // $this->db->group_by('b.user_id');
               return $this->db->get('provider')->num_rows();
        }
    }
    public function addProvider($name,$desc){
        $hasil=$this->db->query("INSERT INTO provider (name,description) VALUES ('$name','$desc') ");
        return $hasil;
    }
    public function remove($kode){
        $hasil=$this->db->query("DELETE FROM provider WHERE id='$kode'");
        return $hasil;
    }
    public function update($id,$provName,$desc){
        $hasil=$this->db->query("UPDATE provider SET name='$provName', description='$desc' WHERE id='$id'");
        return $hasil;
    }
}

?>