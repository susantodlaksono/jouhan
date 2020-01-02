<div id="<?php echo $widget_name ?>_<?php echo $uniqid ?>">
	<div class="col-md-12">
		<div class="col-md-12">
			<div class="panel panel-primary" data-collapsed="0">
        		<div class="panel-heading">
        			<div class="panel-title"><i class="fa fa-credit-card"></i> Check</div>
        		</div>
        		<div class="col-md-5" style="">
        			<div class="description-apply text-center">
      				   <h1 class="no-margin bold" style="color:green;"><?php echo number_format($errorApp, 0, false, "."); ?></h1>
      				   <div class="description-text bold" style="color:green;">Error Apps</div>
      				</div>
      			</div>
        			<div class="description-apply text-center">
      				   <h1 class="no-margin bold" style="color:green;"><?php echo number_format($errorProx, 0, false, "."); ?></h1>
      				   <div class="description-text bold" style="color:green;">Error Proxy</div>
      				</div>
      		</div>
      	</div>
      	<div class="col-md-12">
			<div class="panel panel-primary" data-collapsed="0">
        		<div class="panel-heading">
        			<div class="panel-title"><i class="fa fa-credit-card"></i> Active</div>
        		</div>
        		<div class="col-md-5" style="">
        			<div class="description-apply text-center">
    				    <h1 class="no-margin bold" style="color:orange;"><?php echo number_format($growFoll, 0, false, "."); ?></h1>
    				    <div class="description-text bold" style="color:orange;">Grow Followers</div>
    				</div>
      			</div>
      			<div class="description-apply text-center">
      				   <h1 class="no-margin bold" style="color:green;"><?php echo number_format($ncheck, 0, false, "."); ?></h1>
      				   <div class="description-text bold" style="color:green;">Need Check</div>
      			</div>
      		</div>
      	</div>
      	<div class="col-md-12">
			<div class="panel panel-primary" data-collapsed="0">
        		<div class="panel-heading">
        			<div class="panel-title"><i class="fa fa-credit-card"></i> Suspended</div>
        		</div>
        		<div class="col-md-5" style="">
      				<div class="description-apply text-center">
      				   <h1 class="no-margin bold" style="color:red;"><?php echo number_format($suspendFa, 0, false, "."); ?></h1>
      				   <div class="description-text bold" style="color:red;">Suspended-File an Appreal</div>
      				</div>
      			</div>
			    <div class="description-apply text-center">
			        <h1 class="no-margin bold" style="color:red;"><?php echo number_format($nckQua, 0, false, "."); ?></h1>
			        <div class="description-text bold" style="color:red;">Need Check-Quarantine</div>
			    </div>
      		</div>
      	</div>
      	<div class="col-md-12">
			<div class="panel panel-primary" data-collapsed="0">
        		<div class="panel-heading">
        			<div class="panel-title"><i class="fa fa-credit-card"></i> Locked</div>
        		</div>
        		<div class="col-md-3" style="">
			      <div class="description-apply text-center">
			         <h1 class="no-margin bold" style="color:red;"><?php echo number_format($gocap, 0, false, "."); ?></h1>
			         <div class="description-text bold" style="color:red;">Google Captcha</div>
			      </div>
      			</div>
      			<div class="col-md-3" style="">
			      <div class="description-apply text-center">
			         <h1 class="no-margin bold" style="color:red;"><?php echo number_format($smsV, 0, false, "."); ?></h1>
			         <div class="description-text bold" style="color:red;">Sms Verification</div>
			      </div>
			    </div>
			    <div class="col-md-3" style="">
			      <div class="description-apply text-center">
			         <h1 class="no-margin bold" style="color:red;"><?php echo number_format($cll, 0, false, "."); ?></h1>
			         <div class="description-text bold" style="color:red;">Call Me</div>
			      </div>
			    </div>
			      <div class="description-apply text-center">
			         <h1 class="no-margin bold" style="color:red;"><?php echo number_format($tmp, 0, false, "."); ?></h1>
			         <div class="description-text bold" style="color:red;">Temporary</div>
			      </div>
      		</div>
      	</div>
      </div>
</div>