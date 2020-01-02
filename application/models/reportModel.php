<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ReportModel extends CI_Model {

	public function getData($params,$where){

				$this->db->select('a.phone_number,a.active_period, a.expired_date,a.saldo as saldo_simcard, r.nama_rak as nama_rak_simcard,a.status as status_simcard');
				$this->db->select('b.email, b.password as email_password, b.status as email_status');
				$this->db->select('user_twitter.username as pic_twitter, c.screen_name, c.password as password_twitter,cl.name as client_name_twitter,IF(e.username IS NULL OR e.password IS NULL, concat("http://", e.ip_address, ":", e.port), concat("http://", e.username, ":", e.password, "@", e.ip_address, ":", e.port)) as proxy,c_detail.name as twitter_status');
				$this->db->select('user_fb.username as pic_facebook, fb.id as facebook_id, fb.url as facebook_url, fb.password as facebook_password, clf.name as client_facebook_name, fb.status as facebook_status');
				$this->db->select('user_ig.username as pic_instagram, ig.username as username_ig, ig.password as password_ig, cli.name as client_instagram, ig.status as status_ig');
				$this->db->where($where);
				$this->db->join('rak as r', 'a.rak_id = r.id','left');
				$this->db->join('email as b', 'a.phone_number = b.phone_number', 'left');
				$this->db->join('twitter as c', 'a.phone_number = c.phone_number', 'left');
				$this->db->join('twitter_status_detail as c_detail', 'c.status = c_detail.id', 'left');
				$this->db->join('client as cl', 'c.client_id = cl.id', 'left');
				$this->db->join('users as user_twitter', 'c.user_id = user_twitter.id', 'left');
				$this->db->join('proxy as e', 'c.proxy_id = e.id', 'left');
				$this->db->join('facebook as fb', 'a.phone_number = fb.phone_number', 'left');
				$this->db->join('users as user_fb', 'fb.user_id = user_fb.id', 'left');
				$this->db->join('client as clf', 'fb.client_id = clf.id', 'left');
				$this->db->join('instagram as ig', 'a.phone_number = ig.phone_number', 'left');
				$this->db->join('users as user_ig', 'ig.user_id = user_ig.id', 'left');
				$this->db->join('client as cli', 'ig.client_id = cli.id', 'left');
				return $this->db->get('simcard as a')->result_array();


	}

	public function getDataFb($params,$where){
		$this->db->select('f.*');
		$this->db->select('u.first_name as userName, c.name as clientName');
		$this->db->where($where);
		$this->db->join('users as u','f.user_id=u.id','left');
		$this->db->join('client as c','f.client_id=c.id','left');
		return $this->db->get('facebook_fanspage as f')->result_array();

	}

	public function get_fanspage_admin($fanspage_id) {
      $this->db->select('fb.url');
      $this->db->join('facebook as fb', 'f.facebook_id = fb.id');
      $this->db->where('f.fanspage_id', $fanspage_id);
      $adminVal=$this->db->get('facebook_fanspage_admin as f')->result();
      //return $adminVal;
       return $this->verify($adminVal);
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
	


}