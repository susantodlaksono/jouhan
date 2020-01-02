<?php

class Widget extends Widgets {

   public function __construct() {
      parent::__construct();
      $this->load->model('m_summary');
      if (!$this->ion_auth->logged_in()) {
         return '{"msg":"success"}';
      }
   }

   public function index() {
      $get = $this->input->get();
      $data = array(
         'title' => 'All Summary',
         'count_simcard' => $this->m_summary->all_count('simcard', $get['sdate'], $get['edate']),
         'count_email' => $this->m_summary->all_count('email', $get['sdate'], $get['edate']),
         'count_facebook' => $this->m_summary->all_count('facebook', $get['sdate'], $get['edate']),
         'count_twitter' => $this->m_summary->all_count('twitter', $get['sdate'], $get['edate']),
         'count_instagram' => $this->m_summary->all_count('instagram', $get['sdate'], $get['edate'])
      );
      $this->render_widget($data, TRUE);
   }
   
}