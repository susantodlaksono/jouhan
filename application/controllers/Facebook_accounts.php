<?php

if (!defined('BASEPATH'))
   exit('No direct script access allowed');

class Facebook_accounts extends MY_Controller {
	public function __construct() {
      parent::__construct();
      if (!$this->ion_auth->logged_in() && php_sapi_name() != 'cli') {
         redirect('security?_redirect=' . urlencode(uri_string()));
      }
   }

   public function index() {
      $obj = array(
         '_css' => array(
            'assets/plugins/simplepagination/simplePagination.css'
         ),
         '_js' => array(
          'assets/app/facebook_accounts.js',
          'assets/plugins/simplepagination/jquery.simplePagination.js',
         ),
      'result_view' => 'operator/facebook_accounts',
      );
      $this->rendering_page($obj);
   }

}