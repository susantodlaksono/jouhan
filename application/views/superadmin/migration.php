<div class="row">
   <div class="col-md-4">
      <div class="panel panel-primary" data-collapsed="0">
         <div class="panel-heading">
            <div class="panel-title">Master Rak</div>
         </div>
         <div class="panel-body">
            <form id="form-migration-master-rak">
               <div class="form-group">
                  <label>File</label>
                  <input type="file" class="form-control" name="filedata">
               </div>
               <div class="form-group">
                  <div class="btn-group pull-right">
                     <a href="<?php echo site_url('migration/format_download?mode=rak') ?>" class="btn btn-white"><i class="fa fa-download"></i> Download Format Excel</a>
                     <button type="submit" class="btn btn-primary"><i class="fa fa-cloud-upload"></i> Import</button>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>

<script type="text/javascript">

   var sessions = '#<?php echo $this->ion_auth->logged_in() ?>';

   $(function () {

      'use restrict';

      $(this).on('submit', '#form-migration-master-rak', function(e) {
         var form = $(this);
         $(this).ajaxSubmit({
            url: site_url + '/migration/master_rak',
            data:{
               'csrf_token_nalda' : $('#csrf').val()
            },
            type: 'POST',
            dataType: 'JSON',
            error: function (jqXHR, status, errorThrown) {
               error_handle(jqXHR, status, errorThrown);
               form.find('[type="submit"]').removeClass('disabled');
               form.find('[type="submit"]').html('Submit');
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
                  toastr.success(r.msg);
               }else{
                  toastr.error(r.msg);
               }
               form.find('[type="submit"]').removeClass('disabled');
               form.find('[type="submit"]').html('Submit');
            },
         });
         e.preventDefault();
      });

   });
</script>