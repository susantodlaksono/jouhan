<?php

class Questions extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->helper('mapping_file_helper');
        $this->basic = array(1,2,3,4,5,6);
    }

    public function get_tests($for, $params = array()) {
        if ($params['search'] != "") {
            $this->db->like('name', $params['search']);
        }
        $this->db->where('status', 1);
        $this->db->where('type', 'Custom');
        $this->db->order_by('id', 'desc');

        if ($for == 'get') {
            return $this->db->get('test_type', 9, $params['offset'])->result_array();
        } else if ($for == 'count') {
            return $this->db->count_all_results('test_type');
        }
    }

    public function detail_test($test_id){
        $group_question = $this->group_question($test_id);
        if($group_question->num_rows() > 0){
            foreach ($group_question->result_array() as $k => $v) {
                $data[$v['question_type_id']]['question_name'] = $v['question_name'];
                $data[$v['question_type_id']]['question_list'] = $this->question($test_id, $v['question_type_id']);
            }
            return $data;
        }else{
            return FALSE;
        }
    }

    public function group_question($test_id){
        $this->db->select('a.question_type_id, b.name as question_name');
        $this->db->join('question_type as b', 'a.question_type_id = b.id');
        $this->db->where('a.test_type_id', $test_id);
        // $this->db->where_not_in('a.question_type_id', array(7,8));
        $this->db->group_by('a.question_type_id');
        return $this->db->get('question as a');
    }

    public function question($test_id, $question_type_id){
        $question = $this->get_question($test_id, $question_type_id);
        if($question->num_rows() > 0){
            foreach ($question->result_array() as $k => $v) {
                if(in_array($question_type_id, $this->basic)){
                    $data[$v['id']]['question_id'] = $v['id'];
                    $data[$v['id']]['question_text'] = $v['question_text'];  
                    $data[$v['id']]['question_type_id'] = $v['question_type_id'];                         
                }else{
                    $data[$v['id']]['question_answers'] = $this->question_answers($v['id']); 
                }
            }
            return $data;
        }else{
            return FALSE;
        }
    }

    public function edit_question($question_id, $question_type_id){
        // if(in_array($question_type_id, $this->basic)){
            $question = $this->question_detail($question_id);
            foreach ($question->result_array() as $key => $value) {
                $data['question_id'] = $value['id'];
                $data['question_text'] = $value['question_text'];
                $data['question_description'] = $value['question_description'];
                $data['correct_answers_id'] = $value['correct_answers_id'];
                $data['correct_answers_multiple'] = json_decode($value['correct_answers_multiple'], TRUE);
                $data['question_file'] = $this->question_dir($value['id'], 'question_file');  
                $data['question_image'] = $this->question_dir($value['id'], 'question_image'); 
                if(!in_array($question_type_id, array(2,3,5,6))){
                    $data['question_answers'] = $this->question_answers($value['id']); 
                } 
            }
            return $data;
        // }
    }

    public function question_detail($question_id){
        $this->db->where('id', $question_id);
        return $this->db->get('question');
    }

    public function question_answers($question_id){
        $this->db->where('question_id', $question_id);
        $rs = $this->db->get('question_answers');
        if($rs->num_rows() > 0){
            foreach ($rs->result_array() as $key => $value) {
                $data[$value['id']] = $value;
            }
            return $data;
        }else{
            return FALSE;
        }
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

    public function get_question($test_type_id, $question_type_id){
        $this->db->where('test_type_id', $test_type_id);
        $this->db->where('question_type_id', $question_type_id);
        return $this->db->get('question');
    }

    public function update_question_file($file_name, $temp_name, $file_id){
        $obj = array(
            'file' => $file_name,
            'temp_name' => $temp_name
        );
        return $this->db->update('question_file', $obj, array('id' => $file_id));
    }

    public function insert_question_file($file_name, $temp_name, $question_id){
        $obj = array(
            'file' => $file_name,
            'temp_name' => $temp_name,
            'question_id' => $question_id,
        );
        return $this->db->insert('question_file', $obj);
    }

    public function update_question_image($file_name, $temp_name, $image_id){
        $obj = array(
            'image' => $file_name,
            'temp_name' => $temp_name
        );
        return $this->db->update('question_image', $obj, array('id' => $image_id));
    }

    public function insert_question_image($file_name, $temp_name, $question_id){
        $obj = array(
            'image' => $file_name,
            'temp_name' => $temp_name,
            'question_id' => $question_id,
        );
        return $this->db->insert('question_image', $obj);
    }

    public function save_question($post){
        if(!in_array($post['type_question'], array(7,8))){
            $insert_question = array(
                'question_text' => $post['question_text'] != '' ? utf8_encode($post['question_text']) : NULL,
                'test_type_id' => $post['type_test'],
                'question_type_id' => $post['type_question'],
                'question_description' => $post['question_description'] != '' ? $post['question_description'] : NULL
            );
        }else{
            $insert_question = array(
                'question_text' => NULL,
                'test_type_id' => $post['type_test'],
                'question_type_id' => $post['type_question'],
                'question_description' => NULL
            );
        }
        return $this->db->insert('question', $insert_question);
    }

    public function insert_special_question($question_id, $question_answers, $question_answers_alias){
        $obj = array(
            'question_id' => $question_id,
            'question_answers' => $question_answers,
            'question_answers_alias' => $question_answers_alias
        );
        return $this->db->insert('question_answers', $obj);
    }

    public function save_question_answers($question_id, $answers_sort, $answers){
        $insert_answers = array(
            'question_id' => $question_id,
            'question_answers' => $answers,
            'question_type' => 'text',
            'answers_sort' => $answers_sort
        );
        return $this->db->insert('question_answers', $insert_answers);
    }

    public function save_correct_answers($question_id, $answers_sort, $type = '_by_sort'){
        $correct_answers_id = $this->_correct_answers_id($question_id, $answers_sort, $type);
        $q = array(
            'correct_answers_id' => $correct_answers_id['id'],
        );
        return $this->db->update('question', $q, array('id' => $question_id));
    }

    public function save_correct_answers_multiple($question_id, $answers_correct){
        $correct_answers_id = $this->_correct_answers_id_multiple($question_id, $answers_correct);
        $q = array(
            'correct_answers_multiple' => json_encode($correct_answers_id),
        );
        return $this->db->update('question', $q, array('id' => $question_id));
    }

    public function change_correct_answers_multiple($question_id, $correct_answers_id){
        $q = array(
            'correct_answers_multiple' => json_encode($correct_answers_id),
        );
        return $this->db->update('question', $q, array('id' => $question_id));
    }

    public function _correct_answers_id_multiple($question_id, $answers_correct){
        $this->db->select('id');
        $this->db->where('question_id', $question_id);
        $this->db->where_in('answers_sort', $answers_correct);
        $rs  = $this->db->get('question_answers')->result_array();
        if($rs){
            foreach ($rs as $v) {
                $data[] = $v['id'];
            }
            return $data;
        }
    }

    public function _correct_answers_id($question_id, $answers_sort, $type){
        $this->db->select('id');
        $this->db->where('question_id', $question_id);
        if($type == '_by_sort'){
            $this->db->where('answers_sort', $answers_sort);
        }else{
            $this->db->where('id', $answers_sort);
        }
        return $this->db->get('question_answers')->row_array();
    }

    public function delete_question($question_id){
        return $this->db->delete('question', array('id' => $question_id));
    }

}