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
                    <div class="panel-title"><i class="fa fa-list"></i> List Provider</div>
                    <div class="panel-options" style="width: auto;border:0px solid black;">
                        <div class="form-group" style="margin-top: 8px;margin-bottom: 5px;">  
                            <button class="btn btn-white btn-sm" data-toggle="modal" data-target="#mySearch"><i class="fa fa-filter"></i> Filter</button>
                            <button class="btn btn-white btn-sm" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> New</button>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <input type="hidden" id="offset" value="0">
                    <input type="hidden" id="curpage" value="1">
                    <table class="table">
                        <thead>
                            <th>Nama Provider</th>
                            <th>Description</th>
                            <th> </th>
                        </thead>
                        <tbody id="show_data"></tbody>
                    </table>
                    <div class="row">
                        <div class="col-md-6">
                        <h4 id="total_data" class="text-left show_total"></h4>
                        </div>
                        <div class="col-md-6">
                            <ul id="pagination_data" class="pagination pagination-sm no-margin pull-right"></ul> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="myModal">
        <div class="modal-dialog" style="width: 30%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-plus"></i> Create New</h4>
                </div>
                <form id="form-add">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Provider Name</label>
                            <input type="text" name="provname" class="form-control" required="">
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <input type="text" name="desc" class="form-control">
                        </div>
                    </div>
					<div class="modal-footer">
					   <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Submit</button> 
					</div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="myUpdate">
        <div class="modal-dialog" style="width: 30%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-edit"></i> Edit Provider</h4>
                </div>
                <form id="form-edit">
                    <input type="hidden" class="form-control" style="width: 350px;" name="ids">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Provider Name </label>
                            <input type="text" class="form-control" name="provider" required="">
                        </div>
                        <div class="form-group">
                            <label>Description </label>
                            <input type="text" class="form-control" name="descript">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Change</button> 
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="mySearch">
        <div class="modal-dialog" style="width: 30%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-filter"></i> Filter</h4>
                </div>
                <div class="modal-body">
                    <form id="form-filter">
                       <div class="form-group">
                          <label>Provider Name</label>
                          <select id="filter_provider" class="choose form-control" >
                            <option value="">--Choose--</option>
                             <?php
                                 $data = $this->db->get('provider')->result_array();
                                 foreach ($data as $value) {
                                    echo '<option value="'.$value['id'].'">'.$value['name'].'</option>';
                                 }
                             ?> 
                          </select>
                       </div> 
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white btn-reset">Reset</button>
                    <button type="button" id="search" class="btn btn-primary btn-search"><i class="fa fa-search"></i> Search</button>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        var sessions = '#<?php echo $this->ion_auth->logged_in() ?>';
        var loading = '<i class="fa fa-spinner fa-spin"></i>';
        var overlay = '<h3 class="text-center text-danger overlay"><i class="fa fa-spinner fa-spin"></i></h3>';

        $(function () {
			
          $('.choose').select2();
           
            $.fn.render_data = function(params){
                var p = $.extend({
                    offset: $('#offset').val(),
                    currentPage : $('#curpage').val(),
                    search : $('#filter_provider').val(),
                },params);

                ajaxManager.addReq({
                    url: "<?php echo base_url('index.php/master_provider/render_data')?>",
                    type: 'GET',
                    dataType: 'JSON',
                    data: {
                       offset : p.offset,
                       currentPage : p.currentPage,
                       search : p.search
                    },
                    beforeSend: function (xhr) {
                       if(sessions){
                          $('#show_data').html('<tr><td colspan="4"><h1 class="text-center text-danger">'+loading+'</h1></td></tr>');
                       }else{
                          xhr.done();
                          window.location.href = location; 
                       }
                    },
                    error: function (jqXHR, status, errorThrown) {
                       error_handle(jqXHR, status, errorThrown);
                    },
                    success:function(r){
                        var t = '';
                        if(r.total!=0){
                            $.each(r.response, function(k ,v) {
                                t += '<tr>';
                                    t += '<td>'+v.provider_name+'</td>';
                                    t += '<td>'+v.desc+'</td>';
                                    t += '<td><div class="btn-group"><button class="btn-edit btn btn-white btn-change-password btn-sm" data-toggle="tooltip" data-original-title="Edit" data-id="'+v.id_provider+'"><i class="fa fa-edit"></i></button><button class="btn btn-white btn-sm btn_hps" data-toggle="tooltip" data-original-title="Delete" data-id="'+v.id_provider+'"><i class="fa fa-remove"></i></button></div></td>';
                                t += '</tr>';
                                
                            });
                        }else{
                           t += '<tr><td colspan="6"><h4 class="text-center">No Result</h4></td></tr>';
                        }
                        $('#show_data').html(t);
                        $('#total_data').html('Total : ' + r.total);
                        $('#pagination_data').paging({
                          items : r.total,
                          currentPage : p.currentPage
                        });
                        $('#offset').val(p.offset);
                        $('#curpage').val(p.currentPage);
                    }
                })
            }

            $(this).on('click', '.btn-reset', function(e) {
                $('#mySearch').modal('hide');
                $('#form-filter').resetForm();
                $("#filter_provider").select2("val", "");
                $(this).render_data();
            });

            $(this).on('click','#search',function(e){
                $('#offset').val(0);
                $('#curpage').val(1);
                $('#mySearch').modal('hide');
                $(this).render_data();
            });

            $(this).on('submit','#form-add',function(e){
                var form=$(this);
                $(this).ajaxSubmit({
                    url  : "<?php echo base_url('index.php/master_provider/add')?>",
                    type : "POST",
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
                           $('#myModal').modal('hide');
                           $(this).render_data();
                           toastr.success(r.msg);
                        }
                        else{
                           toastr.error(r.msg);
                        }
                        form.find('[type="submit"]').removeClass('disabled');
                        form.find('[type="submit"]').html('<i class="fa fa-save"></i> Submit');
                    }                            
                });
                e.preventDefault();
            });

            $(this).on('submit','#form-edit',function(e){
                var form=$(this);
                $(this).ajaxSubmit({
                    type : "POST",
                    url  : "<?php echo base_url('index.php/master_provider/update')?>",
                    dataType : "JSON",
                    data : {
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
                           $('#myUpdate').modal('hide');
                           $(this).render_data();
                           toastr.success(r.msg);
                        }else{
                           toastr.error(r.msg);
                         }
                        form.find('[type="submit"]').removeClass('disabled');
                        form.find('[type="submit"]').html('<i class="fa fa-edit"></i> Change');
                    }
                });
                e.preventDefault();
            });

            $(this).on('click','.btn-edit',function(e){
                var id=$(this).data('id');
                var form_update=$('#form-edit');
                $.ajax({
                    type : "GET",
                    url  : "<?php echo base_url('index.php/master_provider/getID')?>",
                    dataType : "JSON",
                    data : {
                        update : id
                    },
                    success: function(r){
                        form_update.find('input[name="ids"]').val(r.list.id);
                        form_update.find('input[name="provider"]').val(r.list.name);
                        form_update.find('input[name="descript"]').val(r.list.description);
                    }
                });
                $('#myUpdate').modal('toggle');
                e.preventDefault();
            });

            $(this).on('click', '.btn_hps',function(e){
                var id = $(this).data('id');
                $(this).ajaxSubmit({
                    type: 'GET',
                    url  : "<?php echo base_url('index.php/master_provider/remove')?>",
                    dataType : "JSON",
                    data : {
                        rmv:id
                    },
                    beforeSend: function (xhr) {
                       if(sessions){
                          $('.btn_hps[data-id="'+id+'"]').addClass('disabled');
                          $('.btn_hps[data-id="'+id+'"]').html(loading);
                       }else{
                          xhr.done();
                          window.location.href = location; 
                       }
                    },
                    error: function (jqXHR, status, errorThrown) {
                       error_handle(jqXHR, status, errorThrown);
                    },
                    success : function(r){
                        $('.btn_hps[data-id="'+id+'"]').removeClass('disabled');
                        $('.btn_hps[data-id="'+id+'"]').html('<i class="fa fa-remove"></i>');
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

            $.fn.paging = function (opt) {
                var s = $.extend({
                items: 0,
                itemsOnPage: 10,
                currentPage: 1
            }, opt);

                $('#pagination_data').pagination({
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