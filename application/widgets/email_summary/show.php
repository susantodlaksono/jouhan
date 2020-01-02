<div id="<?php echo $widget_name ?>_<?php echo $uniqid ?>">
	<div class="col-md-12" style="border-bottom: 1px solid #eaeaea;margin-bottom: 10px;">
      <div class="description-apply text-center">
         <h2 class="no-margin bold"><?php echo number_format($data['total_acc'], 0, false, "."); ?></h2>
         <div class="description-text bold">Total Account</div>
      </div>
   </div>
	<div class="col-md-12" style="border-bottom: 1px solid #eaeaea;margin-bottom: 10px;">
      <div class="description-apply text-center">
         <h2 class="no-margin bold text-success" style="color:green;"><?php echo number_format($active, 0, false, "."); ?></h2>
         <div class="description-text bold text-success" style="color:green;">Total Active</div>
      </div>
   </div>
   <div class="col-md-12" style="">
      <div class="description-apply text-center">
         <h2 class="no-margin bold text-danger" style="color:red;"><?php echo number_format($blocked, 0, false, "."); ?></h2>
         <div class="description-text bold text-danger" style="color:red;">Total Blocked</div>
      </div>
   </div>
</div>
<!-- <div id="<?php echo $widget_name ?>_<?php echo $uniqid ?>"> 
	<div class="row">
		<div class="col-sm-4 col-xs-6">
			<div class="tile-stats tile-aqua">
				<div class="icon"><i class="fa fa-user"></i></div>
				<div class="num"><?php echo number_format($data['total_acc'], 0, false, "."); ?></div>
				<h3>Total Account</h3>
			</div>
		</div>
		<div class="col-sm-4 col-xs-6">
			<div class="tile-stats tile-aqua">
				<div class="icon"><i class="fa fa-check"></i></div>
				<div class="num"><?php echo number_format($active['total'], 0, false, "."); ?></div>
				<h3>Total Active</h3>
			</div>
		</div>
		<div class="col-sm-4 col-xs-6">
			<div class="tile-stats tile-aqua">
				<div class="icon"><i class="fa fa-remove"></i></div>
				<div class="num"><?php echo number_format($blocked['total'], 0, false, "."); ?></div>
				<h3>Total Blocked</h3>
			</div>
		</div>
	</div>
</div> -->