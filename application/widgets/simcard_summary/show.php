<div id="<?php echo $widget_name ?>_<?php echo $uniqid ?>">
	<div class="col-md-12" style="border-bottom: 1px solid #eaeaea;margin-bottom: 10px;">
      <div class="description-apply text-center">
         <h2 class="no-margin bold text-success" style="font-size: 21px;"><?php echo number_format($data['total_saldo'], 0, false, "."); ?></h2>
         <div class="description-text bold text-success">Total Saldo</div>
      </div>
   </div>
	<div class="col-md-12" style="border-bottom: 1px solid #eaeaea;margin-bottom: 10px;">
      <div class="description-apply text-center">
         <h2 class="no-margin bold"><?php echo number_format($data['total_acc'], 0, false, "."); ?></h2>
         <div class="description-text bold">Total Simcard</div>
      </div>
   </div>
   <div class="col-md-12" style="border-bottom: 1px solid #eaeaea;margin-bottom: 10px;">
      <div class="description-apply text-center">
         <h2 class="no-margin bold"><?php echo number_format($rak['total_rak'], 0, false, "."); ?></h2>
         <div class="description-text bold">Total RAK</div>
      </div>
   </div>
   <div class="col-md-12" style="border-bottom: 1px solid #eaeaea;margin-bottom: 10px;">
      <div class="description-apply text-center">
         <h2 class="no-margin bold text-success"><?php echo number_format($active, 0, false, "."); ?></h2>
         <div class="description-text bold text-success">Active</div>
      </div>
   </div>
   <div class="col-md-12" style="border-bottom: 1px solid #eaeaea;margin-bottom: 10px;">
      <div class="description-apply text-center">
         <h2 class="no-margin bold text-info" style="color:orange;"><?php echo number_format($top_up, 0, false, "."); ?></h2>
         <div class="description-text bold text-info" style="color:orange;">Need Top-up</div>
      </div>
   </div>
   <div class="col-md-12" style="">
      <div class="description-apply text-center">
         <h2 class="no-margin bold text-danger" style="color:red;"><?php echo number_format($expired, 0, false, "."); ?></h2>
         <div class="description-text bold text-danger" style="color:red;">C Number / Expired</div>
      </div>
   </div>
</div>
<!-- 
<div id="<?php echo $widget_name ?>_<?php echo $uniqid ?>">
	<div class="row">
		<div class="col-sm-4 col-xs-6">
			<div class="tile-stats tile-aqua">
				<div class="icon"><i class="fa fa-credit-card"></i></div>
				<div class="num"></div>
				<h3>Total SIMCARD</h3>
			</div>
		</div>
		<div class="col-sm-4 col-xs-6">
			<div class="tile-stats tile-aqua">
				<div class="icon"><i class="fa fa-server"></i></div>
				<div class="num"></div>
				<h3>Total RAK</h3>
			</div>
		</div>
		<div class="col-sm-4 col-xs-6">
			<div class="tile-stats tile-aqua">
				<div class="icon"><i class="fa fa-money"></i></div>
				<div class="num"><?php echo number_format($data['total_saldo'], 0, false, "."); ?></div>
				<h3>Total Saldo</h3>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-4 col-xs-6">
			<div class="tile-stats tile-aqua">
				<div class="icon"><i class="fa fa-check"></i></div>
				<div class="num"><?php echo number_format($reg['total'], 0, false, ".");  ?></div>
				<h3>SIMCARD Registered</h3>
			</div>
		</div>
		<div class="col-sm-4 col-xs-6">
			<div class="tile-stats tile-aqua">
				<div class="icon"><i class="fa fa-minus"></i></div>
				<div class="num"><?php echo number_format($unreg['total'], 0, false, "."); ?></div>
				<h3>SIMCARD Unregistered</h3>
			</div>
		</div>
		<div class="col-sm-4 col-xs-6">
			<div class="tile-stats tile-aqua">
				<div class="icon"><i class="fa fa-remove"></i></div>
				<div class="num"><?php echo number_format($blocked['total'], 0, false, ".");  ?></div>
				<h3>SIMCARD Blocked</h3>
			</div>
		</div>
	</div>
</div> -->