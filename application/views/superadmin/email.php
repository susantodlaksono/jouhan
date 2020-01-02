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
                  <input type="text" class="form-control" id="search_name" placeholder="Find for email, pic, phone number, password ..." value="">
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
                  <select id="phone" name="phone_number" class="choose form-control">
                    <option value=""></option>
                     <?php
                           $data = $this->db->get('simcard')->result_array();
                           foreach ($data as $value) {
                              echo '<option value="'.$value['phone_number'].'">'.$value['phone_number'].'</option>';
                           }
                     ?>
                  </select>
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
               <label>Status</label>
                <select id="email_stats" name="statuss" class="form-control">
                    <option value="0">No Action</option>
                    <option value="1">Active</option>
                    <option value="2">Blocked</option>
                </select>
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
                <div class="form-group">
                  <label>Phone Number</label>
                  <select id="phone_select" name="phone_number" class="choose form-control" >
                     <?php
                           $data = $this->db->get('simcard')->result_array();
                           foreach ($data as $value) {
                              echo '<option value="'.$value['phone_number'].'">'.$value['phone_number'].'</option>';
                           }
                     ?>
                  </select>
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
                  <select id="status" name="statuss" class="form-control">
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
                  <button class="btn btn-white btn-sm" data-toggle="modal" data-target="#modal-filter"><i class="fa fa-filter"></i> Filter</button>
                  <button class="btn btn-white btn-sm" data-toggle="modal" data-target="#modal-create"><i class="fa fa-plus"></i> New</button>
               </div>
            </div>
         </div>

         <div class="panel-body">
            <input type="hidden" id="offset" value="0">
            <input type="hidden" id="curpage" value="1">
            <table class="table">
               <thead>
                  <tr>
                     <th>Phone Number</th>
                     <th>Email</th>
                     <th>Password</th>
                     <th>Birth Day</th>
                     <th>info</th>
                     <th>Status</th>
                     <th>PIC</th>
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
      $('.choose').select2();

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

      $(this).on('submit', '#form-create', function(e) {
            var form = $(this);

            $(this).ajaxSubmit({
                   type : "POST",
                   url  : "<?php echo base_url('index.php/email/input_email')?>",
                   dataType : "JSON",
                   data : {
                     'csrf_token_nalda' : $('#csrf').val()
                     },
                  error: function (jqXHR, status, errorThrown) {
                     error_handle(jqXHR, status, errorThrown);
                     form.find('[type="submit"]').removeClass('disabled');
                     form.find('[type="submit"]').html('<i class="fa fa-save"></i> Submit');
                  },
                  beforeSend: function (xhr) {
                     if(sessions){
                        form.find('[type="submit"]').addClass('disabled');
                        form.find('[type="submit"]').html('<i class="fa fa-refresh fa-spin"></i> Please Wait...');  
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

                     form.find('[type="submit"]').removeClass('disabled');
                     form.find('[type="submit"]').html('<i class="fa fa-save"></i> Submit');
                  },
            });
            e.preventDefault();
      });  

      $(this).on('click','.btn-edit',function(e){
         var id = $(this).data('id');
         var form_edit = $('#form-modify');

         ajaxManager.addReq({
             type : "GET",
             url  : "<?php echo base_url('index.php/email/ambil_edit')?>",
             dataType : "JSON",
             data : {
               id:id
            },
            beforeSend: function (xhr) {
               if(sessions){
                  $('.btn-edit[data-id="'+id+'"]').addClass('disabled');
                  $('.btn-edit[data-id="'+id+'"]').html(loading);
               }else{
                  xhr.done();
                  window.location.href = location; 
               }
            },
            error: function (jqXHR, status, errorThrown) {
               error_handle(jqXHR, status, errorThrown);
            },
            success: function(r){
               $('.btn-edit[data-id="'+id+'"]').removeClass('disabled');
               $('.btn-edit[data-id="'+id+'"]').html('<i class="fa fa-edit"></i>');

               form_edit.find('input[name="id_email"]').val(r.detail_email.id);
               form_edit.find('input[name="email"]').val(r.detail_email.email);
               form_edit.find('input[name="pass"]').val(r.detail_email.password);
               form_edit.find('input[name="birth_day"]').val(r.detail_email.birth_day);
               form_edit.find('input[name="password"]').val(r.detail_email.password);
               $('#status').val(r.detail_email.status);
               $('#phone_select').select2('val', r.detail_email.phone_number);
               $("#modal-modify").modal("toggle");
            }
         });
         e.preventDefault();
      });

      $(this).on('submit', '#form-modify', function(e) {
          var form = $(this);

          $(this).ajaxSubmit({
               type : "POST",
               url  : "<?php echo base_url('index.php/email/edit')?>",
               dataType : "JSON",
               data : {
                    'csrf_token_nalda' : $('#csrf').val()
               },
               error: function (jqXHR, status, errorThrown) {
                 error_handle(jqXHR, status, errorThrown);
                 form.find('[type="submit"]').removeClass('disabled');
                 form.find('[type="submit"]').html('<i class="fa fa-save"></i> Submit');
               },
               beforeSend: function (xhr) {
                 if(sessions){
                    form.find('[type="submit"]').addClass('disabled');
                    form.find('[type="submit"]').html('<i class="fa fa-refresh fa-spin"></i> Please Wait...');
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

                 form.find('[type="submit"]').removeClass('disabled');
                 form.find('[type="submit"]').html('<i class="fa fa-save"></i> Submit');
               },
         
          });

         e.preventDefault();
      });
      
      $(this).on('click','.item_hapus',function(e){
         var id = $(this).data('id');

         ajaxManager.addReq({
            type : "GET",
                url  : "<?php echo base_url('index.php/email/hapus')?>",
                dataType : "JSON",
                data : {
                  no:id
                },
                beforeSend: function (xhr) {
                  if(sessions){
                     $('.item_hapus[data-id="'+id+'"]').addClass('disabled');
                     $('.item_hapus[data-id="'+id+'"]').html(loading);
                  }else{
                     xhr.done();
                     window.location.href = location; 
                  }
                },
                error: function (jqXHR, status, errorThrown) {
                  error_handle(jqXHR, status, errorThrown);
                },
                success : function(r){
                  $('.item_hapus[data-id="'+id+'"]').removeClass('disabled');
                  $('.item_hapus[data-id="'+id+'"]').html('<i class="fa fa-trash"></i>');
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
            url : site_url + 'email/get_email',
            dataType : "JSON",
            data : {
               offset:str.offset,
               curpage:str.curpage,
               search_name:str.search_name,
               search_status:str.filter_status
            },
            beforeSend: function (xhr) {
               if(sessions){
                  set_loading_table('.show_data', 8);
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
                        t+='<td>'+( value.phone_number ? value.phone_number: '' )+'</td>';
                        t+='<td>'+value.email+'</td>';
                        t+='<td>'+value.password+'</td>';
                        t+='<td>'+value.birth_day+'</td>';
                        t+='<td>'+value.info+'</td>';
                        t+='<td>'+value.status+'</td>';
                        t+='<td><b>'+value.user+'</b><br>at '+value.created_date+'</td>';
                        t+= '<td>';
                           t+='<div class="btn-group">';
                              t+='<button class="btn btn-white btn-sm btn-edit" data-toggle="tooltip" data-original-title="Edit" data-id="'+value.id+'"><i class="fa fa-edit"></i></button>';
                              t+= '<button class="btn btn-white btn-sm item_hapus" data-toggle="tooltip" data-original-title="Delete" data-id="'+value.id+'"><i class="fa fa-remove"></i></button>';
                           t+='</div>';
                        t+='</td>';
                     t+= '</tr>';
                  });
               }else{
                  t += set_no_result(2);
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