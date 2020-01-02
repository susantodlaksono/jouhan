<style type="text/css">
   .label{
      font-size: 13px;
   }
   .label + .label{
      margin-left: 0px;  
      margin-top: 5px;       
   }
   .label{
      margin-right: 2px;
   }
</style>

<ul class="nav nav-tabs bordered">
   <li class="active">
      <a href="#tab-summary" data-toggle="tab">
         <span class="visible-xs"><i class="fa fa-credit-card"></i></span>
         <span class="hidden-xs">Summary</span>
      </a>
   </li>
   <li>
      <a href="#tab-log" data-toggle="tab">
         <span class="visible-xs"><i class="entypo-home"></i></span>
         <span class="hidden-xs">Today Activity</span>
      </a>
   </li>
</ul>
<div class="tab-content">
   <div class="tab-pane active" id="tab-summary">
      <div class="row">
         <div class="col-md-12">
            <div class="form-group">
               <select class="form-control" id="user_id">
                  <option value="">All User</option>
                  <?php
                     foreach ($users as $v) {
                        echo '<option value="'.$v['id'].'">'.$v['first_name'].'</option>';
                     }
                  ?>
               </select>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-md-2">
            <div class="panel panel-primary" data-collapsed="0">
               <div class="panel-heading">
                  <div class="panel-title"><i class="fa fa-credit-card"></i> Simcard & Rak</div>
               </div>
               <div class="panel-body" id="widget-simcard-summary"></div>
            </div>
            <div class="panel panel-primary" data-collapsed="0">
               <div class="panel-heading">
                  <div class="panel-title"><i class="fa fa-envelope"></i> Email</div>
               </div>
               <div class="panel-body" id="widget-email-summary"></div>
            </div>
         </div>
         <div class="col-md-10">
            <div class="col-md-12">
               <div class="panel panel-primary" data-collapsed="0">
                  <div class="panel-heading">
                     <div class="panel-title text-info" style="color:#5fade6;"><i class="fa fa-twitter"></i> Twitter</div>
                  </div>
                  <div class="panel-body" id="widget-twitter-summary"></div>
               </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-primary" data-collapsed="0">
                  <div class="panel-heading">
                     <div class="panel-title" style="color:#3983b9;"><i class="fa fa-facebook"></i> Facebook</div>
                  </div>
                  <div class="panel-body" id="widget-facebook-summary"></div>
               </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-primary" data-collapsed="0">
                  <div class="panel-heading">
                     <div class="panel-title" style="color: #b72727;"><i class="fa fa-instagram"></i> Instagram</div>
                  </div>
                  <div class="panel-body" id="widget-instagram-summary"></div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="tab-pane" id="tab-log">
      <div class="row" style="margin-top: 10px;padding-bottom:10px;border-bottom: 1px solid #efefef;">
         <div class="col-md-3" style="">
            <h1 class="text-center bold" id="show_number">0</h1>
            <h4 class="text-center">New Number Card</h4>
         </div>
         <div class="col-md-9" style="margin-top: 10px;" id="name0">
         </div>
      </div>
      <div class="row" style="border-bottom: 1px solid #efefef;padding-bottom:10px;">
         <div class="col-md-3" style="">
            <h1 class="text-center bold" id="show_email">0</h1>
            <h4 class="text-center">New Email</h4>
         </div>
         <div class="col-md-9" style="margin-top: 10px;">
            <h4 class="bold">Created</h4>
            <div class="col-md" style="margin-top: 10px;" id="name1">

            </div>
         </div>
      </div>
      <div class="row" style="border-bottom: 1px solid #efefef;padding-bottom:10px;">
         <div class="col-md-3" style="">
            <h1 class="text-center bold" id="show_facebook">0</h1>
            <h4 class="text-center">New Facebook</h4>
         </div>
         <div class="col-md-9" style="margin-top: 10px;">
            <h4 class="bold">Created</h4>
            <div class="col-md" style="margin-top: 10px;" id="name2">

            </div>
         </div>
      </div>
      <div class="row" style="border-bottom: 1px solid #efefef;padding-bottom:10px;">
         <div class="col-md-3" style="">
            <h1 class="text-center bold" id="show_twitter">0</h1>
            <h4 class="text-center">New Twitter</h4>
         </div>
         <div class="col-md-9" style="margin-top: 10px;">
            <h4 class="bold">Created</h4>
            <div class="col-md" style="margin-top: 10px;" id="name3">

            </div>
         </div>
      </div>
      <div class="row" style="border-bottom: 1px solid #efefef;padding-bottom:10px;">
         <div class="col-md-3" style="">
            <h1 class="text-center bold" id="show_instagram">0</h1>
            <h4 class="text-center">New Instagram</h4>
         </div>
         <div class="col-md-9" style="margin-top: 10px;">
            <h4 class="bold">Created</h4>
            <div class="col-md" style="margin-top: 10px;" id="name4">

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
   	// Widget.Loader('all_summary', {
   	// 	sdate: null,
   	// 	edate: null,
   	// }, 
   	// 'widget-all-summary');

      $(this).on('change', '#user_id', function(e){
         var user_id = $(this).val();
          Widget.Loader(
            'twitter_summary',
            {
               user_id : user_id
            },
            'widget-twitter-summary'
         );
         Widget.Loader(
            'facebook_summary',
            {
               user_id : user_id
            },
            'widget-facebook-summary'
         );
         Widget.Loader(
            'instagram_summary',
            {
               user_id : user_id
            },
            'widget-instagram-summary'
         );
         Widget.Loader(
            'simcard_summary',
            {
               user_id : user_id
            },
            'widget-simcard-summary'
         );
         Widget.Loader(
            'email_summary',
            {
               user_id : user_id
            },
            'widget-email-summary'
         );
      });
      
      Widget.Loader(
         'simcard_summary',
         {
            user_id : ''
         },
         'widget-simcard-summary'
      );
      Widget.Loader(
         'email_summary',
         {
            user_id : ''
         },
         'widget-email-summary'
      );
      // Widget.Loader(
      //    'socmed_summary',
      //    {},
      //    'widget-socmed-summary'
      // );
      Widget.Loader(
         'twitter_summary',
         {
            user_id : ''
         },
         'widget-twitter-summary'
      );
      Widget.Loader(
         'facebook_summary',
         {
            user_id : ''
         },
         'widget-facebook-summary'
      );
      Widget.Loader(
         'instagram_summary',
         {
            user_id : ''
         },
         'widget-instagram-summary'
      );

      $.fn.render_data  = function(params){
         ajaxManager.addReq({
            type : "GET",
            url : "<?php echo base_url('index.php/security/get_count')?>",
            dataType : "JSON",
            data : { },
            success : function(r){
               var i=0;
               var a='<h4 class="bold">Created</h4>'; 
               var b=''; 
               var c=''; 
               var d=''; 
               var e=''; 
               
               $.each(r.data.data.simcards, function(key,value){
                  a+='<span class="label label-primary" >'+value.name+' : '+value.subtot+'</span>';
                  // i++;
                  // if(i%6==0){
                  //    a+='<br><br>';
                  // }
               });
               $.each(r.data.data.emails, function(key,value){
                  b+='<span class="label label-primary" >'+value.name+' : '+value.subtot+'</span>';
               });
               $.each(r.data.data.facebooks, function(key,value){
                  c+='<span class="label label-primary" >'+value.name+' : '+value.subtot+'</span>';
               });
               $.each(r.data.data.twitters, function(key,value){
                  d+='<span class="label label-primary" >'+value.name+' : '+value.subtot+'</span>';
               });
               $.each(r.data.data.instagrams, function(key,value){
                  e+='<span class="label label-primary" >'+value.name+' : '+value.subtot+'</span>';
               });

               $('#name0').html(a);
               $('#name1').html(b);
               $('#name2').html(c);
               $('#name3').html(d);
               $('#name4').html(e);
               
               $('#show_number').html(r.data.total.simcards.totals);
               $('#show_email').html(r.data.total.emails.totals);
               $('#show_facebook').html(r.data.total.facebooks.totals);
               $('#show_twitter').html(r.data.total.twitters.totals);
               $('#show_instagram').html(r.data.total.instagrams.totals);
            }
         });
      };

      $(this).render_data();
	});

</script>