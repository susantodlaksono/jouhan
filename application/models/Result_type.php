<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Model Result Type
 *
 * @author SUSANTO DWI LAKSONO
 */

class Result_type extends CI_Model {

	public function get_tests($for, $search, $offset = 0) {
        if ($search != "") {
            $this->db->like('name', $search);
        }
        $this->db->order_by('id', 'asc');

        if ($for == 'get') {
            $rs = $this->db->get('test_type', 9, $offset);
            if($rs->num_rows() > 0){
            	foreach ($rs->result_array() as $k => $v) {
            		$result[$v['id']]['id'] = $v['id'];
            		$result[$v['id']]['name'] = $v['name'];
            		$result[$v['id']]['total_question'] = $v['total_question'];
            		$result[$v['id']]['time'] = $v['time'];
            		$result[$v['id']]['status'] = $v['status'];
            		$result[$v['id']]['type'] = $v['type'];
            		$result[$v['id']]['complete_question'] = $this->_complete_question($v['id']);
            		$result[$v['id']]['registered'] = $this->_get_registered('count', $v['id']);
                    $result[$v['id']]['finished'] = $this->_get_registered('count', $v['id'], FALSE);
            		$result[$v['id']]['for_generate_result'] = $this->_for_generate_result($v['id']);
            	}
            	return $result;
            }else{
            	return FALSE;
            }
        } else if ($for == 'count') {
            return $this->db->count_all_results('test_type');
        }
    }

    public function _for_generate_result($test_type_id){
        $q_type = array(1,7,8);
        $this->db->where('test_type_id', $test_type_id);
        $this->db->where_in('question_type_id', $q_type);
        $rs = $this->db->count_all_results('question');
        return $rs > 0 ? TRUE : FALSE;
    }

    public function get_applicant($for, $test_type_id, $search, $sdate, $edate, $offset = 0) {
        $this->db->select('b.*, c.name as division_name');
        $this->db->join('applicant as b', 'a.applicant_id = b.id');
        $this->db->join('vacancy_division as c', 'b.vacancy_division_id = c.id');
        $this->db->where('a.test_type_id', $test_type_id);
        $this->db->where('a.status !=', 0);
        $this->db->where('date(a.time_start) BETWEEN "' . $sdate . '" AND "' . $edate . '"');

        if ($search != "") {
            $this->db->like('b.name', $search);
            $this->db->or_like('b.education_degree', $search);
            $this->db->or_like('b.school_majors', $search);
            $this->db->or_like('b.university', $search);
            $this->db->or_like('b.contact_number', $search);
            $this->db->or_like('b.email', $search);
            $this->db->or_like('c.name', $search);
        }

        if ($for == 'get') {
            $rs = $this->db->get('test_transaction as a', 9, $offset);
            if($rs->num_rows() > 0){
            	foreach ($rs->result_array() as $k => $v) {
            		$result[$v['id']]['id'] = $v['id'];
                    $result[$v['id']]['name'] = $v['name'];
                    $result[$v['id']]['division_name'] = $v['division_name'];
                    $result[$v['id']]['email'] = $v['email'];
            		$result[$v['id']]['test_result'] = $this->_get_result($test_type_id, $v['id']);
            	}
            	return $result;
            }else{
            	return FALSE;
            }
        } else if ($for == 'count') {
            return $this->db->count_all_results('test_transaction as a');
        }
    }

    public function _get_result($test_type_id, $applicant_id){
        $this->db->select('result');
        $this->db->where('test_type_id', $test_type_id);
        $this->db->where('applicant_id', $applicant_id);
        $rs = $this->db->get('test_result');
        if($rs->num_rows() > 0){
            $result = $rs->row_array();
            $result_fetch = json_decode($result['result']);
            foreach ($result_fetch as $key => $value) {
                $data[$key]['question_type_id'] = $key;
                $data[$key]['question_type_name'] = $this->_question_name($key);
                $data[$key]['question_result'] = $value;
            }
            return $data;
        }else{
            $group_type_question = $this->test_result->_group_type_question($test_type_id);
            if($group_type_question){
                foreach ($group_type_question->result_array() as $key => $value) {
                    $data[$value['question_type_id']]['question_type_id'] = $value['question_type_id'];
                    $data[$value['question_type_id']]['question_type_name'] = $this->_question_name($value['question_type_id']);
                    $data[$value['question_type_id']]['question_result'] = 0;
                }
                return $data;
            }else{
                return FALSE;
            }
        }
    }

    private function _question_name($id){
        $this->db->select('name');
        $this->db->where('id', $id);
        $rs = $this->db->get('question_type')->row_array();
        return $rs['name'];
    }

    private function _complete_question($test_type_id){
    	$count = 0;
    	$test_transaction_id = $this->_get_registered('get', $test_type_id);
    	$_question_count = $this->_question_count($test_type_id);

    	if($test_transaction_id){
    		foreach ($test_transaction_id as $v) {
    			$this->db->where('test_transaction_id', $v);
    			$total = $this->db->count_all_results('test_answers');
    			$total == $_question_count ? $count++ : FALSE;
    		}
    		return $count;
    	}else{
    		return 0;
    	}
    }

    private function _get_registered($mode, $test_type_id, $registered = TRUE){
		$this->db->where('test_type_id', $test_type_id);
		if($registered){
			$this->db->where('status !=', 0);
		}else{
			$this->db->where('status', 2);
		}
		if($mode == 'count'){
			return $this->db->count_all_results('test_transaction');
		}else{
			$rs = $this->db->get('test_transaction');
			if($rs->num_rows() > 0){
				foreach ($rs->result_array() as $k => $v) {
					$test_transaction_id[] = $v['id'];
				}
				return $test_transaction_id;
			}else{
				return FALSE;
			}
		}
    }

    private function _question_count($test_type_id){
		$this->db->where('test_type_id', $test_type_id);
		return $this->db->count_all_results('question');
    }

    public function detail_result($applicant_id, $question_type_id, $test_type_id){
        $this->db->where('question_type_id', $question_type_id);
        $this->db->where('test_type_id', $test_type_id);
        $rs = $this->db->get('question');
        if($rs->num_rows() > 0){
            foreach ($rs->result_array() as $key => $value) {
                $data[$value['id']]['question_text'] = $value['question_text'];
                $data[$value['id']]['question_answers'] = $this->_get_answers_applicant($applicant_id, $test_type_id, $value['id'], 'answers');
                $data[$value['id']]['question_answers_id'] = $this->_get_answers_applicant($applicant_id, $test_type_id, $value['id'], 'id');
                $data[$value['id']]['question_answers_result'] = $this->_get_answers_applicant($applicant_id, $test_type_id, $value['id'], 'result');
                $data[$value['id']]['question_image'] = $this->_dir_question('image', $value['id']);
                $data[$value['id']]['question_file'] = $this->_dir_question('file', $value['id']);
            }            
            return $data;
        }else{
            return FALSE;
        }
    }

    public function _get_answers_applicant($applicant_id, $test_type_id, $question_id, $field){
        $test_transaction_id = $this->_get_transaction($applicant_id, $test_type_id);
        $this->db->select('result, id, answers');
        $this->db->where('test_transaction_id', $test_transaction_id['id']);
        $this->db->where('question_id', $question_id);
        $rs = $this->db->get('test_answers')->row_array();
        return $rs[$field];
    }

    private function _get_transaction($applicant_id, $test_type_id){
        return $this->db->select('id')->where('applicant_id', $applicant_id)->where('test_type_id', $test_type_id)->get('test_transaction')->row_array();
    }

    private function _dir_question($type, $question_id){
        $this->db->where('question_id', $question_id);
        $rs = $this->db->get('question_'.$type.'');
        if($rs->num_rows() > 0){
            $row = $rs->row_array();
            return base_url().'files/question_'.$type.'/'.$row[$type].'';
        }else{
            return FALSE;
        }
    }

}