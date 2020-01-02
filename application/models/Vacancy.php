<?php

class Vacancy extends CI_Model {

	public function get_vacancy($for, $search) {
        if ($search != "") {
            $this->db->like('name', $search);
        }
        $this->db->order_by('id', 'desc');

        if ($for == 'get') {
            return $this->db->get('vacancy_division')->result_array();
        } else if ($for == 'count') {
            return $this->db->count_all_results('vacancy_division');
        }
    }

    public function remove_test($id, $test_type_id, $vacancy_id){
        $this->db->select('a.id');
        $this->db->join('applicant as b', 'a.applicant_id = b.id');
        $this->db->where('a.test_type_id', $test_type_id);
        $this->db->where('b.vacancy_division_id', $vacancy_id);
        $get = $this->db->get('test_transaction as a');
        if($get->num_rows() > 0){
            $this->db->delete('test_groups', array('id' => $id));
            foreach ($get->result_array() as $key => $value) {
                $this->db->delete('test_transaction', array('id' => $value['id']));
            }
            return TRUE;
        }else{
            $this->db->delete('test_groups', array('id' => $id));
            return TRUE;
        }
    }

    public function remove_vacancy($vacancy_id){
        $this->db->where('id', $vacancy_id);
        return $this->db->delete('vacancy_division');
    }


    public function get_tests_list($id){
        $this->db->select('a.test_type_id, b.name');
        $this->db->join('test_type as b', 'a.test_type_id = b.id');
        $this->db->where('a.vacancy_division_id', $id);
        $rs = $this->db->get('test_groups as a');
        if($rs->num_rows() > 0){
            return $rs->result_array();
        }else{
            return false;
        }
    }

    public function get_evaluator($for, $params){
        $this->db->select('a.test_type_id, a.id, b.name as test_name, group_concat(c.first_name) as evaluator');
        $this->db->join('test_type as b', 'a.test_type_id = b.id');
        $this->db->join('users  as c', 'a.user_id  = c.id');
        $this->db->group_by('a.test_type_id');
        if($params['search'] != ''){
            $this->db->like('test_name', $params['search']);
            $this->db->or_like('evaluator', $params['search']);
        }
        if($params['test_type'] != 'all'){
            $this->db->where('a.test_type_id', $params['test_type']);
        }
        if ($for == 'get') {
            return $this->db->get('evaluator_tests as a', 10, $params['offset'])->result_array();
        } else if ($for == 'count') {
            return $this->db->count_all_results('evaluator_tests as a');
        }
    }
}