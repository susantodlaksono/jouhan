<?php

class M_summary extends CI_Model{

	public function all_count($table, $sdate, $edate){
		if($sdate && $edate){
			$this->db->where('date(created_date) BETWEEN "'.$sdate.'" AND "'.$edate.'"');
		}
		return number_format($this->db->count_all_results($table), 0, false, ".");
	}

	public function get_data($table){
		switch ($table) {
			case 'facebook':
				$this->db->select('count(phone_number) as total_akun,avg(friends) as avg_friends,sum(friends) as sum_friends');
				$hasil = $this->db->get($table)->row_array();
				break;
			case 'instagram':
				$this->db->select('count(id) as total_acc, avg(followers) as avg_followers, sum(followers) as total_followers');
				$hasil = $this->db->get($table)->row_array();
				break;
			case 'twitter':
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

	public function get_status($table,$mode){
		switch ($mode) {
			case 'no_action':
				$this->db->select('count(status) as total');
				$this->db->where('status',0);
				return $this->db->get($table)->row_array();
			
			case 'active':
				$this->db->select('count(status) as total');
				$this->db->where('status',1);
				return $this->db->get($table)->row_array();

			case 'blocked':
				$this->db->select('count(status) as total');
				$this->db->where('status',2);
				return $this->db->get($table)->row_array();
		}
	}

	public function get_data_simcard($table){
      switch ($table) {
         case 'simcard':
            $this->db->select('count(phone_number) as total_acc,sum(saldo) as total_saldo');
            $hasil = $this->db->get($table)->row_array();
            break;
         case 'rak':
            $this->db->select('count(id) as total_rak');
            $hasil = $this->db->get($table)->row_array();
            break;
         case 'email':
            $this->db->select('count(id) as total_acc');
            $hasil = $this->db->get($table)->row_array();
            break;
         case 'facebook':
            $this->db->select('count(phone_number) as total_acc,avg(friends) as avg_friends,sum(friends) as sum_friends');
            $hasil = $this->db->get($table)->row_array();
            break;
         case 'instagram':
            $this->db->select('count(id) as total_acc, avg(followers) as avg_followers, sum(followers) as total_followers');
            $hasil = $this->db->get($table)->row_array();
            break;
         case 'twitter':
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

   public function get_status_simcard($table,$mode){
      switch ($mode) {
         case 'no_action':
            $this->db->select('count(status) as total');
            $this->db->where('status',0);
            return $this->db->get($table)->row_array();
         case 'active':
            $this->db->select('count(status) as total');
            $this->db->where('status',1);
            return $this->db->get($table)->row_array();

         case 'blocked':
            $this->db->select('count(status) as total');
            $this->db->where('status',2);
            return $this->db->get($table)->row_array();
      }
   }
   
   public function get_reg_simcard($table,$mode){
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