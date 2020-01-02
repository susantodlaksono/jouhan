<?php

if (!defined('BASEPATH'))
   exit('No direct script access allowed');

class Email extends MY_Controller {
	
	public function __construct() {
      parent::__construct();
      $this->load->model('m_email');
      $this->load->library('validation_email');
      if (!$this->ion_auth->logged_in() && php_sapi_name() != 'cli') {
         redirect('security');
      }
   }

   public function index() {
      $obj = array(
         '_css' => array(
            'assets/plugins/simplepagination/simplePagination.css'
         ),
         '_js' => array(
            'assets/plugins/simplepagination/jquery.simplePagination.js"',
         ),
         'result_view' => 'operator/email',
         'user_id' => $this->_user->id
      );
      $this->rendering_page($obj);
   }

   public function get_email(){
      $param = $this->input->get();
      $list = array();
      $data = $this->m_email->get_data_email('get',$param);
      if($data){
         foreach ($data as $value) {
            $list[] = array(
               'id' => $value['id'],
               'phone_number' => $value['phone_number'],
               'email' => $value['email'],
               'password' => $value['password'],
               'created_date' => date('d M Y', strtotime($value['created_date'])),
               'birth_day' => date('d M Y', strtotime($value['birth_day'])),
               'status' => $this->status($value['status']),
               'info' => $value['info'] ? $value['info'] : '',
               'user' => $value['username_pembuat'],
               'status_phone' => $value['status_phone'],
            );
         }
         $response['data'] = $list;
         $response['total'] = $this->m_email->get_data_email('count', $param);
      }else{
         $response['total'] = 0;
      }
      $this->json_result($response);
   }

   public function status($status){
      switch ($status) {
         case '0':
            return '<span class="label label-default" data-toggle="tooltip" data-original-title="No Action"><i class="fa fa-minus"></i></span>';
            break;
         case '1':
            return '<span class="label label-success" data-toggle="tooltip" data-original-title="Active"><i class="fa fa-check"></i></span>';
            break;
         case '2':
            return '<span class="label label-danger" data-toggle="tooltip" data-original-title="Blocked"><i class="fa fa-remove"></i></span>';
            break;
      }
   }

   public function input_email(){
      $params = $this->input->post();
      $response['success'] = FALSE;
      if($this->validation_email->create($params)){
         $data = $this->m_email->input_data($params);
         if($data){
            $response['success'] = TRUE;
            $response['msg'] = 'Data Updated';
         }else{
            $response['msg'] = 'Function Failed';
         }
      }else{
         $response['msg'] = validation_errors();
      }  
      $this->json_result($response);
   }
   
   public function edit(){
      $params = $this->input->post();
      $response['success'] = FALSE;
      $params['user_id'] = $this->_user->id;
      
      if($this->validation_email->modify_data($params)){
         $data = $this->m_email->update_data($params);
         if($data){
            $response['success'] = TRUE;
            $response['msg'] = 'Data Updated';
         }else{
            $response['msg'] = 'Function Failed';
         }  
      }else{
         $response['msg'] = validation_errors();
      }

      $this->json_result($response);
      
   }

   public function hapus(){
      $params = $this->input->get();
      $response['success'] = FALSE;

      $data=$this->m_email->delete_data($params);

      if($data){
         $response['success'] = TRUE;
         $response['msg'] = 'Data Updated';
      }else{
         $response['msg'] = 'Function Failed';
      }

      echo json_encode($response);
   }

   public function ambil_edit(){
      $id = $this->input->get('id');
      $this->db->select('a.*,b.id as id_user');
      $this->db->join('users as b','a.user_id=b.id','left');
      $this->db->where('a.id', $id);
      $data['detail_email'] = $this->db->get('email as a')->row_array();
     
      echo json_encode($data);
   }

   public function get_phone_number(){
      $params = $this->input->get();
      $response['response'] = $this->m_email->get_phone_number($params);
      $this->json_result($response);
   }
}

?>