<style type="text/css">
   #select2-drop{
      z-index: 9999999999;
   }
   .page-body .select2-container .select2-choice{
      height:30px;
      line-height:30px;
   }
</style>

<?php
   $master_client = $this->db->get('client');
   $master_proxy = $this->db->where('status', 1)->get('proxy');
?>
<div class="row">
   <div class="col-md-12">
      <div class="panel panel-primary" data-collapsed="0">
         <div class="panel-heading">
            <div class="panel-title"><i class="fa fa-list"></i> List facebook Account</div>
            <div class="panel-options" style="width: auto;border:0px solid black;">
               <div class="form-group" style="margin-top: 8px;margin-bottom: 5px;">  
                  <div class="btn-group dropdown-default"> 
                     <button class="btn btn-white btn-sm btn-download-client" data-toggle="modal" data-target="#modal-download-client">
                        <i class="fa fa-user"></i> Download By Client
                     </button>
                  </div> 
                  <div class="btn-group dropdown-default"> 
                     <button class="btn btn-white btn-sm" data-toggle="modal" data-target="#modal-migrasi-all"><i class="fa fa-upload"></i> Migration</button>
                  </div> 
                  <div class="btn-group dropdown-default"> 
                     <button class="btn btn-white btn-sm" data-toggle="modal" data-target="#modal-bulk"><i class="fa fa-upload"></i> Bulk</button>
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
                        <li style="font-weight: bold;text-align: center;">To Status</li>
                        <div class="divider"></div>
                        <li style="font-size: 13px;"><a href="#" class="bulk_action" data-mode="status" data-value="1">Set Active</a></li>
                        <li style="font-size: 13px;"><a href="#" class="bulk_action" data-mode="status" data-value="2">Set Blocked</a></li>
                        <div class="divider"></div>
                        <li style="font-weight: bold;text-align: center;">Assign</li>
                        <div class="divider"></div>
                        <li style="font-size: 13px;"><a href="#" class="assign-client" data-toggle="modal" data-target="#modal-assign-client">To Client</a></li>   
                     </ul>
                  </div>
                  <button class="btn btn-white btn-sm btn-filter" data-toggle="modal" data-target="#modal-filter"><i class="fa fa-filter"></i> Filter</button>
                  <button class="btn btn-white btn-sm btn-new" data-type="create" data-toggle="modal" data-target="#modal-create"><i class="fa fa-plus"></i> Create</button>
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
                  <th>Created</th>
                  <th>Phone Number</th>
                  <th>Display Name</th>
                  <th>Password</th>
                  <th>Client</th>
                  <th>Proxy</th>
                  <th>Status</th>
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

<div class="modal" id="modal-download-client">
   <div class="modal-dialog" style="width: 40%;">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close btn-dismiss-modal" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3 class="modal-title bold"><i class="fa fa-user"></i> Download By Client</h3>
         </div>
         <div class="modal-body">
            <form id="form-download-client" method="post" action="<?php echo site_url().'reporting/downloadByClient' ?>">
               <input type="hidden" name="cluster" value="facebook">
               <div class="form-group">
                  <label>Client</label>
                  <select name="client_id[]" class="form-control choose" multiple="">
                     <?php
                        if($master_client->num_rows() > 0){
                           foreach ($master_client->result_array() as $key => $value) {
                              echo '<option value="'.$value['id'].'">'.$value['name'].'</option>';
                           }
                        }
                     ?>
                  </select>
               </div> 
               <div class="form-group">
                  <label>Created Date</label>
                  <input type="hidden" name="client_date_sdate" id="client_date_sdate">
                  <input type="hidden" name="client_date_edate" id="client_date_edate">
                  <div class="input-group">
                     <input type="text" class="form-control client_date">
                     <div class="input-group-addon set-empty-client" style="cursor: pointer;" data-target="client_date">Empty</div>
                  </div>
               </div>
               <div class="form-group">
                  <label>Status</label>
                  <select name="status[]" class="form-control choose" multiple="">
                     <option value=""></option>
                     <option value="1">Active</option>
                     <option value="2">Blocked</option>
                  </select>
               </div> 
               <div class="form-group">
                  <label>Filename</label>
                  <div class="input-group">
                     <input type="text" name="filename" class="form-control">
                     <div class="input-group-addon">.xlsx</div>
                  </div>
               </div>
               <button type="submit" class="btn btn-white btn-block"><i class="fa fa-download"></i> Download</button> 
            </form>
         </div>
      </div>
   </div>
</div>

<div class="modal fade" id="modal-assign-client">
   <div class="modal-dialog" style="width: 35%;">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3 class="modal-title">Assign Client</h3>
         </div>
         <form id="form-assign-client">
            <div class="modal-body">
               <div class="form-group">
                  <label>To Client</label>
                  <select name="assign_client" class="form-control choose" id="assign_client">
                     <?php
                        $data = $this->db->get('client')->result_array();
                        foreach ($data as $value) {
                           echo '<option value="'.$value['id'].'">'.$value['name'].'</option>';
                        }
                     ?>
                  </select>
               </div>
               <div class="form-group" style="display: none;">
                  <input type="checkbox" class="with_download" name="with_download_mode" value="1"> With Download Selected
                  <select class="form-control choose" multiple="" name="module[facebook][]" disabled="" id="with_download_field">
                     <?php
                        foreach ($field['facebook'] as $key => $value) {
                           echo '<option value="'.$key.'">'.$value.'</option>';
                        }
                     ?>
                  </select>
               </div>
               <!-- <h5 class="bold">Your File :</h5> -->
               <!-- <p class="text-muted"><a id="your-file" class="text-center"></a></p> -->
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-white btn-block">Assign</button>
            </div>
         </form>
      </div>
   </div>
</div>

<div class="modal fade" id="modal-filter">
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
                        <label>Status</label>
                        <select id="filter_status" class="form-control choose" multiple="">
                           <option value="0">No Action</option>
                           <option value="1">Active</option>
                           <option value="2">Blocked</option>
                        </select>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>Client</label>
                        <select id="filter_client" class="form-control choose" multiple="">
                           <option value="0">Empty Client</option>
                           <?php
                              if($master_client->num_rows() > 0){
                                 foreach ($master_client->result_array() as $key => $value) {
                                    echo '<option value="'.$value['id'].'">'.$value['name'].'</option>';
                                 }
                              }
                           ?>
                        </select>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>Expired Date Simcard</label>
                        <input type="hidden" name="filter_expireddate_sdate" id="filter_expireddate_sdate">
                        <input type="hidden" name="filter_expireddate_edate" id="filter_expireddate_edate">
                        <div class="input-group">
                           <input type="text" class="form-control filter_expireddate">
                           <div class="input-group-addon set-empty" style="cursor: pointer;" data-target="filter_expireddate">Empty</div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>Created Date</label>
                        <input type="hidden" name="filter_createddate_sdate" id="filter_createddate_sdate">
                        <input type="hidden" name="filter_createddate_edate" id="filter_createddate_edate">
                        <div class="input-group">
                           <input type="text" class="form-control filter_createddate">
                           <div class="input-group-addon set-empty" style="cursor: pointer;" data-target="filter_createddate">Empty</div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>Sort By</label>
                        <select id="filter_sort" class="form-control">
                           <option value="a.created_facebook" selected="">Created Facebook</option>
                           <option value="a.created_date">Created in System</option>
                           <option value="a.phone_number">Phone Number</option>
                           <option value="b.expired_date">Expired Date Simcard</option>
                           <option value="e.ip_address">Proxy</option>
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

<div class="modal fade" id="modal-delete">
   <div class="modal-dialog" style="width: 40%;">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"><i class="fa fa-trash"></i> Delete</h4>
         </div>
         <form id="form-delete">
            <input type="hidden" name="id">
            <input type="hidden" name="phone_number">
            <div class="modal-body">
               <div class="form-group">
                  <label>Choose Module Delete</label>
                  <select name="mode[]" class="form-control choose" multiple="">
                    <option value="1" selected="">Only facebook</option>
                    <option value="2">With Email Related</option>
                    <option value="3">With Simcard Related</option>
                  </select>
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-white btn-block"><i class="fa fa-trash"></i> Delete</button>
            </div>
         </form>
      </div>
   </div>
</div>

<div class="modal fade" id="modal-create">
   <div class="modal-dialog" style="width: 80%;">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3 class="modal-title bold"><i class="fa fa-plus"></i> Create Data</h3>
         </div>
         <form id="form-add">
            <input type="hidden" name="phone_number">
            <div class="modal-body">
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <div class="input-group">
                           <input type="number" class="form-control filter_search_phone_number" data-render="form-add" placeholder="Search phone number here...">
                           <div class="input-group-addon" style="padding: 0px;border:0px;">
                              <button type="button" class="btn btn-white btn-block btn-search-phone-number" data-render="form-add"><i class="fa fa-search"></i></button>
                           </div>
                        </div>
                     </div>
                     <hr>
                     <div class="form-group">
                        <label>Phone Number <span class="text-require">(*)</span></label>
                        <span class="text-center result-phone-number">
                           <div class="container-phone-loading" style="display: none;">
                              <i class="fa fa-spinner fa-spin"></i> Please Wait Searcing Phone Number...
                           </div>
                           <input type="text" class="form-control" name="phone_number_choosed" disabled="" readonly="" required="">
                        </span>
                     </div>
                     <div class="form-group">
                        <label>Display Name <span class="text-require">(*)</span></label>
                        <input type="text" class="form-control" name="display_name" required="">
                     </div>
                     <div class="form-group">
                        <label>URL <span class="text-require">(*)</span></label>
                        <div class="input-group">
                           <div class="input-group-addon">https://www.facebook.com/</div>
                           <input type="text" class="form-control" name="url" required="">
                        </div>
                     </div>
                     <div class="form-group">
                        <label>Password <span class="text-require">(*)</span></label>
                        <input type="text" class="form-control" name="password" required="">
                     </div>
                     <div class="form-group">
                        <div class="row">
                           <div class="col-md-6">
                              <label>Birth Date <span class="text-require">(*)</span></label>
                              <input type="hidden" name="birth_date">
                              <div class="input-group">
                                 <input type="text" class="form-control date-birthdate" data-formrender="#form-add" required="">
                                 <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <label>Create Date <span class="text-require">(*)</span></label>
                              <input type="hidden" name="created_facebook">
                              <div class="input-group">
                                 <input type="text" class="form-control date-data" data-formrender="#form-add" required="">
                                 <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                              <label>facebook ID <span class="text-require">(*)</span></label>
                              <input type="number" class="form-control" name="facebook_id" required="">
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Friends</label>
                              <input type="number" class="form-control" name="friends">
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Cookies</label>
                              <input type="text" class="form-control" name="cookies">
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Access Token</label>
                              <input type="text" class="form-control" name="access_token">
                           </div>
                        </div>
                     </div>
                     <div class="form-group">
                        <label>Client</label>
                        <select name="client_id" class="form-control choose">
                           <option value="" selected="">None</option>
                           <?php
                           foreach ($master_client->result_array() as $key => $value) {
                              echo '<option value="'.$value['id'].'">'.$value['name'].'</option>';
                           }
                           ?>
                        </select>
                     </div>
                     <div class="form-group">
                        <label>Proxy</label>
                        <select name="proxy_id" class="form-control choose">
                           <option value="" selected="">None</option>
                           <?php
                           foreach ($master_proxy->result_array() as $key => $value) {
                              echo '<option value="'.$value['id'].'">'.$value['ip_address'].''.($value['port'] ? ':'.$value['port'].'' : '').' '.($value['network'] == 1 ? '(VPS)' : '(Proxy)').'</option>';
                           }
                           ?>
                        </select>
                     </div>
                     <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                           <option value="1" selected="">Active</option>  
                           <option value="2">Blocked</option>  
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
   <div class="modal-dialog" style="width: 80%;">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3 class="modal-title bold"><i class="fa fa-edit"></i> Edit Data</h3>
         </div>
         <form id="form-edit">
            <input type="hidden" name="phone_number">
            <input type="hidden" name="id">
            <input type="hidden" name="phone_number_before">
            <input type="hidden" name="url_facebook_before">
            <input type="hidden" name="facebook_id_before">
            <div class="modal-body">
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <div class="input-group">
                           <input type="number" class="form-control filter_search_phone_number" data-render="form-edit" placeholder="Search phone number here...">
                           <div class="input-group-addon" style="padding: 0px;border:0px;">
                              <button type="button" class="btn btn-white btn-block btn-search-phone-number" data-render="form-edit"><i class="fa fa-search"></i></button>
                           </div>
                        </div>
                     </div>
                     <hr>
                     <div class="form-group">
                        <label>Phone Number <span class="text-require">(*)</span></label>
                        <span class="text-center result-phone-number">
                           <div class="container-phone-loading" style="display: none;">
                              <i class="fa fa-spinner fa-spin"></i> Please Wait Searcing Phone Number...
                           </div>
                           <input type="text" class="form-control" name="phone_number_choosed" disabled="" readonly="" required="">
                        </span>
                     </div>
                     <div class="form-group">
                        <label>Display Name <span class="text-require">(*)</span></label>
                        <input type="text" class="form-control" name="display_name">
                     </div>
                     <div class="form-group">
                        <label>URL <span class="text-require">(*)</span></label>
                        <input type="text" class="form-control" name="url_facebook">
                     </div>
                     <div class="form-group">
                        <label>Password <span class="text-require">(*)</span></label>
                        <input type="text" class="form-control" name="password">
                     </div>
                     <div class="form-group">
                        <div class="row">
                           <div class="col-md-6">
                              <label>Birth Date <span class="text-require">(*)</span></label>
                              <input type="hidden" name="birth_date">
                              <div class="input-group">
                                 <input type="text" class="form-control date-birthdate" data-formrender="#form-edit">
                                 <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <label>Create Date <span class="text-require">(*)</span></label>
                              <input type="hidden" name="created_facebook">
                              <div class="input-group">
                                 <input type="text" class="form-control date-data" data-formrender="#form-edit">
                                 <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                              <label>facebook ID <span class="text-require">(*)</span></label>
                              <input type="number" class="form-control" name="facebook_id" required="">
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Friends</label>
                              <input type="number" class="form-control" name="friends">
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Cookies</label>
                              <input type="text" class="form-control" name="cookies">
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Access Token</label>
                              <input type="text" class="form-control" name="access_token">
                           </div>
                        </div>
                     </div>
                     <div class="form-group">
                        <label>Client</label>
                        <select name="client_id" class="form-control choose">
                           <option value="" selected="">None</option>
                           <?php
                           foreach ($master_client->result_array() as $key => $value) {
                              echo '<option value="'.$value['id'].'">'.$value['name'].'</option>';
                           }
                           ?>
                        </select>
                     </div>
                     <div class="form-group">
                        <label>Proxy</label>
                        <select name="proxy_id" class="form-control choose">
                           <option value="" selected="">None</option>
                           <?php
                           foreach ($master_proxy->result_array() as $key => $value) {
                              echo '<option value="'.$value['id'].'">'.$value['ip_address'].''.($value['port'] ? ':'.$value['port'].'' : '').' '.($value['network'] == 1 ? '(VPS)' : '(Proxy)').'</option>';
                           }
                           ?>
                        </select>
                     </div>
                     <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                           <option value="1">Active</option>  
                           <option value="2">Blocked</option>  
                           <!-- <option value="2">Blocked</option>   -->
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

<div class="modal fade" id="modal-bulk">
   <div class="modal-dialog" style="width: 35%;">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3 class="modal-title bold"><i class="fa fa-upload"></i> Bulk</h3>
         </div>
         <form id="form-bulk-client">
            <div class="modal-body">
               <h5 class="text-center">Download one of the file formats below</h5>
               <p class="text-muted text-center bold" style="margin-top: -5px;">
                  <a href="<?php echo site_url('facebook/bulkFormat') ?>" class="text-center"> PhoneNumberList.xlsx</a>
               </p>               
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
               <p class="text-muted text-center bold" style="margin-top: -5px;"><a href="<?php echo site_url() ?>facebook/download_format" class="text-center"> Format Migration Facebook.xlsx</a></p>
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

<script type="text/javascript">
   var sessions = '#<?php echo $this->ion_auth->logged_in() ?>';
   var loading = '<i class="fa fa-refresh fa-spin"></i>';
   var overlay = '<h3 class="text-center text-danger overlay"><i class="fa fa-spinner fa-spin"></i></h3>';

   $(function () {
      $('.choose').select2();

      $.fn.render_data  = function(params){
         var str = $.extend({
            offset : $('#offset').val(),
            curpage : $('#curpage').val(),
            filter_keyword : $('#filter_keyword').val(),
            filter_status : $('#filter_status').val(),
            filter_client : $('#filter_client').val(),
            filter_rows : $('#filter_rows').val(),
            filter_sort : $('#filter_sort').val(),
            filter_sort_type : $('#filter_sort_type').val(),
            filter_expireddate_sdate : $('#filter_expireddate_sdate').val(),
            filter_expireddate_edate : $('#filter_expireddate_edate').val(),
            filter_createddate_sdate : $('#filter_createddate_sdate').val(),
            filter_createddate_edate : $('#filter_createddate_edate').val()
         },params);
         ajaxManager.addReq({
            type : "GET",
            url : site_url + '/facebook/get',
            dataType : "JSON",
            data : {
               offset : str.offset,
               curpage : str.curpage,  
               filter_keyword : str.filter_keyword,
               filter_status : str.filter_status,
               filter_client : str.filter_client,
               filter_rows : str.filter_rows,
               filter_sort : str.filter_sort,
               filter_sort_type : str.filter_sort_type,
               filter_expireddate_sdate : str.filter_expireddate_sdate,
               filter_expireddate_edate : str.filter_expireddate_edate,
               filter_createddate_sdate : str.filter_createddate_sdate,
               filter_createddate_edate : str.filter_createddate_edate
            },
            beforeSend: function (xhr) {
               if(sessions){
                  set_loading_table('#sect-data', 9);
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
                        t += '<td><input type="checkbox" class="option_id" id="checkbox'+v.id+'" value="'+v.id+'"></td>';
                         t += '<td>';
                           t += '<b>'+v.pic+'</b></br>';
                           if(v.pic_updated){
                              t += '<a style="cursor:pointer" data-toggle="tooltip" data-placement="top" title="" data-original-title="By '+v.pic_updated+' at '+v.updated_date+'"><i class="fa fa-external-link"></i></a> at '+v.created_facebook+'';
                           }else{
                              t += 'at '+v.created_facebook+'';
                           }
                        t += '</td>';
                        t += '<td>';
                           if(v.phone_number){
                              if(v.status_phone_number == 1){
                                 t += ''+v.phone_number+' <br> <b>Exp.</b> '+v.expired_date+'';
                              }else if(v.status_phone_number == 0){
                                 t += '<span class="label label-info" style="padding:2px;font-size:12px;">Need Top-up : '+v.phone_number+'</span><br> Exp.'+v.expired_date+'';
                              }else{
                                 t += '<span class="label label-danger" style="padding:2px;font-size:12px;">Expired : '+v.phone_number+'</span><br> Exp.'+v.expired_date+'';
                              }
                           }else{
                              t += '<span class="text-danger bold"><i class="fa fa-exclamation"></i> No Phone Number</span>';
                           }
                           if(v.info){
                              t += '&nbsp;<a style="cursor:pointer" data-toggle="tooltip" data-placement="top" data-original-title="'+v.info+'"><i class="fa fa-comment"></i></a>';
                           }
                        t += '</td>';
                        t += '<td>';
                           if(v.url){
                              t += '<a href="'+v.url+'" target="_blank"><b>'+v.display_name+'</b></a><br>'+(v.facebook_id ? v.facebook_id : '')+'';
                           }else{
                              t += '<b>'+v.display_name+'</b><br>'+(v.facebook_id ? v.facebook_id : '')+'';
                           }
                        t += '</td>';
                        t += '<td><button class="btn btn-xs btn-white btn-show-password" data-id="'+v.id+'">Show Password</button><p class="show-password-'+v.id+'" style="display:none;">'+(v.password ? v.password : '')+'</p></td>';
                        t += '<td>'+(v.client_name ? v.client_name : '')+'</td>';
                        t += '<td>';
                        t += ''+(v.ip_address ? v.ip_address : '')+''+(v.port ? ':'+v.port : '')+'<br>';
                        t += ''+v.status_ip_address+'';
                        t += '</td>';
                        t += '<td>'+v.status+'</td>'; 
                        t += '<td>';
                           t += '<div class="btn-group">';
                              t += '<button class="btn btn-white btn-sm btn-edit" data-type="edit" data-toggle="tooltip" data-original-title="Edit" data-id="'+v.id+'"><i class="fa fa-edit"></i></button>';
                              t += '<button class="btn btn-white btn-sm btn-delete" data-toggle="tooltip" data-original-title="Delete" data-id="'+v.id+'" data-phone="'+v.phone_number+'"><i class="fa fa-trash"></i></button>';
                           t += '</div>';
                        t += '</td>';
                     t += '</tr>';
                  });
               }else{
                  t += set_no_result(9);
               }

               $('#sect-data').html(t);
               $('#sect-total').html("Total : " + data.total);
               $('#sect-pagination').paging({
                  items : data.total,
                  itemsOnPage : str.filter_rows,
                  currentPage : str.currentPage 
               });
               $('#offset').val(str.offset);
               $('#curpage').val(str.currentPage);
            }
         });
      };

      $(this).on('click', '.btn-show-password',function(e){
         var id = $(this).data('id');
         $('.show-password-'+id+'').show();
      });

      $(this).on('click', '.btn-download-client', function(e) {
         $(this).render_picker({
            modal : '#modal-download-client'
         });   
         e.preventDefault();
      });

      $(this).on('click', '.set-empty-client',function(e){
         var target = $(this).data('target');

         $('#form-download-client').find('.'+target+'').val('');
         $('#form-download-client').find('input[name="'+target+'_sdate"]').val('');
         $('#form-download-client').find('input[name="'+target+'_edate"]').val('');
      });

      $(this).on('change', '#filter_rows', function(e){
         $('#offset').val(0);
         $('#curpage').val(1);
         $('.select_id').removeAttr('checked');
         $(this).render_data();
         e.preventDefault();
      });

      $.fn.render_phone_number  = function(params){
         var str = $.extend({
            target : '',
            with_choosed : null,
            render_container : 'create'
         },params);
         ajaxManager.addReq({
            type : "GET",
            url : site_url + '/facebook/get_phone_number',
            dataType : "JSON",
            data : {
               with_choosed : str.with_choosed
            },
            beforeSend: function (xhr) {
               if(sessions){
                  $('.container-phone-loading[data-container="'+str.render_container+'"]').show();
                  $('.container-phone[data-container="'+str.render_container+'"]').hide();
               }else{
                  xhr.done();
                  window.location.href = location; 
               }
            },
            error: function (jqXHR, status, errorThrown) {
               error_handle(jqXHR, status, errorThrown);
            },
            success : function(data){
               t = '';
               if(data.response){
                  t += '<option value=""></option>';
                  $.each(data.response, function(k,v){
                     t += '<option value="'+v.phone_number+'" data-displayname="'+v.display_name+'" data-birthday="'+v.birth_day+'">'+v.phone_number+' - '+v.email+'</option>';
                  });
                  $('.phone_number[data-target="'+str.target+'"]').html(t);
               }else{
                  alert('Phone Number Not Found');
               }
               $('.phone_number[data-target="'+str.target+'"]').select2();
               if(str.with_choosed !== ''){
                  $('.phone_number[data-target="'+str.target+'"]').select2('val', str.with_choosed);
               }
               $('.container-phone-loading[data-container="'+str.render_container+'"]').hide();
               $('.container-phone[data-container="'+str.render_container+'"]').show();
            }
         });
      }

      $(this).on('submit', '#form-add', function(e){
         var form = $(this);
         $(this).ajaxSubmit({
            url  : site_url +'/facebook/create',
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
                  $('#form-add').find('select[name="proxy_id"]').select2('val', '');
                  $('#form-add').find('select[name="client_id"]').select2('val', '');
                  form.resetForm();
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

      $(this).on('submit', '#form-edit', function(e){
         var form = $(this);
         $(this).ajaxSubmit({
            url  : site_url +'facebook/change',
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

      $(this).on('submit', '#form-delete', function(e){
         var form = $(this);
         $(this).ajaxSubmit({
            url  : site_url +'/facebook/delete',
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
                  $('#modal-delete').modal('hide');
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
         var type = $(this).data('type');         
         ajaxManager.addReq({
            type : "GET",
            url : site_url + '/facebook/edit',
            dataType : "JSON",
            data : {
               id : id
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
               $(this).render_picker({
                  modal : '#modal-edit'
               });
               form.find('input[name="id"]').val(r.response.id);
               form.find('input[name="phone_number_before"]').val(r.response.phone_number);
               form.find('input[name="phone_number"]').val(r.response.phone_number);
               form.find('input[name="phone_number_choosed"]').val(r.response.phone_number+' (Exp. '+moment(r.response.expired_date).format('DD/MMM/YYYY')+') ('+r.response.email+')');
               form.find('#data_choosed').val(r.response.phone_number);
               form.find('input[name="password"]').val(r.response.password);
               form.find('input[name="display_name"]').val(r.response.display_name);
               form.find('input[name="url_facebook"]').val(r.response.url);
               form.find('input[name="url_facebook_before"]').val(r.response.url);
               if(r.response.created_facebook){
                  form.find('.date-data').val(moment(r.response.created_facebook).format('DD/MMM/YYYY'));
                  form.find('input[name="created_facebook"]').val(r.response.created_facebook);
               }else{
                  form.find('.date-data').val('');
                  form.find('input[name="created_facebook"]').val('');
               }
               if(r.response.birth_date){
                  form.find('.date-birthdate').val(moment(r.response.birth_date).format('DD/MMM/YYYY'));
                  form.find('input[name="birth_date"]').val(r.response.birth_date);
               }else{
                  form.find('.date-birthdate').val('');
                  form.find('input[name="birth_date"]').val('');
               }
               form.find('input[name="facebook_id"]').val(r.response.facebook_id);
               form.find('input[name="facebook_id_before"]').val(r.response.facebook_id);
               form.find('input[name="friends"]').val(r.response.friends);
               form.find('input[name="cookies"]').val(r.response.cookies);
               form.find('input[name="access_token"]').val(r.response.access_token);
               form.find('textarea[name="info"]').html(r.response.info);
               form.find('select[name="status"]').val(r.response.status);
               form.find('select[name="client_id"]').select2('val', r.response.client_id);
               form.find('select[name="proxy_id"]').select2('val', r.response.proxy_id);
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
         var id = $(this).data('id');
         var phone_number = $(this).data('phone');

         $('#form-delete').find('input[name="id"]').val(id);
         $('#form-delete').find('input[name="phone_number"]').val(phone_number);
         $('#modal-delete').modal('show');
         e.preventDefault();
      });


      $(this).on('click', '.btn-search-phone-number', function(e){
         var render = $(this).data('render');
         var phone = $('.filter_search_phone_number[data-render="'+render+'"]').val();
         if(phone !== ''){
            ajaxManager.addReq({
               type : "GET",
               url : site_url + 'facebook/find_phone',
               dataType : "JSON",
               data : {
                  phone : phone
               },
               beforeSend: function (xhr) {
                  if(sessions){
                     $('#'+render+'').find('input[name="phone_number_choosed"]').hide();
                     $('#'+render+'').find('.container-phone-loading').show();
                  }else{
                     xhr.done();
                     window.location.href = location; 
                  }
               },
               error: function (jqXHR, status, errorThrown) {
                  error_handle(jqXHR, status, errorThrown);
                  $('#'+render+'').find('.container-phone-loading').hide();
               },
               success : function(r){
                  if(r.response){
                     if(r.response.registered_facebook == 0 && r.response.registered == 1){
                        $('#'+render+'').find('input[name="phone_number"]').val(r.response.phone_number);
                        $('#'+render+'').find('input[name="phone_number_choosed"]').val(r.response.phone_number+' (exp. '+moment(r.response.expired_date).format('DD/MMM/YYYY')+') ('+r.response.email+')');
                        if(r.response.display_name){
                           $('#'+render+'').find('input[name="display_name"]').val(r.response.display_name);
                        }else{
                           $('#'+render+'').find('input[name="display_name"]').val('');
                        }
                        if(r.response.birth_day){
                           $('#'+render+'').find('.date-birthdate').val(moment(r.response.birth_day).format('DD/MMM/YYYY'));
                           $('#'+render+'').find('input[name="birth_date"]').val(r.response.birth_day);
                        }else{
                           $('#'+render+'').find('input[name="birth_date"]').val('');
                        }
                     }else if(r.response.registered_facebook == 1){
                        if(r.response.phone_number == $('#'+render+'').find('input[name="phone_number_before"]').val()){
                           $('#'+render+'').find('input[name="phone_number"]').val(r.response.phone_number);
                           $('#'+render+'').find('input[name="phone_number_choosed"]').val(r.response.phone_number+' (exp. '+moment(r.response.expired_date).format('DD/MMM/YYYY')+') ('+r.response.email+')');
                        }else{
                           $('#'+render+'').find('input[name="phone_number"]').val('');
                           $('#'+render+'').find('input[name="phone_number_choosed"]').val('The number has been registered');
                        }
                     }else if(r.response.registered_facebook == 0 && r.response.registered == 0){
                        $('#'+render+'').find('input[name="phone_number"]').val('');
                        $('#'+render+'').find('input[name="phone_number_choosed"]').val('Phone number doesnt have an email');
                     }
                  }else{
                     $('#'+render+'').find('input[name="phone_number"]').val('');
                     $('#'+render+'').find('input[name="display_name"]').val('');
                     $('#'+render+'').find('input[name="birth_date"]').val('');
                     $('#'+render+'').find('input[name="phone_number_choosed"]').val('Phone number not found');
                  }
                  $('#'+render+'').find('.container-phone-loading').hide();
                  $('#'+render+'').find('input[name="phone_number_choosed"]').show();
               }
            });
         }
         e.preventDefault();
      });

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
               url: site_url + '/facebook/bulk_action',
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


      $(this).on('click', '.btn-new', function(e) {
         var type = $(this).data('type');
         $(this).render_picker({
            modal : '#modal-create'
         });   
         e.preventDefault();
      });

      $(this).on('change', '#form-add .phone_number', function(e) {
         var display_name = $('option:selected', this).attr('data-displayname');
         var birth_day = $('option:selected', this).attr('data-birthday');
         if(display_name !== 'null'){
            $('#form-add').find('input[name="display_name"]').val(display_name);
         }else{
            $('#form-add').find('input[name="display_name"]').val('');
         }
         if(birth_day !== 'null'){
            $('#form-add').find('.date-birthdate').val(moment(birth_day).format('DD/MMM/YYYY'));
            $('#form-add').find('input[name="birth_date"]').val(birth_day);
         }else{
            $('#form-add').find('input[name="birth_date"]').val('');
         }
         e.preventDefault();
      });

      $(this).on('click', '.btn-refresh', function(e) {
         var type = $(this).data('type');
         if(type == 'create'){
            var with_choosed = '';
         }
         if(type == 'edit'){
            var with_choosed = $('#data_choosed').val();
         }

         $(this).render_phone_number({
            target : type,
            with_choosed : with_choosed,
            render_container : type
         });
         e.preventDefault();
      });

      $(this).on('click', '.btn-search',function(e){
         $('#modal-filter').modal('hide');
         $('#offset').val(0);
         $('#curpage').val(1);
         $('.select_id').removeAttr('checked'); 
         $(this).render_data();
         e.preventDefault();
      });

      $(this).on('change', '#filter_keyword', function(e){
         $('#modal-filter').modal('hide');
         $('#offset').val(0);
         $('#curpage').val(1);
         $('.select_id').removeAttr('checked'); 
         $(this).render_data();
         e.preventDefault();
      });

      $(this).on('click', '.btn-reset', function(e) {
         $('#form-filter').find('#filter_client').select2('val', '');
         $('#form-filter').find('#filter_status').select2('val', '');
         $('#form-filter').find('#filter_expireddate_sdate').val('');
         $('#form-filter').find('#filter_expireddate_edate').val('');
         $('#form-filter').find('#filter_createddate_sdate').val('');
         $('#form-filter').find('#filter_createddate_edate').val('');
         $('#modal-filter').modal('hide');
         $('#offset').val(0);
         $('#curpage').val(1);
         $('#form-filter').resetForm();
         $('.select_id').removeAttr('checked');
         $(this).render_data();
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

         if(opt.modal == '#modal-download-client'){
            $('.client_date').daterangepicker({
               parentEl : opt.modal,
               autoUpdateInput: false,
            },
               function (start, end) {
                  $('.client_date').val(''+start.format('DD MMM YYYY')+' sd '+end.format('DD MMM YYYY')+'');
                  $('#form-download-client').find('input[name="client_date_sdate"]').val(start.format('YYYY-MM-DD'));
                  $('#form-download-client').find('input[name="client_date_edate"]').val(end.format('YYYY-MM-DD'));
               }
            );
         }

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

            $('.filter_createddate').daterangepicker({
               parentEl : opt.modal,
               autoUpdateInput: false,
            },
               function (start, end) {
                  $('.filter_createddate').val(''+start.format('DD MMM YYYY')+' sd '+end.format('DD MMM YYYY')+'');
                  $('#form-filter').find('input[name="filter_createddate_sdate"]').val(start.format('YYYY-MM-DD'));
                  $('#form-filter').find('input[name="filter_createddate_edate"]').val(end.format('YYYY-MM-DD'));
               }
            );
         }

         $('.date-birthdate').daterangepicker({
            parentEl : opt.modal,
            autoUpdateInput: false,
            locale: {
               format: 'DD/MMM/YYYY'
            },
            singleDatePicker: true,
            showDropdowns: true
         });

         $('.date-data').on('apply.daterangepicker', function(ev, picker) {
            var formrender = $(this).data('formrender');
            $(this).val(picker.startDate.format('DD/MMM/YYYY'));
            $(formrender).find('input[name="created_facebook"]').val(picker.startDate.format('YYYY-MM-DD'));
         });

         $('.date-birthdate').on('apply.daterangepicker', function(ev, picker) {
            var formrender = $(this).data('formrender');
            $(this).val(picker.startDate.format('DD/MMM/YYYY'));
            $(formrender).find('input[name="birth_date"]').val(picker.startDate.format('YYYY-MM-DD'));
         });
      }

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
               $(this).render_data({
                  offset: offset,
                  currentPage: n
               });
            }
         });
      };

      $(this).on('submit', '#form-bulk-client', function(e){
         var form = $(this);
         $(this).ajaxSubmit({
            url  : site_url +'facebook/bulkFacebook',
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
                  $('#modal-migrasi-client').modal('hide');
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

      $(this).on('submit', '#form-migration', function(e){
         var form = $(this);
         $(this).ajaxSubmit({
            url  : site_url +'facebook/migration_all',
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

      $(this).on('click', '.with_download', function(e){
         if($(this).is(':checked')){
            $('#with_download_field').prop("disabled", false);
         }else{
            $('#with_download_field').prop("disabled", true);
         }
         return true;
      });

      $(this).on('submit', '#form-assign-client', function(e){
         var form = $(this);
         var data = [];
         $('.option_id').each(function () {
            if (this.checked) {
               data.push($(this).val());
            }
         });

         $(this).ajaxSubmit({
            url  : site_url +'facebook/assign_client',
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
                  if(r.with_download_mode){
                     $('#your-file').attr('href', ''+base_url+'/download/'+r.filename+'.xlsx');
                     $('#your-file').html(r.filename+'.xlsx');
                  }
                  $('#modal-assign-client').modal('hide');
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

      $(this).render_data();
   });
</script>