<?php

class Ebcarrier extends MY_Controller {
    public function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in() && php_sapi_name() != 'cli') {
            redirect('security');
        }
    }

    public function index(){
    	$data = array(
            'title' => 'Beranda',
            'content' => 'main',
    	);
    	$this->render_page($data);
    }

}