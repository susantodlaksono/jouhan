<?php

if (!defined('BASEPATH'))
   exit('No direct script access allowed');

class Sim_card extends MY_Controller
{
	public function __construct() {
      parent::__construct();
      $this->load->model('m_simcard');
      $this->load->library('validation_simcard');
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
         'result_view' => 'operator/sim_card',
         'user_id' => $this->_user->id
      );
      $this->rendering_page($obj);
   }

   public function get(){
      $params = $this->input->get();
      $list = array();
      $data = $this->m_simcard->get_data_simcard('get', $params);
      if($data){
         foreach ($data as $value) {
            $list[] = array(
               'no_handphone' => $value['phone_number'],
               'masa_aktif' => date('d M Y', strtotime($value['expired_date'])),
               'first_name' => $value['first_name'],
               'provider' => $value['provider_name'],
               'nik' => $value['nik'],
               'nkk' => $value['nkk'],
               'status' => $this->status($value['status']),
               'phone_number_type' => $this->phone_number_type($value['phone_number_type']),
               'saldo' => $value['saldo'],
               'rak' => $value['nama_rak'],
               'no_rak' => $value['no_rak'],
               'registered' => $this->registered($value['registered'], 'fa fa-envelope'),
               'registered_facebook' => $this->registered($value['registered_facebook'], 'fa fa-facebook'),
               'registered_twitter' => $this->registered($value['registered_twitter'], 'fa fa-twitter'),
               'registered_instagram' => $this->registered($value['registered_instagram'], 'fa fa-instagram'),
               'created_date' => date('d M Y', strtotime($value['created_date'])),
            );
         }
         $response['data'] = $list;
         $response['total'] = $this->m_simcard->get_data_simcard('count',$params);
      }else{
         $response['total'] = 0;
      }
      $this->json_result($response);
   }

   public function registered($status, $icon){
      switch ($status) {
         case '0':
            return '';
            break;
         case '1':
            return '<i class="'.$icon.'" style="font-size:16px;"></i>';
            break;
      }
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
            return '<span class="label label-danger" data-toggle="tooltip" data-original-title="Expired"><i class="fa fa-remove"></i></span>';
            break;
      }
   }

   public function phone_number_type($phone_number_type){
      switch ($phone_number_type) {
         case '1':
            return '- Fisik';
            break;
         case '2':
            return '- Cloud';
            break;
      }
   }

   public function input_simcard(){
      $params = $this->input->post();
      $params['user_id'] = $this->_user->id;
      $response['success'] = FALSE;

      if($this->validation_simcard->create($params)){
         $data = $this->m_simcard->input_data($params);
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
      $params['user_id'] = $this->_user->id;
      $response['success'] = FALSE;

      if($this->validation_simcard->modify($params)){
         $data = $this->m_simcard->update_data($params);
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
      $id = $this->input->get('no');
      $response['success'] = FALSE;

      $data=$this->m_simcard->delete_data($id);

      if($data!=false){
         $response['success'] = TRUE;
         $response['msg'] = 'Data Updated';
      }else{
         $response['msg'] = 'Function Failed';
      };
      $this->json_result($response);
   }
   
   public function ambil_edit(){
      $id = $this->input->get('id');
      $data['detail_simcard'] = $this->db->select('a.*,b.nama_rak,c.id as id_user,d.id as id_provider')->join('provider as d','d.id=a.provider_id')->join('users as c','c.id=a.user_id')->join('rak as b','a.rak_id=b.id')->where('a.phone_number', $id)->get('simcard as a')->row_array();
      echo json_encode($data);
   }

}
?>