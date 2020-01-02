<div id="<?php echo $widget_name ?>_<?php echo $uniqid ?>"> 
	<div class="row">
		<div class="col-sm-4 col-xs-6">
			<div class="tile-stats tile-aqua">
				<div class="icon"><i class="fa fa-user"></i></div>
				<div class="num"><?php echo number_format($twitter['total_acc'], 0, false, "."); ?></div>
				<h3>Total Twitter</h3>
			</div>
		</div>
		<div class="col-sm-4 col-xs-6">
			<div class="tile-stats tile-aqua">
				<div class="icon"><i class="fa fa-users"></i></div>
				<div class="num"><?php echo number_format($facebook['total_acc'], 0, false, "."); ?></div>
				<h3>Total Facebook</h3>
			</div>
		</div>
		<div class="col-sm-4 col-xs-6">
			<div class="tile-stats tile-aqua">
				<div class="icon"><i class="fa fa-line-chart"></i></div>
				<div class="num"><?php echo number_format($instagram['total_acc'], 0, false, "."); ?></div>
				<h3>Total Instagram</h3>
			</div>
		</div>
	</div>
</div>