<?php

class M_dashboard extends CI_Model{

   public function all_count($table, $sdate, $edate){
      if($sdate && $edate){
         $this->db->where('date(created_date) BETWEEN "'.$sdate.'" AND "'.$edate.'"');
      }
      return $this->db->count_all_results($table);
   }

   public function get_data($table, $user_id){
      switch ($table) {
         case 'simcard':
            $this->db->select('count(phone_number) as total_acc,sum(saldo) as total_saldo');
            if($user_id != ''){
               $this->db->where('user_id', $user_id);
            }
            $hasil = $this->db->get($table)->row_array();
            break;
         case 'rak':
            $this->db->select('count(id) as total_rak');
            $hasil = $this->db->get($table)->row_array();
            break;
         case 'email':
            $this->db->select('count(id) as total_acc');
            if($user_id != ''){
               $this->db->where('user_id', $user_id);
            }
            $hasil = $this->db->get($table)->row_array();
            break;
         case 'facebook':
            $this->db->select('count(phone_number) as total_acc,');
            $this->db->select('avg(friends) as avg_friends, sum(friends) as total_friends');
            if($user_id != ''){
               $this->db->where('user_id', $user_id);
            }
            $hasil = $this->db->get($table)->row_array();
            break;
         case 'instagram':
            $this->db->select('count(id) as total_acc, avg(followers) as avg_followers, sum(followers) as total_followers');
            if($user_id != ''){
               $this->db->where('user_id', $user_id);
            }
            $hasil = $this->db->get($table)->row_array();
            break;
         case 'twitter':
            $this->db->select('count(id) as total_acc, avg(followers) as avg_followers, sum(followers) as total_followers');
            if($user_id != ''){
               $this->db->where('user_id', $user_id);
            }
            $hasil = $this->db->get($table)->row_array();
            break;
         case 'list_twitter':
            $this->db->select('count(id) as total_acc, avg(followers) as avg_followers, sum(followers) as total_followers');
            $hasil = $this->db->get($table)->row_array();
            break;
      }
      if($hasil){
         return $hasil;
      }else{
         return false;
      }
   }

   public function get_listTw(){
      $this->db->select('tsd.name as name_status');
      $this->db->join('twitter_status_detail as tsd','t.status=tsd.id','left');
      $this->db->get('twitter as t')->row_array();
   }

   public function get_status($table, $status = array(), $user_id){
      $this->db->select('count(status) as total');
      if($user_id != ''){
         $this->db->where('user_id', $user_id);
      }
      $this->db->where_in('status', $status);
      return $this->db->count_all_results($table);
   }
   
   public function get_reg($table,$mode){
      switch ($mode) {
         case 'registered':
            $this->db->select('count(phone_number) as total');
            $this->db->where('nik !=', NULL);
            $this->db->where('nkk !=', NULL);
            $this->db->where('status ', 1);
            return $this->db->get($table)->row_array();
         break;
         case 'unregistered':
            $this->db->select('count(phone_number) as total');
            $this->db->where('nik =', NULL);
            $this->db->where('nkk =', NULL);
            return $this->db->get($table)->row_array();
         break;
      }
   }
}