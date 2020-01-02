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
            <div class="panel-title"><i class="fa fa-list"></i> List Email Account</div>
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
                  <button class="btn btn-white btn-sm" data-toggle="modal" data-target="#modal-filter"><i class="fa fa-filter"></i> Filter</button>
                  <button class="btn btn-white btn-sm btn-new" data-type="create" data-toggle="modal" data-target="#modal-create"><i class="fa fa-plus"></i> Create</button>
               </div>
            </div>
         </div>
         <div class="panel-body">
            <input type="hidden" id="offset" value="0">
            <input type="hidden" id="curpage" value="1">
            <table class="table">
               <thead>
                  <!-- <th>
                     <input type="checkbox" class="select_id">
                     <label for="checkbox_choose"></label>
                  </th> -->
                  <th>Created</th>
                  <th>Email</th>
                  <th>Display Name</th>
                  <th>Password</th>
                  <th>Birth Date</th>
                  <th>info</th>
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

<div class="modal" id="modal-filter">
   <div class="modal-dialog" style="width: 35%;">
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
               <div class="form-group">
                  <label>Status Email</label>
                  <select id="filter_status" class="form-control">
                     <option value=""></option>
                     <option value="0">No Action</option>
                     <option value="1">Active</option>
                     <option value="2">Blocked</option>
                  </select>
               </div>
               <div class="form-group">
                  <label>Status Simcard</label>
                  <select id="filter_status_simcard" class="form-control">
                     <option value=""></option>
                     <option value="1">Active</option>
                     <option value="0">Need Top-up Credits</option>
                     <option value="2">Change Number / Expired</option>
                  </select>
                  </div>
               <div class="form-group">
                  <label>Type Phone Number</label>
                  <select id="filter_type" class="form-control">
                     <option value=""></option>
                     <option value="1">Fisik</option>
                     <option value="2">Cloud</option>
                  </select>
               </div>
            </form>
         </div>
         <div class="modal-footer">
            <div class="col-md-12">
               <button type="button" class="btn btn-white btn-block btn-reset">Reset</button>
               <button type="button" class="btn btn-white btn-block btn-search"><i class="fa fa-search"></i> search</button>
            </div>
         </div>
      </div>
   </div>
</div>

<div class="modal" id="modal-create">
   <div class="modal-dialog" style="width: 50%;">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3 class="modal-title bold"><i class="fa fa-plus"></i> Create Data</h3>
         </div>
         <form id="form-add">
            <input type="hidden" name="phone_number">
            <div class="modal-body">
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
                  <div class="row">
                     <div class="col-md-6">
                        <label>Phone Number <span class="text-require">(*)</span></label>
                        <span class="text-center result-phone-number">
                           <div class="container-phone-loading" style="display: none;">
                              <i class="fa fa-spinner fa-spin"></i> Please Wait Searcing Phone Number...
                           </div>
                           <input type="text" class="form-control" name="phone_number_choosed" disabled="" readonly="" required="">
                        </span>
                     </div>
                     <div class="col-md-6">
                        <label>Email <span class="text-require">(*)</span></label>
                        <input type="email" class="form-control" name="email" required="">
                     </div>
                  </div>
               </div>
               <div class="form-group">
                  <div class="row">
                     <div class="col-md-6">
                        <label>Display Name <span class="text-require">(*)</span></label>
                        <input type="text" class="form-control" name="display_name" required="">
                     </div>
                     <div class="col-md-6">
                        <label>Password <span class="text-require">(*)</span></label>
                        <input type="text" class="form-control" name="password" required="">
                     </div>
                  </div>
               </div>
               <div class="form-group">
                  <div class="row">
                     <div class="col-md-6">
                        <label>Birth Date</label>
                        <input type="hidden" name="birth_day">
                        <div class="input-group">
                           <input type="text" class="form-control date-data" data-formrender="#form-add">
                           <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <label>Status</label>
                        <select name="status" class="form-control">
                          <option value="1">Active</option>
                          <option value="0">No Action</option>
                          <option value="2">Blocked</option>
                        </select>
                     </div>
                  </div>
               </div>
               <div class="form-group">
                  <label>Info</label>
                  <input type="text" class="form-control" name="info" placeholder="">
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-white btn-block"><i class="fa fa-save"></i> Submit</button> 
            </div>
         </form>
      </div>
   </div>
</div>

<div class="modal" id="modal-edit">
   <div class="modal-dialog" style="width: 50%;">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3 class="modal-title bold"><i class="fa fa-edit"></i> Edit Data</h3>
         </div>
         <form id="form-edit">
            <input type="hidden" name="phone_number">
            <input type="hidden" name="id">
            <input type="hidden" name="phone_number_before">
            <input type="hidden" name="email_before">
            <div class="modal-body">
               <!-- <div class="form-group">
                  <div class="row">
                     <div class="col-md-10">
                        <label>Phone Number <span class="text-require">(*)</span></label>
                        <div class="container-phone-loading" data-container="edit" style="display: none;">
                           <i class="fa fa-spinner fa-spin"></i> Please Wait Rendering Select...
                        </div>
                        <div class="container-phone" data-container="edit" style="display: none;">
                           <select name="phone_number" class="form-control choose phone_number" data-target="edit"></select>
                        </div>
                     </div>
                     <div class="col-md-2">
                        <input type="hidden" id="data_choosed" value="">
                        <button class="btn btn-white btn-refresh btn-block" type="button" data-type="edit" style="margin-left:-20px;margin-top:22px;"><i class="fa fa-refresh"></i> Refresh</button>
                     </div>
                  </div>
               </div> -->
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
                  <div class="row">
                     <div class="col-md-6">
                        <label>Phone Number <span class="text-require">(*)</span></label>
                        <span class="text-center result-phone-number">
                           <div class="container-phone-loading" style="display: none;">
                              <i class="fa fa-spinner fa-spin"></i> Please Wait Searcing Phone Number...
                           </div>
                           <input type="text" class="form-control" name="phone_number_choosed" disabled="" readonly="" required="">
                        </span>
                     </div>
                     <div class="col-md-6">
                        <label>Email <span class="text-require">(*)</span></label>
                        <input type="email" class="form-control" name="email" required="">
                     </div>
                  </div>
               </div>
               <div class="form-group">
                  <div class="row">
                     <div class="col-md-6">
                        <label>Display Name <span class="text-require">(*)</span></label>
                        <input type="text" class="form-control" name="display_name" required="">
                     </div>
                     <div class="col-md-6">
                        <label>Password <span class="text-require">(*)</span></label>
                        <input type="text" class="form-control" name="password" required="">
                     </div>
                  </div>
               </div>
               <div class="form-group">
                  <div class="row">
                     <div class="col-md-6">
                        <label>Birth Date</label>
                        <input type="hidden" name="birth_day">
                        <div class="input-group">
                           <input type="text" class="form-control date-data" data-formrender="#form-edit">
                           <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           <label>Status</label>
                           <select name="status" class="form-control">
                             <option value="1">Active</option>
                             <option value="0">No Action</option>
                             <option value="2">Blocked</option>
                           </select>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="form-group">
                  <label>Info</label>
                  <input type="text" class="form-control" name="info" placeholder="Jika Status Blocked">
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-white btn-block"><i class="fa fa-save"></i> Update</button> 
            </div>
         </form>
      </div>
   </div>
</div>

<div class="modal" id="modal-migrasi-all">
   <div class="modal-dialog" style="width: 35%;">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3 class="modal-title bold"><i class="fa fa-upload"></i> Migration</h3>
         </div>
         <form id="form-migration">
            <div class="modal-body">
               <h5 class="text-center">Download the file format below</h5>
               <p class="text-muted text-center bold" style="margin-top: -5px;"><a href="<?php echo site_url() ?>email/download_format" class="text-center"> Format Migration Email.xlsx</a></p>
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
               <p class="text-muted text-center bold" style="margin-top: -5px;"><a href="<?php echo site_url('email/bulkFormat') ?>" class="text-center"> PhoneNumberList.xlsx</a></p>
               <div class="form-group">
                  <label>Upload Format</label>
                  <input type="file" name="userfile" class="form-control">
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-block btn-white"><i class="fa fa-upload"></i> Upload</button>
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

      $.fn.render_data  = function(params){
         var str = $.extend({
            offset : $('#offset').val(),
            curpage : $('#curpage').val(),
            filter_keyword : $('#filter_keyword').val(),
            filter_type : $('#filter_type').val(),
            filter_rows : $('#filter_rows').val(),
            filter_status : $('#filter_status').val(),
            filter_status_simcard : $('#filter_status_simcard').val()
         },params);
         ajaxManager.addReq({
            type : "GET",
            url : site_url + 'email/get',
            dataType : "JSON",
            data : {
               offset : str.offset,
               curpage : str.curpage,
               filter_keyword : str.filter_keyword,
               filter_type : str.filter_type,
               filter_rows : str.filter_rows,
               filter_status : str.filter_status,
               filter_status_simcard : str.filter_status_simcard
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
                        // t += '<td><input type="checkbox" class="option_id" id="checkbox'+v.id+'" value="'+v.id+'"></td>';
                        t += '<td>';
                           t += '<b>'+v.pic+'</b></br>';
                           if(v.pic_updated){
                              t += '<a style="cursor:pointer" data-toggle="tooltip" data-placement="top" title="" data-original-title="By '+v.pic_updated+' at '+v.updated_date+'"><i class="fa fa-external-link"></i></a> at '+v.created_date+'';
                           }else{
                              t += 'at '+v.created_date+'';
                           }
                        t += '</td>';
                        t += '<td>';
                           t += '<b>'+v.email+'</b><br>';
                           if(v.phone_number){
                              if(v.status_phone_number == 1){
                                 t += ''+v.phone_number+'';
                              }else if(v.status_phone_number == 0){
                                 t += '<span class="label label-info" style="padding:2px;">Need Top Up : '+v.phone_number+'</span>';
                              }else if(v.status_phone_number == 2){
                                 t += '<span class="label label-danger" style="padding:2px;">Change Number : '+v.phone_number+'</span>';
                              }else if(v.status_phone_number == 3){
                                 t += '<span class="label label-danger" style="padding:2px;">Deactive : '+v.phone_number+'</span>';
                              }else{
                                 t += '<span class="label label-default" style="padding:2px;">No flag : '+v.phone_number+'</span>';
                              }
                           }else{
                              t += '<span class="text-danger bold"><i class="fa fa-exclamation"></i> No Phone Number</span>';
                           }
                        t += '</td>';
                        t += '<td>'+(v.display_name ? v.display_name : '')+'</td>';
                        t += '<td>'+(v.password ? v.password : '')+'</td>';
                        t += '<td>'+v.birth_day+'</td>';
                        t += '<td>'+(v.info ? v.info : '')+'</td>';                        
                        t += '<td>'+v.status+'</td>'; 
                        t += '<td>';
                           t += '<div class="btn-group">';
                              t += '<button class="btn btn-white btn-sm btn-edit" data-type="edit" data-toggle="tooltip" data-original-title="Edit" data-id="'+v.id+'"><i class="fa fa-edit"></i></button>';
                              t += '<button class="btn btn-danger btn-sm btn-delete" data-toggle="tooltip" data-original-title="Delete" data-id="'+v.id+'" data-phone="'+v.phone_number+'"><i class="fa fa-trash"></i></button>';
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

      $(this).on('submit', '#form-add', function(e){
         var form = $(this);
         $(this).ajaxSubmit({
            url  : site_url +'email/create',
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
            url  : site_url +'email/change',
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

      $(this).on('click', '.btn-new', function(e) {
         var type = $(this).data('type');
         // $(this).render_phone_number({
         //    target : type
         // });
         $(this).render_picker({
            modal : '#modal-create'
         });
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
            url : site_url + 'email/get_phone_number',
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
                     t += '<option value="'+v.phone_number+'">'+v.phone_number+' ('+v.provider_name+') '+(v.phone_number_type == 2 ? '(cloud number)' : '')+'</option>';
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
               url: site_url + 'email/bulk_action',
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

      $(this).on('click', '.btn-edit',function(e){
         var id = $(this).data('id');
         var form = $('#form-edit');
         var type = $(this).data('type');

         ajaxManager.addReq({
            type : "GET",
            url : site_url + 'email/edit',
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
               if(r.response.birth_day){
                  form.find('.date-data').val(moment(r.response.birth_day).format('DD/MMM/YYYY'));
                  form.find('input[name="birth_day"]').val(r.response.birth_day);
               }
               form.find('input[name="id"]').val(r.response.id);
               form.find('input[name="phone_number_before"]').val(r.response.phone_number);
               form.find('input[name="phone_number"]').val(r.response.phone_number);
               form.find('input[name="phone_number_choosed"]').val(r.response.phone_number+' (Exp. '+moment(r.response.expired_date).format('DD/MMM/YYYY')+')');
               form.find('input[name="email_before"]').val(r.response.email);

               form.find('#data_choosed').val(r.response.phone_number);
               form.find('input[name="email"]').val(r.response.email);
               form.find('input[name="display_name"]').val(r.response.display_name);
               form.find('input[name="password"]').val(r.response.password);
               form.find('select[name="status"]').val(r.response.status);
               form.find('input[name="info"]').val(r.response.info);

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
            var phone_number = $(this).data('phone');
            ajaxManager.addReq({
               type : "GET",
               url : site_url + 'email/delete',
               dataType : "JSON",
               data : {
                  id : id,
                  phone_number : phone_number,
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

      $(this).on('click', '.btn-search-phone-number', function(e){
         var render = $(this).data('render');
         var phone = $('.filter_search_phone_number[data-render="'+render+'"]').val();
         if(phone !== ''){
            ajaxManager.addReq({
               type : "GET",
               url : site_url + 'email/find_phone',
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
                     if(r.response.registered == 0){
                        $('#'+render+'').find('input[name="phone_number"]').val(r.response.phone_number);
                        $('#'+render+'').find('input[name="phone_number_choosed"]').val(r.response.phone_number+' (Exp. '+moment(r.response.expired_date).format('DD/MMM/YYYY')+')');
                     }else{
                        $('#'+render+'').find('input[name="phone_number_choosed"]').val('The number you are search for has been registered');
                     }
                  }else{
                     $('#'+render+'').find('input[name="phone_number"]').val('');
                     $('#'+render+'').find('input[name="phone_number_choosed"]').val('Phone number not found');
                  }
                  $('#'+render+'').find('.container-phone-loading').hide();
                  $('#'+render+'').find('input[name="phone_number_choosed"]').show();
               }
            });
         }
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
            $(formrender).find('input[name="birth_day"]').val(picker.startDate.format('YYYY-MM-DD'));
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

      $(this).on('click', '.btn-search',function(e){
         $('#modal-filter').modal('hide');
         $('#offset').val(0);
         $('#curpage').val(1);
         $('.select_id').removeAttr('checked'); 
         $(this).render_data();
         e.preventDefault();
      });

      $(this).on('click', '.btn-reset', function(e) {
         $('#modal-filter').modal('hide');
         $('#offset').val(0);
         $('#curpage').val(1);
         $('#form-filter').resetForm();
         $('.select_id').removeAttr('checked');
         $(this).render_data();
      });

      $(this).on('submit', '#form-filter', function(e){
         $('#modal-filter').modal('hide');
         $('#offset').val(0);
         $('#curpage').val(1);
         $('.select_id').removeAttr('checked'); 
         $(this).render_data();
         e.preventDefault();
      });

      $(this).on('change', '#filter_rows', function(e){
         $('.select_id').removeAttr('checked');
         $(this).render_data();
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

      $(this).on('submit', '#form-bulk-phone', function(e){
         var form = $(this);
         $(this).ajaxSubmit({
            url  : site_url +'email/bulk_phone',
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


      $(this).on('submit', '#form-migration', function(e){
         var form = $(this);
         $(this).ajaxSubmit({
            url  : site_url +'email/migration_all',
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
            url  : site_url +'email/bulk_phone',
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
                  form.find('select[name="assign_status"]').prop("disabled", true);
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