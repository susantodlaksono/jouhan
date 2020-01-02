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
      	'title' => 'Socmed Summary',
         'twitter' => $this->m_dashboard->get_data('twitter'),
         'facebook' => $this->m_dashboard->get_data('facebook'),
         'instagram' => $this->m_dashboard->get_data('instagram'),
      );

      $this->render_widget($data, TRUE);
   }
}