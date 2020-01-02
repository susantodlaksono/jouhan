<style type="text/css">
   #select2-drop{
      z-index: 9999999999;
   }
   .page-body .select2-container .select2-choice{
       height:30px;
       line-height:30px;
   }
</style>

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
                  <input type="text" class="form-control" id="search_name" placeholder="" value="">
               </div>
               <div class="form-group">
                  <label>Status</label>
                  <select id="filter_status" class="form-control">
                     <option value="">--Choose--</option>
                     <option value="0">No Action</option>
                     <option value="1">Active</option>
                     <option value="2">Blocked</option>
                  </select>
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
   <div class="modal-dialog" style="width: 50%;">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"><i class="fa fa-plus"></i> Create New</h4>
         </div>
         <form id="form-create">
            <input type="hidden" class="form-control" name="user_id" value="<?php echo $user_id; ?>">
            <input type="hidden" class="form-control" name="created_date" value="<?php echo date('Y-m-d H:i:s');?>">
            <div class="modal-body">
               <div class="form-group">
                  <label>Phone Number</label>
                  <select name="phone_number" class="choose form-control phone_number" data-target="create"></select>
               </div>
               <div class="form-group">
                  <label>Email</label>
                  <input type="email" class="form-control" name="emails">
               </div>
               <div class="form-group">
                  <label>Password</label>
                  <input type="text" class="form-control" name="pass">
               </div>
               <div class="form-group">
                  <label>Birth Day</label>
                  <input type="date" class="form-control" name="birth_day">
               </div>
               <div class="form-group">
                  <label>Status</label>
                  <select id="email_stats" name="status" class="form-control">
                    <option value="0">No Action</option>
                    <option value="1">Active</option>
                    <option value="2">Blocked</option>
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

<div class="modal fade" id="modal-modify">
   <div class="modal-dialog" style="width: 50%;">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"><i class="fa fa-edit"></i> Edit Email</h4>
         </div>
         <form id="form-modify">
            <div class="modal-body">
                <input type="hidden" class="form-control" name="id_email">
                <input type="hidden" class="form-control" name="phone_number_before">
                <input type="hidden" class="form-control" name="email_before">
                <div class="form-group">
                  <label>Phone Number</label>
                  <select name="phone_number" class="choose form-control phone_number" data-target="edit"></select>
               </div>
               <div class="form-group">
                  <label>Email</label>
                  <input type="email" class="form-control" name="email">
               </div>
               <div class="form-group">
                  <label>Password</label>
                  <input type="text" class="form-control" name="password">
               </div>
               <div class="form-group">
                  <label>Birthday</label>
                  <input type="date" class="form-control" name="birth_day">
               </div>
               <div class="form-group">
                  <label>Status</label>
                  <select id="status" name="status" class="form-control">
                     <option value="0">No Action</option>
                     <option value="1">Active</option>
                     <option value="2">Blocked</option>
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

<div class="row">
   <div class="col-md-12">
      <div class="panel panel-primary" data-collapsed="0">
         <div class="panel-heading">
            <div class="panel-title"><i class="fa fa-list"></i> List Email</div>
            <div class="panel-options" style="width: auto;border:0px solid black;">
               <div class="form-group" style="margin-top: 8px;margin-bottom: 5px;">  
                  <button class="btn btn-white btn-sm" data-toggle="modal"  data-target="#modal-filter"><i class="fa fa-filter"></i> Filter</button>
                  <button class="btn btn-primary btn-sm btn-new" data-type="create" data-toggle="modal" data-target="#modal-create"><i class="fa fa-plus"></i> New</button>
               </div>
            </div>
         </div>

         <div class="panel-body">
            <input type="hidden" id="offset" value="0">
            <input type="hidden" id="curpage" value="1">
            <table class="table">
               <thead>
                  <tr>
                     <th>Status</th>
                     <th>Email</th>
                     <th>Password</th>
                     <th>Birth Day</th>
                     <th>info</th>
                     <th>PIC</th>
                     <th></th>
                  </tr>
               </thead>
               <tbody class="show_data"></tbody>
            </table>
            <div class="row">
               <div class="col-md-3">
                  <h4 class="text-left show_total"></h4>
               </div>
               <div class="col-md-9">
                  <ul id="sect-pagination" class="pagination pagination-sm no-margin pull-right"></ul>
               </div>
            </div>
         </div>
      </div>
   </div>
</div> 

<script type="text/javascript">
   var sessions = '#<?php echo $this->ion_auth->logged_in() ?>';
   var loading = '<i class="fa fa-spinner fa-spin"></i>';
   var overlay = '<h3 class="text-center text-danger overlay"><i class="fa fa-spinner fa-spin"></i></h3>';

   $(function(){ 
      
      $(this).on('click','.btn-search',function(e){
         $('#modal-filter').modal('hide');
         $('#offset').val(0);
         $('#curpage').val(1);
         $(this).render_data();
         e.preventDefault();
      });

      $(this).on('click', '.btn-reset', function(e) {
         $('#modal-filter').modal('hide');
         $('#form-filter').resetForm();
         $(this).render_data();
      });

      $(this).on('click', '.btn-new', function(e) {
         var type = $(this).data('type');
         $(this).render_phone_number({
            target : type
         });
         e.preventDefault();
      });

      $.fn.render_phone_number  = function(params){
         var str = $.extend({
            target : '',
            with_choosed : null
         },params);
         ajaxManager.addReq({
            type : "GET",
            url : site_url + '/email/get_phone_number',
            dataType : "JSON",
            data : {
               with_choosed : str.with_choosed
            },
            beforeSend: function (xhr) {
               if(sessions){
                  
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
                     t += '<option value="'+v.phone_number+'">'+v.phone_number+' ('+v.provider_name+')</option>';
                  });
                  $('.phone_number[data-target="'+str.target+'"]').html(t);
               }else{
                  alert('Phone Number Not Found');
               }
               $('.phone_number[data-target="'+str.target+'"]').select2();
               if(str.with_choosed !== ''){
                  $('.phone_number[data-target="'+str.target+'"]').select2('val', str.with_choosed);
               }
            }
         });
         
      }

      $(this).on('submit', '#form-create', function(e) {
         var form = $(this);
         $(this).ajaxSubmit({
            type : "POST",
            url : site_url + '/email/input_email',
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
                  $("#phone").select2("val", "");
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

      $(this).on('click','.btn-edit',function(e){
         var id = $(this).data('id');
         var form_edit = $('#form-modify');
         var type = $(this).data('type');

         ajaxManager.addReq({
            type : "GET",
            url : site_url + '/email/ambil_edit',
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
               $(this).render_phone_number({
                  target : type,
                  with_choosed : r.detail_email.phone_number
               });
               form_edit.find('select[name="phone_number"]').val(r.detail_email.phone_number);
               form_edit.find('input[name="id_email"]').val(r.detail_email.id);
               form_edit.find('input[name="phone_number_before"]').val(r.detail_email.phone_number);
               form_edit.find('input[name="email_before"]').val(r.detail_email.email);
               
               form_edit.find('input[name="email"]').val(r.detail_email.email);
               form_edit.find('input[name="pass"]').val(r.detail_email.password);
               form_edit.find('input[name="birth_day"]').val(r.detail_email.birth_day);
               form_edit.find('input[name="password"]').val(r.detail_email.password);
               form_edit.find('select[name="status"]').val(r.detail_email.status);

               $("#modal-modify").modal("toggle");
               loading_button('.btn-edit', id, 'hide', 'edit');
            }
         });
         e.preventDefault();
      });

      $(this).on('submit', '#form-modify', function(e) {
         var form = $(this);
         $(this).ajaxSubmit({
            type : "POST",
            url : site_url + '/email/edit',
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
                  $('#modal-modify').modal('hide');
                  toastr.success(r.msg);
               }else{
                  toastr.error(r.msg);
               }
               loading_form(form, 'hide');
            }         
         });
         e.preventDefault();
      });
      
      $(this).on('click', '.item_hapus', function(e){
         var id = $(this).data('id');
         var phone_number = $(this).data('phone');

         ajaxManager.addReq({
            type : "GET",
            url : site_url + '/email/hapus',
            dataType : "JSON",
            data : {
               no:id,
               phone_number : phone_number,
            },
            beforeSend: function (xhr) {
               if(sessions){
                  loading_button('.item_hapus', id, 'show', 'delete');
               }else{
                  xhr.done();
                  window.location.href = location; 
               }
            },
            error: function (jqXHR, status, errorThrown) {
               error_handle(jqXHR, status, errorThrown);
               loading_button('.item_hapus', id, 'hide', 'delete');
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
               loading_button('.item_hapus', id, 'hide', 'delete');
            }
         });
         e.preventDefault();
      });

      $.fn.render_data  = function(params){
         var str = $.extend({
            offset : $('#offset').val(),
            curpage : $('#curpage').val(),
            search_name : $('#search_name').val(),
            filter_status : $('#filter_status').val()
         },params);
         ajaxManager.addReq({
            type : "GET",
            url : site_url + '/email/get_email',
            dataType : "JSON",
            data : {
               offset:str.offset,
               curpage:str.curpage,
               search_name:str.search_name,
               search_status:str.filter_status
            },
            beforeSend: function (xhr) {
               if(sessions){
                  set_loading_table('.show_data', 7);
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
                  $.each(data.data, function(key,value){
                     t+='<tr>';
                        t += '<td>'+value.status+'</td>';
                        t += '<td>';
                           t += '<b>'+value.email+'</b><br>';
                           if(value.phone_number){
                              if(value.status_phone == 1){
                                 t += ''+value.phone_number+'';
                              }else if(value.status_phone == 0){
                                 t += '<span class="label label-default" style="padding:2px;">No Action : '+value.phone_number+'</span>';
                              }else{
                                 t += '<span class="label label-danger" style="padding:2px;">Expired : '+value.phone_number+'</span>';
                              }
                           }else{
                              t += '<i class="fa fa-exclamation"></i> No Phone Number';
                           }
                        t += '</td>';
                        t += '<td>'+value.password+'</td>';
                        t += '<td>'+value.birth_day+'</td>';
                        t += '<td>'+value.info+'</td>';
                        t += '<td><b>'+value.user+'</b><br>at '+value.created_date+'</td>';
                        t += '<td>';
                           t += '<div class="btn-group">';
                              t += '<button class="btn btn-blue btn-sm btn-edit" data-type="edit" data-toggle="tooltip" data-original-title="Edit" data-id="'+value.id+'"><i class="fa fa-edit"></i></button>';
                              t += '<button class="btn btn-danger btn-sm item_hapus" data-toggle="tooltip" data-original-title="Delete" data-id="'+value.id+'" data-phone="'+value.phone_number+'"><i class="fa fa-trash"></i></button>';
                           t += '</div>';
                        t += '</td>';
                     t += '</tr>';
                  });
               }else{
                  t += set_no_result(7);
               }

               $('.show_data').html(t);
               $('.show_total').html("Total : "+data.total);
               $('#sect-pagination').paging({
                  items : data.total,
                  currentPage : str.currentPage 
               });
               $('#offset').val(str.offset);
               $('#curpage').val(str.currentPage);
            }
         });
      };

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
      
      $(this).render_data();
   });

</script>