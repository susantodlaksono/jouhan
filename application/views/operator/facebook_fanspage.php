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
   $facebook = $this->db->select('id, display_name')->where('status', 1)->get('facebook')->result_array();
?>

<div class="row">
   <div class="col-md-12">
      <div class="panel panel-primary" data-collapsed="0">
         <div class="panel-heading">
            <div class="panel-title"><i class="fa fa-list"></i> List facebook Fanspage</div>
            <div class="panel-options" style="width: auto;border:0px solid black;">
               <div class="form-group" style="margin-top: 8px;margin-bottom: 5px;">  
                  <div class="btn-group dropdown-default"> 
                     <button class="btn btn-white btn-sm" data-toggle="modal" data-target="#modal-migrasi-all"><i class="fa fa-download"></i> Migration</button>
                  </div> 
                  <div class="btn-group dropdown-default"> 
                     <button class="btn btn-white btn-sm" data-toggle="modal" data-target="#modal-bulk"><i class="fa fa-upload"></i> Bulk By URL</button>
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
                        <li style="font-weight: bold;text-align: center;">Assign</li>
                        <div class="divider"></div>
                        <li style="font-size: 13px;"><a href="#" class="assign-client" data-toggle="modal" data-target="#modal-assign-client">To Client</a></li>   
                     </ul>
                  </div>
                  <button class="btn btn-white btn-sm btn-filter" data-toggle="modal" data-target="#modal-filter"><i class="fa fa-filter"></i> Filter</button>
                  <button class="btn btn-primary btn-sm btn-new" data-type="create" data-toggle="modal" data-target="#modal-create"><i class="fa fa-plus"></i> New</button>
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
                  <th>Fanspage</th>
                  <th>Followers</th>
                  <th>Likes</th>
                  <th>Admin</th>
                  <th>Client</th>
                  <th>Info</th>
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

<div class="modal fade" id="modal-migrasi-all">
   <div class="modal-dialog" style="width: 35%;">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Migration</h4>
         </div>
         <form id="form-migration">
            <div class="modal-body">
               <h5 class="text-center">Format Migration</h5>
               <p class="text-muted text-center bold" style="margin-top: -5px;"><a href="<?php echo site_url() ?>facebook/format_migration_fanspage" class="text-center"> MigrationFanspage.xlsx</a></p>
               <div class="form-group">
                  <label>Upload Format</label>
                  <input type="file" name="userfile" class="form-control">
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-primary">Upload</button>
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
            <h4 class="modal-title">Bulk By URL</h4>
         </div>
         <form id="form-bulk">
            <div class="modal-body">
               <h5 class="text-center">Format Bulk</h5>
               <p class="text-muted text-center bold" style="margin-top: -5px;"><a href="<?php echo site_url('facebook/format_fanspage') ?>" class="text-center"> URLFanspageList.xlsx</a></p>
               <div class="form-group">
                  <label>Upload Format</label>
                  <input type="file" name="userfile" class="form-control">
               </div>
               <div class="form-group">
                  <label>To Client</label>
                  <div class="input-group">
                     <div class="input-group-addon">
                        <input name="tags_assign_client" type="checkbox" class="select_field" data-type="select" data-field="assign_client" data-form="#form-bulk">
                     </div>
                     <select name="assign_client" class="form-control choose" id="assign_client" disabled="">
                        <?php
                           $data = $this->db->get('client')->result_array();
                           echo '<option value="">No Client</option>';
                           foreach ($data as $value) {
                              echo '<option value="'.$value['id'].'">'.$value['name'].'</option>';
                           }
                        ?>
                     </select>
                  </div>
               </div>
               <div class="form-group">
                  <label>To Status</label>
                  <div class="input-group">
                     <div class="input-group-addon">
                        <input name="tags_assign_status" type="checkbox" class="select_field" data-type="select" data-field="assign_status" data-form="#form-bulk">
                     </div>
                     <select name="assign_status" class="form-control choose" id="assign_status" disabled="">
                        <option value="1">Published</option>  
                        <option value="2">Un-Published</option> 
                     </select>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-primary">Assign</button>
            </div>
         </form>
      </div>
   </div>
</div>

<div class="modal fade" id="modal-create">
   <div class="modal-dialog" style="width: 60%;">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3 class="modal-title bold"><i class="fa fa-plus"></i> Create New</h3>
         </div>
         <form id="form-add">
            <div class="modal-body">
               <div class="row">
                  <div class="col-md-6">
               	 	<div class="form-group">
                        <label>Fanspage Name <span class="text-require">(*)</span></label>
                        <input type="text" class="form-control" name="name" required="">
                     </div>
                  </div>
                  <div class="col-md-6">
                  	<div class="form-group">
                        <label>Fanspage URL <span class="text-require">(*)</span></label>
                        <input type="text" class="form-control" name="url" required="">
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-12">
                  	<div class="form-group">
                        <label>Admin URL<span class="text-require">(*)</span></label>
                        <select name="admin_url[]" class="form-control choose" multiple="">
                           <?php
                              if($facebook){
                                 foreach ($facebook as $v) {
                                    echo '<option value="'.$v['id'].'">'.$v['display_name'].'</option>';
                                 }
                              }
                           ?>
                        </select>
                       	<!-- <div class="row">
                           <div class="col-md-12">
                              <label>Admin URL<span class="text-require">(*)</span></label>
                              <div class="container-phone-loading" data-container="create" style="display: none;">
                                 <i class="fa fa-spinner fa-spin"></i> Please Wait Rendering Select...
                              </div>
                              <div class="container-phone" data-container="create" style="display: none;">
                                 <select name="admin_url[]" class="form-control choose phone_number" data-target="create" multiple=""></select>
                              </div>
                           </div>
                        </div> -->
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-4">
                     <label>Create Date <span class="text-require">(*)</span></label>
                     <input type="hidden" name="created_fanspage">
                     <div class="input-group">
                        <input type="text" class="form-control date-data" data-formrender="#form-add" required="">
                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                     </div>
                  </div>
                  <div class="col-md-4">
                  	<div class="form-group">
                        <label>Followers</label>
                        <input type="number" class="form-control" name="followers">
                     </div>
               	</div>
               	<div class="col-md-4">
               		<div class="form-group">
                        <label>Likes</label>
                        <input type="number" class="form-control" name="likes">
                     </div>
               	</div>
            	</div>
               <div class="row">
                  <div class="col-md-6">
                  	<div class="form-group">
		                  <label>Status</label>
		                  <select name="status" class="form-control choose">
		                     <option value="1" selected="">Published</option>
		                     <option value="2">Un-published</option>
		                  </select>
		               </div>
               	</div>
               	<div class="col-md-6">
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
               	</div>
            	</div>
               <div class="form-group">
                  <label>Info</label>
                  <textarea class="form-control" name="info"></textarea>
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-save"></i> Submit</button> 
            </div>
         </form>
      </div>
   </div>
</div>

<div class="modal fade" id="modal-filter">
   <div class="modal-dialog" style="width: 30%;">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"><i class="fa fa-filter"></i> Filter</h4>
         </div>
         <div class="modal-body">
            <form id="form-filter">
               <div class="form-group">
                  <label>Keyword</label>
                  <input type="text" class="form-control" id="filter_keyword" value="">
               </div>
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
               <div class="form-group">
                  <label>Status</label>
                  <select id="filter_status" class="form-control choose" multiple="">
                     <option value="0">Empty</option>
                     <option value="1">Published</option>
                     <option value="2">Un-Published</option>
                  </select>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>Sort By</label>
                        <select id="filter_sort" class="form-control">
                           <option value="a.created_fanspage" selected="">Created Date</option>
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
            <button type="button" class="btn btn-white btn-reset">Reset</button>
            <button type="button" class="btn btn-primary btn-search"><i class="fa fa-search"></i> Search</button>
         </div>
      </div>
   </div>
</div>

<div class="modal fade" id="modal-edit">
   <div class="modal-dialog" style="width: 60%;">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"><i class="fa fa-plus"></i> Edit Data</h4>
         </div>
         <form id="form-edit">
            <input type="hidden" name="id">
            <input type="hidden" name="url_before">
            <div class="modal-body">
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>Fanspage Name <span class="text-require">(*)</span></label>
                        <input type="text" class="form-control" name="name" required="">
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>Fanspage URL <span class="text-require">(*)</span></label>
                        <input type="text" class="form-control" name="url" required="">
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-12">
                  	<div class="form-group">
                        <label>Admin URL<span class="text-require">(*)</span></label>
                        <select name="admin_url[]" class="form-control choose" multiple="">
                           <?php
                              if($facebook){
                                 foreach ($facebook as $v) {
                                    echo '<option value="'.$v['id'].'">'.$v['display_name'].'</option>';
                                 }
                              }
                           ?>
                        </select>
                       	<!-- <div class="row">
                           <div class="col-md-12">
                              <label>Admin URL<span class="text-require">(*)</span></label>
                              <div class="container-phone-loading" data-container="edit" style="display: none;">
                                 <i class="fa fa-spinner fa-spin"></i> Please Wait Rendering Select...
                              </div>
                              <div class="container-phone" data-container="edit" style="display: none;">
                                 <select name="admin_url[]" class="form-control choose phone_number" data-target="edit" multiple=""></select>
                              </div>
                           </div>
                        </div> -->
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-4">
                     <label>Create Date <span class="text-require">(*)</span></label>
                     <input type="hidden" name="created_fanspage">
                     <div class="input-group">
                        <input type="text" class="form-control date-data" data-formrender="#form-edit" required="">
                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                     </div>
                  </div>
                  <div class="col-md-4">
                  	<div class="form-group">
                        <label>Followers</label>
                        <input type="number" class="form-control" name="followers">
                     </div>
               	</div>
               	<div class="col-md-4">
               		<div class="form-group">
                        <label>Likes</label>
                        <input type="number" class="form-control" name="likes">
                     </div>
               	</div>
            	</div>
               <div class="row">
                  <div class="col-md-6">
                  	<div class="form-group">
		                  <label>Status</label>
		                  <select name="status" class="form-control choose">
		                     <option value="1" selected="">Published</option>
		                     <option value="2">Un-published</option>
		                  </select>
		               </div>
               	</div>
               	<div class="col-md-6">
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
               	</div>
            	</div>
               <div class="form-group">
                  <label>Info</label>
                  <textarea class="form-control" name="info"></textarea>
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-save"></i> Submit</button> 
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
       var fanspage_admin_before = null;

      $.fn.render_phone_number  = function(params){
         var str = $.extend({
            target : '',
            with_choosed : null,
            render_container : 'create'
         },params);
         ajaxManager.addReq({
            type : "GET",
            url : site_url + '/facebook/get_facebook_list',
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
                  $.each(data.response, function(k,v){
                     t += '<option value="'+v.id+'">'+(v.display_name ? v.display_name : '')+'</option>';
                  });
                  $('.phone_number[data-target="'+str.target+'"]').html(t);
               }else{
                  alert('Facebook URL Not Found');
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

      $.fn.render_data  = function(params){
         var str = $.extend({
            offset : $('#offset').val(),
            curpage : $('#curpage').val(),
            filter_keyword : $('#filter_keyword').val(),
            filter_client : $('#filter_client').val(),
            filter_status : $('#filter_status').val(),
            filter_rows : $('#filter_rows').val(),
            filter_sort : $('#filter_sort').val(),
            filter_sort_type : $('#filter_sort_type').val()
         },params);
         ajaxManager.addReq({
            type : "GET",
            url : site_url + '/facebook/get_fanspage',
            dataType : "JSON",
            data : {
               offset : str.offset,
               curpage : str.curpage,  
               filter_keyword : str.filter_keyword,
               filter_client : str.filter_client,
               filter_status : str.filter_status,
               filter_rows : str.filter_rows,
               filter_sort : str.filter_sort,
               filter_sort_type : str.filter_sort_type,
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
                     var fanspage_admin = [];
                     t += '<tr>';
                        t += '<td><input type="checkbox" class="option_id" id="checkbox'+v.id+'" value="'+v.id+'"></td>';
                         t += '<td>';
                           t += '<b>'+v.pic+'</b></br>';
                           if(v.pic_updated){
                              t += '<a style="cursor:pointer" data-toggle="tooltip" data-placement="top" title="" data-original-title="By '+v.pic_updated+' at '+v.updated_date+'"><i class="fa fa-external-link"></i></a> at '+v.created_date+'';
                           }else{
                              t += 'at '+v.created_date+'';
                           }
                        t += '</td>';
                        t += '<td>';
                        	t += '<a '+(v.url ? 'href="'+v.url+'"' : '')+' target="_blank">';
                        		t += '<b>'+(v.name ? v.name : '<span style="color:red;">None</span>')+'</b>';
                        	t += '</a>';
                        t += '</td>';
                        t += '<td>'+(v.followers ? v.followers : '')+'</td>';
                        t += '<td>'+(v.likes ? v.likes : '')+'</td>';
                        if(v.admin){
                           $.each(v.admin, function(kk ,vv) {
                              fanspage_admin.push('<a href="'+vv.url+'" target="_blank">'+vv.display_name+'</a>');
                           });
                           t += '<td>'+fanspage_admin.join(', ') +'</a></td>';
                        }else{
                           t += '<td>-</td>';
                        }
                        t += '<td>'+(v.client_name ? v.client_name : '')+'</td>';
                        t += '<td>'+(v.info ? v.info : '')+'</td>';
                        t += '<td>'+v.status+'</td>'; 
                        t += '<td>';
                           t += '<div class="btn-group">';
                              t += '<button class="btn btn-white btn-sm btn-edit" data-type="edit" data-toggle="tooltip" data-original-title="Edit" data-id="'+v.id+'" data-container="edit"><i class="fa fa-edit"></i></button>';
                              t += '<button class="btn btn-danger btn-sm btn-delete" data-toggle="tooltip" data-original-title="Delete" data-id="'+v.id+'"><i class="fa fa-trash"></i></button>';
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

      $(this).on('click', '.btn-edit',function(e){
         var id = $(this).data('id');
         var form = $('#form-edit');
         var type = $(this).data('type');
         var render_container = $(this).data('container');

         ajaxManager.addReq({
            type : "GET",
            url : site_url + '/facebook/edit_fanspage',
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
               if(r.admin){
                  var fanspage_admin = [];
                  $.each(r.admin, function(kk ,vv) {
                     fanspage_admin.push(vv);
                  });
                  fanspage_admin_before = fanspage_admin;
               }else{
                  fanspage_admin_before = null;
               }
               form.find('input[name="id"]').val(r.response.id);
               form.find('input[name="name"]').val(r.response.name);
               form.find('input[name="url"]').val(r.response.url);
               form.find('input[name="url_before"]').val(r.response.url);
               form.find('input[name="followers"]').val(r.response.followers);
               form.find('input[name="likes"]').val(r.response.likes);
               form.find('select[name="status"]').select2('val', r.response.status);
               form.find('select[name="client_id"]').select2('val', r.response.client_id);
               if(r.admin){
                  form.find('select[name="admin_url[]"]').select2('val', r.admin);
               }
               if(r.response.created_fanspage){
                  form.find('.date-data').val(moment(r.response.created_fanspage).format('DD/MMM/YYYY'));
                  form.find('input[name="created_fanspage"]').val(r.response.created_fanspage);
               }else{
                  form.find('.date-data').val('');
                  form.find('input[name="created_fanspage"]').val('');
               }
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
               url : site_url + 'facebook/delete_fanspage',
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


      // $(this).on('click', '.btn-new', function(e) {
      //    var type = $(this).data('type');
      //    $(this).render_phone_number({
      //       target : type
      //    });
      //    e.preventDefault();
      // });

       $(this).on('click', '.btn-new', function(e) {
         var type = $(this).data('type');
         $(this).render_picker({
            modal : '#modal-create'
         });   
         e.preventDefault();
      });

      $(this).on('submit', '#form-add', function(e){
         var form = $(this);
         $(this).ajaxSubmit({
            url  : site_url +'/facebook/create_fanspage',
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
                  $('#form-add').find('select[name="client_id"]').select2('val', '');
                  $('#form-add').find('select[name="admin_url[]"]').select2('val', '');
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
            url  : site_url +'/facebook/change_fanspage',
            type : "POST",
            dataType : "JSON",
            data : {
               'fanspage_admin_before' : fanspage_admin_before
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
                  fanspage_admin_before = null;
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
         if(this.checked) {
            $(form).find(''+type+'[name="'+field+'"]').prop("disabled", false);
         }else{
            $(form).find(''+type+'[name="'+field+'"]').prop("disabled", true);
         }
         e.preventDefault();
      });

      $(this).on('change', '#filter_rows', function(e){
         $('#offset').val(0);
         $('#curpage').val(1);
         $('.select_id').removeAttr('checked');
         $(this).render_data();
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
         $('#modal-filter').modal('hide');
         $('#offset').val(0);
         $('#curpage').val(1);
         $('#form-filter').resetForm();
         $('.select_id').removeAttr('checked');
         $(this).render_data();
      });

      $(this).on('submit', '#form-bulk', function(e){
         var form = $(this);
         $(this).ajaxSubmit({
            url  : site_url +'/facebook/bulk_migration_fanspage',
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
                  form.find('select[name="assign_client"]').prop("disabled", true);
                  form.find('select[name="assign_status"]').prop("disabled", true);
                  form.find('select[name="assign_client"]').select2('val', '');
                  form.find('select[name="assign_status"]').select2('val', '1');
                  $('#modal-bulk').modal('hide');
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
            url  : site_url +'/facebook/migration_all_fanspage',
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

         $('.date-data').on('apply.daterangepicker', function(ev, picker) {
            var formrender = $(this).data('formrender');
            $(this).val(picker.startDate.format('DD/MMM/YYYY'));
            $(formrender).find('input[name="created_fanspage"]').val(picker.startDate.format('YYYY-MM-DD'));
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

   	$(this).render_data();


   });

</script>