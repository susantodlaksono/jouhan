<?php

class Applicant extends CI_Model {
    
	public function get_applicant($for, $params) {
        $this->db->select('b.name as vacancy_name, a.*, date_format(a.created_date, "%d %b %Y") as created, c.username, c.active as active_login');
        $this->db->join('vacancy_division as b', 'a.vacancy_division_id = b.id');
        $this->db->join('users as c', 'a.user_id = c.id');
        if ($params['created'] != '') {
            $this->db->where('date(a.created_date)', $params['created']);
        }
        if ($params['status'] != 'all') {
            $this->db->where('c.active', $params['status']);
        }
        if ($params['vacancy'] != 'all') {
            $this->db->where('a.vacancy_division_id', $params['vacancy']);
        }
        if ($params['search'] != "") {
            $this->db->like('a.name', $params['search']);
            $this->db->or_like('a.education_degree', $params['search']);
            $this->db->or_like('a.school_majors', $params['search']);
            $this->db->or_like('a.university', $params['search']);
            $this->db->or_like('a.contact_number', $params['search']);
            $this->db->or_like('a.email', $params['search']);
            $this->db->or_like('b.name', $params['search']);
            $this->db->or_like('c.username', $params['search']);
        }
        $this->db->order_by('a.created_date', 'desc');
        if ($for == 'get') {
            return $this->db->get('applicant as a', 10, $params['offset'])->result_array();
        } else if ($for == 'count') {
            return $this->db->count_all_results('applicant as a');
        }
    }

    public function applicant_result($for, $params){
        $this->db->select('b.id as vacancy_id, b.name as vacancy_name, a.*, date_format(a.created_date, "%d %b %Y") as created');
        $this->db->join('vacancy_division as b', 'a.vacancy_division_id = b.id');
        $this->db->join('users as c', 'a.user_id = c.id');
        if ($params['sdate'] && $params['edate']) {
            $this->db->where('date(a.created_date) BETWEEN "' . $params['sdate'] . '" AND "' . $params['edate'] . '"');
        }
        $this->db->where('c.active', 1);

        if ($params['vacancy'] != 'all') {
            $this->db->where('a.vacancy_division_id', $params['vacancy']);
        }
        if ($params['search'] != "") {
            $this->db->like('a.name', $params['search']);
            $this->db->or_like('a.education_degree', $params['search']);
            $this->db->or_like('a.school_majors', $params['search']);
            $this->db->or_like('a.university', $params['search']);
            $this->db->or_like('a.contact_number', $params['search']);
            $this->db->or_like('a.email', $params['search']);
            $this->db->or_like('b.name', $params['search']);
        }
        $this->db->order_by('a.created_date', 'desc');
        if ($for == 'get') {
            return $this->db->get('applicant as a', 10, $params['offset'])->result_array();
        } else if ($for == 'count') {
            return $this->db->count_all_results('applicant as a');
        }
    }

    public function detail_applicant($params){
        $this->db->select('a.*, b.name as vacancy_name, c.applicant_file, c.applicant_temp_file');
        $this->db->join('vacancy_division as b', 'a.vacancy_division_id = b.id');
        $this->db->join('applicant_file as c', 'a.id = c.applicant_id', 'left');
        $this->db->where('a.id', $params['applicant_id']);
        return $this->db->get('applicant as a')->row_array();
    }

    public function get_applicant_evaluator($for, $params, $user_id) {
        $test_type_id = $this->_evaluator_test_type($user_id);

        $this->db->select('a.*, date_format(a.time_start, "%d %b %Y") as time_start');
        $this->db->select('b.name as test_type_name');
        $this->db->select('c.name, c.education_degree');

        $this->db->join('test_type as b', 'a.test_type_id = b.id');
        $this->db->join('applicant as c', 'a.applicant_id = c.id');
        $this->db->where('a.status', 2); // finish test
        $this->db->where_in('a.test_type_id', $test_type_id);
        $this->db->order_by('a.id', 'desc');
        if ($params['search'] != "") {
            $this->db->like('c.name', $params['search']);
            $this->db->or_like('c.education_degree', $params['search']);
        }
        if ($for == 'get') {
            $rs = $this->db->get('test_transaction as a', 10, $params['offset']);
            if($rs->num_rows() > 0){
                // foreach ($rs->result_array() as $key => $value) {
                //     $data[$value['id']]['id'] = $value['id'];
                //     $data[$value['id']]['name'] = $value['name'];
                //     $data[$value['id']]['education_degree'] = $value['education_degree'];
                //     $data[$value['id']]['time_start'] = $value['time_start'];
                //     $data[$value['id']]['test_type_name'] = $value['test_type_name'];
                //     $data[$value['id']]['test_type_id'] = $value['test_type_id'];
                //     $data[$value['id']]['rate'] = $this->get_rate($value['id'], $value['test_type_id']);
                // }
                return $rs->result_array();
            }else{
                return false;
            }
        } else if ($for == 'count') {
            return $this->db->count_all_results('test_transaction as a');
        }
    }

    public function get_rate($test_transaction_id, $test_type_id){
        $list_question_id = $this->question_id($test_type_id);
        if($list_question_id){
            $this->db->select('sum(result) as total');
            $this->db->where_in('question_id', $list_question_id);
            $this->db->where('test_transaction_id', $test_transaction_id);
            $rs = $this->db->get('test_answers')->row_array();
            $question_result = $rs['total'] / count($list_question_id);
            return round($question_result, 2);
        }else{
            return false;
        }
    }

    public function question_id($test_type_id){
        $this->db->select('id');
        $this->db->where('test_type_id', $test_type_id);
        $this->db->where_in('question_type_id', array(2,3,5,6));
        $rs = $this->db->get('question');
        if($rs->num_rows() > 0){
            foreach ($rs->result_array() as $key => $value) {
                $data[] = $value['id'];
            }
            return $data;
        }else{
            return FALSE;
        }
    }

    public function _evaluator_test_type($user_id){
        $this->db->where('user_id', $user_id);
        $rs = $this->db->get('evaluator_tests');
        if($rs->num_rows() > 0){
            foreach ($rs->result_array() as $key => $value) {
                $data[] = $value['test_type_id'];
            }
            return $data;
        }else{
            return FALSE;
        }
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

    public function upload_applicant_file($applicant_id, $applicant_file, $applicant_temp_file, $type){
        $obj = array(
            'applicant_id' => $applicant_id,
            'applicant_file' => $applicant_file,
            'applicant_temp_file' => $applicant_temp_file,
            'applicant_type_file' => $type
        );
        return $this->db->insert('applicant_file', $obj);
    }

    public function update_applicant_file($applicant_id, $applicant_file, $applicant_temp_file, $type){
        $obj = array(
            'applicant_file' => $applicant_file,
            'applicant_temp_file' => $applicant_temp_file
        );
        return $this->db->update('applicant_file', $obj, array('applicant_id' => $applicant_id, 'applicant_type_file' => 2));
    }

    public function get_question($test_type_id){
        $this->db->select('*');
        $this->db->where('test_type_id', $test_type_id);
        $this->db->where_in('question_type_id', array(2,3,5,6));
        return $this->db->get('question');
    }

    public function question_dir($question_id, $source){
        $this->db->where('question_id', $question_id);
        $rs = $this->db->get($source);
        if($rs->num_rows() > 0){
            $row = $rs->row_array();
            $data['dir_id'] = $row['id'];
            $data['dir'] = $source == 'question_file' ?  $row['file'] : $row['image'];
            $data['dir_temp'] = $row['temp_name'];
            return $data;
        }else{
            return FALSE;
        }
    }

    public function get_answers($question_id, $test_transaction_id, $question_type_id){
        $this->db->select('id, answers, result');
        $this->db->where('question_id', $question_id);
        $this->db->where('test_transaction_id', $test_transaction_id);
        $rs = $this->db->get('test_answers');
        if($rs->num_rows() > 0){
            $row = $rs->row_array();
            $data['id'] = $row['id'];
            if($question_type_id == 5 || $question_type_id == 6){
                $data['answers'] = json_decode($row['answers']);
            }else{
                if($question_type_id == 2){
                    $str = substr($row['answers'], -3, 4);
                    if($str == 'jpg' || $str == 'png' || $str == 'gif'){
                        $data['filetype'] = 'image';
                    }else{
                        $data['filetype'] = 'file';
                    }
                }
                $data['answers'] = $row['answers'];
            }
            $data['result'] = $row['result'];
            return $data;
        }else{
            return FALSE;
        }
    }

}