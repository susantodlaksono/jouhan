<?php

if (!defined('BASEPATH'))
   exit('No direct script access allowed');

class Reporting extends MY_Controller {

	public function __construct() {
      parent::__construct();
      $this->load->model('m_twitter');
      $this->load->library('validation_twitter');
      if (!$this->ion_auth->logged_in() && php_sapi_name() != 'cli') {
         redirect('security?_redirect=' . urlencode(uri_string()));
      }
      $this->_field = array(
         'simcard' => array(
            'phone_number' => 'Phone Number',
            'phone_number_type' => 'Type',
            'provider_id' => 'Provider',
            'active_period' => 'Active Period',
            'expired_date' => 'Expired Date',
            'nik' => 'NIK',
            'nkk' => 'NKK',
            'saldo' => 'Saldo',
            'status' => 'Status',
            'user_id' => 'PIC',
            'rak_id' => 'Rak',
            'created_date' => 'Created',
         ),
         'email' => array(
            'phone_number' => 'Phone Number',
            'phone_number_type' => 'Type',
            'email' => 'Email',
            'display_name' => 'Display Name',
            'password' => 'Password',
            'birth_day' => 'Birth Day',
            'status' => 'Status',
            'info' => 'Info',
            'user_id' => 'PIC',
            'created_date' => 'Created',
         ),
         'twitter' => array(
            'phone_number' => 'Phone Number',
            'display_name' => 'Display Name',
            'email' => 'Email',
            'screen_name' => 'Screen Name',
            'created_twitter' => 'Created Account',
            'birth_date' => 'Birth Date',
            'password' => 'Password',
            'cookies' => 'Cookies',
            'twitter_id' => 'Twitter ID',
            'followers' => 'followers',
            'apps_id' => 'Apps ID',
            'apps_name' => 'Apps Name',
            'consumer_key' => 'Consumer Key',
            'consumer_secret' => 'Consumer Secret',
            'access_token' => 'Access Token',
            'access_token_secret' => 'Access Token Secret',
            'status' => 'Status',
            'client_id' => 'Client',
            'client_id_key' => 'Client ID',
            'proxy_id' => 'Proxy',
            'proxy_id_key' => 'Proxy ID',
            'user_id' => 'PIC',
            'user_id_key' => 'User ID',
            'created_date' => 'Created',
         ),
         'facebook' => array(
            'phone_number' => 'Phone Number',
            'display_name' => 'Display Name',
            'url' => 'URL',
            'email' => 'Email',
            'created_facebook' => 'Created Account',
            'birth_date' => 'Birth Date',
            'facebook_id' => 'Facebook ID',
            'password' => 'Password',
            'cookies' => 'Cookies',
            'friends' => 'Friends',
            'info' => 'Info',
            'access_token' => 'Access Token',
            'status' => 'Status',
            'client_id' => 'Client',
            'client_id_key' => 'Client ID',
            'proxy_id' => 'Proxy',
            'proxy_id_key' => 'Proxy ID',
            'user_id' => 'PIC',
            'user_id_key' => 'PIC ID',
            'created_date' => 'Created',
         ),
         'instagram' => array(
            'phone_number' => 'Phone Number',
            'display_name' => 'Display Name',
            'username' => 'Username',
            'email' => 'Email',
            'created_instagram' => 'Created Account',
            'birth_date' => 'Birth Date',
            'password' => 'Password',
            'cookies' => 'Cookies',
            'followers' => 'Followers',
            'info' => 'Info',
            'status' => 'Status',
            'client_id' => 'Client',
            'client_id_key' => 'Client ID',
            'proxy_id' => 'Proxy',
            'proxy_id_key' => 'Proxy ID',
            'user_id' => 'PIC',
            'user_id_key' => 'PIC ID',
            'created_date' => 'Created',
         ),
         'proxy' => array(
            'id'=>'ID',
            'network'=>'Network',
            'ip_address'=>'IP Address',
            'port'=>'Port',
            'username'=>'Username',
            'password'=>'Password',
            'location'=>'Location',
            'status'=>'Status',
            'created_date'=>'Created Date',
            'user_id'=>'User ID',
         )
      );
   }

	public function index() {
      $obj = array(
         '_css' => array(
            'assets/plugins/simplepagination/simplePagination.css'
         ),
         '_js' => array(
          'assets/plugins/simplepagination/jquery.simplePagination.js"',
         ),
         'title'=>'- Reporting',
         'field' => $this->_field,
         'result_view' => 'pages/reporting',
      );
      $this->rendering_page($obj);
   }

   public function get(){
      $this->load->library('mapping_report');
      $this->load->library('bulk_uploader');
      $params = $this->input->post();

      if($params['mode_report'] == 1){
         $filename = $this->_user->username.'-'.uniqid(date("hisu"));
         if($_FILES) {
            $config['upload_path'] = './upload/';
            $config['allowed_types'] = 'xls|xlsx';
            $config['max_size'] = 0;
            $config['file_name'] = $filename;

            $this->load->library('upload', $config);
            if($this->upload->do_upload('userfile')) {
               $data = $this->upload->data();
               $read = $this->bulk_uploader->rawData($data['file_name']);
               if($read['success']){
                  $params['phone_number'] = $read['data'];
               }else{
                  $params['phone_number'] = NULL;
               }
            }else{
               $params['phone_number'] = NULL;
            }
         }else{
            $params['phone_number'] = NULL;
         }
      }
      return $this->mapping_report->get($params, $params['filename'], 'download');
      
   }

   public function get_all_module(){
      $this->load->library('mapping_report');
      $params = $this->input->get();
      return $this->mapping_report->get_all_module($params, $params['filename'], 'download');
   }

   public function get_proxy(){
      $this->load->library('mapping_report');
      $params = $this->input->get();
      return $this->mapping_report->get_proxy($params, $params['filename'], 'download');
      // $data=$this->mapping_report->get_proxy($params,'Reporting','download');
      // echo json_encode($data);
   }

   public function downloadByClient(){
      $this->load->library('mapping_report');
      $params = $this->input->post();
      return $this->mapping_report->downloadByClient($params, $params['filename'], 'download', $params['cluster']);
   }

}