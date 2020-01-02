<?php

class Management_tests extends CI_Model {
	
    public function get_tests($for, $params = array()) {
        $this->db->select('a.*, count(b.test_type_id) as total');
        $this->db->join('test_groups as b', 'a.id = b.test_type_id', 'left');
        if ($params['status'] != 'all') {
            $this->db->where('a.status', $params['status']);
        }
        if ($params['search'] != "") {
            $this->db->like('a.name', $params['search']);
        }
        $this->db->group_by('a.id');
        $this->db->order_by('a.id', 'desc');

        if ($for == 'get') {
            return $this->db->get('test_type as a', 10, $params['offset'])->result_array();
        } else if ($for == 'count') {
            return $this->db->count_all_results('test_type as a');
        }
    }

    public function remove_test($id){
        $this->db->where('id', $id);
        return $this->db->delete('test_type');
    }

}