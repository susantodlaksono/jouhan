<?php

if (!defined('BASEPATH'))
   exit('No direct script access allowed');

class twitter extends MY_Controller
{
	
	public function __construct() {
      parent::__construct();
      $this->load->model('m_twitter');
      $this->load->library('validation_twitter');
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
         'result_view' => 'operator/twitter',
         'user_id' => $this->_user->id
      );
      $this->rendering_page($obj);
   }

   public function get_phone_number(){
      $params = $this->input->get();
      $response['response'] = $this->m_twitter->get_phone_number($params);
      $this->json_result($response);
   }


   public function get_twitter(){
      $param = $this->input->get();
      $list = array();

      $data = $this->Twitters->get_data_twitter('get',$param);
      if($data){
         foreach ($data as $value) {
            $list[] = array(
               'id' => $value['id'],
               'phone_number' => $value['phone_number'],
               'display_name' => $value['display_name'],
               'screen_name' => $value['screen_name'],
               'email' => $this->Twitters->get_email($value['email_id']),
               'follower' => $value['followers'],
               'status' => $value['status']  == 0 ? '<span class="label label-info">No Action</span>' : ( $value['status']  == 1 ? '<span class="label label-success">Active</span>': '<span class="label label-danger">Blocked</span>'),
               'created_date' => $value['created_date'],
               'user' => $this->Twitters->get_user($value['user_id'])
            );
         }
         $response['data'] = $list;
         $response['total'] = $this->Twitters->get_data_twitter('count',$param);
      }else{
         $response['total']=0;
      }

      echo json_encode($response);
   }

   public function input_twitter(){
      $params = $this->input->post();
      $response['success'] = FALSE;
      
      if($this->validation_twitter->create($params)){
         
         
            $data = $this->Twitters->input_data($params);

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

      if($this->validation_twitter->modify_data($params)){    

            $data = $this->Twitters->update_data($params);

            if($data!=false){
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

   public function change_password(){
      $params = $this->input->post();
      $response['success'] = FALSE;

      if($this->validation_twitter->modify_twitter_password($params)){    
         $data = $this->Twitters->change_passwords($params);

         if($data!=false){
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

      $data=$this->Twitters->delete_data($id);

      if($data!=false){
         $response['success'] = TRUE;
         $response['msg'] = 'Data Updated';
      }else{
         $response['msg'] = 'Function Failed';
      }

      echo json_encode($response);
   }

   public function ambil_edit(){
      $id = $this->input->get('id');
      $data['detail_twitter'] = $this->db->select('a.*,b.email,c.id as id_user')->join('email as b','a.email_id=b.id')->join('users as c','c.id=a.user_id')->where('a.id', $id)->get('twitter as a')->row_array();
      echo json_encode($data);
   }

}

?>