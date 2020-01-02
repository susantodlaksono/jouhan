<style type="text/css">
   #select2-drop{
      z-index: 9999999999;
   }
   .page-body .select2-container .select2-choice{
      height:30px;
      line-height:30px;
   }
   .label + .label{
      margin-left: 0px;
   }
</style>

<div class="row">
   <div class="col-md-12">
      <div class="panel panel-primary" data-collapsed="0">
         <div class="panel-heading">
            <div class="panel-title"><i class="fa fa-list"></i> List Provider </div>
            <div class="panel-options" style="width: auto;border:0px solid black;">
               <div class="form-group" style="margin-top: 8px;margin-bottom: 5px;">  
                  <!-- <div class="btn-group dropdown-default"> 
                     <a class="btn btn-white btn-sm dropdown-toggle" data-toggle="dropdown" href="#" style="width: auto;" aria-expanded="true"> 
                        <i class="fa fa-gear"></i> Bulk Action <span class="caret"></span>
                     </a>
                     <ul class="dropdown-menu " style="width: auto;">
                        <li style="font-weight: bold;text-align: center;">Set Status</li>
                        <div class="divider"></div>
                        <li style="font-size: 13px;"><a href="#" class="bulk_action" data-mode="status" data-value="1"><i class="fa fa-check"></i> Set Connected</a></li>   
                        <li style="font-size: 13px;"><a href="#" class="bulk_action" data-mode="status" data-value="0"><i class="fa fa-remove"></i> Set Not Connected</a></li>
                     </ul>
                  </div> -->
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
                  <th>Produk</th>
                  <th>Provider</th>
                  <th>Code Number</th>
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
                  <label>Product <span class="text-require">(*)</span></label>
                  <input type="text" name="product" class="form-control" required="">
               </div>
               <div class="form-group">
                  <label>Provider <span class="text-require">(*)</span></label>
                  <input type="text" name="provider" class="form-control">
               </div>
               <div class="form-group">
                  <label>Code Number</label>
                  <input type="text" name="code_number[]" class="form-control tagsinput" id="tag_add">
                  <p class="text-muted"><i>Use <b>ENTER</b> to lock your code number</i></p>
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
            <input type="hidden" name="product_before" value="">
            <input type="hidden" name="code_number_before" value="">
            <div class="modal-body">
               <div class="form-group">
                  <label>Product <span class="text-require">(*)</span></label>
                  <input type="text" name="product" class="form-control" required="">
               </div>
               <div class="form-group">
                  <label>Provider <span class="text-require">(*)</span></label>
                  <input type="text" name="provider" class="form-control">
               </div>
               <div class="form-group">
                  <label>Code Number</label>
                  <input type="text" name="code_number[]" class="form-control tagsinput" id="tag_modify">
                  <p class="text-muted"><i>Use <b>ENTER</b> to lock your code number</i></p>
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Submit</button> 
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

      $("#tag_add").on('itemAdded', function(event) {
         ajaxManager.addReq({
            type : "GET",
            url : site_url + '/master_provider/check_code_number',
            dataType : "JSON",
            data : {
               item : event.item
            },
            error: function (jqXHR, status, errorThrown) {
               error_handle(jqXHR, status, errorThrown);
            },
            success : function(r){
               if(!r.response){
                  $('#tag_add').tagsinput('remove', event.item);
                  alert('code number has been registered');
               }
            }
         });
      }); 


      $.fn.render_data  = function(params){
         var str = $.extend({
            offset : $('#offset').val(),
            curpage : $('#curpage').val(),
            filter_keyword : $('#filter_keyword').val(),
         },params);
         ajaxManager.addReq({
            type : "GET",
            url : site_url + '/master_provider/get',
            dataType : "JSON",
            data : {
               offset : str.offset,
               curpage : str.curpage,
               filter_keyword : str.filter_keyword,
            },
            beforeSend: function (xhr) {
               if(sessions){
                  set_loading_table('#sect-data', 4);
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
                        t += '<td>'+v.product+'</td>';
                        t += '<td>'+v.provider+'</td>';
                        t += '<td>'+(v.code_number ? v.code_number : '')+'</td>';
                        t += '<td>';
                           t += '<div class="btn-group">';
                              t += '<button class="btn btn-default btn-sm btn-edit" data-type="edit" data-toggle="tooltip" data-original-title="Edit" data-id="'+v.id+'"><i class="fa fa-edit"></i></button>';
                              t += '<button class="btn btn-danger btn-sm btn-delete" data-toggle="tooltip" data-original-title="Delete" data-id="'+v.id+'"><i class="fa fa-trash"></i></button>';
                           t += '</div>';
                        t += '</td>';
                     t += '</tr>';
                  });
               }else{
                  t += set_no_result(4);
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
            url  : site_url +'/master_provider/create',
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
                  $('#tag_add').tagsinput('removeAll');
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
            url  : site_url +'/master_provider/change',
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
            url : site_url + '/master_provider/edit',
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
               form.find('input[name="code_number[]"]').tagsinput('removeAll');
               form.find('input[name="id"]').val(r.response.id);
               form.find('input[name="product_before"]').val(r.response.product);
               form.find('input[name="product"]').val(r.response.product);
               form.find('input[name="provider"]').val(r.response.provider);
               form.find('input[name="code_number_before"]').val(r.code_number);

               $.each(r.code_number, function(index, value) {
                  form.find('input[name="code_number[]"]').tagsinput('add', value);
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
               url : site_url + '/master_provider/delete',
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

   });
</script>