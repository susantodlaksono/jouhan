<!DOCTYPE html>
<html>
   <head>
      <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
      <meta charset="utf-8" />
      <title>Task Management | Login</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no" />
      <link rel="icon" type="image/x-icon" href="favicon.ico" />
      <meta name="apple-mobile-web-app-capable" content="yes">
      <meta name="apple-touch-fullscreen" content="yes">
      <meta name="apple-mobile-web-app-status-bar-style" content="default">
      <meta content="" name="description" />
      <meta content="" name="author" />
      <link href="<?php echo base_url('assets/plugins/pace/pace-theme-flash.css') ?>" rel="stylesheet" type="text/css" />
      <link href="<?php echo base_url('assets/plugins/bootstrapv3/css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css" />
      <link href="<?php echo base_url('assets/plugins/font-awesome/css/font-awesome.css') ?>" rel="stylesheet" type="text/css" />
      <link href="<?php echo base_url('assets/pages/css/pages-icons.css'); ?>" rel="stylesheet" type="text/css">
      <link class="main-stylesheet" href="<?php echo base_url('assets/pages/css/pages.css') ?>" rel="stylesheet" type="text/css" />
      <link class="main-stylesheet" href="<?php echo base_url('assets/plugins/select2/css/select2.min.css') ?>" rel="stylesheet" type="text/css" />
      <link class="main-stylesheet" href="<?php echo base_url('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') ?>" rel="stylesheet" type="text/css" />
      <script type="text/javascript">
      window.onload = function()
      {
        // fix for windows 8
        if (navigator.appVersion.indexOf("Windows NT 6.2") != -1)
          document.head.innerHTML += '<link rel="stylesheet" type="text/css" href="pages/css/windows.chrome.fix.css" />'
      }
      </script>
   </head>
   <body style="padding:20px;">
      <form id="job-assignment-request-form">
         <div class="row">
            <div class="col-md-6">
               <div class="panel panel-default">
                  <div class="panel-body">
                     <h4 class="bold">Job Assignment Request</h4><hr>
                     <div class="form-group form-group-default">
                        <label>Project Name</label>
                        <input type="text" class="form-control" name="job_name">
                     </div>
                     <div class="form-group form-group-default">
                        <label>Job Category</label>
                        <select class="form-control" name="job_category">
                           <option value="">Choose...</option>
                           <?php foreach($job_type as $v){ ?>
                              <option value="<?php echo $v['id']; ?>"><?php echo $v['name']; ?></option>
                           <?php } ?>
                        </select>
                     </div>
                     <div class="form-group form-group-default">
                        <label>Description</label>
                        <textarea class="form-control" rows="2" name="job_description"></textarea>
                     </div>
                     <div class="form-group form-group-default">
                        <label>Leader</label>
                        <select class="form-control leader-field" style="width: 100%;" required>
                           <option selected disabled>Choose...</option>
                           <?php foreach($member as $k => $v){ ?>
                              <optgroup label="<?php echo $k ?>">
                                 <?php foreach($v as $kk => $vv){ ?>
                                    <option value="<?php echo $kk; ?>"><?php echo $vv ?></option>
                                 <?php } ?>
                              </optgroup>
                              
                           <?php } ?>
                        </select>
                     </div>
                     <div class="form-group form-group-default">
                        <label>Date</label>
                        <input type="text" class="form-control field-start-date" name="job_start_date">
                     </div>
                     <div class="form-group form-group-default">
                        <label>Contributor</label>
                        <select class="form-control contributor-field">
                         <option selected disabled>Choose...</option>
                           <?php foreach($member as $k => $v){ ?>
                              <optgroup label="<?php echo $k ?>">
                                 <?php foreach($v as $kk => $vv){ ?>
                                    <option value="<?php echo $kk; ?>"><?php echo $vv ?></option>
                                 <?php } ?>
                              </optgroup>
                              
                           <?php } ?>
                        </select>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-6 no-padding">
               <div class="panel panel-default">
                  <div class="panel-body">
                     <h4 class="bold">Contributor of Job</h4><hr>
                     <h5 class="bold" style="border-bottom: 1px solid rgba(0, 0, 0, 0.07);">Leader</h5>
                     <div class="row" id="sect-leader"></div>
                     <h5 class="bold" style="border-bottom: 1px solid rgba(0, 0, 0, 0.07);">Contributor</h5>
                     <div class="row" id="sect-contributor"></div>
                  </div>
            </div>
         </div>
         <div class="row">
            <div class="col-md-12">
               <div class="panel panel-default">
                  <div class="panel-body">
                        <button type="submit" class="btn btn-info pull-right">Send Request</button>
                     <a href="<?php echo site_url('security'); ?>" class="btn btn-secondary pull-right">Back To Login</a>
                  </div>
               </div>
            </div>
         </div>
      </form>

      <script src="<?php echo base_url('assets/plugins/pace/pace.min.js') ?>" type="text/javascript"></script>
      <script src="<?php echo base_url('assets/plugins/jquery/jquery-1.11.1.min.js') ?>" type="text/javascript"></script>
      <script src="<?php echo base_url('assets/plugins/modernizr.custom.js') ?>" type="text/javascript"></script>
      <script src="<?php echo base_url('assets/plugins/jquery-ui/jquery-ui.min.js') ?>" type="text/javascript"></script>
      <script src="<?php echo base_url('assets/plugins/bootstrapv3/js/bootstrap.min.js') ?>" type="text/javascript"></script>
      <script src="<?php echo base_url('assets/plugins/jquery/jquery-easy.js') ?>" type="text/javascript"></script>
      <script src="<?php echo base_url('assets/plugins/jquery-unveil/jquery.unveil.min.js') ?>" type="text/javascript"></script>
      <script src="<?php echo base_url('assets/plugins/jquery-bez/jquery.bez.min.js') ?>"></script>
      <script src="<?php echo base_url('assets/plugins/jquery-ios-list/jquery.ioslist.min.js') ?>" type="text/javascript"></script>
      <script src="<?php echo base_url('assets/plugins/jquery-actual/jquery.actual.min.js') ?>"></script>
      <script src="<?php echo base_url('assets/plugins/jquery-scrollbar/jquery.scrollbar.min.js') ?>"></script>
      <script type="text/javascript" src="<?php echo base_url('assets/plugins/classie/classie.js') ?>"></script>
      <script src="<?php echo base_url('assets/plugins/switchery/js/switchery.min.js') ?>" type="text/javascript"></script>
      <script src="<?php echo base_url('assets/plugins/jquery-validation/js/jquery.validate.min.js') ?>" type="text/javascript"></script>
      <script src="<?php echo base_url('assets/plugins/select2/js/select2.full.min.js') ?>"></script>
      <script src="<?php echo base_url('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') ?>"></script>
      <script src="<?php echo base_url('assets/plugins/jquery.form.min.js') ?>"></script>
      <!-- END VENDOR JS -->
      <script src="<?php echo base_url('assets/pages/js/pages.min.js') ?>"></script>
      <script>
         var site_url = '<?php echo site_url(); ?>';
         var base_url = '<?php echo base_url(); ?>';
      </script>
      <script>
      $(function(){
         $('.leader-field, .contributor-field').select2();

         $('.field-start-date').datepicker({
            autoclose: true
         });

         $(this).on('submit', '#job-assignment-request-form', function(e) {
            var form = $(this);
            $(this).ajaxSubmit({
               url: site_url + '/security/send_request',
               type: 'POST',
               dataType: 'JSON',
               beforeSend: function() {
                  form.find('[type="submit"]').html('<i class="fa fa-spinner fa-spin"></i> Sending...');
                  form.find('[type="submit"]').attr('disabled', 'disabled');
               },
               success: function(r) {
                  form.find('[type="submit"]').html('Send Request');
                  form.find('[type="submit"]').removeAttr('disabled');

                  if(r.status) {
                     alert('success');  
                  }else {
                     alert('failed');
                  }
               },
               error: function() {
                   form.find('[type="submit"]').html('Send Request');
                   form.find('[type="submit"]').removeAttr('disabled');
               }
            });

            e.preventDefault();
         });

         $(this).on("select2:select", '.leader-field', function(e) {
            var id = $(this).val();
            var name = $('.leader-field option:selected').text();
            var label = $('.leader-field :selected').parent().attr('label');
            var t = '';
            t += '<input type="hidden" name="job_leader" value="'+id+'">';
            t += '<div class="col-md-5">';
               t += '<h5 style="font-size:13px;" class="font-arial">'+name+'</h5>'; 
            t += '</div>'; 
            t += '<div class="col-md-5">';
               t += '<h5 style="font-size:13px;" class="font-arial">'+label+'</h5>'; 
            t += '</div>'; 
            $('#sect-leader').html(t);
            e.preventDefault();
         });

         $(this).on('click', '.remove-member-list-btn', function(e) {
            var id = $(this).data('id');
            $(this).parents('#target-'+id+'').remove();
            e.preventDefault();
         });

         $(this).on("select2:select", '.contributor-field', function(e) {
            var id = $(this).val();
            var name = $('.contributor-field option:selected').text();
            var label = $('.contributor-field :selected').parent().attr('label');
            if($('#sect-contributor').find('[name="job_leader[' + id + ']"]').length < 1) {
               var t = '';
               t += '<div class="col-md-12 no-padding" id="target-'+id+'">';
                  t += '<input type="hidden" name="job_contributor['+id+'][id]" value="'+id+'">';
                  t += '<div class="col-md-4">';
                     t += '<h5 style="font-size:13px;" class="font-arial">'+name+'</h5>'; 
                  t += '</div>'; 
                  t += '<div class="col-md-3">';
                     t += '<h5 style="font-size:13px;" class="font-arial">'+label+'</h5>'; 
                  t += '</div>'; 
                  t += '<div class="col-md-4">';
                     t += '<input style="margin-top:4px;" type="text" name="job_contributor['+id+'][main_task]" class="form-control input-sm" placeholder="Main task here...">'; 
                  t += '</div>'; 
                  t += '<div class="col-md-1">';
                     t += '<a href="#" class="remove-member-list-btn" data-id="'+id+'" style="color: red;">';
                     t += '<i class="fa fa-remove" style="font-size: 15px;margin-top:10px;"></i>';
                     t += '</a>';
                  t += '</div>';   
               t += '</div>';   
               $('#sect-contributor').append(t);
            }
            e.preventDefault();
         });
      })
      </script>
   </body>
</html>