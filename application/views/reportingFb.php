<div class="container">
   <div class="row" style="text-align: center">

<!-- wadah -->
<!--  -->

   <!-- facebook fanspage -->
   <div class="col-md-6 col-centered">
      <div class="panel panel-primary" data-collapsed="0">
         <div class="panel-heading">
            <div class="panel-title"><i class="fa fa-file"></i> Reporting Facebook Fanpages</div>
         </div>
         <div class="panel-body">
            <div class="row">
               <div class="col-md-12">
                  <form method="get" action="<?php echo site_url().'index.php/reportFb/get' ?>" id="form-fb">
                     <div class="form-group">
                        <div class="row">
                           <div class="col-md-6">
                              <label>Start Date</label>
                              <input type="hidden" name="sdate_created" id="sdate_created">
                              <div class="input-group">
                                 <input type="text" class="form-control sdate_created">
                                 <div class="input-group-addon set-empty" data-target="sdate_created" style="cursor: pointer;"><i class="fa fa-eraser"></i></div>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <label>End Date</label>
                              <input type="hidden" name="edate_created" id="edate_created">
                              <div class="input-group">
                                 <input type="text" class="form-control edate_created">
                                 <div class="input-group-addon set-empty" data-target="edate_created" style="cursor: pointer;"><i class="fa fa-eraser"></i></div>
                              </div>
                           </div>
                        </div>
                     </div>
                    
                     <div class="form-group">
                        <button id="on_submit" class="btn btn-primary" type="submit">Submit</button>
                     </div>
                  </form>
               </div>
         
            </div>
         </div>
      </div>
   </div>
<!-- wadah -->
   </div>
</div>

<style type="text/css">
   .col-centered{
      display: inline-block;
      /*float: none;*/
      text-align: left;
      margin-right: -4px;
   }
</style>

<script type="text/javascript">
	$(function () {
		
		'use restrict';
		
		$('.choose').select2();


      $('.by_modul_sdate_created').daterangepicker({
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

////fb
      $('.sdate_created').daterangepicker({
         autoUpdateInput: false,
         locale: {
            format: 'DD/MMM/YYYY'
         },
         singleDatePicker: true,
         showDropdowns: true
      });

      $('.sdate_created').on('apply.daterangepicker', function(ev, picker) {
         $(this).val(picker.startDate.format('DD/MMM/YYYY'));
         $('#form-fb').find('input[name="sdate_created"]').val(picker.startDate.format('YYYY-MM-DD'));
      });

      $('.edate_created').daterangepicker({
         autoUpdateInput: false,
         locale: {
            format: 'DD/MMM/YYYY'
         },
         singleDatePicker: true,
         showDropdowns: true
      });

      $('.edate_created').on('apply.daterangepicker', function(ev, picker) {
         $(this).val(picker.startDate.format('DD/MMM/YYYY'));
         $('#form-fb').find('input[name="edate_created"]').val(picker.startDate.format('YYYY-MM-DD'));
      });

      
      $(this).on('click', '.set-empty',function(e){
         var target = $(this).data('target');
         $('#form-fb').find('#'+target+'').val('');
         $('#form-fb').find('.'+target+'').val('');
      });
  

	});
</script>