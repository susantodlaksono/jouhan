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
                  <input type="text" class="form-control" id="filter_keyword" value="">
               </div>
               <div class="form-group">
                  <label>Status</label>
                  <select id="filter_status" class="form-control">
                     <option value="">----</option>
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
   <div class="modal-dialog" style="width: 90%;">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3 class="modal-title bold"><i class="fa fa-plus"></i> Create New</h3>
         </div>
         <form id="form-create">
            <div class="modal-body">
               <div class="row">
                  <div class="col-md-4">
                     <div class="form-group">
                        <div class="row">
                           <div class="col-md-11">
                              <label>Phone Number <span class="text-require">(*)</span></label>
                              <div class="container-phone-loading" data-container="create" style="display: none;">
                                 <i class="fa fa-spinner fa-spin"></i> Please Wait Rendering Select...
                              </div>
                              <div class="container-phone" data-container="create" style="display: none;">
                                 <select name="phone_number" class="form-control choose phone_number" data-target="create"></select>
                              </div>
                           </div>
                           <div class="col-md-1">
                              <button class="btn btn-white btn-refresh" type="button" data-type="create" style="margin-left:-25px;margin-top:22px;"><i class="fa fa-refresh"></i></button>
                           </div>
                        </div>
                     </div>
                     <div class="form-group">
                        <label>Screen Name <span class="text-require">(*)</span></label>
                        <input type="text" class="form-control" name="screen_name">
                     </div>
                     <div class="form-group">
                        <label>Password <span class="text-require">(*)</span></label>
                        <input type="text" class="form-control" name="password">
                     </div>
                     <div class="form-group">
                        <label>Display Name</label>
                        <input type="text" class="form-control" name="display_name">
                     </div>
                     
                     <div class="form-group">
                        <label>Twitter ID</label>
                        <input type="number" class="form-control" name="twitter_id">
                     </div>
                     <div class="form-group">
                        <label>Followers</label>
                        <input type="number" class="form-control" name="followers">
                     </div>
                     <div class="form-group">
                        <label>Apps Id</label>
                        <input type="text" class="form-control" name="apps_id">
                     </div>
                     <div class="form-group">
                        <label>Apps Name</label>
                        <input type="text" class="form-control" name="apps_name">
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label>Cookies</label>
                        <input type="text" class="form-control" name="cookies">
                     </div>
                     <div class="form-group">
                        <label>Consumer Key</label>
                        <input type="text" class="form-control" name="consumer_key">
                     </div>
                      <div class="form-group">
                        <label>Consumer Secret</label>
                        <input type="text" class="form-control" name="consumer_secret">
                     </div>
                     <div class="form-group">
                        <label>Access Token</label>
                        <input type="text" class="form-control" name="access_token">
                     </div>
                     <div class="form-group">
                        <label>Access Token Secret</label>
                        <input type="text" class="form-control" name="access_token_secret">
                     </div>
                     <div class="form-group">
                        <label>IP Proxy</label>
                        <input type="text" class="form-control" name="ip_proxy">
                     </div>
                     <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                          <option value="0">No Action</option>
                          <option value="1">Active</option>
                          <option value="2">Blocked</option>
                        </select>
                     </div>
                  </div>
               </div>
               <!-- <div class="row" style="">
                  <div class="col-md-6">
                  </div>
               </div> -->
               <div class="form-group">
                  <div class="row">
                     <div class="col-md-11">
                        <label>Phone Number</label>
                        <div class="container-phone-loading" data-container="create" style="display: none;">
                           <i class="fa fa-spinner fa-spin"></i> Please Wait Rendering Select...
                        </div>
                        <div class="container-phone" data-container="create" style="display: none;">
                           <select name="phone_number" class="form-control choose phone_number" data-target="create"></select>
                        </div>
                     </div>
                     <div class="col-md-1">
                        <button class="btn btn-white btn-refresh" type="button" data-type="create" style="margin-left:-15px;margin-top:22px;"><i class="fa fa-refresh"></i></button>
                     </div>
                  </div>
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
            <h4 class="modal-title"><i class="fa fa-edit"></i> Edit Twitter</h4>
         </div>
         <form id="form-modify">
            <input type="hidden" name="id" value="">
            <input type="hidden" name="phone_number_before" value="">
            <input type="hidden" name="screen_name_before" value="">
            <div class="modal-body">
               <div class="form-group">
                  <div class="row">
                     <div class="col-md-11">
                        <label>Phone Number</label>
                        <div class="container-phone-loading" data-container="edit" style="display: none;">
                           <i class="fa fa-spinner fa-spin"></i> Please Wait Rendering Select...
                        </div>
                        <div class="container-phone" data-container="edit" style="display: none;">
                           <select name="phone_number" class="form-control choose phone_number" data-target="edit"></select>
                        </div>
                     </div>
                     <div class="col-md-1">
                        <input type="hidden" id="data_choosed" value="">
                        <button class="btn btn-white btn-refresh" type="button" data-type="edit" style="margin-left:-15px;margin-top:22px;"><i class="fa fa-refresh"></i></button>
                     </div>
                  </div>
               </div>
               <div class="form-group">
                  <label>Display Name</label>
                  <input type="text" class="form-control" name="display_name">
               </div>
               <div class="form-group">
                  <label>Screen Name</label>
                  <input type="text" class="form-control" name="screen_name">
               </div>
               <div class="form-group">
                  <label>Twitter ID</label>
                  <input type="number" class="form-control" name="twitter_id">
               </div>
               <div class="form-group">
                  <label>Password</label>
                  <input type="text" class="form-control" name="password">
               </div>
               <div class="form-group">
                  <label>Followers</label>
                  <input type="number" class="form-control" name="followers">
               </div>
               <div class="form-group">
                  <label>Cookies</label>
                  <input type="text" class="form-control" name="cookies">
               </div>
               <div class="form-group">
                  <label>Consumer Key</label>
                  <input type="text" class="form-control" name="consumer_key">
               </div>
               <div class="form-group">
                  <label>Access Token</label>
                  <input type="text" class="form-control" name="access_token">
               </div>
               <div class="form-group">
                  <label>Access Token Secret</label>
                  <input type="text" class="form-control" name="access_token_secret">
               </div>
               <div class="form-group">
                  <label>IP Proxy</label>
                  <input type="text" class="form-control" name="ip_proxy">
               </div>
               <div class="form-group">
                  <label>Apps Id</label>
                  <input type="text" class="form-control" name="apps_id">
               </div>
               <div class="form-group">
                  <label>Apps Name</label>
                  <input type="text" class="form-control" name="apps_name">
               </div>
               <div class="form-group">
                  <label>Consumer Secret</label>
                  <input type="text" class="form-control" name="consumer_secret">
               </div>
               <div class="form-group">
                  <label>Status</label>
                  <select name="status" class="form-control">
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
            <div class="panel-title"><i class="fa fa-list"></i> List Twitter</div>
            <div class="panel-options" style="width: auto;border:0px solid black;">
               <div class="form-group" style="margin-top: 8px;margin-bottom: 5px;">  
                  <button class="btn btn-white btn-sm" data-toggle="modal" data-target="#modal-filter"><i class="fa fa-filter"></i> Filter</button>
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
                     <th>Screen Name</th>
                     <th>Display Name</th>
                     <th>Twitter ID</th>
                     <th>Email</th>
                     <th>Followers</th>
                     <th>PIC</th>
                     <th></th>
                  </tr>
               </thead>
               <tbody class="show_data"></tbody>
            </table>
            <div class="row">
               <div class="col-md-3">
                  <h4 id="sect-total" class="text-left show_total"></h4>
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
      $('.choose').select2();

      $(this).on('click','.btn-search',function(e){
          $('#modal-filter').modal('hide');
          $(this).render_data();
      });

      $(this).on('click', '.btn-new', function(e) {
         var type = $(this).data('type');
         $(this).render_phone_number({
            target : type
         });
         e.preventDefault();
      });

      $(this).on('click', '.btn-refresh', function(e) {
         var type = $(this).data('type');
         var with_choosed = $('#data_choosed').val();

         $(this).render_phone_number({
            target : type,
            with_choosed : with_choosed,
            render_container : type
         });
         e.preventDefault();
      });

      $.fn.render_phone_number = function(params){
         var str = $.extend({
            target : '',
            with_choosed : null,
            render_container : 'create'
         },params);
         ajaxManager.addReq({
            type : "GET",
            url : site_url + '/twitter/get_phone_number',
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
                     t += '<option value="'+v.phone_number+'">'+v.phone_number+' - '+v.email+'</option>';
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

      $(this).on('click', '.btn-reset', function(e) {
         $('#modal-filter').modal('hide');
         $('#form-filter').resetForm();
         $(this).render_data();
      });

      $(this).on('click', '.btn-edit',function(e){
         var id = $(this).data('id');
         var form_edit = $('#form-modify');
         var type = $(this).data('type');
         var render_container = $(this).data('container');

         ajaxManager.addReq({
            type : "GET",
            url : site_url + '/twitter/ambil_edit',
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
               $('#data_choosed').val(r.response.phone_number);
               $(this).render_phone_number({
                  target : type,
                  with_choosed : r.response.phone_number,
                  render_container : type
               });;
               form_edit.find('input[name="id"]').val(r.response.id);
               form_edit.find('input[name="phone_number_before"]').val(r.response.phone_number);
               form_edit.find('input[name="display_name"]').val(r.response.display_name);
               form_edit.find('input[name="screen_name"]').val(r.response.screen_name);
               form_edit.find('input[name="screen_name_before"]').val(r.response.screen_name);
               form_edit.find('input[name="twitter_id"]').val(r.response.twitter_id);
               form_edit.find('input[name="password"]').val(r.response.password);
               form_edit.find('input[name="followers"]').val(r.response.followers);
               form_edit.find('input[name="cookies"]').val(r.response.cookies);
               form_edit.find('input[name="consumer_key"]').val(r.response.consumer_key);
               form_edit.find('input[name="access_token"]').val(r.response.access_token);
               form_edit.find('input[name="access_token_secret"]').val(r.response.access_token_secret);
               form_edit.find('input[name="ip_proxy"]').val(r.response.ip_proxy);
               form_edit.find('input[name="apps_id"]').val(r.response.apps_id);
               form_edit.find('input[name="apps_name"]').val(r.response.apps_name);
               form_edit.find('input[name="consumer_secret"]').val(r.response.consumer_secret);
               form_edit.find('select[name="status"]').val(r.response.status);
               // form_edit.find('input[name="email_before"]').val(r.detail_email.email);
               
               // form_edit.find('input[name="email"]').val(r.detail_email.email);
               // form_edit.find('input[name="pass"]').val(r.detail_email.password);
               // form_edit.find('input[name="birth_day"]').val(r.detail_email.birth_day);
               // form_edit.find('input[name="password"]').val(r.detail_email.password);
               // form_edit.find('select[name="status"]').val(r.detail_email.status);

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
            url : site_url + '/twitter/edit',
            dataType : "JSON",
            // data : {
            //    'csrf_token_nalda' : $('#csrf').val()
            // },
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
            },
         
         });
         e.preventDefault();
      });

      $(this).on('submit', '#form-create', function(e) {
         var form = $(this);
         $(this).ajaxSubmit({
            type : "POST",
            url : site_url + '/twitter/input_twitter',
            dataType : "JSON",
            // data : {
            //    'csrf_token_nalda' : $('#csrf').val()
            // },
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

      $(this).on('click', '.item_hapus', function(e){

            var r=confirm("are you sure to delete ?")
               
            if (r==true)
           {
             alert("pressed OK!")
             // call the controller
           }
           else
           {
            alert("pressed Cancel!");
            return false;
           }

         var id = $(this).data('id');
         var phone_number = $(this).data('phone');

         ajaxManager.addReq({
            type : "GET",
            url : site_url + '/twitter/hapus',
            dataType : "JSON",
            data : {
               id:id,
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
            filter_keyword : $('#filter_keyword').val(),
            filter_status : $('#filter_status').val()
         },params);

         ajaxManager.addReq({
            type : "GET",
            url : site_url + '/twitter/get_twitter',
            dataType : "JSON",
            data : {
               offset: str.offset,
               curpage: str.curpage,
               filter_keyword: str.filter_keyword,
               filter_status: str.filter_status
            },
            beforeSend: function (xhr) {
               if(sessions){
                  set_loading_table('.show_data', 9);
               }else{
                  xhr.done();
                  window.location.href = location;
               }
            },
            error: function (jqXHR, status, errorThrown) {
               error_handle(jqXHR, status, errorThrown);
            },
            success : function(data){
               if(data.total>0){
                  var t = '';
                  var usert = "";
                  var mail = "";
                     $.each(data.data, function(key, value){
                        t+='<tr>';
                        t+='<td>'+value.status+'</td>';
                        t += '<td>';
                           t += '<b>'+value.screen_name+'</b><br>';
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

                        // t+='<td><b>@'+value.screen_name+'</b><br>'+( value.phone_number ? value.phone_number: '' )+'</td>';
                        t+='<td>'+value.display_name+'</td>';
                        t+='<td>'+value.twitter_id+'</td>';
                        t += '<td>';
                        if(value.email){
                           if(value.status_email == 1){
                              t += ''+value.email+'';
                           }else if(value.status_email == 0){
                              t += '<span class="label label-default" style="padding:2px;">No Action<br>'+value.email+'</span>';
                           }else{
                              t += '<span class="label label-danger" style="padding:2px;">Blocked<br>'+value.email+'</span>';
                           }
                        }else{
                           t += '<h5 style="color:red;">Not Found</h5>';
                        }
                        t += '</td>';
                        // t+='<td>'+(value.email ? value.email : '<h5 style="color:red;">Not Found</h5>')+'</td>';
                        t+='<td>'+( value.followers ? value.followers: '' )+'</td>';
                        t+='<td><b>'+value.pic+'</b><br>at '+value.created_date+'</td>';
                        t += '<td>';
                        t += '<div class="btn-group">';
                           t += '<button class="btn btn-blue btn-sm btn-edit" data-container="edit" data-toggle="tooltip" data-original-title="Edit" data-id="'+value.id+'" data-type="edit"><i class="fa fa-edit"></i></button>';
                           t += '<button class="btn btn-danger btn-sm item_hapus" data-toggle="tooltip" data-original-title="Delete" data-id="'+value.id+'" data-phone="'+( value.phone_number ? value.phone_number: null )+'"><i class="fa fa-trash"></i></button>';
                        t += '</div>';
                     t += '</td>';
                        t+= '</tr>';
                     });
                  }else{
                     t += set_no_result(9);
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