<style type="text/css">
   #select2-drop{
      z-index: 9999999999;
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
                  <input type="text" class="form-control" id="filter_name" placeholder="Find for name, username, password, email, pic, phone number" value="">
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
            <button type="button" class="btn btn-danger btn-search"><i class="fa fa-search"></i> Search</button>
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
                  <select id="phone_select_edit" name="phone_number" class="form-control choose">
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
                  <label>Name</label>
                  <input type="text" class="form-control" name="name">
               </div>
               <div class="form-group">
                  <label>Username</label>
                  <input type="text" class="form-control" name="username">
               </div>
               <div class="form-group">
                  <label>Email</label>
                  <select id="email_select_edit" name="emails" class="form-control choose">
                     <option value=""></option>
                     <?php
                           $data = $this->db->get('email')->result_array();
                           foreach ($data as $value) {
                              echo '<option value="'.$value['id'].'">'.$value['email'].'</option>';
                           }
                     ?>
                  </select>
               </div>
               <div class="form-group">
                  <label>Password</label>
                  <input type="text" class="form-control" name="password">
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
               <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-save"></i> Submit</button> 
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
               <input type="hidden" class="form-control" name="id_facebook">
               <input type="hidden" class="form-control" name="email_before">
               <div class="form-group">
                  <label>Phone Number</label>
                  <select id="phone_select" name="phone_number" class="form-control choose">
                     <?php
                           $data = $this->db->get('simcard')->result_array();
                           foreach ($data as $value) {
                              echo '<option value="'.$value['phone_number'].'">'.$value['phone_number'].'</option>';
                           }
                     ?>
                  </select>
               </div>
               <div class="form-group">
                  <label>Name</label>
                  <input type="text" class="form-control" name="name">
               </div>
               <div class="form-group">
                  <label>Username</label>
                  <input type="text" class="form-control" name="username">
               </div>
               <div class="form-group">
                  <label>Password</label>
                  <input type="text" class="form-control" name="password">
               </div>
               <div class="form-group">
                  <label>Email</label>
                  <select id="email_select" name="emails" class="form-control choose">
                     <?php
                           $data = $this->db->get('email')->result_array();
                           foreach ($data as $value) {
                              echo '<option value="'.$value['id'].'">'.$value['email'].'</option>';
                           }
                     ?>
                  </select>
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
               <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-save"></i> Submit</button> 
            </div>
         </form>
      </div>
   </div>
</div>

<div class="row">
   <div class="col-md-12">
      <div class="panel panel-primary" data-collapsed="0">
         <div class="panel-heading">
            <div class="panel-title"><i class="fa fa-list"></i> List Facebook</div>
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
                     <th>Name</th>
                     <th>Username</th>
                     <th>Password</th>
                     <th>Email</th>
                     <th>Friends</th>
                     <th>Created Date</th>
                     <th>Status</th>
                     <th>PIC</th>
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
          $('#offset').val(0);
          $('#curpage').val(1);
          e.preventDefault();
          $(this).render_data();
      });

      $(this).on('click', '.btn-reset', function(e) {
         $('#modal-filter').modal('hide');
         $('#form-filter').resetForm();
         $(this).render_data();
      });

      $(this).on('click','.item_hapus',function(e){
         var id = $(this).data('id');

         ajaxManager.addReq({
                type : "GET",
                url  : "<?php echo base_url('index.php/facebook/hapus')?>",
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

      $(this).on('click','.btn-edit',function(e){
            var id = $(this).data('id');
            var form_edit = $('#form-modify');

            ajaxManager.addReq({
                   type : "GET",
                   url  : "<?php echo base_url('index.php/facebook/ambil_edit')?>",
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
                     form_edit.find('input[name="id_facebook"]').val(r.detail_facebook.id);
                     form_edit.find('input[name="name"]').val(r.detail_facebook.name);
                     form_edit.find('input[name="username"]').val(r.detail_facebook.username);
                     form_edit.find('input[name="password"]').val(r.detail_facebook.password);
                     form_edit.find('input[name="email_before"]').val(r.detail_facebook.email_id);
                     $('#status').val(r.detail_facebook.status);
                     $('#phone_select').select2('val',r.detail_facebook.phone_number);
                     $('#email_select').select2('val',r.detail_facebook.email_id);
                     $("#modal-modify").modal("toggle");
                  }
            });
            e.preventDefault();
      });

      $(this).on('submit', '#form-modify', function(e) {
            var form = $(this);

            $(this).ajaxSubmit({
                   type : "POST",
                   url  : "<?php echo base_url('index.php/facebook/edit')?>",
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

      $(this).on('submit', '#form-create', function(e) {
            var form = $(this);

            $(this).ajaxSubmit({
                   type : "POST",
                   url  : "<?php echo base_url('index.php/facebook/input_data')?>",
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
                       $("#phone_select_edit").select2("val", "");
                       $("#email_select_edit").select2("val", "");
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

         $.fn.render_data  = function(params){
            
            var str = $.extend({
               offset : $('#offset').val(),
               curpage : $('#curpage').val(),
               filter_status : $('#filter_status').val(),
               filter_name : $('#filter_name').val()
            },params);



            ajaxManager.addReq({
               type : "GET",
               url : "<?php echo base_url('index.php/facebook/get_facebook')?>",
               dataType : "JSON",
               data : {
                  offset:str.offset,
                  curpage:str.curpage,
                  search_status:str.filter_status,
                  search_keyword:str.filter_name
               },
               beforeSend: function (xhr) {
                    if(sessions){
                       $('.show_data').html('<tr><td colspan="9"><h1 class="text-center text-danger">'+loading+'</h1></td></tr>');
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
                        $.each(data.data, function(key,value){
                           t+='<tr>';
                              t+='<td>'+(value.phone_number ? value.phone_number : '')+'</td>';
                              t+='<td>'+value.name+'</td>';
                              t+='<td>'+value.username +'</td>';
                              t+='<td>'+value.password +'</td>';
                              t+='<td>'+(value.email ? value.email : '') +'</td>';
                              t+='<td>'+value.friends+'</td>';
                              t+='<td>'+value.created_date+'</td>';
                              t+='<td>'+value.status+'</td>';
                              t+='<td>'+value.user+'</td>';
                              t+= '<td>';
                                 t+='<div class="btn-group">';
                                 
                                    t+='<button class="btn btn-white btn-sm btn-edit" data-toggle="tooltip" data-original-title="Edit" data-id="'+value.id+'"><i class="fa fa-edit"></i>';
                                    t+= '</button>';

                                    t+= '<button class="btn btn-white btn-sm item_hapus" data-toggle="tooltip" data-original-title="Delete" data-id="'+value.id+'"><i class="fa fa-remove"></i>';
                                    t+= '</button>';

                                 t+='</div>';
                              t+='</td>';
                           t+= '</tr>';
                        });

                     }else{
                        t += '<tr><td colspan="9"><h4 class="text-center">No Result</h4></td></tr>';
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