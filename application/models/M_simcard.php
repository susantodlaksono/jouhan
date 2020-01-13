<?php

class M_simcard extends CI_Model{

	public function get($mode,$params){
      $itemspage = $params['filter_rows'] == '' ? 10 : $params['filter_rows'];

		$this->db->select('a.*, c.no as no_rak, c.nama_rak, b.product as provider_name, u.first_name as pic, g.first_name as pic_updated');
      $this->db->join('users as u','u.id = a.user_id', 'left');
		$this->db->join('users as g','a.updated_user_id = g.id', 'left');
      $this->db->join('rak as c', 'c.id = a.rak_id', 'left');
      $this->db->join('provider as b', 'b.id = a.provider_id', 'left');

      if($params['filter_sort'] == 'tw.created_twitter' || $params['filter_createddate_socmed_sdate']  != '' && $params['filter_createddate_socmed_sdate']  != ''){
         $this->db->join('twitter as tw', 'a.phone_number = tw.phone_number', 'left');
         if($params['filter_createddate_socmed_type'] == 'twitter'){
            $this->db->where('tw.created_twitter between "'.$params['filter_createddate_socmed_sdate'].'" and "'.$params['filter_createddate_socmed_edate'].'"');
         }
      }
      if($params['filter_sort'] == 'fb.created_facebook' || $params['filter_createddate_socmed_edate']  != '' && $params['filter_createddate_socmed_sdate']  != ''){
         $this->db->join('facebook as fb', 'a.phone_number = fb.phone_number', 'left');
         if($params['filter_createddate_socmed_type'] == 'facebook'){
            $this->db->where('fb.created_facebook between "'.$params['filter_createddate_socmed_sdate'].'" and "'.$params['filter_createddate_socmed_edate'].'"');
         }
      }
      if($params['filter_sort'] == 'ig.created_instagram' || $params['filter_createddate_socmed_edate']  != '' && $params['filter_createddate_socmed_sdate']  != ''){
         $this->db->join('instagram as ig', 'a.phone_number = ig.phone_number', 'left');
         if($params['filter_createddate_socmed_type'] == 'instagram'){
            $this->db->where('ig.created_instagram between "'.$params['filter_createddate_socmed_sdate'].'" and "'.$params['filter_createddate_socmed_edate'].'"');
         }
      }
      if($params['filter_createddate_socmed_type'] == 'simcard'){
         // $this->db->where('date(a.created_date)', $params['filter_createddate_socmed']);
         $this->db->where('date(a.created_date) between "'.$params['filter_createddate_socmed_sdate'].'" and "'.$params['filter_createddate_socmed_edate'].'"');
      }
      if($params['filter_keyword'] != ""){
         $this->db->group_start();
         $this->db->like('a.phone_number', $params['filter_keyword']);
         $this->db->or_like('a.nik', $params['filter_keyword']);
         $this->db->or_like('a.nkk', $params['filter_keyword']);
         $this->db->or_like('a.saldo', $params['filter_keyword']);
         $this->db->or_like('a.info', $params['filter_keyword']);
         $this->db->or_like('u.first_name', $params['filter_keyword']);
         $this->db->group_end();
      }

      if($params['filter_expireddate_sdate'] != '' && $params['filter_expireddate_edate'] != ''){
         $this->db->where('a.expired_date between "'.$params['filter_expireddate_sdate'].'" and "'.$params['filter_expireddate_edate'].'"');
      }

      if($params['filter_provider'] != ""){
         if(in_array('none', $params['filter_provider'])){
            $this->db->where('a.provider_id IS NULL');
         }else{
            $this->db->where_in('a.provider_id', $params['filter_provider']);
         }
      }

      if($params['filter_rak'] != ""){
         $this->db->where_in('c.id', $params['filter_rak']);
      }

      if($params['filter_status'] != ""){
         $this->db->where('a.status', $params['filter_status']);
      }

      if($params['filter_type'] != ""){
         $this->db->where('a.phone_number_type', $params['filter_type']);
      }

		$this->db->order_by($params['filter_sort'], $params['filter_sort_type']);
		switch ($mode) {
			case 'get':
				return $this->db->get('simcard as a', $itemspage, $params['offset'])->result_array();
			case 'count':
				return $this->db->get('simcard as a')->num_rows();
		}
	}

   public function suggest_provider($phone_number){
      $phone = substr($phone_number, 0, 4);
      $this->db->select('id');
      $this->db->where('MATCH(code_number) AGAINST ("'.$phone.'")');
      $rs = $this->db->get('provider');
      if($rs->num_rows() > 0){
         $row = $rs->row_array();
         return $row['id'];
      }else{
         return NULL;
      }
   }

   public function create($params){
      $compare_left_days = $this->compare_left_days(date('Y-m-d'), $params['expired_date']);
      if($compare_left_days['opr'] == '+' && $compare_left_days['digit'] <= 7){
         $status = 0;
      }
      if($compare_left_days['opr'] == '+' && $compare_left_days['digit'] > 7){
         $status = 1;
      }
      if($compare_left_days['opr'] == '-'){
         $status = 2;
      }
      $obj = array(
         'phone_number' => $params['phone_number'],
         'active_period' => $params['active_period'],
         'expired_date' => $params['expired_date'],
         'created_date' => date('Y-m-d H:i:s'),
         'nik' => $params['nik'] ? $params['nik'] : NULL,
         'nkk' => $params['nkk'] ? $params['nkk'] : NULL,
         'saldo' => $params['saldo'] ? $params['saldo'] : NULL,
         'provider_id' => $params['provider'] ? $params['provider'] : NULL,
         'rak_id' => $params['rak'],
         'status' => $status,
         'user_id' => $params['user_id'],
         'phone_number_type' => $params['phone_number_type'],
         'info' => $params['info'] ? $params['info'] : NULL,
      );
      return $this->db->insert('simcard', $obj);
   }

   public function compare_left_days($sdate, $edate){
      $datetime1 = new DateTime($sdate);
      $datetime2 = new DateTime($edate);
      $interval = $datetime1->diff($datetime2);
      $data['opr'] = $interval->format('%R');
      $data['digit'] = $interval->format('%a');
      return $data;
   }

   public function change($params){
      $compare_left_days = $this->compare_left_days(date('Y-m-d'), $params['expired_date']);
      if($compare_left_days['opr'] == '+' && $compare_left_days['digit'] <= 7){
         $status = 0;
      }
      if($compare_left_days['opr'] == '+' && $compare_left_days['digit'] > 7){
         $status = 1;
      }
      if($compare_left_days['opr'] == '-'){
         $status = 2;
      }
      $obj = array(
         'phone_number' => $params['phone_number'],
         'active_period' => $params['active_period'],
         'expired_date' => $params['expired_date'],
         'nik' => $params['nik'] ? $params['nik'] : NULL,
         'nkk' => $params['nkk'] ? $params['nkk'] : NULL,
         'saldo' => $params['saldo'] ? $params['saldo'] : NULL,
         'provider_id' => $params['provider'] ? $params['provider'] : NULL,
         'rak_id' => $params['rak'],
         'status' => $status,
         'updated_user_id' => $params['user_id'],
         'updated_date' => date('Y-m-d H:i:s'),
         'phone_number_type' => $params['phone_number_type'],
         'info' => $params['info'] ? $params['info'] : NULL
      );
      return $this->db->update('simcard', $obj, array('phone_number' => $params['phone_number_before']));
   }

   public function delete($params){
      return $this->db->delete('simcard', array('phone_number' => $params['id']));
   }

   public function bulk_action($params){
      $count = 0;
      if($params['mode'] == 'status'){
         foreach ($params['data'] as $v) {
            if($params['value'] == 3){
               $obj = array(
                  'active_period' => NULL,
                  'expired_date' => NULL,
                  'status' => $params['value']
               );
            }else{
               $obj = array(
                  'status' => $params['value']
               );
            }
            $this->db->where('phone_number', $v);
            $rs = $this->db->update('simcard', $obj);
            $rs ? $count++ : FALSE;
         }
      }
      if($params['mode'] == 'type'){
         foreach ($params['data'] as $v) {
            $obj = array(
               'phone_number_type' => $params['value']
            );
            $this->db->where('phone_number', $v);
            $rs = $this->db->update('simcard', $obj);
            $rs ? $count++ : FALSE;
         }
      }
      return $count;
   }

   public function assign_rak($params){
      $count = 0;
      foreach ($params['data'] as $v) {
         $obj = array(
            'rak_id' => $params['assign_rak']
         );
         $this->db->where('phone_number', $v);
         $rs = $this->db->update('simcard', $obj);
         $rs ? $count++ : FALSE;
      }
      return $count;
   }

   public function insertImport($data){
      $this->db->insert_batch('simcard',$data);
      return $this->db->inser_id();
   }


}
?>