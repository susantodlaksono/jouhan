<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Model Tests
 *
 * @author SUSANTO DWI LAKSONO
 */

class Tests extends CI_Model {
	
	public function detail_applicant($user_id, $fields = '*'){
		$this->db->select($fields);
		$this->db->where('user_id', $user_id);
		$rs = $this->db->get('applicant');
		if($fields == '*'){
			return $rs->row_array();
		}else{
			$row = $rs->row_array();
			return $row[$fields];
		}
	}

	public function detail_test($test_id, $fields = '*'){
		$this->db->select($fields);
		$this->db->where('id', $test_id);
		$rs = $this->db->get('test_type');
		if($fields == '*'){
			return $rs->row_array();
		}else{
			$row = $rs->row_array();
			return $row[$fields];
		}
	}

	public function rules_vacancy($test_id, $user_id){
		$vacancy_division_id = $this->detail_applicant($user_id, 'vacancy_division_id');
		$this->db->where('vacancy_division_id', $vacancy_division_id);
		$this->db->where('test_type_id', $test_id);
		$rs = $this->db->get('test_groups');
		if($rs->num_rows() > 0){
			return TRUE;
		}else{
			return FALSE;
		}	
	}

	public function rules_transaction($test_id, $user_id){
		$applicant_id = $this->detail_applicant($user_id, 'id');
		$this->db->where('applicant_id', $applicant_id);
		$this->db->where('test_type_id', $test_id);
		$this->db->where('status', 3);
		$rs = $this->db->get('test_transaction');
		//Jika test ditemukan dengan status Finish
		if($rs->num_rows() > 0){ 
			return FALSE;
		}else{
			return TRUE;
		}
	}

	public function registration_test($test_id, $user_id, $time_now_js){
		$applicant_id = $this->detail_applicant($user_id, 'id');
		$time_test = $this->detail_test($test_id, 'time');
		$registered = $this->_checking_registered($test_id, $applicant_id);
		if(!$registered){
			$start_time = date('Y-m-d H:i:s', strtotime($time_now_js));
			// $push_minutes = date($time_now_js, strtotime('+'.$time_test.' minutes'));
			// $_timestamp = strtotime($push_minutes);
			// $end_time = date($time_now_js, $_timestamp);
			// $convert = date('Y-07-d H:i:s', strtotime($time_now_js));
			// $start_time = date('Y-m-d H:i:s', strtotime($time_now_js));
			// $time = new DateTime($start_time);
			// $time->add(new DateInterval('PT' . $time_test . 'M'));
			// $time_end = $time->format('Y-m-d H:i:s');
			$time = strtotime($time_now_js);
			$newformat = date('Y-m-d H:i:s', $time);

			$insert_entity = array(
				'time_start' => $start_time,
				'time_end' => date('Y-m-d H:i:s', strtotime('+'.$time_test.' minutes')),
				'applicant_id' => $applicant_id,
				'test_type_id' => $test_id,
				'status' => 1

			);	
			return $this->db->insert('test_transaction', $insert_entity);
		}else{
			return TRUE;
		}
	}

	private function _checking_registered($test_id, $applicant_id){
		$this->db->where('test_type_id', $test_id);
		$this->db->where('applicant_id', $applicant_id);
		$rs = $this->db->get('test_transaction');
		if($rs->num_rows() > 0){ 
			return TRUE;
		}else{
			return FALSE;
		}
	}

	//Validasi aturan test berdasarkan vacancy dan status test transaksi
	// public function rules_tests($test_id, $user_id){
	// 	$vacancy_division_id = $this->_get_vacancy_division_id($user_id);
	// 	$this->db->where('vacancy_division_id', $vacancy_division_id);
	// 	$this->db->where('test_type_id', $test_id);
	// 	$rs = $this->db->get('test_groups');
	// 	if($rs->num_rows() > 0){
	// 		return TRUE;
	// 	}else{
	// 		return FALSE;
	// 	}
	// }

	public function _get_vacancy_division_id($user_id){
		$this->db->select('vacancy_division_id');
		$this->db->where('user_id', $user_id);
		$rs = $this->db->get('applicant');
		$row = $rs->row_array();
		return $row['vacancy_division_id'];
	}

	public function _get_applicant_id($user_id){
		$this->db->select('id');
		$this->db->where('user_id', $user_id);
		$rs = $this->db->get('applicant');
		$row = $rs->row_array();
		return $row['id'];
	}

	public function detail_tests($test_id, $user_id){
		$check_tests_transaction = $this->check_tests_transaction($test_id, $user_id);
		if($check_tests_transaction){
			$applicant_id = $this->_get_applicant_id($user_id);
			$this->db->select('a.id as test_id, a.*, b.id as test_transaction_id, b.*');
			$this->db->join('test_transaction as b', 'a.id = b.test_type_id');
			$this->db->where('a.id', $test_id);
			$this->db->where('b.applicant_id', $applicant_id);
			return $this->db->get('test_type as a')->row_array();
		}else{
			$this->db->where('id', $test_id);
			return $this->db->get('test_type')->row_array();
		}
		
	}

	public function check_tests_transaction($test_id, $user_id){
		$applicant_id = $this->_get_applicant_id($user_id);
		$this->db->where('applicant_id', $applicant_id);
		$this->db->where('test_type_id', $test_id);
		$rs = $this->db->get('test_transaction');
		if($rs->num_rows() > 0){
			return $rs->row_array();
		}else{
			return FALSE;
		}
	}

	
	public function finish_tests($test_id, $test_transaction_id){
		$update_entity = array(
			'status' => 2
		);	
		return $this->db->update('test_transaction', $update_entity, array('id' => $test_transaction_id));
	}

	public function get_question($question_id){
		$this->db->select('id, question_text, test_type_id, question_type_id, question_description, correct_answers_id');
		$this->db->where('id', $question_id);
		$rs = $this->db->get('question');
		if($rs->num_rows() > 0){
			$row = $rs->row_array();
			$data['id'] = $row['id'];	
			$data['question_text'] = $row['question_text'];	
			$data['question_description'] = $row['question_description'];	
			$data['test_type_id'] = $row['test_type_id'];	
			$data['correct_answers_question'] = $row['correct_answers_id'];	
			$data['question_type_id'] = $row['question_type_id'];	
			$data['question_image'] = $this->_get_question_image($row['id']);	
			$data['question_file'] = $this->_get_question_file($row['id']);	
			$data['question_answers'] = $this->_get_question_answers($row['id'], $row['question_type_id']);	
			return $data;
		}else{
			return FALSE;
		}
	}

	public function _get_question_image($id){
		$this->db->select('image');
		$this->db->where('question_id', $id);
		$rs = $this->db->get('question_image');
		if($rs->num_rows() > 0){
			return $rs->result_array();
		}else{
			return FALSE;
		}
	}

	public function _get_question_file($id){
		$this->db->select('file');
		$this->db->where('question_id', $id);
		$rs = $this->db->get('question_file');
		if($rs->num_rows() > 0){
			return $rs->result_array();
		}else{
			return FALSE;
		}
	}

	public function _get_question_answers($id, $question_type_id){
		switch ($question_type_id) {
			case '1':
				$rs = $this->db->select('id, question_answers, question_type')->where('question_id', $id)->get('question_answers');
				if($rs->num_rows() > 0){
					foreach ($rs->result_array() as $key => $value) {
						$data[$value['id']]['answers_id'] = $value['id'];
						$data[$value['id']]['question_answers'] = $value['question_answers'];
						$data[$value['id']]['question_type'] = $value['question_type'];
					}
					return $data;
				}else{
					return FALSE;
				}
				break;
			case '4':
				$rs = $this->db->select('id, question_answers, question_type')->where('question_id', $id)->get('question_answers');
				if($rs->num_rows() > 0){
					foreach ($rs->result_array() as $key => $value) {
						$data[$value['id']]['answers_id'] = $value['id'];
						$data[$value['id']]['question_answers'] = $value['question_answers'];
						$data[$value['id']]['question_type'] = $value['question_type'];
					}
					return $data;
				}else{
					return FALSE;
				}
				break;
			case '7':
				$rs = $this->db->select('id, question_answers, question_answers_alias, question_type')->where('question_id', $id)->get('question_answers');
				if($rs->num_rows() > 0){
					foreach ($rs->result_array() as $key => $value) {
						$data[$value['id']]['answers_id'] = $value['id'];
						$data[$value['id']]['question_answers'] = $value['question_answers'];
						$data[$value['id']]['question_answers_alias'] = $value['question_answers_alias'];
						$data[$value['id']]['question_type'] = $value['question_type'];
					}
					return $data;
				}else{
					return FALSE;
				}
				break;
			case '8':
				$rs = $this->db->select('id, question_answers, question_answers_alias, question_type')->where('question_id', $id)->get('question_answers');
				if($rs->num_rows() > 0){
					foreach ($rs->result_array() as $key => $value) {
						$data[$value['id']]['answers_id'] = $value['id'];
						$data[$value['id']]['question_answers'] = $value['question_answers'];
						$data[$value['id']]['question_answers_alias'] = $value['question_answers_alias'];
						$data[$value['id']]['question_type'] = $value['question_type'];
					}
					return $data;
				}else{
					return FALSE;
				}
				break;
			default:
				return TRUE;
				break;
		}
	}

	public function checking_file($question_id, $test_transaction_id){
        $this->db->where('question_id', $question_id);
        $this->db->where('test_transaction_id', $test_transaction_id);
        $rs = $this->db->get('test_answers');
        if($rs->num_rows() > 0){
        	$row = $rs->row_array();
        	return $row['answers'];
        }else{
        	return FALSE;
        }
    }

    public function assessment_multiple_choice($question_id, $answers_multiple){
    	$this->db->select('correct_answers_multiple');
    	$this->db->where('id', $question_id);
    	$rs = $this->db->get('question');
    	if($rs->num_rows() > 0){
    		$row = $rs->row_array();
    		$correct_answers = json_decode($row['correct_answers_multiple']);
    		if($answers_multiple){
    			if(!array_diff($correct_answers, $answers_multiple)){
					return 100;
				}else{
					return 0;
				}
    		}else{
    			return 0;
    		}
   //  		sort($correct_answers);
			// sort($answers_multiple);
			// if ($correct_answers == $answers_multiple) {
			// 	return 100;
			// }else{
			// 	return 0;
			// }
    	}else{
    		return NULL;
    	}
    }

}