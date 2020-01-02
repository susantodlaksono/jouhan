<?php

if (!defined('BASEPATH'))
   exit('No direct script access allowed');

class Master_provider extends MY_Controller{

   public function __construct() {
      parent::__construct();
      $this->load->model('m_provider');
      $this->load->library('validation_provider');
      if (!$this->ion_auth->logged_in() && php_sapi_name() != 'cli') {
         redirect('security?_redirect=' . urlencode(uri_string()));
      }
   }

   public function index() {
      $obj = array(
         '_css' => array(
            'assets/plugins/simplepagination/simplePagination.css',
            'assets/plugins/bootstrap-tag/bootstrap-tagsinput.css',
         ),
         '_js' => array(
            'assets/plugins/simplepagination/jquery.simplePagination.js"',
            'assets/plugins/bootstrap-tag/bootstrap-tagsinput.min.js"',
         ),
      'title'=>'- Master Provider',
      'result_view' => 'master/provider',
      );
      $this->rendering_page($obj);
   }

   public function get(){
      $params = $this->input->get();
      $list = array();
      $data = $this->m_provider->get('get', $params);
      if($data){
         foreach ($data as $value) {
            $list[] = array(
               'id' => $value['id'],               
               'product' => $value['product'],
               'provider' => $value['provider'],
               'code_number' => json_decode($value['code_number'], TRUE)
            );
         }
         $response['data'] = $list;
         $response['total'] = $this->m_provider->get('count', $params);
      }else{
         $response['total'] = 0;
      }
      $this->json_result($response);
   }

   public function create(){
      $params = $this->input->post();
      $response['success'] = FALSE;
      $params['user_id'] = $this->_user->id;

      if($this->validation_provider->create($params)){ 
         $result = $this->m_provider->create($params);
         if($result){
            $this->_logging('provider', 'create', $this->db->insert_id(), $this->_user->id);
            $response['success'] = TRUE;
            $response['msg'] = 'Data Update';
         }else{
            $response['msg'] = 'Function Failed';
         }
      }else{
         $response['msg'] = validation_errors();
      }
      $this->json_result($response);
   }

   public function check_code_number(){
      $params = $this->input->get();
      $response['response'] = $this->m_provider->check_code_number($params) > 0 ? FALSE : TRUE;
      $this->json_result($response);
   }

   public function change(){
      $params = $this->input->post();
      $response['success'] = FALSE;
      $params['user_id'] = $this->_user->id;

      foreach ($params['code_number'] as $key => $value) {
         $code_number[] = $value;
      }

      if($this->m_provider->check_duplicate_provider($params, $code_number)){
         if($this->validation_provider->change($params)){ 
            $result = $this->m_provider->change($params);
            if($result){
               $this->_logging('proxy', 'change', $params['id'], $this->_user->id);
               $response['success'] = TRUE;
               $response['msg'] = 'Data Update';
            }else{
               $response['msg'] = 'Function Failed';
            }
         }else{
            $response['msg'] = validation_errors();
         }
      }else{
         $response['msg'] = $this->m_provider->check_duplicate_provider($params, $code_number);
      }
      $this->json_result($response);
   }

   public function delete(){
      $params = $this->input->get();
      $response['success'] = FALSE;

      $result = $this->m_provider->delete($params);
      if($result){
         $this->_logging('provider', 'delete', $params['id'], $this->_user->id);
         $response['success'] = TRUE;
         $response['msg'] = 'Data Updated';
      }else{
         $response['msg'] = 'Function Failed';
      }
      $this->json_result($response);
   }

   public function proxy(){
      $id = $this->input->get('id');
      $this->db->select('a.*,b.id as id_user');
      $this->db->join('users as b','a.user_id=b.id','left');
      $this->db->where('a.id', $id);
      $data['detail_email'] = $this->db->get('email as a')->row_array();
     
      echo json_encode($data);
   }

   public function bulk_action(){
      $params = $this->input->post();

      $result = $this->m_provider->bulk_action($params);
      if($result > 0){
         $response['success'] = TRUE;
         $response['msg'] = 'Data Updated';
      }else{
         $response['msg'] = 'Function Failed';
      }
      $response['success'] = TRUE;
      $this->json_result($response);
   }


   public function status($status){
      switch ($status) {
         case '1':
            return '<span class="label label-success"><i class="fa fa-check"></i> Connected</span>';
            break;
         case '0':
            return '<span class="label label-danger"><i class="fa fa-remove"></i>  Not Connected</span>';
            break;
      }
   }

   public function network($status){
      switch ($status) {
         case '1':
            return 'VPS';
            break;
         case '2':
            return 'Proxy';
            break;
      }
   }

   public function update(){
      $params = $this->input->post();
      $response['success'] = FALSE;

      if($this->validation_proxy->change_proxy($params)){ 
          $hasil=$this->m_provider->update($params['id_edit'],$params['proxy'],$params['descript']);
          if($hasil){
            $response['success'] = TRUE;
            $response['msg'] = 'Data Update';
          }else{
            $response['msg'] = 'Function Failed';
          }
      }else{
         $response['msg'] = validation_errors();
      }
      $this->json_result($response);
   }

   public function remove(){
      $kode = $this->input->get('delete');
      $hasil=$this->m_provider->remove($kode);
      if($hasil){
        $response['success'] = TRUE;
        $response['msg'] = 'Data Update';
      }else{
        $response['msg'] = 'Function Failed';
      }
      $this->json_result($response);
   }

   public function edit(){
      $params = $this->input->get();
      $response['response'] = $this->db->get_where('provider', array('id' => $params['id']))->row_array();
      $response['code_number'] = json_decode($response['response']['code_number']);
      $this->json_result($response);
   }

}

?>