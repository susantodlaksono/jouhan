<?php


class Widget extends Widgets
{
	
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
      	'title' => 'Facebook Summary',
         'data' => $this->m_dashboard->get_data('facebook', $get['user_id']),
         'ready' => $this->ready($get['user_id']),
         'active' => $this->m_dashboard->get_status('facebook', array(1), $get['user_id']),
         'blocked' => $this->m_dashboard->get_status('facebook', array(2), $get['user_id']),
      );

      $this->render_widget($data, TRUE);
   }

   public function ready($user_id){
      if($user_id != ''){
         $this->db->where('user_id', $user_id);
      }
      $this->db->where('status', 1);
      $this->db->where('client_id IS NULL');
      return $this->db->count_all_results('facebook');
   }
}