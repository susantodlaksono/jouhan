<?php

class Widget extends Widgets {

   public function __construct() {
      parent::__construct();
      $this->load->model('m_dashboard');
      if (!$this->ion_auth->logged_in()) {
         return '{"msg":"success"}';
      }
   }

   public function index() {
      $get = $this->input->get();
      $data = array(
            'title' => 'Twitter Summary',
            'data'=> $this->m_dashboard->get_data('twitter', $get['user_id']),
            'ready' => $this->ready($get['user_id']),
            'check' => $this->m_dashboard->get_status('twitter', array(1,2), $get['user_id']),
            'active' => $this->m_dashboard->get_status('twitter',array(3,10), $get['user_id']),
            'suspended' => $this->m_dashboard->get_status('twitter',array(4,5,11), $get['user_id']),
            'locked' => $this->m_dashboard->get_status('twitter',array(6,7,8,9), $get['user_id']),
      );

      $this->render_widget($data, TRUE);
   }

   public function ready($user_id){
      if($user_id != ''){
         $this->db->where('user_id', $user_id);
      }
      $this->db->where_in('status',array(3,10));
      $this->db->where('client_id IS NULL');
      return $this->db->count_all_results('twitter');
   }
}