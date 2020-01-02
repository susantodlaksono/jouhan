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
 	<div class="col-md-4">
      <div class="row">
         <div class="col-md-12">
            <div class="panel panel-primary" data-collapsed="0">
               <div class="panel-heading">
                  <div class="panel-title"><i class="fa fa-file"></i> Reporting By Module</div>
               </div>
               <div class="panel-body">
                  <div class="row">
                     <div class="col-md-12">
                        <form method="post" action="<?php echo site_url('reporting/get') ?>" id="form-by-modul" enctype="multipart/form-data">
                           <div class="row">
                              <div class="col-md-6">
                                 <div class="input-group">
                                    <div class="input-group-addon">
                                       <input name="mode_report" type="radio" class="select_mode" value="1">
                                    </div>
                                    <button class="btn btn-white" type="button" data-toggle="modal" data-target="#modal-param-phone">List Phone Number</button>
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="input-group">
                                    <div class="input-group-addon">
                                       <input name="mode_report" type="radio" class="select_mode" value="2" checked="">
                                    </div>
                                    <button class="btn btn-white" type="button" data-toggle="modal" data-target="#modal-param-date">Created / Expired</button>
                                 </div>
                              </div>
                              <div class="col-md-12" style="margin-top: 20px;">
                                 <button class="btn btn-white btn-block" type="button" data-toggle="modal" data-target="#modal-choose-field">Choose Field From Module</button>
                              </div>
                           </div>
                           <hr>
                           <div class="form-group">
                              <label>Filename</label>
                              <div class="input-group">
                                 <input type="text" name="filename" class="form-control">
                                 <div class="input-group-addon">.xlsx</div>
                              </div>
                           </div>

                           <div class="modal" id="modal-param-phone">
                              <div class="modal-dialog" style="width: 35%;">
                                 <div class="modal-content">
                                    <div class="modal-header">
                                       <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                       <h3 class="modal-title bold"><i class="fa fa-filter"></i> List Phone Number</h3>
                                    </div>
                                    <div class="modal-body">
                                       <h5 class="text-center">Download the file format below</h5>
                                       <p class="text-muted text-center bold" style="margin-top: -5px;">
                                          <a href="<?php echo base_url() ?>format/ListPhoneNumber.xlsx" class="text-center"> ListPhoneNumber.xlsx</a>
                                       </p>
                                       <div class="form-group">
                                          <label>Upload Format</label>
                                          <input type="file" name="userfile" class="form-control">
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>

                           <div class="modal" id="modal-param-date">
                              <div class="modal-dialog" style="width: 35%;">
                                 <div class="modal-content">
                                    <div class="modal-header">
                                       <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                       <h3 class="modal-title bold"><i class="fa fa-filter"></i> Date Created / Expired</h3>
                                    </div>
                                    <div class="modal-body">
                                       

                                      <div class="form-group">
                                          <div class="row">
                                             <div class="col-md-6">
                                                <label>Start Create Date</label>
                                                <input type="hidden" name="by_modul_sdate_created" id="by_modul_sdate_created">
                                                <div class="input-group">
                                                   <input type="text" class="form-control by_modul_sdate_created">
                                                   <div class="input-group-addon set-empty" data-target="by_modul_sdate_created" style="cursor: pointer;"><i class="fa fa-eraser"></i></div>
                                                </div>
                                             </div>
                                             <div class="col-md-6">
                                                <label>End Create Date</label>
                                                <input type="hidden" name="by_modul_edate_created" id="by_modul_edate_created">
                                                <div class="input-group">
                                                   <input type="text" class="form-control by_modul_edate_created">
                                                   <div class="input-group-addon set-empty" data-target="by_modul_edate_created" style="cursor: pointer;"><i class="fa fa-eraser"></i></div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       <hr>
                                       <div class="form-group">
                                          <div class="row">
                                             <div class="col-md-6">
                                                <label>Start Expired Date</label>
                                                <input type="hidden" name="by_modul_sdate_expired" id="by_modul_sdate_expired">
                                                <div class="input-group">
                                                   <input type="text" class="form-control by_modul_sdate_expired">
                                                   <div class="input-group-addon set-empty" data-target="by_modul_sdate_expired" style="cursor: pointer;"><i class="fa fa-eraser"></i></div>
                                                </div>
                                             </div>
                                             <div class="col-md-6">
                                                <label>End Expired Date</label>
                                                <input type="hidden" name="by_modul_edate_expired" id="by_modul_edate_expired">
                                                <div class="input-group">
                                                   <input type="text" class="form-control by_modul_edate_expired">
                                                   <div class="input-group-addon set-empty" data-target="by_modul_edate_expired" style="cursor: pointer;"><i class="fa fa-eraser"></i></div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>

                           <div class="modal" id="modal-choose-field">
                              <div class="modal-dialog" style="width: 35%;">
                                 <div class="modal-content">
                                    <div class="modal-header">
                                       <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                       <h3 class="modal-title bold">Choose Field From Module</h3>
                                    </div>
                                    <div class="modal-body">
                                       <div class="form-group">
                                          <label>Simcard Field</label>
                                          <select class="form-control choose" multiple="" name="module[simcard][]">
                                             <?php
                                                foreach ($field['simcard'] as $key => $value) {
                                                   echo '<option value="'.$key.'">'.$value.'</option>';
                                                }
                                             ?>
                                          </select>
                                       </div>
                                       <div class="form-group">
                                          <label>Email Field</label>
                                          <select class="form-control choose" multiple="" name="module[email][]">
                                             <?php
                                                foreach ($field['email'] as $key => $value) {
                                                   echo '<option value="'.$key.'">'.$value.'</option>';
                                                }
                                             ?>
                                          </select>
                                       </div>
                                       <div class="form-group">
                                          <label>Twitter Field</label>
                                          <select class="form-control choose" multiple="" name="module[twitter][]">
                                             <?php
                                                foreach ($field['twitter'] as $key => $value) {
                                                   echo '<option value="'.$key.'">'.$value.'</option>';
                                                }
                                             ?>
                                          </select>
                                       </div>
                                       <div class="form-group">
                                          <label>Facebook Field</label>
                                          <select class="form-control choose" multiple="" name="module[facebook][]">
                                             <?php
                                                foreach ($field['facebook'] as $key => $value) {
                                                   echo '<option value="'.$key.'">'.$value.'</option>';
                                                }
                                             ?>
                                          </select>
                                       </div>
                                       <div class="form-group">
                                          <label>Instagram Field</label>
                                          <select class="form-control choose" multiple="" name="module[instagram][]">
                                             <?php
                                                foreach ($field['instagram'] as $key => $value) {
                                                   echo '<option value="'.$key.'">'.$value.'</option>';
                                                }
                                             ?>
                                          </select>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="form-group">
                              <button class="btn btn-white btn-block" type="submit"><i class="fa fa-download"></i> Download</button>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-12">
            <div class="panel panel-primary" data-collapsed="0" id="panel-all-module">
               <div class="panel-heading">
                  <div class="panel-title"><i class="fa fa-file"></i> Reporting All Module</div>
               </div>
               <div class="panel-body">
                  <div class="row">
                     <div class="col-md-12">
                        <form method="get" action="<?php echo site_url().'index.php/reporting/get_all_module' ?>" id="form-all-module">
                           <div class="form-group">
                              <label>Choose Module</label>
                              <select id="mod_val" name="module_type" class="form-control">
                                 <option value=""></option>
                                 <option value="1">Simcard</option>
                                 <option value="2">Email</option>
                                 <option value="3">Twiter</option>
                                 <option value="4">Facebook</option>
                                 <option value="5">Instagram</option>
                              </select>
                           </div>
                           <div class="form-group">
                              <label>Created Date Module Selected</label>
                              <input type="hidden" name="all_modul_created_sdate" id="all_modul_created_sdate">
                              <input type="hidden" name="all_modul_created_edate" id="all_modul_created_edate">
                              <div class="input-group">
                                 <input type="text" class="form-control all_modul_created">
                                 <div class="input-group-addon clear-date" data-render="#form-all-module" data-targeted="all_modul_created" style="cursor: pointer;">Empty</div>
                              </div>
                           </div>
                           <div class="form-group">
                              <label>Expired Date Simcard</label>
                              <input type="hidden" name="all_modul_expired_sdate" id="all_modul_expired_sdate">
                              <input type="hidden" name="all_modul_expired_edate" id="all_modul_expired_edate">
                              <div class="input-group">
                                 <input type="text" class="form-control all_modul_expired">
                                 <div class="input-group-addon clear-date" data-render="#form-all-module" data-targeted="all_modul_expired" style="cursor: pointer;">Empty</div>
                              </div>
                           </div>
                           <div class="form-group">
                              <label>Filename</label>
                              <div class="input-group">
                                 <input type="text" name="filename" class="form-control">
                                 <div class="input-group-addon">.xlsx</div>
                              </div>
                           </div>
                           <!-- <div class="row">
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Start Date</label>
                                    <input type="hidden" name="all_modul_sdate_created" id="all_modul_sdate_created">
                                    <div class="input-group">
                                       <input type="text" class="form-control all_modul_sdate_created">
                                       <div class="input-group-addon set-empty" data-target="all_modul_sdate_created" style="cursor: pointer;">
                                          <i class="fa fa-eraser"></i>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>End Date</label>
                                    <input type="hidden" name="all_modul_edate_created" id="all_modul_edate_created">
                                    <div class="input-group">
                                       <input type="text" class="form-control all_modul_edate_created">
                                       <div class="input-group-addon set-empty" data-target="all_modul_edate_created" style="cursor: pointer;">
                                          <i class="fa fa-eraser"></i>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div> -->
                           <div class="form-group">
                              <button class="btn btn-white btn-block" type="submit"><i class="fa fa-download"></i> Download</button>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
	</div>
   <div class="col-md-4">
      <div class="row">
         <div class="col-md-12">
            <div class="panel panel-primary" data-collapsed="0">
               <div class="panel-heading">
                  <div class="panel-title"><i class="fa fa-file"></i> Reporting Proxy</div>
               </div>
               <div class="panel-body">
                  <form method="get" action="<?php echo site_url().'reporting/get_proxy' ?>" id="form-by-proxy">
                     <div class="form-group">
                        <label>Status</label>
                        <select class="form-control" name="status">
                           <option value="">All Status</option>
                           <option value="1">Connected</option>
                           <option value="0">Not Connected</option>
                        </select>
                     </div>
                     <div class="form-group">
                        <label>Choose Field</label>
                        <select class="form-control input-sm choose" multiple="" name="module[proxy][]">
                           <?php
                              foreach ($field['proxy'] as $key => $value) {
                                 echo '<option value="'.$key.'">'.$value.'</option>';
                              }
                           ?>
                        </select>
                     </div>
                     <div class="form-group">
                        <label>Filename</label>
                        <div class="input-group">
                           <input type="text" name="filename" class="form-control">
                           <div class="input-group-addon">.xlsx</div>
                        </div>
                     </div>
                     <div class="form-group">
                        <button class="btn btn-white btn-block" type="submit"><i class="fa fa-download"></i> Download</button>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<script type="text/javascript">
	$(function () {
		
		'use restrict';
		
		$('.choose').select2();

      $('.all_modul_created').daterangepicker({
         drops: 'up',
         autoUpdateInput: false,
      },
         function (start, end) {
            $('.all_modul_created').val(''+start.format('DD MMM YYYY')+' sd '+end.format('DD MMM YYYY')+'');
            $('#form-all-module').find('input[name="all_modul_created_sdate"]').val(start.format('YYYY-MM-DD'));
            $('#form-all-module').find('input[name="all_modul_created_edate"]').val(end.format('YYYY-MM-DD'));
         }
      );

      $('.all_modul_expired').daterangepicker({
         drops: 'up',
         autoUpdateInput: false,
      },
         function (start, end) {
            $('.all_modul_expired').val(''+start.format('DD MMM YYYY')+' sd '+end.format('DD MMM YYYY')+'');
            $('#form-all-module').find('input[name="all_modul_expired_sdate"]').val(start.format('YYYY-MM-DD'));
            $('#form-all-module').find('input[name="all_modul_expired_edate"]').val(end.format('YYYY-MM-DD'));
         }
      );

      $(this).on('click', '.clear-date',function(e){
         var render = $(this).data('render');
         var target = $(this).data('targeted');
         $(render).find('.'+target+'').val('');
         $(render).find('input[name="'+target+'_sdate"]').val('');
         $(render).find('input[name="'+target+'_edate"]').val('');
      });

      $('.by_modul_sdate_created').daterangepicker({
         parentEl : '#modal-param-date',
         autoUpdateInput: false,
         locale: {
            format: 'DD/MMM/YYYY'
         },
         singleDatePicker: true,
         showDropdowns: true
      });

      $('.by_modul_sdate_created').on('apply.daterangepicker', function(ev, picker) {
         $(this).val(picker.startDate.format('DD/MMM/YYYY'));
         $('#form-by-modul').find('input[name="by_modul_sdate_created"]').val(picker.startDate.format('YYYY-MM-DD'));
      });

      $('.by_modul_edate_created').daterangepicker({
         parentEl : '#modal-param-date',
         autoUpdateInput: false,
         locale: {
            format: 'DD/MMM/YYYY'
         },
         singleDatePicker: true,
         showDropdowns: true
      });

      $('.by_modul_edate_created').on('apply.daterangepicker', function(ev, picker) {
         $(this).val(picker.startDate.format('DD/MMM/YYYY'));
         $('#form-by-modul').find('input[name="by_modul_edate_created"]').val(picker.startDate.format('YYYY-MM-DD'));
      });

      $('.by_modul_sdate_expired').daterangepicker({
         parentEl : '#modal-param-date',
         autoUpdateInput: false,
         locale: {
            format: 'DD/MMM/YYYY'
         },
         singleDatePicker: true,
         showDropdowns: true
      });

      $('.by_modul_sdate_expired').on('apply.daterangepicker', function(ev, picker) {
         $(this).val(picker.startDate.format('DD/MMM/YYYY'));
         $('#form-by-modul').find('input[name="by_modul_sdate_expired"]').val(picker.startDate.format('YYYY-MM-DD'));
      });

      $('.by_modul_edate_expired').daterangepicker({
         parentEl : '#modal-param-date',
         autoUpdateInput: false,
         locale: {
            format: 'DD/MMM/YYYY'
         },
         singleDatePicker: true,
         showDropdowns: true
      });

      $('.by_modul_edate_expired').on('apply.daterangepicker', function(ev, picker) {
         $(this).val(picker.startDate.format('DD/MMM/YYYY'));
         $('#form-by-modul').find('input[name="by_modul_edate_expired"]').val(picker.startDate.format('YYYY-MM-DD'));
      });



      $(this).on('click', '.set-empty',function(e){
         var target = $(this).data('target');
         $('#form-by-modul').find('#'+target+'').val('');
         $('#form-by-modul').find('.'+target+'').val('');
      });

      // $('.all_modul_sdate_created').daterangepicker({
      //    autoUpdateInput: false,
      //    locale: {
      //       format: 'DD/MMM/YYYY'
      //    },
      //    singleDatePicker: true,
      //    showDropdowns: true
      // });

      // $('.all_modul_sdate_created').on('apply.daterangepicker', function(ev, picker) {
      //    $(this).val(picker.startDate.format('DD/MMM/YYYY'));
      //    $('#form-by-all').find('input[name="all_modul_sdate_created"]').val(picker.startDate.format('YYYY-MM-DD'));
      // });

      // $('.all_modul_edate_created').daterangepicker({
      //    autoUpdateInput: false,
      //    locale: {
      //       format: 'DD/MMM/YYYY'
      //    },
      //    singleDatePicker: true,
      //    showDropdowns: true
      // });

      // $('.all_modul_edate_created').on('apply.daterangepicker', function(ev, picker) {
      //    $(this).val(picker.startDate.format('DD/MMM/YYYY'));
      //    $('#form-by-all').find('input[name="all_modul_edate_created"]').val(picker.startDate.format('YYYY-MM-DD'));
      // });

	});
</script>