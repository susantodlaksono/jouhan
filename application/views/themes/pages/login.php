<!DOCTYPE html>
   <html>
    <head>
      <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
      <meta charset="utf-8" />
      <title>EB CAREER | Login</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no" />
      <link href="<?php echo base_url('favicon.png'); ?>" rel="shortcut icon"/>
      <meta name="apple-mobile-web-app-capable" content="yes">
      <meta name="apple-touch-fullscreen" content="yes">
      <meta name="apple-mobile-web-app-status-bar-style" content="default">
      <meta content="" name="description" />
      <meta content="" name="author" />
      <link href="<?php echo base_url('assets/plugins/bootstrapv3/css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css" />
      <link class="main-stylesheet" href="<?php echo base_url('assets/pages/css/pages.css') ?>" rel="stylesheet" type="text/css" />
      <link class="main-stylesheet" href="<?php echo base_url('assets/plugins/select2/css/select2.min.css') ?>" rel="stylesheet" type="text/css" />
      <link href="<?php echo base_url('assets/plugins/font-awesome-5.0.1/css/fontawesome-all.min.css'); ?>" rel="stylesheet" type="text/css" />
      <link href="<?php echo base_url('assets/pages/css/pages-icons.css'); ?>" rel="stylesheet" type="text/css">
      <link href="<?php echo base_url('assets/plugins/daterangepicker/css/daterangepicker.css'); ?>" rel="stylesheet" type="text/css">
      <script type="text/javascript">
      window.onload = function()
      {
        // fix for windows 8
        if (navigator.appVersion.indexOf("Windows NT 6.2") != -1)
          document.head.innerHTML += '<link rel="stylesheet" type="text/css" href="pages/css/windows.chrome.fix.css" />'
      }
      </script>
      <style type="text/css">
         .btn-danger{
              background-color: #f11818;
          }
          .text-danger{
              color: #f11818 !important;
          }
          .bg-danger{
            background-color: #f11818;
          }
          select.input-sm{
            line-height: normal;
          }
      </style>
    </head>
    <body class="fixed-header">
      <div class="login-wrapper" style="background-color: white">
         <div class="bg-pic" style="opacity:4.1" id="section-login"> 
            <div class="row" style="margin-top:30px;margin-left:60px;width:600px;">
               <div class="col-md-12">
                  <form id="form-signup" enctype="multipart/form-data">
                     <h4 class="muted text-danger"><b>Registration</b> Test</h4>
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <label class="text-info">Fullname</label>
                              <input type="text" class="form-control input-sm" name="register_fullname" />
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <label class="text-info">Email</label>
                              <input type="email" class="form-control input-sm" name="register_email" />
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-7">
                           <div class="form-group form-group-default">
                              <label class="text-info">Contact Number</label>
                              <input type="text" class="form-control input-sm" name="register_contact" />
                           </div>
                        </div>
                        <div class="col-md-5">
                           <div class="form-group form-group-default">
                              <label class="text-info">Birth Date</label>
                              <input type="hidden" name="register_birth_date" id="tgl_lahir" value="">
                              <input type="text" class="form-control input-sm date-data" value="">
                           </div>
                        </div>
                     </div>
                     <div class="form-group form-group-default">
                        <label class="text-info">Gender</label>
                        <select class="form-control input-sm choose-gender" name="register_gender" />
                           <option value="L" selected="">Male</option>
                           <option value="P">Female</option>
                        </select>
                     </div>
                     <div class="form-group form-group-default">
                        <label class="text-info">Education Degree</label>
                        <select class="form-control input-sm choose-education" name="register_degree" />
                           <option value="SLTA/Sederajat" selected="">SLTA/Sederajat</option>
                           <option value="D1">D1</option>
                           <option value="D2">D2</option>
                           <option value="D3">D3</option>
                           <option value="D4">D4</option>
                           <option value="S1">S1</option>
                           <option value="S2">S2</option>
                           <option value="S3">S3</option>
                        </select>
                     </div>
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <label class="text-info">School Majors</label>
                              <input type="text" class="form-control input-sm" name="register_majors" />
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <label class="text-info">University</label>
                              <input type="text" class="form-control input-sm" name="register_university" />
                           </div>
                        </div>
                     </div>    
                     <div class="row">
                        <div class="col-md-7">
                           <div class="form-group form-group-default">
                              <label class="text-info">Apply As</label>
                              <select class="form-control input-sm choose-vacancy" name="register_vacancy" />
                                 <option value="" selected="">Choose...</option>
                                 <?php
                                    $vacancy = $this->db->where('status', 1)->get('vacancy_division');
                                    foreach ($vacancy->result_array() as $key => $value) {
                                       echo '<option value="'.$value['id'].'">'.$value['name'].'</option>';
                                    }
                                 ?>
                              </select>
                           </div>
                        </div>
                        <div class="col-md-5">
                           <div class="form-group form-group-default">
                              <label class="text-info">Level</label>
                              <select class="form-control input-sm choose-vacancy" name="register_level" />
                                 <option value="1" selected="">Fresh Graduate</option>
                                 <option value="2">Expert</option>
                              </select>
                           </div>
                        </div>
                     </div>
                     <div class="form-group form-group-default">
                        <label class="text-info" style="margin-bottom: 10px;">CV Upload</label>
                        <input type="file" name="cv_file" class="form-control input-sm">
                        <p class="text-muted" style="font-size: 10px;"><i>Only .docx .doc .pdf</i></p>
                        <!-- <select class="form-control input-sm choose-education" name="register_degree" />
                           <option value="SLTA/Sederajat" selected="">SLTA/Sederajat</option>
                           <option value="D1">D1</option>
                           <option value="D2">D2</option>
                           <option value="D3">D3</option>
                           <option value="D4">D4</option>
                           <option value="S1">S1</option>
                           <option value="S2">S2</option>
                           <option value="S3">S3</option>
                        </select> -->
                     </div>
                     <div class="form-group">
                        <button type="submit" class="btn pull-right btn-block btn-danger"><i class="fa fa-id-card"></i> Register</button>
                     </div>
                  </form>
               </div>
            </div>
         </div>

         <div class="login-container bg-danger" style="">
            <div class="p-l-50 m-l-20 p-r-50 m-r-20 p-t-50 m-t-30 sm-p-l-15 sm-p-r-15 sm-p-t-40">
               
               <img src="<?php echo base_url('assets/img/ebdesk.svg') ?>" style="width: 100px;height: 100px;margin-left: 130px;">
               <h2 class="p-t-35 bold text-center text-white">EB CAREER</h2>
               <p class="text-center text-white" style="margin-top: -10px;">Pre-employment Testing</p>
   
               <?php if ($this->session->flashdata('message') != ''){ ?>
                  <div class="alert alert-danger" style="margin-top:20px;margin-bottom: -10px;">
                     <b>Login Failed !</b> Check your username & password
                  </div>
               <?php } ?>
               
               
               <form id="form-login" class="p-t-15" role="form" method="post" action="<?php echo site_url('security/login') ?>">
                  <input type="hidden" id="_csrf_login" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                  <div class="form-group form-group-default">
                     <label>Email</label>
                     <div class="controls">
                        <input type="text" name="username" placeholder="User Name" class="form-control input-sm" />
                     </div>
                  </div>
                  <div class="form-group form-group-default">
                     <label>Password</label>
                     <div class="controls">
                        <input type="password" class="form-control input-sm" name="password" placeholder="Credentials" />
                     </div>
                  </div>
                  <button class="btn btn-danger pull-right" type="submit"><i class="fa fa-sign-in-alt"></i> Sign in</button>
               </form>
               <button class="btn pull-left btn-danger btn-check-username" type="button" data-target="#modal-username" data-toggle="modal"><i class="fa fa-edit"></i> Check Password</button>
            </div>
         </div>
      </div>      
      
      <div class="modal fade fill-in" id="modal-username" tabindex="-1" role="dialog" aria-hidden="true">
         <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close"></i></button>
         <div class="modal-dialog" style="">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="text-left"><span class="bold">Check Password</span></h5>
               </div>
               <div class="modal-body body-check-username">
                  <div class="panel panel-default">
                     <div class="panel-body">
                        <div class="row">
                           <form id="form-check-username">
                              <div class="col-md-9">
                                 <input type="email" name="email_check" placeholder="Your email address here" class="form-control input-sm">
                              </div>
                             <div class="col-md-3 no-padding sm-m-t-10 sm-text-center">
                               <button type="submit" class="btn btn-default"><i class="fa fa-edit"></i> Check</button>
                             </div>
                          </form>
                        </div>
                     </div>
                  </div>
                 <div class="panel panel-default panel-result-username" style="display: none;">
                     <div class="panel-body">
                        <div class="row">
                           <div class="col-md-12">
                              <!-- <h6 class="font-arial text-center text-muted">Your Username : </h6>
                              <h5 class="font-arial text-center result-check-username"></h5> -->
                              <h6 class="font-arial text-center text-muted">Your Password : </h6>
                              <h5 class="font-arial text-center result-check-password"></h5>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      
      <input type="hidden" id="csrf" value="<?php echo $this->security->get_csrf_hash(); ?>">

      <script src="<?php echo base_url('assets/plugins/jquery/jquery-1.11.1.min.js') ?>" type="text/javascript"></script>
      <script src="<?php echo base_url('assets/plugins/jquery-validation/js/jquery.validate.min.js') ?>" type="text/javascript"></script>
      <script src="<?php echo base_url('assets/plugins/select2/js/select2.full.min.js') ?>"></script>
      <script src="<?php echo base_url('assets/js/jquery.form.js') ?>"></script>
      <script src="<?php echo base_url('assets/plugins/bootstrapv3/js/bootstrap.min.js') ?>" type="text/javascript"></script>
      <script src="<?php echo base_url('assets/pages/js/pages.min.js') ?>"></script>
      <script src="<?php echo base_url('assets/plugins/momentjs/momentjs.min.js') ?>" type="text/javascript"></script>
      <script src="<?php echo base_url('assets/plugins/daterangepicker/js/daterangepicker.js') ?>" type="text/javascript"></script>

      <!-- END VENDOR JS -->
   
      <script>
          var site_url = '<?php echo site_url(); ?>';
      </script>

      <script>
      $(function(){
         "use strict";

         $('#form-login').validate();
         $('#modal-username').on('show.bs.modal', function(e) {
            $('body').addClass('fill-in-modal');
         });
         // $('.choose-education').select2();
         // $('.choose-vacancy').select2();
         // $('.choose-gender').select2();

         $(this).on('click', '.btn-check-username', function (){
            $('.panel-result-username').hide();
            $('#form-check-username').resetForm();
         });

         $('.date-data').daterangepicker({
            autoUpdateInput: false,
            locale: {
               format: 'DD/MMM/YYYY'
            },
            singleDatePicker: true,
            showDropdowns: true
         });

         $('.date-data').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD/MMM/YYYY'));
            $('#tgl_lahir').val(picker.startDate.format('YYYY-MM-DD'));
         });

         $(this).on('submit', '#form-signup', function (e){
            var form = $(this);
            $(this).ajaxSubmit({
               url: site_url + '/security/register',
               type: 'POST',
               dataType: 'JSON',
               data: {
                  'csrf_token_app' : $('#csrf').val()
               },
               beforeSend: function(){
                  form.find('[type="submit"]').html('<i class="fa fa-spinner fa-spin"></i> Request Registration...');
                  form.find('[type="submit"]').attr('disabled', 'disabled');
               },
               success: function(r) {
                  form.find('[type="submit"]').html('<i class="fa fa-id-card"></i> Register');
                  form.find('[type="submit"]').removeAttr('disabled');
                  if(r.success){
                     $('.bg-pic').pgNotification({
                        style: 'bar',
                        message: r.msg,
                        position: 'top',
                        timeout: 4000,
                        type: 'success'
                     }).show();
                     form.resetForm();
                  }else{
                     $('.bg-pic').pgNotification({
                        style: 'simple',
                        message: r.msg,
                        position: 'bottom-right',
                        timeout: 3000,
                        type: 'info'
                     }).show();
                  }
                  $('#csrf').val(r.csrf);
                  $('#_csrf_login').val(r.csrf);
               },
               error: function() {
                   form.find('[type="submit"]').html('<i class="fa fa-id-card"></i> Register');
                   form.find('[type="submit"]').removeAttr('disabled');
               }
            });
            e.preventDefault();
         });

         $(this).on('submit', '#form-check-username', function (e){
            var form = $(this);
            $(this).ajaxSubmit({
               url: site_url + '/security/check_username',
               type: 'POST',
               dataType: 'JSON',
               data: {
                  'csrf_token_app' : $('#csrf').val()
               },
               beforeSend: function(){
                  form.find('[type="submit"]').html('<i class="fa fa-spinner fa-spin"></i> Checking...');
                  form.find('[type="submit"]').attr('disabled', 'disabled');
               },
               success: function(r) {
                  form.find('[type="submit"]').html('Check');
                  form.find('[type="submit"]').removeAttr('disabled');
                  if(r.userdata){
                     if(r.userdata.active == 1){
                        // $('.result-check-username').html(r.userdata.username);
                        $('.result-check-password').html(r.userdata.password_show + '<br><span class="label label-success">Active Login</label>');
                     }else{
                        // $('.result-check-username').html(r.userdata.username);
                        $('.result-check-password').html(r.userdata.password_show + '<br><span class="label label-danger">Inactive Login</label>');
                     }
                  }else{
                     $('.result-check-password').html('Email not registered');
                  }
                  $('.panel-result-username').show();
                  $('#csrf').val(r.csrf);
                  $('#_csrf_login').val(r.csrf);
               },
               error: function() {
                   form.find('[type="submit"]').html('Check');
                   form.find('[type="submit"]').removeAttr('disabled');
               }
            });
            e.preventDefault();
         });

      })
      </script>
   </body>
   </html>