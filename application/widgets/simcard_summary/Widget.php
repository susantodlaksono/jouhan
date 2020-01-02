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
      	'title' => 'Simcard Summary',
         'rak' => $this->m_dashboard->get_data('rak', $get['user_id']),
         'data' => $this->m_dashboard->get_data('simcard', $get['user_id']),
         'active' => $this->m_dashboard->get_status('simcard', array(1), $get['user_id']),
         'top_up' => $this->m_dashboard->get_status('simcard', array(0), $get['user_id']),
         'expired' => $this->m_dashboard->get_status('simcard',array(2,3), $get['user_id']),
      );

      $this->render_widget($data, TRUE);
   }
}