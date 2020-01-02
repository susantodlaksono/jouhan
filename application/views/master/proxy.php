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
            <div class="panel-title"><i class="fa fa-list"></i> List Proxy </div>
            <div class="panel-options" style="width: auto;border:0px solid black;">
               <div class="form-group" style="margin-top: 8px;margin-bottom: 5px;">  
                  <div class="btn-group dropdown-default"> 
                     <button class="btn btn-white btn-sm" data-toggle="modal" data-target="#modal-migrasi-all"><i class="fa fa-download"></i> Migration</button>
                  </div> 
                  <div class="btn-group dropdown-default"> 
                     <a class="btn btn-white btn-sm dropdown-toggle" data-toggle="dropdown" href="#" style="width: auto;" aria-expanded="true"> 
                        <i class="fa fa-gear"></i> Bulk Action <span class="caret"></span>
                     </a>
                     <ul class="dropdown-menu " style="width: auto;">
                        <li style="font-weight: bold;text-align: center;">Set Status</li>
                        <div class="divider"></div>
                        <li style="font-size: 13px;"><a href="#" class="bulk_action" data-mode="status" data-value="1"><i class="fa fa-check"></i> Set Connected</a></li>   
                        <li style="font-size: 13px;"><a href="#" class="bulk_action" data-mode="status" data-value="0"><i class="fa fa-remove"></i> Set Not Connected</a></li>
                     </ul>
                  </div>
                  <button class="btn btn-white btn-sm" data-toggle="modal" data-target="#modal-filter"><i class="fa fa-filter"></i> Filter</button>
                  <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-create"><i class="fa fa-plus"></i> New</button>
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
                  <th>Network</th>
                  <th>IP Address</th>
                  <th>Port</th>
                  <th>Username</th>
                  <th>Password</th>
                  <th>Location</th>
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
                  <label>Network</label>
                  <select id="filter_network" class="form-control">
                     <option value="">All</option>
                     <option value="1">VPS</option>
                     <option value="2">Proxy</option>
                  </select>
               </div>
               <div class="form-group">
                  <label>Status</label>
                  <select id="filter_status" class="form-control">
                     <option value="">All</option>
                     <option value="0">Not Connected</option>
                     <option value="1">Connected</option>
                  </select>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>Sort By</label>
                        <select id="filter_sort" class="form-control">
                           <option value="a.id" selected="">Created Proxy</option>
                           <option value="total_twitter">Total Twitter</option>
                           <option value="total_facebook">Total Facebook</option>
                           <option value="total_instagram">Total Instagram</option>
                           <option value="a.location">Location</option>
                           <option value="a.status">Status</option>
                           <option value="a.network">Network</option>
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

<div class="modal fade" id="modal-create">
   <div class="modal-dialog" style="width: 30%;">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"><i class="fa fa-plus"></i> New Data</h4>
         </div>
         <form id="form-add">
            <div class="modal-body">
               <div class="form-group">
                  <label>Network <span class="text-require">(*)</span></label>
                  <select class="form-control" name="network" required="">
                     <option value="1">VPS</option>
                     <option value="2">Proxy</option>
                  </select>
               </div>
               <div class="form-group">
                  <label>IP Address <span class="text-require">(*)</span></label>
                  <input type="text" name="ip_address" class="form-control" required="">
               </div>
               <div class="form-group">
                  <label>Port</label>
                  <input type="number" name="port" class="form-control">
               </div>
               <div class="form-group">
                  <label>Username</label>
                  <input type="text" name="username" class="form-control">
               </div>
               <div class="form-group">
                  <label>Password</label>
                  <input type="text" name="password" class="form-control">
               </div>
               <div class="form-group">
                  <label>Location</label>
                  <input type="text" name="location" class="form-control">
               </div>
               <div class="form-group">
                  <label>Status</label>
                  <select class="form-control" name="status" required="">
                     <option value="1">Connected</option>
                     <option value="0">Not Connected</option>
                  </select>
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Submit</button> 
            </div>
         </form>
      </div>
   </div>
</div>

<div class="modal fade" id="modal-edit">
   <div class="modal-dialog" style="width: 30%;">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"><i class="fa fa-plus"></i> Edit Data</h4>
         </div>
         <form id="form-edit">
            <input type="hidden" name="id" value="">
            <input type="hidden" name="ip_address_before" value="">
            <input type="hidden" name="port_before" value="">
            <div class="modal-body">
               <div class="form-group">
                  <label>Network <span class="text-require">(*)</span></label>
                  <select class="form-control" name="network" required="">
                     <option value="1">VPS</option>
                     <option value="2">Proxy</option>
                  </select>
               </div>
               <div class="form-group">
                  <label>IP Address <span class="text-require">(*)</span></label>
                  <input type="text" name="ip_address" class="form-control" required="">
               </div>
               <div class="form-group">
                  <label>Port</label>
                  <input type="number" name="port" class="form-control">
               </div>
               <div class="form-group">
                  <label>Username</label>
                  <input type="text" name="username" class="form-control">
               </div>
               <div class="form-group">
                  <label>Password</label>
                  <input type="text" name="password" class="form-control">
               </div>
               <div class="form-group">
                  <label>Location</label>
                  <input type="text" name="location" class="form-control">
               </div>
               <div class="form-group">
                  <label>Status</label>
                  <select class="form-control" name="status" required="">
                     <option value="1">Connected</option>
                     <option value="0">Not Connected</option>
                  </select>
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Submit</button> 
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
            <h4 class="modal-title">Migration</h4>
         </div>
         <form id="form-migration">
            <div class="modal-body">
               <h5 class="text-center">Format Migration</h5>
               <p class="text-muted text-center bold" style="margin-top: -5px;"><a href="<?php echo site_url() ?>/master_proxy/download_format" class="text-center"> MigrationProxy.xlsx</a></p>
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

<script type="text/javascript">
   var sessions = '#<?php echo $this->ion_auth->logged_in() ?>';
   var loading = '<i class="fa fa-spinner fa-spin"></i>';
   var overlay = '<h3 class="text-center text-danger overlay"><i class="fa fa-spinner fa-spin"></i></h3>';

   $(function () {

      $.fn.render_data  = function(params){
         var str = $.extend({
            offset : $('#offset').val(),
            curpage : $('#curpage').val(),
            filter_keyword : $('#filter_keyword').val(),
            filter_network : $('#filter_network').val(),
            filter_sort : $('#filter_sort').val(),
            filter_sort_type : $('#filter_sort_type').val(),
            filter_status : $('#filter_status').val()
         },params);
         ajaxManager.addReq({
            type : "GET",
            url : site_url + 'master_proxy/get',
            dataType : "JSON",
            data : {
               offset : str.offset,
               curpage : str.curpage,
               filter_keyword : str.filter_keyword,
               filter_network : str.filter_network,
               filter_sort : str.filter_sort,
               filter_sort_type : str.filter_sort_type,
               filter_status : str.filter_status
            },
            beforeSend: function (xhr) {
               if(sessions){
                  set_loading_table('#sect-data', 8);
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
                        t += '<td><b>'+v.pic+'</b><br>at '+v.created_date+'</td>';
                        t += '<td>'+(v.network ? v.network : '')+'</td>';
                        t += '<td>';
                        t += ''+v.ip_address+'<br>';
                        t += '<i class="fa fa-twitter"></i> '+v.total_twitter+' <i class="fa fa-facebook"></i> '+v.total_facebook+' <i class="fa fa-instagram"></i> '+v.total_instagram+'';
                        t += '</td>';
                        t += '<td>'+(v.port ? v.port : '')+'</td>';
                        t += '<td>'+(v.username ? v.username : '')+'</td>';
                        t += '<td>'+(v.password ? v.password : '')+'</td>';
                        t += '<td>'+(v.location ? v.location : '')+'</td>';
                        t += '<td>'+(v.status ? v.status : '')+'</td>'; 
                        t += '<td>';
                           t += '<div class="btn-group">';
                              t += '<button class="btn btn-white btn-sm btn-edit" data-type="edit" data-toggle="tooltip" data-original-title="Edit" data-id="'+v.id+'"><i class="fa fa-edit"></i></button>';
                              t += '<button class="btn btn-danger btn-sm btn-delete" data-toggle="tooltip" data-original-title="Delete" data-id="'+v.id+'"><i class="fa fa-trash"></i></button>';
                           t += '</div>';
                        t += '</td>';
                     t += '</tr>';
                  });
               }else{
                  t += set_no_result(8);
               }

               $('#sect-data').html(t);
               $('#sect-total').html("Total : " + data.total);
               $('#sect-pagination').paging({
                  items : data.total,
                  currentPage : str.currentPage 
               });
               $('#offset').val(str.offset);
               $('#curpage').val(str.currentPage);
            }
         });
      };

      $(this).on('submit', '#form-add', function(e){
         var form = $(this);
         $(this).ajaxSubmit({
            url  : site_url +'/master_proxy/create',
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
            url  : site_url +'/master_proxy/change',
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
            url : site_url + '/master_proxy/edit',
            dataType : "JSON",
            data : {
               id:id
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
               form.find('input[name="id"]').val(r.response.id);

               form.find('input[name="ip_address_before"]').val(r.response.ip_address);
               form.find('input[name="ip_address"]').val(r.response.ip_address);
               form.find('input[name="port_before"]').val(r.response.port);
               form.find('input[name="port"]').val(r.response.port);

               form.find('select[name="network"]').val(r.response.network);
               form.find('input[name="username"]').val(r.response.username);
               form.find('input[name="password"]').val(r.response.password);
               form.find('input[name="location"]').val(r.response.location);
               form.find('select[name="status"]').val(r.response.status);

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
               url : site_url + '/master_proxy/delete',
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
               url: site_url + '/master_proxy/bulk_action',
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
            itemsOnPage: 10,
            currentPage: 1
         }, opt);

         $('#sect-pagination').pagination({
            items: s.items,
            itemsOnPage: s.itemsOnPage,
            prevText: '&laquo;',
            nextText: '&raquo;',
            hrefTextPrefix: '#',
            currentPage: s.currentPage,
            onPageClick: function (n, e) {
               e.preventDefault();
               var offset = (n - 1) * s.itemsOnPage;
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
         $(this).render_data();
         e.preventDefault();
      });

      $(this).on('click', '.btn-reset', function(e) {
         $('#modal-filter').modal('hide');
         $('#offset').val(0);
         $('#curpage').val(1);
         $('#form-filter').resetForm();
         $(this).render_data();
      });

      $(this).on('submit', '#form-filter', function(e){
         e.preventDefault();
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

      $(this).render_data();

      $(this).on('submit', '#form-migration', function(e){
         var form = $(this);
         $(this).ajaxSubmit({
            url  : site_url +'/master_proxy/migration_all',
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


   });
</script>