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
            'data'=> $this->m_dashboard->get_data('twitter'),
            'errorApp'=>$this->m_dashboard->get_status('twitter',array(1)),
            'errorProx'=>$this->m_dashboard->get_status('twitter',array(2)),
            'growFoll'=>$this->m_dashboard->get_status('twitter',array(3)),
            'ncheck' => $this->m_dashboard->get_status('twitter', array(10)),
            'suspendFa' => $this->m_dashboard->get_status('twitter',array(4)),
            'nckQua'=>$this->m_dashboard->get_status('twitter',array(5)),
            'gocap'=>$this->m_dashboard->get_status('twitter',array(6)),
            'smsV'=>$this->m_dashboard->get_status('twitter',array(7)),
            'cll' => $this->m_dashboard->get_status('twitter', array(8)),
            'tmp' => $this->m_dashboard->get_status('twitter',array(9)),
      );

      $this->render_widget($data, TRUE);
   }

}