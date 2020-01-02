<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ReportFb extends MY_Controller {

	function __construct() {
      parent::__construct();
      $this->load->model('reportModel','rm');
      // $this->load->library('validation_facebook');
      if (!$this->ion_auth->logged_in() && php_sapi_name() != 'cli') {
         redirect('security?_redirect=' . urlencode(uri_string()));
      }
    
   }

	function index(){
	
		$obj = array(
         '_css' => array(
            'assets/plugins/simplepagination/simplePagination.css'
         ),
         '_js' => array( //buat manggil library javascript yang gak dipanggil terus-terusan
          'assets/plugins/simplepagination/jquery.simplePagination.js',
         ),
        'title'=>'- Reporting Fanpage',
      	'result_view' => 'pages/reportingFb',
      // 'field' => config_item('field'),
      );
      $this->rendering_page($obj);
	
	}

	public function getStatusSos($status){
		switch ($status) {
			case '1':
				return "Active";
				break;
			
			case '2':
				return "Blocked";
				break;
		}
	}

	public function getStatusFb($status){
		switch ($status) {
			case '1':
				return "Published";
				break;
			
			case '2':
				return "Un-Published";
				break;
		}
	}

	public function getStatusSim($status){
		switch ($status) {
			case '0':
				return "Need Top Up";
				break;

			case '1':
				return "Active";
				break;
			
			case '2':
				return "Change Number";
				break;

			case '3':
				return "Deactive";
				break;
		
		}
	}


	public function get(){
		// echo json_encode('haiiii');
		$str="";
		$params =$this->input->get();
		$data['result']=$this->get_data($params);
		if($data['result']){
			foreach ($data['result'] as $key => $d) {
				$list[]=array(
               		'userName' => $d['userName'],
               		'created_fanspage' => $d['created_fanspage'],
					'fanspage_url'=>$d['url'],
					'followers'=>$d['followers'],
					'likes'=>$d['likes'],
					'admin'=>$this->rm->get_fanspage_admin($d['id']),
					'clientName'=>$d['clientName'],
					'info'=>$d['info'],
					'status'=>$this->getStatusFb($d['status'])
				);

			}

			//$newStr=$this->verify($list['admin']);
			//$newArr=explode(" ",$newStr);
			//$list['admin']=$newStr;
	
			$data['result']=$list;

		}
		//echo count($data['result']);
		 //echo json_encode($list);
		$this->load->view('export_facebook-fanspage',$data,TRUE);
		
		
	}

	public function verify($params){
		$sep=",";
		$adminVal="";
		foreach ($params as $v) {
			$adminVal.=implode($sep,(array)$v);
			$adminVal.=$sep;
		}
		$adminVal=rtrim($adminVal,$sep);
		return $adminVal;
	}


	// public function getAdmin($params){
	// 	 $fanspage_admin=[];
	// 	 if(v.admin){
 //                $.each(v.admin, function(kk ,vv) {
 //                    fanspage_admin.push('<a href="'+vv.url+'" target="_blank">'+vv.display_name+'</a>');
 //                           });
 //                           t += '<td>'+fanspage_admin.join(', ') +'</a></td>';
 //                        }else{
 //                           t += '<td>-</td>';
 //                        }

	// }

	public function get_data($params){

		$where ='DATE(f.created_fanspage) BETWEEN "'.$params['sdate_created'].'" AND "'.$params['edate_created'].'"';
		$result = $this->rm->getDataFb($params,$where);
		return $result;		
		
	}






}

