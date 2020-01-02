<?php
if (!defined('BASEPATH'))
   exit('No direct script access allowed');

class Mapping_report{

   public function __construct() {
      $this->_ci = & get_instance();
      $this->_ci->load->config('fields');
   }

   public function get($params, $filename, $mode){
      $data['report'] = $this->_report($params);
      $data['module'] = $params['module'];
      $data['mode'] = $mode;
      $data['filename'] = $filename ? $filename : 'By Module (Generate '.date('d M Y').')';
      $data['field_master'] = config_item('field');
      return $this->_ci->load->view('report/_socmed', $data, TRUE);
   }

   public function get_all_module($params, $filename, $mode){
      $data['report'] = $this->_mapping_all_module($params);
      $data['mode'] = $mode;
      $data['filename'] = $filename ? $filename : 'All Module (Generate '.date('d M Y').')';
      return $this->_ci->load->view('report/_all_module', $data, TRUE);
   }

   public function downloadByClient($params, $filename, $mode, $cluster){
      $data['report'] = $this->_downloadByClient($params, $cluster);
      $data['mode'] = $mode;
      $data['filename'] = $filename ? $filename : 'By Client (Generate '.date('d M Y').')';
      switch ($cluster) {
         case 'twitter':
            return $this->_ci->load->view('report/_client_twitter', $data, TRUE);
            break;
         case 'facebook':
            return $this->_ci->load->view('report/_client_facebook', $data, TRUE);
            break;
         case 'instagram':
            return $this->_ci->load->view('report/_client_instagram', $data, TRUE);
            break;
      }
   }

   public function _downloadByClient($params, $cluster){
      switch ($cluster) {
         case 'twitter':
            $this->_ci->db->select('u.first_name, a.phone_number, a.screen_name, a.created_twitter, a.password, c.name as client_name, em.email,
               IF(
                  e.username IS NULL OR e.password IS NULL, 
                  concat("http://", e.ip_address, ":", e.port), 
                  concat("http://", e.username, ":", e.password, "@", e.ip_address, ":", e.port)
               ) as proxy_name,
               st.name as status_name');
            $this->_ci->db->join('email as em', 'a.phone_number = em.phone_number', 'left');
            $this->_ci->db->join('users as u', 'a.user_id = u.id', 'left');
            $this->_ci->db->join('client as c', 'a.client_id = c.id', 'left');
            $this->_ci->db->join('proxy as e', 'a.proxy_id = e.id', 'left');
            $this->_ci->db->join('twitter_status_detail as st', 'a.status = st.id', 'left');
            if(isset($params['client_id'])){
               $this->_ci->db->where_in('a.client_id', $params['client_id']);
            }
            if(isset($params['status'])){
               $this->_ci->db->where_in('a.status', $params['status']);
            }
            if($params['client_date_sdate'] != '' && $params['client_date_edate'] != ''){
               $this->_ci->db->where('date(a.created_twitter) between "'.$params['client_date_sdate'].'" and "'.$params['client_date_edate'].'"');
            }
            return $this->_ci->db->get('twitter as a');
            break;
         case 'facebook':
            $this->_ci->db->select('
               u.first_name, a.display_name, a.facebook_id, a.url, a.phone_number, a.display_name, a.created_facebook, a.password, 
               c.name as client_name, em.email, a.status,
               IF(
                  e.username IS NULL OR e.password IS NULL, 
                  concat("http://", e.ip_address, ":", e.port), 
                  concat("http://", e.username, ":", e.password, "@", e.ip_address, ":", e.port)
               ) as proxy_name');
            $this->_ci->db->join('email as em', 'a.phone_number = em.phone_number', 'left');
            $this->_ci->db->join('users as u', 'a.user_id = u.id', 'left');
            $this->_ci->db->join('client as c', 'a.client_id = c.id', 'left');
            $this->_ci->db->join('proxy as e', 'a.proxy_id = e.id', 'left');
            if(isset($params['client_id'])){
               $this->_ci->db->where_in('a.client_id', $params['client_id']);
            }
            if(isset($params['status'])){
               $this->_ci->db->where_in('a.status', $params['status']);
            }
            if($params['client_date_sdate'] != '' && $params['client_date_edate'] != ''){
               $this->_ci->db->where('date(a.created_facebook) between "'.$params['client_date_sdate'].'" and "'.$params['client_date_edate'].'"');
            }
            return $this->_ci->db->get('facebook as a');
            break;
         case 'instagram':
            $this->_ci->db->select('
               u.first_name, a.display_name, a.username, a.phone_number, a.created_instagram, a.password, 
               c.name as client_name, em.email, a.status,
               IF(
                  e.username IS NULL OR e.password IS NULL, 
                  concat("http://", e.ip_address, ":", e.port), 
                  concat("http://", e.username, ":", e.password, "@", e.ip_address, ":", e.port)
               ) as proxy_name');
            $this->_ci->db->join('email as em', 'a.phone_number = em.phone_number', 'left');
            $this->_ci->db->join('users as u', 'a.user_id = u.id', 'left');
            $this->_ci->db->join('client as c', 'a.client_id = c.id', 'left');
            $this->_ci->db->join('proxy as e', 'a.proxy_id = e.id', 'left');
            if(isset($params['client_id'])){
               $this->_ci->db->where_in('a.client_id', $params['client_id']);
            }
            if(isset($params['status'])){
               $this->_ci->db->where_in('a.status', $params['status']);
            }
            if($params['client_date_sdate'] != '' && $params['client_date_edate'] != ''){
               $this->_ci->db->where('date(a.created_instagram) between "'.$params['client_date_sdate'].'" and "'.$params['client_date_edate'].'"');
            }
            return $this->_ci->db->get('instagram as a');
            break;
      }
   }

   public function get_proxy($params, $filename, $mode){
      $data['report'] = $this->_mapping_proxy_report($params);
      $data['module'] = $params['module'];
      $data['mode'] = $mode;
      $data['filename'] = $filename ? $filename : 'All Proxy (Generate '.date('d M Y').')';
      $data['field_master'] = config_item('field');
      // return $data;
      return $this->_ci->load->view('report/_proxy_module', $data, TRUE);
   }

   public function _mapping_proxy_report($params){
      foreach ($params['module'] as $key => $value) {
         switch($key){
            case 'proxy':
               foreach ($params['module']['proxy'] as $v) {
                  $this->_ci->db->select('a.'.$v);      
               }
               if(in_array('user_id',$params['module']['proxy'])){
                  $this->_ci->db->select('b.id as user_id');
                  $this->_ci->db->join('users as b', 'a.user_id = b.id');
               }
               if($params['status'] != ''){
                  $this->_ci->db->where('a.status', $params['status']);
               }
               $result = $this->_ci->db->get($key.' as a')->result_array();
               foreach ($result as $kk  =>  $vv) {
                  $data[$key][] = $vv;
               }
            break;
         }
      }
      return isset($data) ? $data : NULL;
   }


   public function rawData($phone_number, $module, $filename, $mode){
      $data['report'] = $this->getRawData($phone_number, $module);
      $data['mode'] = $mode;
      $data['filename'] = $filename;
      switch ($module) {
         case 'twitter':
            return $this->_ci->load->view('report/raw_twitter', $data, TRUE);
            break;
      }
   }

   public function getRawData($phone_number, $module){
      if($phone_number){
         switch ($module) {
            case 'twitter':
               $this->_ci->db->select('a.*, b.name as client_name');
               $this->_ci->db->where_in('a.phone_number', $phone_number);
               return $this->_ci->db->get('twitter as a')->result_array();
               break;
         }
      }else{
         return FALSE;
      }
   }

   public function _mapping_all_module($params){
      $where_created = '';
      $where_expired = '';
      if($params['all_modul_created_sdate'] != '' && $params['all_modul_created_edate']){
         switch ($params['module_type']) {
            case '1':
               $where_created .= 'DATE(a.created_date) BETWEEN "'.$params['all_modul_created_sdate'].'" AND "'.$params['all_modul_created_edate'].'"';
               break;
            case '2':
               $where_created .= 'DATE(b.created_date) BETWEEN "'.$params['all_modul_created_sdate'].'" AND "'.$params['all_modul_created_edate'].'"';
               break;
            case '3':
               $where_created .= 'DATE(c.created_twitter) BETWEEN "'.$params['all_modul_created_sdate'].'" AND "'.$params['all_modul_created_edate'].'"';
               break;
            case '4':
               $where_created .= 'DATE(fb.created_facebook) BETWEEN "'.$params['all_modul_created_sdate'].'" AND "'.$params['all_modul_created_edate'].'"';
               break;
            case '5':
               $where_created .= 'DATE(ig.created_instagram) BETWEEN "'.$params['all_modul_created_sdate'].'" AND "'.$params['all_modul_created_edate'].'"';
               break;
         }         
      }
      if($params['all_modul_expired_sdate'] != '' && $params['all_modul_expired_edate']){
         $where_expired .= 'DATE(a.expired_date) BETWEEN "'.$params['all_modul_expired_sdate'].'" AND "'.$params['all_modul_expired_edate'].'"';
      }

      $result = $this->_all_module($params, $where_created, $where_expired);
      if($result){
         foreach ($result as $key => $d) {
            $list[] = array(
               'phone_number' => $d['phone_number'],
               'active_period' => $d['active_period'],
               'expired_date' => $d['expired_date'],
               'saldo' => $d['saldo_simcard'],
               'rak' => $d['nama_rak_simcard'],
               'status' => $this->getStatusSim($d['status_simcard']),
               'email' => $d['email'],
               'b.password' => $d['email_password'],
               'b.status' => $this->getStatusSos($d['email_status']),
               'c.username' => $d['pic_twitter'],
               'c.screen_name' => $d['screen_name'],
               'c.password' => $d['password_twitter'],
               'cl.name' => $d['client_name_twitter'],
               'proxy' => $d['proxy'],
               'c_detail.name' => $d['twitter_status'],
               'user_fb.username' => $d['pic_facebook'],
               'fb.id' => $d['facebook_id'],
               'fb.url' => $d['facebook_url'],
               'fb.password' => $d['facebook_password'],
               'clf.name' => $d['client_facebook_name'],
               'fb.status' => $this->getStatusSos($d['facebook_status']),
               'user_ig.username' => $d['pic_instagram'],
               'ig.username' => $d['username_ig'],
               'ig.password' => $d['password_ig'],
               'cli.name' => $d['client_instagram'],
               'ig.status' => $this->getStatusSos($d['status_ig']),

            );
         }
         return $list;
      }else{
         return FALSE;
      }
   }


   public function _all_module($params, $where_created, $where_expired){
      $this->_ci->db->select('a.phone_number,a.active_period, a.expired_date,a.saldo as saldo_simcard, concat(r.nama_rak, " (Rak ", r.no, ")") AS nama_rak_simcard, a.status as status_simcard');
      $this->_ci->db->select('b.email, b.password as email_password, b.status as email_status');
      $this->_ci->db->select('user_twitter.username as pic_twitter, c.screen_name, c.password as password_twitter,cl.name as client_name_twitter,IF(e.username IS NULL OR e.password IS NULL, concat("http://", e.ip_address, ":", e.port), concat("http://", e.username, ":", e.password, "@", e.ip_address, ":", e.port)) as proxy,c_detail.name as twitter_status');
      $this->_ci->db->select('user_fb.username as pic_facebook, fb.id as facebook_id, fb.url as facebook_url, fb.password as facebook_password, clf.name as client_facebook_name, fb.status as facebook_status');
      $this->_ci->db->select('user_ig.username as pic_instagram, ig.username as username_ig, ig.password as password_ig, cli.name as client_instagram, ig.status as status_ig');
      if($where_created != ''){
         $this->_ci->db->where($where_created);
      }
      if($where_expired != ''){
         $this->_ci->db->where($where_expired);
      }
      $this->_ci->db->join('rak as r', 'a.rak_id = r.id','left');
      $this->_ci->db->join('email as b', 'a.phone_number = b.phone_number', 'left');
      $this->_ci->db->join('twitter as c', 'a.phone_number = c.phone_number', 'left');
      $this->_ci->db->join('twitter_status_detail as c_detail', 'c.status = c_detail.id', 'left');
      $this->_ci->db->join('client as cl', 'c.client_id = cl.id', 'left');
      $this->_ci->db->join('users as user_twitter', 'c.user_id = user_twitter.id', 'left');
      $this->_ci->db->join('proxy as e', 'c.proxy_id = e.id', 'left');
      $this->_ci->db->join('facebook as fb', 'a.phone_number = fb.phone_number', 'left');
      $this->_ci->db->join('users as user_fb', 'fb.user_id = user_fb.id', 'left');
      $this->_ci->db->join('client as clf', 'fb.client_id = clf.id', 'left');
      $this->_ci->db->join('instagram as ig', 'a.phone_number = ig.phone_number', 'left');
      $this->_ci->db->join('users as user_ig', 'ig.user_id = user_ig.id', 'left');
      $this->_ci->db->join('client as cli', 'ig.client_id = cli.id', 'left');
      return $this->_ci->db->get('simcard as a')->result_array();
   }

   public function _report($params){
      foreach ($params['module'] as $key  =>  $value) {
         switch ($key) {
            case 'simcard':
               foreach ($params['module']['simcard'] as $v) {
                  $this->_ci->db->select('a.'.$v);
               }
               if(in_array('provider_id', $params['module']['simcard'])){
                  $this->_ci->db->select('b.provider as provider_id');
                  $this->_ci->db->join('provider as b', 'a.provider_id = b.id');
               }
               if(in_array('user_id', $params['module']['simcard'])){
                  $this->_ci->db->select('c.first_name as user_id');
                  $this->_ci->db->join('users as c', 'a.user_id = c.id');
               }
               if(in_array('rak_id', $params['module']['simcard'])){
                  $this->_ci->db->select('d.nama_rak, d.no, concat(d.nama_rak, " (Rak ", d.no, ")") AS rak_id');
                  $this->_ci->db->join('rak as d', 'a.rak_id = d.id');
               }
               
               if($params['mode_report'] == 1){
                  if($params['phone_number']){
                     $this->_ci->db->where_in('a.phone_number', $params['phone_number']);
                  }
               }  

               if($params['mode_report'] == 2){
                  if($params['by_modul_sdate_created'] !== '' || $params['by_modul_edate_created'] !== ''){
                     $by_modul_sdate_created = $params['by_modul_sdate_created'] !== '' ?  $params['by_modul_sdate_created'] :  $params['by_modul_edate_created'];
                     $by_modul_edate_created = $params['by_modul_edate_created'] !== '' ?  $params['by_modul_edate_created'] :  $params['by_modul_sdate_created'];
                     $this->_ci->db->where('DATE(a.created_date) BETWEEN "'.$by_modul_sdate_created.'" AND "'.$by_modul_edate_created.'"');
                  }
                  if($params['by_modul_sdate_expired'] !== '' || $params['by_modul_edate_expired'] !== ''){
                     $by_modul_sdate_expired = $params['by_modul_sdate_expired'] !== '' ?  $params['by_modul_sdate_expired'] :  $params['by_modul_edate_expired'];
                     $by_modul_edate_expired = $params['by_modul_edate_expired'] !== '' ?  $params['by_modul_edate_expired'] :  $params['by_modul_sdate_expired'];
                     $this->_ci->db->where('DATE(a.expired_date) BETWEEN "'.$by_modul_sdate_expired.'" AND "'.$by_modul_edate_expired.'"');
                  }
               }

               $result = $this->_ci->db->get($key.' as a')->result_array();
               foreach ($result as $kk  =>  $vv) {
                  $data[$key][] = $vv;
               }
               
            break;     
            case 'email':
               foreach ($params['module']['email'] as $v) {
                  $this->_ci->db->select('a.'.$v);
               }
               if(in_array('user_id', $params['module']['email'])){
                  $this->_ci->db->select('c.first_name as user_id');
                  $this->_ci->db->join('users as c', 'a.user_id = c.id');
               }

               if($params['mode_report'] == 1){
                  if($params['phone_number']){
                     $this->_ci->db->where_in('a.phone_number', $params['phone_number']);
                  }
               }  

               if($params['mode_report'] == 2){
                  if($params['by_modul_sdate_created'] !== '' || $params['by_modul_edate_created'] !== ''){
                     $by_modul_sdate_created = $params['by_modul_sdate_created'] !== '' ?  $params['by_modul_sdate_created'] :  $params['by_modul_edate_created'];
                     $by_modul_edate_created = $params['by_modul_edate_created'] !== '' ?  $params['by_modul_edate_created'] :  $params['by_modul_sdate_created'];
                     $this->_ci->db->where('DATE(a.created_date) BETWEEN "'.$by_modul_sdate_created.'" AND "'.$by_modul_edate_created.'"');
                  }
                  if($params['by_modul_sdate_expired'] !== '' || $params['by_modul_edate_expired'] !== ''){
                     $this->_ci->db->join('simcard as sc', 'a.phone_number = sc.phone_number', 'left');
                     $by_modul_sdate_expired = $params['by_modul_sdate_expired'] !== '' ?  $params['by_modul_sdate_expired'] :  $params['by_modul_edate_expired'];
                     $by_modul_edate_expired = $params['by_modul_edate_expired'] !== '' ?  $params['by_modul_edate_expired'] :  $params['by_modul_sdate_expired'];
                     $this->_ci->db->where('DATE(sc.expired_date) BETWEEN "'.$by_modul_sdate_expired.'" AND "'.$by_modul_edate_expired.'"');
                  }
               }
               $result = $this->_ci->db->get($key.' as a')->result_array();
               foreach ($result as $kk  =>  $vv) {
                  $data[$key][] = $vv;
               }
            break;
            case 'twitter':
               foreach ($params['module']['twitter'] as $v) {
                  if($v !== 'client_id_key' && $v !== 'proxy_id_key' && $v !== 'user_id_key' && $v !== 'email'){
                     $this->_ci->db->select('a.'.$v);
                  } 
               }
               if(in_array('status', $params['module']['twitter'])){
                  $this->_ci->db->select('b.name as status');
                  $this->_ci->db->join('twitter_status_detail as b', 'a.status = b.id');
               }
               if(in_array('client_id', $params['module']['twitter']) || in_array('client_id_key', $params['module']['twitter'])){
                  $this->_ci->db->select('d.name as client_id, d.id as client_id_key');
                  $this->_ci->db->join('client as d', 'a.client_id = d.id', 'left');
               }
               if(in_array('proxy_id', $params['module']['twitter']) || in_array('proxy_id_key', $params['module']['twitter'])){
                  // $this->_ci->db->select('concat("http://", e.username, ":", e.password, "@", e.ip_address, ":", e.port) as proxy_id');
                  $this->_ci->db->select('IF(e.username IS NULL OR e.password IS NULL, concat("http://", e.ip_address, ":", e.port), concat("http://", e.username, ":", e.password, "@", e.ip_address, ":", e.port)) as proxy_id, e.id as proxy_id_key');
                  $this->_ci->db->join('proxy as e', 'a.proxy_id = e.id', 'left');
               }
               if(in_array('user_id', $params['module']['twitter']) || in_array('user_id_key', $params['module']['twitter'])){
                  $this->_ci->db->select('c.first_name as user_id, c.id as user_id_key');
                  $this->_ci->db->join('users as c', 'a.user_id = c.id', 'left');
               }
               if(in_array('email', $params['module']['twitter'])){
                  $this->_ci->db->select('f.email as email');
                  $this->_ci->db->join('email as f', 'a.phone_number = f.phone_number', 'left');
               }

               if($params['mode_report'] == 1){
                  if($params['phone_number']){
                     $this->_ci->db->where_in('a.phone_number', $params['phone_number']);
                  }
               }  

               if($params['mode_report'] == 2){
                  if($params['by_modul_sdate_created'] !== '' || $params['by_modul_edate_created'] !== ''){
                     $by_modul_sdate_created = $params['by_modul_sdate_created'] !== '' ?  $params['by_modul_sdate_created'] :  $params['by_modul_edate_created'];
                     $by_modul_edate_created = $params['by_modul_edate_created'] !== '' ?  $params['by_modul_edate_created'] :  $params['by_modul_sdate_created'];
                     $this->_ci->db->where('DATE(a.created_twitter) BETWEEN "'.$by_modul_sdate_created.'" AND "'.$by_modul_edate_created.'"');
                  }
                  if($params['by_modul_sdate_expired'] !== '' || $params['by_modul_edate_expired'] !== ''){
                     $this->_ci->db->join('simcard as sc', 'a.phone_number = sc.phone_number', 'left');
                     $by_modul_sdate_expired = $params['by_modul_sdate_expired'] !== '' ?  $params['by_modul_sdate_expired'] :  $params['by_modul_edate_expired'];
                     $by_modul_edate_expired = $params['by_modul_edate_expired'] !== '' ?  $params['by_modul_edate_expired'] :  $params['by_modul_sdate_expired'];
                     $this->_ci->db->where('DATE(sc.expired_date) BETWEEN "'.$by_modul_sdate_expired.'" AND "'.$by_modul_edate_expired.'"');
                  }
               }

               $result = $this->_ci->db->get($key.' as a')->result_array();
               foreach ($result as $kk  =>  $vv) {
                  $data[$key][] = $vv;
               }
            break; 
            case 'facebook':
               foreach ($params['module']['facebook'] as $v) {
                  if($v !== 'client_id_key' && $v !== 'proxy_id_key' && $v !== 'user_id_key' && $v !== 'email'){
                     $this->_ci->db->select('a.'.$v);
                  } 
               }
               if(in_array('status', $params['module']['facebook'])){
                  $this->_ci->db->select('b.name as status');
                  $this->_ci->db->join('facebook_status as b', 'a.status = b.id', 'left');
               }
               if(in_array('client_id', $params['module']['facebook']) || in_array('client_id_key', $params['module']['facebook'])){
                  $this->_ci->db->select('d.name as client_id, d.id as client_id_key');
                  $this->_ci->db->join('client as d', 'a.client_id = d.id', 'left');
               }
               if(in_array('proxy_id', $params['module']['facebook']) || in_array('proxy_id_key', $params['module']['facebook'])){
                  // $this->_ci->db->select('e.ip_address as proxy_id');
                  $this->_ci->db->select('IF(e.username IS NULL OR e.password IS NULL, concat("http://", e.ip_address, ":", e.port), concat("http://", e.username, ":", e.password, "@", e.ip_address, ":", e.port)) as proxy_id, e.id as proxy_id_key');
                  $this->_ci->db->join('proxy as e', 'a.proxy_id = e.id', 'left');
               }
               if(in_array('user_id', $params['module']['facebook']) || in_array('user_id_key', $params['module']['facebook'])){
                  $this->_ci->db->select('c.first_name as user_id, c.id as user_id_key');
                  $this->_ci->db->join('users as c', 'a.user_id = c.id', 'left');
               }
               if(in_array('email', $params['module']['facebook'])){
                  $this->_ci->db->select('f.email as email');
                  $this->_ci->db->join('email as f', 'a.phone_number = f.phone_number', 'left');
               }

               if($params['mode_report'] == 1){
                  if($params['phone_number']){
                     $this->_ci->db->where_in('a.phone_number', $params['phone_number']);
                  }
               }  

               if($params['mode_report'] == 2){
                  if($params['by_modul_sdate_created'] !== '' || $params['by_modul_edate_created'] !== ''){
                     $by_modul_sdate_created = $params['by_modul_sdate_created'] !== '' ?  $params['by_modul_sdate_created'] :  $params['by_modul_edate_created'];
                     $by_modul_edate_created = $params['by_modul_edate_created'] !== '' ?  $params['by_modul_edate_created'] :  $params['by_modul_sdate_created'];
                     $this->_ci->db->where('DATE(a.created_facebook) BETWEEN "'.$by_modul_sdate_created.'" AND "'.$by_modul_edate_created.'"');
                  }
                  if($params['by_modul_sdate_expired'] !== '' || $params['by_modul_edate_expired'] !== ''){
                     $this->_ci->db->join('simcard as sc', 'a.phone_number = sc.phone_number', 'left');
                     $by_modul_sdate_expired = $params['by_modul_sdate_expired'] !== '' ?  $params['by_modul_sdate_expired'] :  $params['by_modul_edate_expired'];
                     $by_modul_edate_expired = $params['by_modul_edate_expired'] !== '' ?  $params['by_modul_edate_expired'] :  $params['by_modul_sdate_expired'];
                     $this->_ci->db->where('DATE(sc.expired_date) BETWEEN "'.$by_modul_sdate_expired.'" AND "'.$by_modul_edate_expired.'"');
                  }
               }

               $result = $this->_ci->db->get($key.' as a')->result_array();
               foreach ($result as $kk  =>  $vv) {
                  $data[$key][] = $vv;
               }
            break;   
            case 'instagram':
               foreach ($params['module']['instagram'] as $v) {
                  if($v !== 'client_id_key' && $v !== 'proxy_id_key' && $v !== 'user_id_key' && $v !== 'email'){
                     $this->_ci->db->select('a.'.$v);
                  } 
               }
               if(in_array('status', $params['module']['instagram'])){
                  $this->_ci->db->select('b.name as status');
                  $this->_ci->db->join('instagram_status as b', 'a.status = b.id');
               }
               if(in_array('client_id', $params['module']['instagram']) || in_array('client_id_key', $params['module']['instagram'])){
                  $this->_ci->db->select('d.name as client_id, d.id as client_id_key');
                  $this->_ci->db->join('client as d', 'a.client_id = d.id', 'left');
               }
               if(in_array('proxy_id', $params['module']['instagram']) || in_array('proxy_id_key', $params['module']['instagram'])){
                  // $this->_ci->db->select('e.ip_address as proxy_id');
                  $this->_ci->db->select('IF(e.username IS NULL OR e.password IS NULL, concat("http://", e.ip_address, ":", e.port), concat("http://", e.username, ":", e.password, "@", e.ip_address, ":", e.port)) as proxy_id, e.id as proxy_id_key');
                  $this->_ci->db->join('proxy as e', 'a.proxy_id = e.id', 'left');
               }
               if(in_array('user_id', $params['module']['instagram']) || in_array('user_id_key', $params['module']['instagram'])){
                  $this->_ci->db->select('c.first_name as user_id, c.id as user_id_key');
                  $this->_ci->db->join('users as c', 'a.user_id = c.id', 'left');
               }
               if(in_array('email', $params['module']['instagram'])){
                  $this->_ci->db->select('f.email as email');
                  $this->_ci->db->join('email as f', 'a.phone_number = f.phone_number', 'left');
               }

               if($params['mode_report'] == 1){
                  if($params['phone_number']){
                     $this->_ci->db->where_in('a.phone_number', $params['phone_number']);
                  }
               }  

               if($params['mode_report'] == 2){
                  if($params['by_modul_sdate_created'] !== '' || $params['by_modul_edate_created'] !== ''){
                     $by_modul_sdate_created = $params['by_modul_sdate_created'] !== '' ?  $params['by_modul_sdate_created'] :  $params['by_modul_edate_created'];
                     $by_modul_edate_created = $params['by_modul_edate_created'] !== '' ?  $params['by_modul_edate_created'] :  $params['by_modul_sdate_created'];
                     $this->_ci->db->where('DATE(a.created_instagram) BETWEEN "'.$by_modul_sdate_created.'" AND "'.$by_modul_edate_created.'"');
                  }
                  if($params['by_modul_sdate_expired'] !== '' || $params['by_modul_edate_expired'] !== ''){
                     $this->_ci->db->join('simcard as sc', 'a.phone_number = sc.phone_number', 'left');
                     $by_modul_sdate_expired = $params['by_modul_sdate_expired'] !== '' ?  $params['by_modul_sdate_expired'] :  $params['by_modul_edate_expired'];
                     $by_modul_edate_expired = $params['by_modul_edate_expired'] !== '' ?  $params['by_modul_edate_expired'] :  $params['by_modul_sdate_expired'];
                     $this->_ci->db->where('DATE(sc.expired_date) BETWEEN "'.$by_modul_sdate_expired.'" AND "'.$by_modul_edate_expired.'"');
                  }
               }
               
               $result = $this->_ci->db->get($key.' as a')->result_array();
               foreach ($result as $kk  =>  $vv) {
                  $data[$key][] = $vv;
               }
            break;         
         }
      }
      return isset($data) ? $data : NULL;
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

   public function excelColumnRange($lower, $upper) {
      ++$upper;
      for ($i = $lower; $i !== $upper; ++$i) {
         $data[] = $i;
      }
      return $data;
   }
}