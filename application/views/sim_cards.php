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
                  <label>Provider</label>
                  <select id="filter_provider" name="filter_provider" class="form-control choose">
                    <option value="">----</option>
                     <?php
                           $datas = $this->db->select('id,name')->get('provider'); 
                           foreach ($datas->result_array() as $value) {
                              echo '<option value="'.$value['id'].'">'.$value['name'].'</option>';
                           }
                     ?>
                  </select>
               </div>
               <div class="form-group">
                  <label>Status</label>
                  <select id="filter_status" class="form-control">
                     <option value="">----</option>
                     <option value="1">Active</option>
                     <option value="0">Expired</option>
                  </select>
               </div>
               <div class="form-group">
                  <label>Rak</label>
                  <select id="filter_rak" class="form-control choose">
                    <option value="">----</option>
                     <?php
                           $data = $this->db->get('rak')->result_array();
                           foreach ($data as $value) {
                              echo '<option value="'.$value['id'].'">'.$value['nama_rak'].'</option>';
                           }
                     ?>
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
            <div class="modal-body">
               <div class="form-group">
                  <label>No Handphone</label>
                  <input type="text" class="form-control" name="no_handphone">
               </div>
               <div class="form-group">
                  <label>Nama Provider</label>
                  <select name="provider" class="form-control choose">
                    <option value=""></option>
                     <?php
                           $data = $this->db->get('provider')->result_array();
                           foreach ($data as $value) {
                              echo '<option value="'.$value['id'].'">'.$value['name'].'</option>';
                           }
                     ?>
                  </select>
               </div>
               <div class="form-group">
                  <label>Masa Aktif</label>
                  <input type="date" class="form-control" name="masa_aktif">
               </div>
               <div class="form-group">
                  <label>NIK</label>
                  <input type="text" class="form-control" name="nik">
               </div>
               <div class="form-group">
                  <label>KK (Kartu Keluarga)</label>
                  <input type="text" class="form-control" name="kk">
               </div>
               <div class="form-group">
                  <label>Status</label>
                  <select name="status" class="form-control">
                     <option value="1">Active</option>
                     <option value="0">Expired</option>
                  </select>
               </div>
               <div class="form-group">
                  <label>Tgl Isi Pulsa</label>
                  <input type="date" class="form-control" name="tgl_isi">
               </div>
               <div class="form-group">
                  <label>Saldo</label>
                  <input type="text" class="form-control" name="saldo">
               </div>
               <div class="form-group">
                  <label>Rak</label>
                  <select id="rak_select" name="rak" class="form-control choose">
                    <option value=""></option>
                     <?php
                           $data = $this->db->get('rak')->result_array();
                           foreach ($data as $value) {
                              echo '<option value="'.$value['id'].'">'.$value['nama_rak'].'</option>';
                           }
                     ?>
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
            <h4 class="modal-title"><i class="fa fa-edit"></i> Edit Simcard</h4>
         </div>
         <form id="form-modify">
            <div class="modal-body">
               <input type="hidden" class="form-control" name="no_handphone">
               
               <div class="form-group">
                  <label>Provider</label>
                  <select id="provider_select" name="provider" class="form-control choose"  id="user_select">
                     <?php
                           $data = $this->db->get('provider')->result_array();
                           foreach ($data as $value) {
                              echo '<option value="'.$value['id'].'">'.$value['name'].'</option>';
                           }
                     ?>
                  </select>
               </div>
               <div class="form-group">
                  <label>Masa Aktif</label>
                  <input type="date" class="form-control" name="masa_aktif">
               </div>
               <div class="form-group">
                  <label>NIK</label>
                  <input type="text" class="form-control" name="nik">
               </div>
               <div class="form-group">
                  <label>NKK</label>
                  <input type="text" class="form-control" name="nkk">
               </div>
               <div class="form-group">
                  <label>Saldo</label>
                  <input type="text" class="form-control" name="saldo">
               </div>
               <div class="form-group">
                  <label>Status</label>
                  <select id="status_select" name="status" class="form-control">
                     <option value="1">Active</option>
                     <option value="0">Expired</option>
                  </select>
               </div>
               <div class="form-group">
                <label>PIC</label>
                <select name="user" class="form-control choose" id="user_select">
                     <?php
                           $data = $this->db->get('users')->result_array();
                           foreach ($data as $value) {
                              echo '<option value="'.$value['id'].'">'.$value['first_name'].'</option>';
                           }
                     ?>
                  </select>
               </div>
               <div class="form-group">
                  <label>Rak</label>
                  <select name="rak" class="form-control choose" id="rak_selects">
                     <?php
                           $data = $this->db->get('rak')->result_array();
                           foreach ($data as $value) {
                              echo '<option value="'.$value['id'].'">'.$value['nama_rak'].'</option>';
                           }
                     ?>
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
            <div class="panel-title"><i class="fa fa-list"></i> List Simcard</div>
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
                     <th>No Handphone</th>
                     <th>Provider</th>
                     <th>PIC</th>
                     <th>Masa Aktif</th>
                     <th>Info kartu</th>
                     <th>Status</th>
                     <th>Saldo</th>
                     <th>Rak</th>
                     <th>Aksi</th>
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
          $(this).render_data();
       });

      $(this).on('click', '.btn-reset', function(e) {
         $('#modal-filter').modal('hide');
         $('#form-filter').resetForm();
         $("#filter_provider").select2("val", "");
         $("#filter_rak").select2("val", "");
         $(this).render_data();
      });

      $(this).on('submit', '#form-create', function(e) {
            var form = $(this);
            
            $(this).ajaxSubmit({
                   type : "POST",
                   url  : "<?php echo base_url('index.php/sim_card/input_simcard')?>",
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
            var id = $(this).data('nope');
            var form_edit = $('#form-modify');

            ajaxManager.addReq({
                   type : "GET",
                   url  : "<?php echo base_url('index.php/sim_card/ambil_edit')?>",
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
                     form_edit.find('input[name="no_handphone"]').val(r.detail_simcard.phone_number);
                     form_edit.find('input[name="nik"]').val(r.detail_simcard.nik);
                     form_edit.find('input[name="nkk"]').val(r.detail_simcard.nkk);
                     form_edit.find('input[name="masa_aktif"]').val(r.detail_simcard.expired_date);
                     form_edit.find('input[name="saldo"]').val(r.detail_simcard.saldo);
                     $('#rak_selects').select2('val',r.detail_simcard.rak_id);
                     $('#status_select').val(r.detail_simcard.status);
                     $('#user_select').select2('val',r.detail_simcard.user_id);
                     $('#provider_select').select2('val', r.detail_simcard.id_provider);
                     

                     $("#modal-modify").modal("toggle");
                  }
            });
            e.preventDefault();
      });

      $(this).on('submit', '#form-modify', function(e) {
            var form = $(this);

            $(this).ajaxSubmit({
                   type : "POST",
                   url  : "<?php echo base_url('index.php/sim_card/edit')?>",
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
         var no_hp = $(this).data('nope');

         ajaxManager.addReq({
            type : "GET",
                url  : "<?php echo base_url('index.php/sim_card/hapus')?>",
                dataType : "JSON",
                data : {
                  no:no_hp
                },
                beforeSend: function (xhr) {
                  if(sessions){
                     $('.item_hapus[data-nope="'+no_hp+'"]').addClass('disabled');
                     $('.item_hapus[data-nope="'+no_hp+'"]').html(loading);
                  }else{
                     xhr.done();
                     window.location.href = location; 
                  }
                },
                error: function (jqXHR, status, errorThrown) {
                  error_handle(jqXHR, status, errorThrown);
                },
                success : function(r){
                  $('.item_hapus[data-nope="'+no_hp+'"]').removeClass('disabled');
                  $('.item_hapus[data-nope="'+no_hp+'"]').html('<i class="fa fa-trash"></i>');
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
               filter_provider : $('#filter_provider').val(),
               filter_rak : $('#filter_rak').val(),
               filter_status : $('#filter_status').val()
            },params);

            ajaxManager.addReq({
               type : "GET",
               url : "<?php echo base_url('index.php/sim_card/get')?>",
               dataType : "JSON",
               data : {
                  offset:str.offset,
                  curpage:str.curpage,
                  search_provider:str.filter_provider,
                  search_rak:str.filter_rak,
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
                     var provider = "";
                     var rak_nama = "";
                     var rak_no = "";
                        $.each(data.data, function(key,value){
                           t+='<tr>';
                           t+='<td>'+value.no_handphone+'</td>';
                           $.each(value.provider, function(k,v){
                              provider = v.name;
                              
                           });
                           t+='<td>'+provider+'</td>';
                           t+='<td>'+value.first_name+'</td>';
                           t+='<td>'+value.masa_aktif+'</td>';
                           t+='<td> NIK : '+value.nik+'<br>KK : '+value.nkk+'</td>';
                           t+='<td>'+value.status+'</td>';
                           t+='<td>'+value.saldo+'</td>';
                           $.each(value.rak, function(k,v){
                              rak_nama=v.nama_rak;
                              rak_no = v.no;
                           });
                           t+='<td><b>'+rak_nama+'</b><br>No Rak. '+rak_no+'</td>';
                           t+= '<div class="btn-group"><td><button class="btn btn-white btn-sm btn-edit" data-toggle="tooltip" data-original-title="Edit" data-nope="'+value.no_handphone+'"><i class="fa fa-edit"></i></button>';
                           t+= '<button class="btn btn-white btn-sm item_hapus" data-toggle="tooltip" data-original-title="Delete" data-nope="'+value.no_handphone+'"><i class="fa fa-remove"></i></button></td></div>';
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