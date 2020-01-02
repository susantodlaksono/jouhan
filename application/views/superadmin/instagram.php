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
                  <label>Phone Number</label>
                  <select id="filter_phone" class="choose form-control" >
                    <option value="">----</option>
                     <?php
                           $data = $this->db->get('simcard')->result_array();
                           foreach ($data as $value) {
                              echo '<option value="'.$value['phone_number'].'">'.$value['phone_number'].'</option>';
                           }
                     ?>
                  </select>
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
                  <select name="phone_number" class="choose form-control" >
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
                  <label>Username</label>
                  <input type="text" class="form-control" name="username">
               </div>
               <div class="form-group">
                  <label>Email</label>
                  <select name="email" class="choose form-control" >
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
                  <input type="Password" class="form-control" name="pass">
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-save"></i> Submit</button> 
            </div>
         </form>
      </div>
   </div>
</div>

<div class="modal fade" id="modal-modify-password">
   <div class="modal-dialog" style="width: 30%;">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"><i class="fa fa-key"></i> Edit Password</h4>
         </div>
         <form id="form-modify-password">
            <input type="hidden" name="id">
            <input type="hidden" name="password_before">
            <div class="modal-body">
               <div class="form-group">
                  <label>New Password</label>
                  <input type="password" class="form-control" name="password">
               </div>
               <div class="form-group">
                  <label>Password Confirmation</label>
                  <input type="password" class="form-control" name="passwordconf">
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-edit"></i> Change</button> 
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
            <h4 class="modal-title"><i class="fa fa-edit"></i> Edit Instagram</h4>
         </div>
         <form id="form-modify">
            <div class="modal-body">
               <div class="form-group">
                  <input type="hidden" class="form-control" name="id_instagram">
               </div>
               <div class="form-group">
                  <label>Phone Number</label>
                  <select id="phon_select" name="phone_number" class="choose form-control" >
                     <?php
                           $data = $this->db->get('simcard')->result_array();
                           foreach ($data as $value) {
                              echo '<option value="'.$value['phone_number'].'">'.$value['phone_number'].'</option>';
                           }
                     ?>
                  </select>
               </div>
               <div class="form-group">
                  <label>Username</label>
                  <input type="text" class="form-control" name="username">
               </div>
               <div class="form-group">
                  <label>Email</label>
                  <select id="email_select" name="email" class="choose form-control" >
                     <?php
                           $data = $this->db->get('email')->result_array();
                           foreach ($data as $value) {
                              echo '<option value="'.$value['id'].'">'.$value['email'].'</option>';
                           }
                     ?>
                  </select>
               </div>
               <div class="form-group">
                  <label>User</label>
                  <select id="user_select" name="user" class="choose form-control">
                     <?php
                           $data = $this->db->get('users')->result_array();
                           foreach ($data as $value) {
                              echo '<option value="'.$value['id'].'">'.$value['first_name'].'</option>';
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
            <div class="panel-title"><i class="fa fa-list"></i> List Instagram</div>
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
                     <th>Username</th>
                     <th>Email</th>
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
          $(this).render_data();
       });

      $(this).on('click', '.btn-reset', function(e) {
         $('#modal-filter').modal('hide');
         $('#form-filter').resetForm();
         $("#filter_phone").select2("val", "");
         $(this).render_data();
      });

      $(this).on('submit', '#form-create', function(e) {
         var form = $(this);
         $(this).ajaxSubmit({
                type : "POST",
                url  : "<?php echo base_url('index.php/instagram/input_instagram')?>",
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
            var id = $(this).data('instagram');
            var form_edit = $('#form-modify');
            $.ajax({
                   type : "GET",
                   url  : "<?php echo base_url('index.php/instagram/ambil_edit')?>",
                   dataType : "JSON",
                   data : {
                     id:id
                   },
                  success: function(r){
                     form_edit.find('input[name="id_instagram"]').val(r.detail_instagram.id);
                     form_edit.find('input[name="username"]').val(r.detail_instagram.username);
                     $('#status').val(r.detail_instagram.status);
                     $('#user_select').val();
                     if(r.detail_instagram.phone_number){
                        $('#phon_select').select2('val', r.detail_instagram.phone_number);
                     }
                     if(r.detail_instagram.email_id){
                        $('#email_select').select2('val', r.detail_instagram.email_id);
                     }
                     if(r.detail_instagram.user_id){
                        $('#user_select').select2('val', r.detail_instagram.user_id);
                     }
                  }
            });
            $("#modal-modify").modal("toggle");
      });

      $(this).on('submit', '#form-modify', function(e) {
            var form = $(this);

            $(this).ajaxSubmit({
                   type : "POST",
                   url  : "<?php echo base_url('index.php/instagram/edit')?>",
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
      
   $(this).on('click', '.btn-change-password', function(e) {
         var id = $(this).data('instagram');
         var form = $('#form-modify-password');
         form.find('input[name="id"]').val(id);
         $('#modal-modify-password').modal('show');
         e.preventDefault();
      });

      $(this).on('submit', '#form-modify-password', function(e) {
         var form = $(this);
         $(this).ajaxSubmit({
            type : "POST",
            url  : "<?php echo base_url('index.php/instagram/change_password')?>",
            dataType : "JSON",
            data:{
               'csrf_token_nalda' : $('#csrf').val()
            },
            error: function (jqXHR, status, errorThrown) {
               error_handle(jqXHR, status, errorThrown);
               form.find('[type="submit"]').removeClass('disabled');
               form.find('[type="submit"]').html('<i class="fa fa-edit"></i> Change');
            },
            beforeSend: function (xhr) {
               if(sessions){
                  form.find('[type="submit"]').addClass('disabled');
                  form.find('[type="submit"]').html(loading);  
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
                  $('#modal-modify-password').modal('hide');
                  $(this).render_data();
                  toastr.success(r.msg);
               }else{
                  toastr.error(r.msg);
               }
               form.find('[type="submit"]').removeClass('disabled');
               form.find('[type="submit"]').html('<i class="fa fa-edit"></i> Change');
            },
         });
         e.preventDefault();
      });

      $(this).on('click','.item_hapus',function(e){
         var id = $(this).data('instagram');
         $(this).ajaxSubmit({
            type : "GET",
                url  : "<?php echo base_url('index.php/instagram/hapus')?>",
                dataType : "JSON",
                data : {
                  no:id
                },
                beforeSend: function (xhr) {
                  if(sessions){
                     $('.item_hapus[data-instagram="'+id+'"]').addClass('disabled');
                     $('.item_hapus[data-instagram="'+id+'"]').html(loading);
                  }else{
                     xhr.done();
                     window.location.href = location; 
                  }
                },
                error: function (jqXHR, status, errorThrown) {
                  error_handle(jqXHR, status, errorThrown);
                },
                success : function(r){
                  $('.item_hapus[data-instagram="'+id+'"]').removeClass('disabled');
                  $('.item_hapus[data-instagram="'+id+'"]').html('<i class="fa fa-trash"></i>');
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
            filter_phone : $('#filter_phone').val(),
            filter_status : $('#filter_status').val()
         },params);
         ajaxManager.addReq({
            type : "GET",
            url : "<?php echo base_url('index.php/instagram/get_instagram')?>",
            // async : false,
            dataType : "JSON",
            data : {
               offset:str.offset,
               curpage:str.curpage,
               search_phone:str.filter_phone,
               search_status:str.filter_status
            },
            beforeSend: function (xhr) {
               if(sessions){
                  $('.show_data').html('<tr><td colspan="5"><h1 class="text-center text-danger">'+loading+'</h1></td></tr>');
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
                     $.each(data.data, function(key,value){
                        t+='<tr>';
                        t+='<td>'+value.phone_number+'</td>';
                        t+='<td>'+value.username+'</td>';
                        $.each(value.email, function(k,v){
                           mail = v.email;
                        });
                        t+='<td>'+mail+'</td>';
                        t+='<td>'+value.created_date+'</td>';
                        t+='<td>'+value.status+'</td>';
                        $.each(value.user, function(k,v){
                           usert = v.first_name;
                        });
                        t+='<td>'+usert+'</td>';
                        t+= '<div class="btn-group"><td><button class="btn btn-white btn-sm btn-edit" data-toggle="tooltip" data-original-title="Edit" data-instagram="'+value.id+'"><i class="fa fa-edit"></i></button>';
                        t += '<button class="btn btn-white btn-change-password btn-sm" data-toggle="tooltip" data-original-title="Change Password" data-instagram="'+value.id+'"><i class="fa fa-key"></i></button>';
                        t+= '<button class="btn btn-white btn-sm item_hapus" data-toggle="tooltip" data-original-title="Delete" data-instagram="'+value.id+'"><i class="fa fa-remove"></i></button></td></div>';
                        t+= '</tr>';
                     });
                  }else{
                     t += '<tr><td colspan="6"><h4 class="text-center">No Result</h4></td></tr>';
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