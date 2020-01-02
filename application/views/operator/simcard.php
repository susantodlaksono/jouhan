<style type="text/css">
   #select2-drop{
      z-index: 9999999999;
   }
   .page-body .select2-container .select2-choice{
      height:30px;
      line-height:30px;
   }
</style>

<div class="row">
   <div class="col-md-12">
      <div class="panel panel-primary" data-collapsed="0">
         <div class="panel-heading">
            <div class="panel-title"><i class="fa fa-list"></i> List Simcard </div>
            <div class="panel-options" style="width: auto;border:0px solid black;">
               <div class="form-group" style="margin-top: 8px;margin-bottom: 5px;">  
                  <div class="btn-group dropdown-default"> 
                     <button class="btn btn-white btn-sm" data-toggle="modal" data-target="#modal-migrasi-all"><i class="fa fa-upload"></i> Migration</button>
                  </div> 
                  <div class="btn-group dropdown-default"> 
                     <button class="btn btn-white btn-sm" data-toggle="modal" data-target="#modal-bulk-phone"><i class="fa fa-upload"></i> Bulk</button>
                  </div>  
                  <div class="btn-group dropdown-default"> 
                     <select class="form-control input-sm" id="filter_rows">
                        <option value="">Number of rows</option>
                        <option value="50">50</option>
                        <option value="70">70</option>
                        <option value="100">100</option>
                        <option value="200">200</option>
                     </select>
                  </div>
                  <div class="btn-group dropdown-default"> 
                     <a class="btn btn-white btn-sm dropdown-toggle" data-toggle="dropdown" href="#" style="width: auto;" aria-expanded="true"> 
                        <i class="fa fa-gear"></i> Bulk Action <span class="caret"></span>
                     </a>
                     <ul class="dropdown-menu " style="width: auto;">
                        <li style="font-weight: bold;text-align: center;">Set Status</li>
                        <div class="divider"></div>
                        <li style="font-size: 13px;"><a href="#" class="bulk_action" data-mode="status" data-value="0">Set Need Top-Up</a></li>
                        <li style="font-size: 13px;"><a href="#" class="bulk_action" data-mode="status" data-value="1">Set Active</a></li>   
                        <li style="font-size: 13px;"><a href="#" class="bulk_action" data-mode="status" data-value="2">Set Expired</a></li>   
                        <li style="font-size: 13px;"><a href="#" class="bulk_action" data-mode="status" data-value="3">Set Removed</a></li>   
                        <div class="divider"></div>
                        
                        <li style="font-weight: bold;text-align: center;">Set Type</li>
                        <div class="divider"></div>
                        <li style="font-size: 13px;"><a href="#" class="bulk_action" data-mode="type" data-value="1">Set Fisik</a></li>   
                        <li style="font-size: 13px;"><a href="#" class="bulk_action" data-mode="type" data-value="2">Set Cloud</a></li>
                        <div class="divider"></div>

                        <li style="font-weight: bold;text-align: center;">Assign</li>
                        <div class="divider"></div>
                        <li style="font-size: 13px;"><a href="#" class="assign-rak" data-toggle="modal" data-target="#modal-assign-rak">To Rak</a></li>   
                     </ul>
                  </div>
                  <button class="btn btn-white btn-sm btn-filter" data-toggle="modal" data-target="#modal-filter"><i class="fa fa-filter"></i> Filter</button>
                  <button class="btn btn-white btn-sm btn-new" data-toggle="modal" data-target="#modal-create"><i class="fa fa-plus"></i> Create</button>
               </div>
            </div>
         </div>
         <div class="panel-body">
            <input type="hidden" id="offset" value="0">
            <input type="hidden" id="curpage" value="1">
            <table class="table">
               <thead>
                  <th>
                     <input type="checkbox" class="select_id">
                     <label for="checkbox_choose"></label>
                  </th>
                  <th>Created Date</th>
                  <th>Phone Number</th>
                  <th>Active Period</th>
                  <th>Expired Date</th>
                  <!-- <th>Info</th> -->
                  <th>Saldo</th>
                  <th>Rak</th>
                  <th class="text-center">Register In</th>
                  <!-- <th>Last Check</th> -->
                  <th>Status</th>
                  <th></th>

                  <th></th>
               </thead>
               <tbody id="sect-data"></tbody>
            </table>
            <div class="row">
               <div class="col-md-6">
                  <h4 id="sect-total"></h4>
               </div>
               <div class="col-md-6">
                  <ul id="sect-pagination" class="pagination pagination-sm no-margin pull-right"></ul> 
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<div class="modal fade" id="modal-assign-rak">
   <div class="modal-dialog" style="width: 35%;">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Assign Rak</h4>
         </div>
         <form id="form-assign-rak">
            <div class="modal-body">
               <div class="form-group">
                  <label>To Rak</label>
                  <select name="assign_rak" class="form-control choose" id="assign_rak">
                     <?php
                        $data = $this->db->get('rak')->result_array();
                        foreach ($data as $value) {
                           echo '<option value="'.$value['id'].'">'.$value['nama_rak'].' (Rak '.$value['no'].')</option>';
                        }
                     ?>
                  </select>
               </div>
               <div class="form-group">
                  <input type="checkbox" class="with_download" name="with_download_mode" value="1"> With Download Selected
                  <select class="form-control choose" multiple="" name="module[simcard][]" disabled="" id="with_download_field">
                     <?php
                        foreach ($field['simcard'] as $key => $value) {
                           echo '<option value="'.$key.'">'.$value.'</option>';
                        }
                     ?>
                  </select>
               </div>
               <h5 class="bold">Your File :</h5>
               <p class="text-muted"><a id="your-file" class="text-center"></a></p>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-white btn-block">Assign</button>
            </div>
         </form>
      </div>
   </div>
</div>

<div class="modal" id="modal-filter">
   <div class="modal-dialog" style="width: 50%;">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3 class="modal-title bold"><i class="fa fa-filter"></i> Filter</h3>
         </div>
         <div class="modal-body">
            <form id="form-filter">
               <div class="form-group">
                  <label>Keyword</label>
                  <input type="text" class="form-control" id="filter_keyword" value="">
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>Expired Date</label>
                        <input type="hidden" name="filter_expireddate_sdate" id="filter_expireddate_sdate">
                        <input type="hidden" name="filter_expireddate_edate" id="filter_expireddate_edate">
                        <div class="input-group">
                           <input type="text" class="form-control filter_expireddate">
                           <div class="input-group-addon set-empty" data-target="filter_expireddate" style="cursor: pointer;">Empty</div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>Created Date</label>
                        <input type="hidden" name="filter_createddate_socmed_sdate" id="filter_createddate_socmed_sdate">
                        <input type="hidden" name="filter_createddate_socmed_edate" id="filter_createddate_socmed_edate">
                        <div class="input-group">
                           <input type="text" class="form-control filter_createddate_socmed">
                           <div class="input-group-addon" style="width: 100px;padding: 1px;margin: 0px;">
                              <select id="filter_createddate_socmed_type" class="form-control input-sm">
                                 <option value="twitter" selected="">Twitter</option>
                                 <option value="facebook">Facebook</option>
                                 <option value="instagram">Instagram</option>
                                 <option value="simcard">Simcard</option>
                              </select>
                           </div>
                           <div class="input-group-addon set-empty" data-target="filter_createddate_socmed" style="cursor: pointer;">Empty</div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>Status</label>
                        <select id="filter_status" class="form-control">
                           <option value=""></option>
                           <option value="1">Active</option>
                           <option value="0">Need Top-up Credits</option>
                           <option value="2">Change Number / Expired</option>
                           <option value="3">Removed</option>
                           <!-- <option value="3">Expired</option> -->
                        </select>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>Type</label>
                        <select id="filter_type" class="form-control">
                           <option value=""></option>
                           <option value="1">Fisik</option>
                           <option value="2">Cloud</option>
                        </select>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>Provider</label>
                        <select id="filter_provider" name="filter_provider" class="form-control choose" multiple="">
                          <option value="none">No Provider</option>
                           <?php
                                 $datas = $this->db->select('id,product,provider')->get('provider'); 
                                 foreach ($datas->result_array() as $value) {
                                    echo '<option value="'.$value['id'].'">'.$value['product'].'</option>';
                                 }
                           ?>
                        </select>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>Rak</label>
                        <select id="filter_rak" class="form-control choose" multiple="">
                           <?php
                                 $data = $this->db->get('rak')->result_array();
                                 foreach ($data as $value) {
                                    echo '<option value="'.$value['id'].'">'.$value['nama_rak'].' (Rak '.$value['no'].')</option>';
                                 }
                           ?>
                        </select>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>Sort By</label>
                        <select id="filter_sort" class="form-control">
                           <option value="a.created_date" selected="">Created Date Simcard</option>
                           <option value="a.phone_number">Phone Number</option>
                           <option value="a.expired_date">Expired Date</option>
                           <option value="a.active_period">Active Period</option>
                           <option value="a.rak_id">Rak</option>
                           <option value="a.status">Status</option>
                           <option value="a.saldo">Saldo</option>
                           <option value="tw.created_twitter">Created Date Twitter</option>
                           <option value="fb.created_facebook">Created Date Facebook</option>
                           <option value="ig.created_instagram">Created Date Instagram</option>
                        </select>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>Type Sort</label>
                        <select id="filter_sort_type" class="form-control">
                           <option value="desc" selected="">Descending</option>
                           <option value="asc">Ascending</option>
                        </select>
                     </div>
                  </div>
               </div>
            </form>
         </div>
         <div class="modal-footer">
            <div class="col-md-12">
               <button type="button" class="btn btn-white btn-block btn-reset">Reset</button>
               <button type="button" class="btn btn-white btn-block btn-search"><i class="fa fa-search"></i> Search</button>
            </div>
         </div>
      </div>
   </div>
</div>

<div class="modal" id="modal-create">
   <div class="modal-dialog" style="width: 70%;">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3 class="modal-title bold"><i class="fa fa-plus"></i> Create Data</h3>
         </div>
         <form id="form-add">
            <div class="modal-body">
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <div class="row">
                           <div class="col-md-9">
                              <label>Phone Number <span class="text-require">(*)</span></label>
                              <input type="number" class="form-control" name="phone_number" required="">
                           </div>
                           <div class="col-md-3">
                              <button class="btn btn-white btn-suggest-provider" type="button" data-type="create" style="margin-left:-25px;margin-top:22px;"><i class="fa fa-refresh"></i> Cek Provider</button>
                           </div>
                        </div>
                     </div>
                     <div class="form-group">
                        <label>Active Period <span class="text-require">(*)</span></label>
                        <input type="hidden" name="active_period">
                        <div class="input-group">
                           <input type="text" class="form-control date-data" required="" data-formrender="#form-add" data-to="active_period">
                           <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                        </div>
                     </div>
                     <div class="form-group">
                        <label>Expired Date <span class="text-require">(*)</span></label>
                        <input type="hidden" name="expired_date">
                        <div class="input-group">
                           <input type="text" class="form-control date-data date-data-expired" required="" data-formrender="#form-add" data-to="expired_date">
                           <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                        </div>
                     </div>
                     <div class="form-group">
                        <label>NIK</label>
                        <input type="number" class="form-control" name="nik">
                     </div>
                     <div class="form-group">
                        <label>No KK (Kartu Keluarga)</label>
                        <input type="number" class="form-control" name="nkk">
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>Saldo</label>
                        <input type="number" class="form-control" name="saldo">
                     </div>
                     <div class="form-group">
                        <label>Nama Provider</label>
                        <select name="provider" class="form-control choose" id="provider_insert">
                          <option value=""></option>
                           <?php
                              $data = $this->db->get('provider')->result_array();
                              foreach ($data as $value) {
                                 echo '<option value="'.$value['id'].'">'.$value['product'].' - '.$value['provider'].'</option>';
                              }
                           ?>
                        </select>
                     </div>
                     <div class="form-group">
                        <label>Rak <span class="text-require">(*)</span></label>
                        <select name="rak" class="form-control choose">
                          <option value=""></option>
                           <?php
                                 $data = $this->db->get('rak')->result_array();
                                 foreach ($data as $value) {
                                    echo '<option value="'.$value['id'].'">'.$value['nama_rak'].' (Rak '.$value['no'].')</option>';
                                 }
                           ?>
                        </select>
                     </div>
                     <div class="form-group">
                        <label>Type No</label>
                        <select name="phone_number_type" class="form-control">
                           <option value="1">Fisik</option>
                           <option value="2">Cloud</option>
                        </select>
                     </div>
                     <div class="form-group">
                        <label>Info</label>
                        <textarea class="form-control" name="info"></textarea>
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-white btn-block"><i class="fa fa-save"></i> Submit</button> 
            </div>
         </form>
      </div>
   </div>
</div>

<div class="modal fade" id="modal-edit">
   <div class="modal-dialog" style="width: 70%;">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
             <h3 class="modal-title bold"><i class="fa fa-edit"></i> Edit Data</h3>
         </div>
         <form id="form-edit">
            <input type="hidden" name="phone_number_before" value="">
            <div class="modal-body">
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <div class="row">
                           <div class="col-md-9">
                              <label>Phone Number <span class="text-require">(*)</span></label>
                              <input type="number" class="form-control" name="phone_number" required="">
                           </div>
                           <div class="col-md-3">
                              <button class="btn btn-white btn-suggest-provider" type="button" data-type="edit" style="margin-left:-25px;margin-top:22px;"><i class="fa fa-refresh"></i> Suggest Provider</button>
                           </div>
                        </div>
                     </div>
                     <div class="form-group">
                        <label>Active Period <span class="text-require">(*)</span></label>
                        <input type="hidden" name="active_period">
                        <div class="input-group">
                           <input type="text" class="form-control date-data date-data-activeperiod" required="" data-formrender="#form-edit" data-to="active_period">
                           <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                        </div>
                     </div>
                     <div class="form-group">
                        <label>Expired Date <span class="text-require">(*)</span></label>
                        <input type="hidden" name="expired_date">
                        <div class="input-group">
                           <input type="text" class="form-control date-data date-data-expired" required="" data-formrender="#form-edit" data-to="expired_date">
                           <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                        </div>
                     </div>
                     <div class="form-group">
                        <label>NIK</label>
                        <input type="number" class="form-control" name="nik">
                     </div>
                     <div class="form-group">
                        <label>No KK (Kartu Keluarga)</label>
                        <input type="number" class="form-control" name="nkk">
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>Saldo</label>
                        <input type="number" class="form-control" name="saldo">
                     </div>
                     <div class="form-group">
                        <label>Nama Provider</label>
                        <select name="provider" class="form-control choose" id="provider_update">
                          <option value=""></option>
                           <?php
                              $data = $this->db->get('provider')->result_array();
                              foreach ($data as $value) {
                                 echo '<option value="'.$value['id'].'">'.$value['product'].' - '.$value['provider'].'</option>';
                              }
                           ?>
                        </select>
                     </div>
                     <div class="form-group">
                        <label>Rak <span class="text-require">(*)</span></label>
                        <select name="rak" class="form-control choose">
                          <option value=""></option>
                           <?php
                                 $data = $this->db->get('rak')->result_array();
                                 foreach ($data as $value) {
                                    echo '<option value="'.$value['id'].'">'.$value['nama_rak'].' (Rak '.$value['no'].')</option>';
                                 }
                           ?>
                        </select>
                     </div>
                     <!-- <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                           <option value="1">Active</option>
                           <option value="0">Need Top-up Credits</option>
                           <option value="2">Change Number</option>
                           <option value="3">Deactive</option>
                        </select>
                     </div> -->
                     <div class="form-group">
                        <label>Type Number</label>
                        <select name="phone_number_type" class="form-control">
                           <option value="1">Fisik</option>
                           <option value="2">Cloud</option>
                        </select>
                     </div>
                     <div class="form-group">
                        <label>Info</label>
                        <textarea class="form-control" name="info"></textarea>
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-white btn-block"><i class="fa fa-save"></i> Update</button> 
            </div>
         </form>
      </div>
   </div>
</div>

<div class="modal fade" id="modal-migrasi-all">
   <div class="modal-dialog" style="width: 35%;">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3 class="modal-title bold"><i class="fa fa-upload"></i> Migration</h3>
         </div>
         <form id="form-migration">
            <div class="modal-body">
               <h5 class="text-center">Download the file format below</h5>
               <p class="text-muted text-center bold" style="margin-top: -5px;"><a href="<?php echo site_url() ?>simcard/download_format" class="text-center">Format Migration Simcard.xlsx</a></p>
               <div class="form-group">
                  <label>Upload Format</label>
                  <input type="file" name="userfile" class="form-control">
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-white btn-block"><i class="fa fa-upload"></i> Upload</button>
            </div>
         </form>
      </div>
   </div>
</div>

<div class="modal fade" id="modal-bulk-phone">
   <div class="modal-dialog" style="width: 35%;">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3 class="modal-title"><i class="fa fa-upload"></i> Bulk</h3>
         </div>
         <form id="form-bulk-phone">
            <div class="modal-body">
               <h5 class="text-center">Download the file format below</h5>
               <p class="text-muted text-center bold" style="margin-top: -5px;"><a href="<?php echo site_url('simcard/bulkFormat') ?>" class="text-center"> PhoneNumberList.xlsx</a></p>
               <div class="form-group">
                  <label>Upload Format</label>
                  <input type="file" name="userfile" class="form-control">
               </div>
               <!-- <div class="form-group">
                  <label>To Client</label>
                  <div class="input-group">
                     <div class="input-group-addon">
                        <input name="tags_assign_rak" type="checkbox" class="select_field" data-type="select" data-field="assign_rak" data-form="#form-bulk-phone">
                     </div>
                     <select name="assign_rak" class="form-control choose" id="assign_client" disabled="">
                        <?php
                           $data = $this->db->get('rak')->result_array();
                           echo '<option value="">No Rak</option>';
                           foreach ($data as $value) {
                              echo '<option value="'.$value['id'].'">'.$value['nama_rak'].' (Rak '.$value['no'].')</option>';
                           }
                        ?>
                     </select>
                  </div>
               </div>
               <div class="form-group" style="display: none;">
                  <label>To Status</label>
                  <div class="input-group">
                     <div class="input-group-addon">
                        <input name="tags_assign_status" type="checkbox" class="select_field" data-type="select" data-field="assign_status" data-form="#form-bulk-phone">
                     </div>
                     <select name="assign_status" class="form-control choose" id="assign_status" disabled="">
                        <option value="1">Active</option>
                        <option value="0">Need Top-up Credits</option>
                        <option value="2">Change Number</option>
                        <option value="3">Deactive</option>
                     </select>
                  </div>
               </div>
               <div class="form-group">
                  <label>To Provider</label>
                  <div class="input-group">
                     <div class="input-group-addon">
                        <input name="tags_assign_provider" type="checkbox" class="select_field" data-type="select" data-field="assign_provider" data-form="#form-bulk-phone">
                     </div>
                     <select name="assign_provider" class="form-control choose" id="assign_provider" disabled="">
                        <option value="">No Provider</option>
                        <?php
                           $data = $this->db->get('provider')->result_array();
                           foreach ($data as $value) {
                              echo '<option value="'.$value['id'].'">'.$value['product'].' - '.$value['provider'].'</option>';
                           }
                        ?>
                     </select>
                  </div>
               </div>
               <div class="form-group">
                  <label>To Active Period</label>
                  <div class="input-group">
                     <div class="input-group-addon">
                        <input name="tags_active_period" type="checkbox" class="select_field" data-type="input" data-field="date_assign_period" data-form="#form-bulk-phone">
                     </div>
                     <input name="assign_active_period" type="hidden">
                     <input name="date_assign_period" class="form-control assign_active_period" disabled="">
                  </div>
               </div>
               <div class="form-group">
                  <label>Saldo</label>
                  <div class="input-group">
                     <div class="input-group-addon saldo">
                        <input name="tags_assign_saldo" type="checkbox" class="select_field" data-type="select" data-field="assign_saldo" data-form="#form-bulk-phone">
                     </div>
                     <select name="assign_saldo" class="form-control" id="assign_saldo" disabled="">
                        <option value="">Saldo</option>
                     </select>
                  </div>
               </div> -->
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-block btn-white"><i class="fa fa-upload"></i> Upload</button>
            </div>
         </form>
      </div>
   </div>
</div>

<!-- <div class="modal fade" id="modal-bulk-phone">
   <div class="modal-dialog" style="width: 35%;">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Bulk By Phone Number nie</h4>
         </div>
         <form method="post" id="import_form" enctype="multipart/form-data">
            <p><label>Select Excel</label>
               <input type="file" name="file" id="file" required accept=".xls, .xlsx" /></p>
            <br>
            <input type="submit" name="import" value="Import" class="btn btn-info"/>
         </form>
      </div>
   </div>
</div> -->

<script type="text/javascript">
   var sessions = '#<?php echo $this->ion_auth->logged_in() ?>';
   var loading = '<i class="fa fa-refresh fa-spin"></i>';
   var overlay = '<h3 class="text-center text-danger overlay"><i class="fa fa-spinner fa-spin"></i></h3>';

   function getFormData($form){
      var unindexed_array = $form.serializeArray();
      var indexed_array = {};

      $.map(unindexed_array, function(n, i){
        indexed_array[n['name']] = n['value'];
      });

    return indexed_array;
   }

   $(function () {

      $('.choose').select2();

      $(this).on('click', '.btn-suggest-provider', function(e) {
         var type = $(this).data('type');
         if(type == 'create'){
            var phone_number = $('#form-add').find('input[name="phone_number"]').val();
         }
         if(type == 'edit'){
            var phone_number = $('#form-edit').find('input[name="phone_number"]').val();
         }

         ajaxManager.addReq({
            type : "GET",
            url : site_url + 'simcard/suggest_provider',
            dataType : "JSON",
            data : {
               phone_number : phone_number
            },
            beforeSend: function (xhr) {
               if(sessions){
                  $('.btn-suggest-provider[data-type="'+type+'"]').html(loading);
               }else{
                  xhr.done();
                  window.location.href = location; 
               }
            },
            error: function (jqXHR, status, errorThrown) {
               error_handle(jqXHR, status, errorThrown);
            },
            success : function(r){
               if(r.provider_id){
                  if(type == 'create'){
                     $('#provider_insert').select2('val', r.provider_id);
                  }
                  if(type == 'edit'){
                     $('#provider_update').select2('val', r.provider_id);
                  }
               }
               $('.btn-suggest-provider[data-type="'+type+'"]').html('<i class="fa fa-refresh"></i> Suggest Provider');
            }
         });
         e.preventDefault();
      });

      $.fn.render_data  = function(params){
         var str = $.extend({
            offset : $('#offset').val(),
            curpage : $('#curpage').val(),
            filter_keyword : $('#filter_keyword').val(),
            filter_type : $('#filter_type').val(),
            filter_rows : $('#filter_rows').val(),
            filter_provider : $('#filter_provider').val(),
            filter_rak : $('#filter_rak').val(),
            filter_status : $('#filter_status').val(),
            filter_sort : $('#filter_sort').val(),
            filter_sort_type : $('#filter_sort_type').val(),
            filter_expireddate_sdate : $('#filter_expireddate_sdate').val(),
            filter_expireddate_edate : $('#filter_expireddate_edate').val(),
            filter_createddate_socmed_sdate : $('#filter_createddate_socmed_sdate').val(),
            filter_createddate_socmed_edate : $('#filter_createddate_socmed_edate').val(),
            filter_createddate_socmed_type : $('#filter_createddate_socmed_type').val()
         },params);
         ajaxManager.addReq({
            type : "GET",
            url : site_url + 'simcard/get',
            dataType : "JSON",
            data : {
               offset : str.offset,
               curpage : str.curpage,
               filter_keyword : str.filter_keyword,
               filter_type : str.filter_type,
               filter_rows : str.filter_rows,
               filter_provider : str.filter_provider,
               filter_rak : str.filter_rak,
               filter_status : str.filter_status,
               filter_sort : str.filter_sort,
               filter_sort_type : str.filter_sort_type,
               filter_expireddate_sdate : str.filter_expireddate_sdate,
               filter_expireddate_edate : str.filter_expireddate_edate,
               filter_createddate_socmed_sdate : str.filter_createddate_socmed_sdate,
               filter_createddate_socmed_edate : str.filter_createddate_socmed_edate,
               filter_createddate_socmed_type : str.filter_createddate_socmed_type
            },
            beforeSend: function (xhr) {
               if(sessions){
                  set_loading_table('#sect-data', 11);
               }else{
                  xhr.done();
                  window.location.href = location; 
               }
            },
            error: function (jqXHR, status, errorThrown) {
               error_handle(jqXHR, status, errorThrown);
            },
            success : function(data){
               if(data.total > 0){
                  var t = '';
                  $.each(data.data, function(k,v){
                     t += '<tr>';
                        t += '<td><input type="checkbox" class="option_id" id="checkbox'+v.phone_number+'" value="'+v.phone_number+'"></td>';
                        t += '<td>';
                           t += '<b>'+v.pic+'</b></br>';
                           if(v.pic_updated){
                              t += '<a style="cursor:pointer" data-toggle="tooltip" data-placement="top" title="" data-original-title="By '+v.pic_updated+' at '+v.updated_date+'"><i class="fa fa-external-link"></i></a> at '+v.created_date+'';
                           }else{
                              t += 'at '+v.created_date+'';
                           }
                        t += '</td>';
                        t += '<td>';
                           t += '<b>'+( v.phone_number ? v.phone_number: '' )+'</b>';
                           if(v.info){
                              t += '&nbsp;<a style="cursor:pointer" data-toggle="tooltip" data-placement="top" data-original-title="'+v.info+'"><i class="fa fa-comment"></i></a>';
                           }
                           t += '<br>'+(v.provider ? v.provider : '<span style="color:red">No Provider</span>')+' '+v.phone_number_type+'';
                        t += '</td>';
                        t += '<td>'+(v.active_period ? v.active_period : '')+'</td>';
                        t += '<td>';
                           t += ''+(v.expired_date ? v.expired_date : '')+'';
                           t += ''+(v.left_day ? '<br><span class="text-warning bold" style="font-size:11px;">'+v.left_day.opr+' '+v.left_day.digit+' Hari</span>' : '')+'';
                        t += '</td>';
                        // t += '<td><b>NIK</b>. '+(v.nik ? v.nik : '')+'<br><b>NKK</b>. '+(v.nkk ? v.nkk : '')+'</td>';
                        t += '<td>'+(v.saldo ? v.saldo : '')+'</td>';
                        if(v.rak){
                           t += '<td><b>'+(v.rak ? v.rak : '')+'</b> (Rak '+(v.no_rak ? v.no_rak : '')+')</td>';
                        }else{
                           t += '<td></td>';
                        }
                        t += '<td class="text-center">';
                        t += ''+v.registered+' '+v.registered_facebook+' '+v.registered_twitter+' '+v.registered_instagram+'';
                        t += '</td>';
                        // t += '<td>'+v.pic_last_check+'</td>'; 
                        t += '<td>'+v.status+'</td>'; 
                        t += '<td>';
                           t += '<div class="btn-group">';
                              t += '<button class="btn btn-white btn-sm btn-edit" data-type="edit" data-toggle="tooltip" data-original-title="Edit" data-id="'+v.phone_number+'"><i class="fa fa-edit"></i></button>';
                              t += '<button class="btn btn-danger btn-sm btn-delete" data-toggle="tooltip" data-original-title="Delete" data-id="'+v.phone_number+'"><i class="fa fa-trash"></i></button>';
                           t += '</div>';
                        t += '</td>';
                     t += '</tr>';
                  });
               }else{
                  t += set_no_result(11);
               }

               $('#sect-data').html(t);
               $('#sect-total').html("Total : " + data.total);
               $('#sect-pagination').paging({
                  items : data.total,
                  itemsOnPage : str.filter_rows,
                  currentPage : str.curpage 
               });
               $('#offset').val(str.offset);
               $('#curpage').val(str.curpage);
            }
         });
      };

      $(this).on('change', '#filter_keyword', function(e){
         $('#modal-filter').modal('hide');
         $('#offset').val(0);
         $('#curpage').val(1);
         $('.select_id').removeAttr('checked'); 
         $(this).render_data();
         e.preventDefault();
      });

      $(this).on('submit', '#form-add', function(e){
         var form = $(this);
         $(this).ajaxSubmit({
            url  : site_url +'simcard/create',
            type : "POST",
            dataType : "JSON",
            data : {
               'csrf_token_nalda' : $('#csrf').val()
            },
            error: function (jqXHR, status, errorThrown) {
               error_handle(jqXHR, status, errorThrown);
               loading_form(form, 'hide');
            },
            beforeSend: function (xhr) {
               if(sessions){
                  loading_form(form, 'show');
               }else{
                  xhr.done();
                  window.location.href = location; 
               }
            },
            success: function(r) {
               $('#csrf').val(r.csrf);
               if(r.success){
                  form.resetForm();
                  form.find('select[name="provider"]').select2('val', '');
                  form.find('select[name="rak"]').select2('val', '');
                  $('#offset').val(0);
                  $('#curpage').val(1);
                  $(this).render_data();
                  $('#modal-create').modal('hide');
                  toastr.success(r.msg);
               }else{
                  toastr.error(r.msg);
               }
               loading_form(form, 'hide');
            },
         });
         e.preventDefault();
      });

      $(this).on('submit', '#form-assign-rak', function(e){
         var form = $(this);
         var data = [];
         $('.option_id').each(function () {
            if (this.checked) {
               data.push($(this).val());
            }
         });

         $(this).ajaxSubmit({
            url  : site_url +'simcard/assign_rak',
            type : "POST",
            dataType : "JSON",
            data : {
               'csrf_token_nalda' : $('#csrf').val(),
               data : data
            },
            error: function (jqXHR, status, errorThrown) {
               error_handle(jqXHR, status, errorThrown);
               loading_form(form, 'hide');
            },
            beforeSend: function (xhr) {
               if(sessions){
                  loading_form(form, 'show');
               }else{
                  xhr.done();
                  window.location.href = location; 
               }
            },
            success: function(r) {
               $('#csrf').val(r.csrf);
               $('.select_id').prop('checked', false);
               if(r.success){
                  $('#modal-assign-rak').modal('hide');
                  if(r.with_download_mode){
                     $('#your-file').attr('href', ''+base_url+'/download/'+r.filename+'.xlsx');
                     $('#your-file').html(r.filename+'.xlsx');
                  }
                  $('.select_id').removeAttr('checked'); 
                  $(this).render_data();
                  toastr.success(r.msg);
               }else{
                  toastr.error(r.msg);
               }
               loading_form(form, 'hide');
            },
         });
         e.preventDefault();
      });

      $(this).on('submit', '#form-edit', function(e){
         var form = $(this);
         $(this).ajaxSubmit({
            url  : site_url +'simcard/change',
            type : "POST",
            dataType : "JSON",
            data : {
               'csrf_token_nalda' : $('#csrf').val()
            },
            error: function (jqXHR, status, errorThrown) {
               error_handle(jqXHR, status, errorThrown);
               loading_form(form, 'hide');
            },
            beforeSend: function (xhr) {
               if(sessions){
                  loading_form(form, 'show');
               }else{
                  xhr.done();
                  window.location.href = location; 
               }
            },
            success: function(r) {
               $('#csrf').val(r.csrf);
               if(r.success){
                  form.resetForm();
                  $('#offset').val(0);
                  $('#curpage').val(1);
                  $('.select_id').removeAttr('checked');
                  $(this).render_data();
                  $('#modal-edit').modal('hide');
                  toastr.success(r.msg);
               }else{
                  toastr.error(r.msg);
               }
               loading_form(form, 'hide');
            },
         });
         e.preventDefault();
      });

      $(this).on('click', '.btn-edit',function(e){
         var id = $(this).data('id');
         var form = $('#form-edit');

         ajaxManager.addReq({
            type : "GET",
            url : site_url + 'simcard/edit',
            dataType : "JSON",
            data : {
               phone_number : id
            },
            beforeSend: function (xhr) {
               if(sessions){
                  loading_button('.btn-edit', id, 'show', 'edit');
               }else{
                  xhr.done();
                  window.location.href = location; 
               }
            },
            error: function (jqXHR, status, errorThrown) {
               error_handle(jqXHR, status, errorThrown);
               loading_button('.btn-edit', id, 'hide', 'edit');
            },
            success: function(r){
               form.find('input[name="phone_number_before"]').val(r.response.phone_number);
               form.find('input[name="phone_number"]').val(r.response.phone_number);
               form.find('input[name="expired_date"]').val(r.response.expired_date);
               if(r.response.expired_date){
                  form.find('.date-data-expired').val(moment(r.response.expired_date).format('DD/MMM/YYYY'));
               }
               form.find('input[name="active_period"]').val(r.response.active_period);

               if(r.response.active_period){
                  form.find('.date-data-activeperiod').val(moment(r.response.active_period).format('DD/MMM/YYYY'));
               }
               form.find('input[name="nik"]').val(r.response.nik);
               form.find('input[name="nkk"]').val(r.response.nkk);
               form.find('input[name="saldo"]').val(r.response.saldo);
               form.find('select[name="provider"]').select2('val', r.response.provider_id);
               form.find('select[name="rak"]').select2('val', r.response.rak_id);
               form.find('select[name="status"]').val(r.response.status);
               form.find('select[name="phone_number_type"]').val(r.response.phone_number_type);
               form.find('textarea[name="info"]').html((r.response.info ? r.response.info : ''));

               $(this).render_picker({
                  modal : '#modal-edit'
               });

               $("#modal-edit").modal("toggle");
               loading_button('.btn-edit', id, 'hide', 'edit');
            }
         });
         e.preventDefault();
      });

      $(this).on('click', '.btn-delete', function(e){
         var conf = confirm('Are you sure ?');
         if(conf){
            var id = $(this).data('id');
            ajaxManager.addReq({
               type : "GET",
               url : site_url + 'simcard/delete',
               dataType : "JSON",
               data : {
                  id : id,
               },
               beforeSend: function (xhr) {
                  if(sessions){
                     loading_button('.btn-delete', id, 'show', 'delete');
                  }else{
                     xhr.done();
                     window.location.href = location; 
                  }
               },
               error: function (jqXHR, status, errorThrown) {
                  error_handle(jqXHR, status, errorThrown);
                  loading_button('.btn-delete', id, 'hide', 'delete');
               },
               success : function(r){
                  if(r.success){
                     $('#offset').val(0);
                     $('#curpage').val(1);
                     $('.select_id').removeAttr('checked'); 
                     $(this).render_data();
                     toastr.success(r.msg);
                  }else{
                     toastr.error(r.msg);
                  }
                  loading_button('.btn-delete', id, 'hide', 'delete');
               }
            });
         }else{
            return false;
         }
         e.preventDefault();
      });

      // $('.btn-assign-rak').on('click', function(e){
      //    var data = [];
      //    var assign_rak = $('#assign_rak').val();
      //    var $form = $("#form-assign-rak");

      //    $('.option_id').each(function () {
      //       if (this.checked) {
      //          data.push($(this).val());
      //       }
      //    });

      //    if (data.length > 0) {
      //       ajaxManager.addReq({
      //          url: site_url + 'simcard/assign_rak',
      //          type: 'POST',
      //          dataType: 'JSON',
      //          data: {
      //             data: getFormData($form),
      //          },
      //          beforeSend: function (xhr) {
      //             if(!sessions){
      //                xhr.done();
      //                window.location.href = location; 
      //             }
      //          },
      //          error: function (jqXHR, status, errorThrown) {
      //             error_handle(jqXHR, status, errorThrown);
      //          },
      //          success: function (r) {
      //             $('#csrf').val(r.csrf);
      //             $('.select_id').prop('checked', false);
      //             if(r.success){
      //                $('#modal-assign-rak').modal('hide');
      //                $('.select_id').removeAttr('checked'); 
      //                $(this).render_data();
      //                toastr.success(r.msg);
      //             }else{
      //                toastr.error(r.msg);
      //             }
      //          }
      //       });
      //    } else {
      //       alert('No Data Selected');
      //       return false;
      //    }
      //    e.preventDefault();
      // });
      
      $('.bulk_action').on('click', function(e) {
         var mode = $(this).data('mode');
         var value = $(this).data('value');

         var data = [];
         $('.option_id').each(function () {
            if (this.checked) {
                data.push($(this).val());
            }
         });
         if (data.length > 0) {
            ajaxManager.addReq({
               url: site_url + 'simcard/bulk_action',
               type: 'POST',
               dataType: 'JSON',
               data: {
                  mode: mode,
                  data: data,
                  value: value,
                  'csrf_token_app' : $('#csrf').val()
               },
               error: function (jqXHR, status, errorThrown) {
                  error_handle(jqXHR, status, errorThrown);
               },
               success: function (r) {
                  $('#csrf').val(r.csrf);
                  $('.select_id').prop('checked', false);
                  if(r.success){
                     $('#offset').val(0);
                     $('#curpage').val(1);
                     $('.select_id').removeAttr('checked'); 
                     $(this).render_data();
                     toastr.success(r.msg);
                  }else{
                     toastr.error(r.msg);
                  }
               }
            });
         } else {
            alert('No Data Selected');
         }
         e.preventDefault();
      });

      $.fn.paging = function (opt) {
         var s = $.extend({
            items: 0,
            itemsOnPage: '',
            currentPage: 1
         }, opt);

         var itempage = (s.itemsOnPage == '' ? 10 : s.itemsOnPage);

         $('#sect-pagination').pagination({
            items: s.items,
            itemsOnPage: itempage,
            prevText: '&laquo;',
            nextText: '&raquo;',
            hrefTextPrefix: '#',
            currentPage: s.currentPage,
            onPageClick: function (n, e) {
               e.preventDefault();
               var offset = (n - 1) * itempage;
               $('#offset').val(offset);
               $('#curpage').val(n);

               $(this).render_data({
                  offset: offset,
                  currentPage: n
               });
               
            }
         });
      };
      
      $(this).on('click', '.btn-search',function(e){
         $('#modal-filter').modal('hide');
         $('#offset').val(0);
         $('#curpage').val(1);
         $('.select_id').removeAttr('checked'); 
         $(this).render_data();
         e.preventDefault();
      });

      $(this).on('click', '.assign-rak',function(e){
         $('#form-assign-rak').resetForm();
         $('#with_download_field').prop("disabled", true);
         $('#form-assign-rak').find('select[name="module[simcard][]"]').select2('val', '');
         $('#form-assign-rak').find('select[name="assign_rak"]').select2('val', '');
         $('#your-file').html('     ');
         e.preventDefault();
      });

      $(this).on('click', '.btn-filter', function(e) {
         $(this).render_picker({
            modal : '#modal-filter'
         });   
         e.preventDefault();
      });

      $(this).on('click', '.set-empty',function(e){
         var target = $(this).data('target');
         $('#form-filter').find('.'+target+'').val('');
         $('#form-filter').find('input[name="'+target+'_sdate"]').val('');
         $('#form-filter').find('input[name="'+target+'_edate"]').val('');
      });

      $(this).on('click', '.btn-reset', function(e) {
         $('#modal-filter').modal('hide');
         $('#offset').val(0);
         $('#curpage').val(1);
         $('#form-filter').find('#filter_expireddate_sdate').val('');
         $('#form-filter').find('#filter_expireddate_edate').val('');
         $('#form-filter').find('input[name="filter_createddate_socmed_sdate"]').val('');
         $('#form-filter').find('input[name="filter_createddate_socmed_edate"]').val('');
         $('#form-filter').find('#filter_provider').select2('val', '');
         $('#form-filter').find('#filter_rak').select2('val', '');
         $('#form-filter').resetForm();
         $('.select_id').removeAttr('checked');
         $(this).render_data();
      });

      $(this).on('submit', '#form-filter', function(e){
         // $('#modal-filter').modal('hide');
         // $('#offset').val(0);
         // $('#curpage').val(1);
         // $('.select_id').removeAttr('checked'); 
         // $(this).render_data();
         alert('test');
         e.preventDefault();
      });

      $(this).on('change', '#filter_rows', function(e){
         $('#offset').val(0);
         $('#curpage').val(1);
         $('.select_id').removeAttr('checked');
         $(this).render_data();
         e.preventDefault();
      });

       $(this).on('click', '.with_download', function(e){
         if($(this).is(':checked')){
            $('#with_download_field').prop("disabled", false);
         }else{
            $('#with_download_field').prop("disabled", true);
         }
         return true;
      });
      
      $('.select_id').on('change', function (e) {
         if (this.checked) {
            $('.option_id').each(function () {
               this.checked = true;
            });
         } else {
            $('.option_id').each(function () {
               this.checked = false;
            });
         }
      });

      $(this).on('click', '.btn-new', function(e){
         $(this).render_picker({
            modal : '#modal-create'
         });
      });
      
      $.fn.render_picker = function (opt) {
         var s = $.extend({
            modal: '#modal-create'
         }, opt);

         $('.date-data').daterangepicker({
            parentEl : opt.modal,
            autoUpdateInput: false,
            locale: {
               format: 'DD/MMM/YYYY'
            },
            singleDatePicker: true,
            showDropdowns: true
         });

         if(opt.modal == '#modal-filter'){
            $('.filter_expireddate').daterangepicker({
               parentEl : opt.modal,
               autoUpdateInput: false,
            },
               function (start, end) {
                  $('.filter_expireddate').val(''+start.format('DD MMM YYYY')+' sd '+end.format('DD MMM YYYY')+'');
                  $('#form-filter').find('input[name="filter_expireddate_sdate"]').val(start.format('YYYY-MM-DD'));
                  $('#form-filter').find('input[name="filter_expireddate_edate"]').val(end.format('YYYY-MM-DD'));
               }
            );

            $('.filter_createddate_socmed').daterangepicker({
               parentEl : opt.modal,
               autoUpdateInput: false,
            },
               function (start, end) {
                  $('.filter_createddate_socmed').val(''+start.format('DD MMM YYYY')+' sd '+end.format('DD MMM YYYY')+'');
                  $('#form-filter').find('input[name="filter_createddate_socmed_sdate"]').val(start.format('YYYY-MM-DD'));
                  $('#form-filter').find('input[name="filter_createddate_socmed_edate"]').val(end.format('YYYY-MM-DD'));
               }
            );
         }

         $('.date-data').on('apply.daterangepicker', function(ev, picker) {
            var date = picker.startDate.format('YYYY-MM-DD');
            var date_add = moment(date, "YYYY-MM-DD").add(25, 'days');

            var formrender = $(this).data('formrender');
            var to = $(this).data('to');

            if(to === 'active_period'){
               $(this).val(picker.startDate.format('DD/MMM/YYYY'));
               $(formrender).find('input[name="'+to+'"]').val(picker.startDate.format('YYYY-MM-DD'));
               $(formrender).find('[data-to="expired_date"]').val(moment(date_add).format('DD/MMM/YYYY'));  
               $(formrender).find('input[name="expired_date"]').val(moment(date_add).format('YYYY-MM-DD')); 

               $('.date-data-expired').daterangepicker({
                  parentEl : opt.modal,
                  autoUpdateInput: false,
                  locale: {
                     format: 'DD/MMM/YYYY'
                  },
                  singleDatePicker: true,
                  showDropdowns: true
               });

               $('.date-data-expired').on('apply.daterangepicker', function(ev, picker) {
                  var formrender = $(this).data('formrender');
                  var to = $(this).data('to');
                  $(this).val(picker.startDate.format('DD/MMM/YYYY'));
                  $(formrender).find('input[name="'+to+'"]').val(picker.startDate.format('YYYY-MM-DD'));
               });
            }else{
               $(this).val(picker.startDate.format('DD/MMM/YYYY'));
               $(formrender).find('input[name="'+to+'"]').val(picker.startDate.format('YYYY-MM-DD'));
            }
         });

         // $('.date-expiredsimcard').on('apply.daterangepicker', function(ev, picker) {
         //    $(this).val('<i class="fa fa-calendar"></i> '+start.format('DD MMM YYYY')+' sd '+end.format('DD MMM YYYY')+'');
         //    $('#form-filter').find('input[name="filter_expireddate_sdate"]').val(picker.startDate.format('YYYY-MM-DD'));
         //    $('#form-filter').find('input[name="filter_expireddate_edate"]').val(picker.endDate.format('YYYY-MM-DD'));
         // });

         // $('.date-createddate-socmed').on('apply.daterangepicker', function(ev, picker) {
         //    $(this).val(picker.startDate.format('DD/MMM/YYYY'));
         //    $('#form-filter').find('input[name="filter_createddate_socmed"]').val(picker.startDate.format('YYYY-MM-DD'));
         // });

      }

      $(this).render_data();

      $('.assign_active_period').daterangepicker({
         parentEl : '#form-bulk-phone',
         autoUpdateInput: false,
         locale: {
            format: 'DD/MMM/YYYY'
         },
         singleDatePicker: true,
         showDropdowns: true
      });

       $('.assign_active_period').on('apply.daterangepicker', function(ev, picker) {
         $(this).val(picker.startDate.format('DD/MMM/YYYY'));
         $('#form-bulk-phone').find('input[name="assign_active_period"]').val(picker.startDate.format('YYYY-MM-DD'));
      });

      $(this).on('submit', '#form-migration', function(e){
         var form = $(this);
         $(this).ajaxSubmit({
            url  : site_url +'simcard/migration_all',
            type : "POST",
            dataType : "JSON",
            data : {
               'csrf_token_nalda' : $('#csrf').val()
            },
            error: function (jqXHR, status, errorThrown) {
               error_handle(jqXHR, status, errorThrown);
               loading_form(form, 'hide');
            },
            beforeSend: function (xhr) {
               if(sessions){
                  loading_form(form, 'show');
               }else{
                  xhr.done();
                  window.location.href = location; 
               }
            },
            success: function(r) {
               $('#csrf').val(r.csrf);
               if(r.success){
                  form.resetForm();
                  $('#modal-migrasi-all').modal('hide');
                  $(this).render_data();
                  toastr.success(r.msg);
               }else{
                  toastr.error(r.msg);
               }
               loading_form(form, 'hide');
            },
         });
         e.preventDefault();
      });

      $('.select_field').on('change', function (e) {
         var form = $(this).data('form');
         var field = $(this).data('field');
         var type = $(this).data('type');
         if (this.checked) {
            $(form).find(''+type+'[name="'+field+'"]').prop("disabled", false);
         } else {
            $(form).find(''+type+'[name="'+field+'"]').prop("disabled", true);
         }
         e.preventDefault();
      });

      $(this).on('submit', '#form-bulk-phone', function(e){
         var form = $(this);
         $(this).ajaxSubmit({
            url  : site_url +'simcard/bulk_phone',
            type : "POST",
            dataType : "JSON",
            data : {
               'csrf_token_nalda' : $('#csrf').val()
            },
            error: function (jqXHR, status, errorThrown) {
               error_handle(jqXHR, status, errorThrown);
               loading_form(form, 'hide');
            },
            beforeSend: function (xhr) {
               if(sessions){
                  loading_form(form, 'show');
               }else{
                  xhr.done();
                  window.location.href = location; 
               }
            },
            success: function(r) {
               $('#csrf').val(r.csrf);
               if(r.success){
                  form.resetForm();
                  form.find('select[name="assign_rak"]').prop("disabled", true);
                  form.find('select[name="assign_status"]').prop("disabled", true);
                  form.find('select[name="assign_provider"]').prop("disabled", true);
                  form.find('input[name="date_assign_period"]').prop("disabled", true);
                  form.find('input[name="assign_saldo"]').prop("disabled", true);
                  form.find('select[name="assign_rak"]').select2('val', '');
                  form.find('select[name="assign_provider"]').select2('val', '');
                  form.find('input[name="date_assign_period"]').val('');
                  form.find('input[name="assign_active_period"]').val('');
                  form.find('select[name="assign_saldo"]').select2('val', '');
                  $('#modal-bulk-phone').modal('hide');
                  $(this).render_data();
                  toastr.success(r.msg);
               }else{
                  toastr.error(r.msg);
               }
               loading_form(form, 'hide');
            },
         });
         e.preventDefault();
      });

   });
</script>