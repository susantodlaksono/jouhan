<?php

class Questions extends CI_Model {

	public function get_tests($for, $search) {
        if ($search != "") {
            $this->db->like('name', $search);
        }
        $this->db->order_by('id', 'desc');

        if ($for == 'get') {
            return $this->db->get('test_type')->result_array();
        } else if ($for == 'count') {
            return $this->db->count_all_results('test_type');
        }
    }

    public function get_review($question_id){
    	return 'a';
    }

    public function save_question($post){
        $insert_question = array(
            'question_text' => $post['question_text'] != '' ? utf8_encode($post['question_text']) : NULL,
            'test_type_id' => $post['type_test'],
            'question_type_id' => $post['type_question'],
            'question_description' => $post['question_description'] != '' ? $post['question_description'] : NULL,
        );
        return $this->db->insert('question', $insert_question);
    }

    public function save_answers_papi($question_id, $answers_text, $answer){
        $insert_answers = array(
            'question_id' => $question_id,
            'question_answers' => $answers,
            'question_type' => 'text',
            'answers_sort' => $answers_sort
        );
        return $this->db->insert('question_answers', $insert_answers);
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

    public function save_answers_psikotes($question_id, $answers_text, $answers_value){
        $insert_answers = array(
            'question_id' => $question_id,
            'question_answers' => $answers_text,
            'question_answers_alias' => $answers_value,
            'question_type' => 'text'
        );
        return $this->db->insert('question_answers', $insert_answers);
    }

    public function save_image_question($question_id, $post){
        $config['upload_path']  = './files/question_image/';
        $config['allowed_types'] = '|png|jpg|jpeg|gif|';
        $config['file_name'] = $question_id.'_'.$post['name'];

        $this->load->library('upload', $config);
        if (!$this->upload->do_upload($post[''])) {
            $msg = $this->upload->display_errors();          
        }else{
            $datafile = $this->upload->data();
            $msg =  'success';            
        }
        return $msg;
    }

    public function save_correct_answers($question_id, $answers_sort, $type = '_by_sort'){
        $correct_answers_id = $this->_correct_answers_id($question_id, $answers_sort, $type);
        $q = array(
            'correct_answers_id' => $correct_answers_id['id'],
        );
        return $this->db->update('question', $q, array('id' => $question_id));
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
}