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
                  <input type="text" id="filter_keyword" class="form-control">
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
            <button type="hidden" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"><i class="fa fa-plus"></i> Create New</h4>
         </div>
         <form id="form-create">
            <div class="modal-body">
               <div class="form-group">
                  <label>No Rak</label>
                  <input type="number" class="form-control" id="nomor_rak" name="nomor">
               </div>
               <div class="form-group">
                  <label>Nama Rak</label>
                  <input type="text" class="form-control" id="nama_rak" name="nama">
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
   <div class="modal-dialog" style="width: 30%;">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"><i class="fa fa-edit"></i> Edit Rak</h4>
         </div>
         <form id="form-modify">
            <input type="hidden" id="id" name="id">
            <input type="hidden" name="email_before">
            <input type="hidden" name="username_before">
            <div class="modal-body">
               <div class="form-group">
                  <label>No Rak</label>
                  <input type="number" class="form-control" id="no_raks" name="no">
               </div>
               <div class="form-group">
                  <label>Nama Rak</label>
                  <input type="text" class="form-control" id="nama_raks" name="name">
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Change</button> 
            </div>
         </form>
      </div>
   </div>
</div>

<div class="row">
   <div class="col-md-12">
      <div class="panel panel-primary" data-collapsed="0">
         <div class="panel-heading">
            <div class="panel-title"><i class="fa fa-list"></i> List Master Rak</div>
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
                     <th>No Rak</th>
                     <th>Nama Rak</th>
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
            $('#offset').val(0);
            $('#curpage').val(1);
            $('#modal-filter').modal('hide');
            $(this).render_data();
         });

         $(this).on('click', '.btn-reset', function(e) {
            $('#modal-filter').modal('hide');
            $('#form-filter').resetForm();
            $("#filter_nama").select2("val", "");
            $("#filter_no").select2("val", "");
            $(this).render_data();
         });   

         $(this).on('click','.btn-edit',function(e){
               var id = $(this).data('rak_id');
               var form_edit = $('#form-modify');
               $.ajax({
                      type : "GET",
                      url  : "<?php echo base_url('index.php/master_rak/ambil_edit')?>",
                      dataType : "JSON",
                      data : {
                        id:id
                      },
                     success: function(r){
                        form_edit.find('input[name="name"]').val(r.detail_rak.nama_rak);
                        form_edit.find('input[name="no"]').val(r.detail_rak.no);
                        form_edit.find('input[name="id"]').val(r.detail_rak.id);
                     }
               });
               $("#modal-modify").modal("toggle");
         });

         $(this).on('submit', '#form-modify', function(e) {
               var form = $(this);

               $(this).ajaxSubmit({
                      type : "POST",
                      url  : "<?php echo base_url('index.php/master_rak/edit_rak')?>",
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

         $(this).on('click', '.item_hapus', function(e) {
            var ids = $(this).data('rak_ids');
            
               $(this).ajaxSubmit({
                  type : "GET",
                      url  : "<?php echo base_url('index.php/master_rak/hapus')?>",
                      dataType : "JSON",
                      data : {
                        ids:ids
                      },
                      beforeSend: function (xhr) {
                        if(sessions){
                           $('.item_hapus[data-rak_ids="'+ids+'"]').addClass('disabled');
                           $('.item_hapus[data-rak_ids="'+ids+'"]').html(loading);
                        }else{
                           xhr.done();
                           window.location.href = location; 
                        }
                      },
                      error: function (jqXHR, status, errorThrown) {
                        error_handle(jqXHR, status, errorThrown);
                      },
                      success : function(r){
                        $('.item_hapus[data-rak_ids="'+ids+'"]').removeClass('disabled');
                        $('.item_hapus[data-rak_ids="'+ids+'"]').html('<i class="fa fa-remove"></i>');
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

         $(this).on('submit', '#form-create', function(e) {
               var form = $(this);
               $(this).ajaxSubmit({
                      type : "POST",
                      url  : "<?php echo base_url('index.php/master_rak/input_rak')?>",
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

         $.fn.render_data  = function(params){
            
            var str = $.extend({
               offset : $('#offset').val(),
               curpage : $('#curpage').val(),
               filter_keyword : $('#filter_keyword').val(),
            },params);

            ajaxManager.addReq({
               type : "GET",
               url : "<?php echo base_url('index.php/master_rak/get_rak')?>",
               dataType : "JSON",
               data : {
                  offset:str.offset,
                  curpage:str.curpage,
                  keyword:str.filter_keyword,
               },
            beforeSend: function (xhr) {
               if(sessions){
                  $('.show_data').html('<tr><td colspan="3"><h1 class="text-center text-danger">'+loading+'</h1></td></tr>');
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
                              t += '<td>'+value.no_rak+'</td>';
                              t += '<td>'+value.nama_raks+'</td>';
                              t += '<td>';
                                 t += '<div class="btn-group">';
                                    t += '<button class="btn btn-white btn-sm btn-edit" data-toggle="tooltip" data-original-title="Edit" data-rak_id="'+value.id_rak+'"><i class="fa fa-edit"></i></button>';
                                    t += '<button class="btn btn-white btn-sm item_hapus" data-toggle="tooltip" data-original-title="Delete" data-rak_ids="'+value.id_rak+'"><i class="fa fa-remove"></i></button>';
                                 t += '</div>';
   						         t += '</td>';
						         
                           t+= '</tr>';
                        });

                        

                     }else{
                        t += '<tr><td colspan="3"><h4 class="text-center">No Result</h4></td></tr>';
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

