<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Model for Assessment
 *
 * @author SUSANTO DWI LAKSONO
 */

class Assessment extends CI_Model {

	public function __construct() {
        parent::__construct();
        $this->table_test_assessment = 'test_assessment';
        $this->table_test_assessment_result = 'test_assessment';
        $this->table_test_answers = 'test_answers';
    }

    public function checking_assessment($test_transaction_id, $question_type_id){
    	$this->db->where('test_transaction_id', $test_transaction_id);
    	$this->db->where('question_type_id', $question_type_id);
    	return $this->db->count_all_results($this->table_test_assessment);
    }

    public function update_assessment($data, $where){
    	return $this->db->update($this->table_test_assessment, $data, $where);
    }

    public function insert_assessment($data){
    	return $this->db->insert($this->table_test_assessment, $data);
    }

    public function test_answers_assessment($data, $where){
    	return $this->db->update($this->table_test_answers, $data, $where);
    }

    public function question_type_multiple_choice($test_type_id){
    	$this->db->select('question_type_id');
    	$this->db->where('test_type_id', $test_type_id);
    	$this->db->where('question_type_id', 1);    	
    	return $this->db->count_all_results('question');
    }

    public function counting_result($test_type_id, $test_transaction_id){
        $this->load->library('papi_kostick');
        switch ($test_type_id) {
            case '1':
                $assessment = $this->_psikotes_counting($test_type_id, $test_transaction_id);
                $question_type_id = 7;
                break;
            case '4':
                $assessment = json_encode($this->papi_kostick->counting($test_transaction_id));
                $question_type_id = 8;
                break;
            
            default:
                $checking_type = $this->check_question_multiple_choice($test_type_id);
                if($checking_type){
                    $assessment = $this->counting_multiple_choice($test_type_id, $test_transaction_id, 1);
                    $question_type_id = 1;
                }
                break;
        }
        $checking_assessment = $this->checking_assessment($test_transaction_id, $question_type_id);
        if($checking_assessment > 0){
            $tmp = array(
                'assessment' => $assessment
            );
            return $this->update_assessment($tmp, array('test_transaction_id' => $test_transaction_id, 'question_type_id' => $question_type_id));
        }else{
            $tmp = array(
                'test_transaction_id' => $test_transaction_id,
                'question_type_id' => $question_type_id,
                'assessment' => $assessment

            );
            return $this->insert_assessment($tmp);
        }
        
    }

    public function counting_multiple_choice($test_type_id, $test_transaction_id, $question_type_id){
        $question_id = $this->question_multiple_choice($test_type_id, $question_type_id);
        $total_question = $this->total_question($test_type_id);

        $this->db->select('sum(result) as result_correct');
        $this->db->where_in('question_id', $question_id);
        $this->db->where('test_transaction_id', $test_transaction_id);
        $this->db->where('result', 100);
        $rs = $this->db->get('test_answers')->row_array();
        return round($rs['result_correct'] / $total_question, 2);
    }

    public function question_multiple_choice($test_type_id, $question_type_id){
        $this->db->select('id');
        $this->db->where('test_type_id', $test_type_id);
        $this->db->where('question_type_id', $question_type_id);
        $rs = $this->db->get('question');
        foreach ($rs->result_array() as $key => $value) {
            $question_id[] = $value['id'];
        }
        return $question_id;
    }

    public function check_question_multiple_choice($test_type_id){
        $this->db->select('question_type_id');
        $this->db->where('test_type_id', $test_type_id);
        $this->db->group_by('question_type_id');
        $rs = $this->db->get('question');
        if($rs->num_rows() > 0){
            foreach ($rs->result_array() as $key => $value) {
                $question_type_id[] = $value['question_type_id'];
            }
            if(in_array(1, $question_type_id)){
                return TRUE;
            }else{
                return FALSE;
            }
        }else{
            return FALSE;
        }

    }

    private function _psikotes_counting($test_type_id, $test_transaction_id){
        $question_id = $this->_question_list(7, $test_type_id); 
        $_i = $this->db->where_in('question_id', $question_id)->where('test_transaction_id', $test_transaction_id)->where('answers', 'I')->get('test_answers')->num_rows();
        $_e = $this->db->where_in('question_id', $question_id)->where('test_transaction_id', $test_transaction_id)->where('answers', 'E')->get('test_answers')->num_rows();
        $_s = $this->db->where_in('question_id', $question_id)->where('test_transaction_id', $test_transaction_id)->where('answers', 'S')->get('test_answers')->num_rows();
        $_n = $this->db->where_in('question_id', $question_id)->where('test_transaction_id', $test_transaction_id)->where('answers', 'N')->get('test_answers')->num_rows();
        $_t = $this->db->where_in('question_id', $question_id)->where('test_transaction_id', $test_transaction_id)->where('answers', 'T')->get('test_answers')->num_rows();
        $_f = $this->db->where_in('question_id', $question_id)->where('test_transaction_id', $test_transaction_id)->where('answers', 'F')->get('test_answers')->num_rows();
        $_j = $this->db->where_in('question_id', $question_id)->where('test_transaction_id', $test_transaction_id)->where('answers', 'J')->get('test_answers')->num_rows();
        $_p = $this->db->where_in('question_id', $question_id)->where('test_transaction_id', $test_transaction_id)->where('answers', 'P')->get('test_answers')->num_rows();
        
        $_ie = $_i > $_e ? 'I' : 'E';
        $_sn = $_s > $_n ? 'S' : 'N';
        $_tf = $_t > $_f ? 'T' : 'F';
        $_jp = $_j > $_p ? 'J' : 'P';

        return $_ie.$_sn.$_tf.$_jp;
    }

    private function _question_list($question_type_id, $test_type_id){
        $this->db->select('id');
        $this->db->where('test_type_id', $test_type_id);
        $this->db->where('question_type_id', $question_type_id);
        $rs = $this->db->get('question');
        if($rs->num_rows() > 0){
            foreach ($rs->result_array() as $key => $value) {
                $result[] = $value['id'];
            }
            return $result;
        }else{
            return FALSE;
        }
    }

    public function total_question($test_type_id){
        $this->db->where('test_type_id', $test_type_id);
        return $this->db->count_all_results('question');
    }
}