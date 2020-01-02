<div id="<?php echo $widget_name ?>_<?php echo $uniqid ?>"> 
	<div class="col-md-2" style="">
      <div class="description-apply text-center">
         <h1 class="no-margin bold"><?php echo number_format($data['total_acc'], 0, false, "."); ?></h1>
         <div class="description-text bold">Total Account</div>
      </div>
	</div>
	<div class="col-md-2" style="">
      <div class="description-apply text-center">
         <h1 class="no-margin bold" style="color:green;"><?php echo number_format($ready, 0, false, "."); ?></h1>
         <div class="description-text bold" style="color:green;">Ready</div>
      </div>
	</div>
	<div class="col-md-2" style="">
      <div class="description-apply text-center">
         <h1 class="no-margin bold" style="color:orange;"><?php echo number_format($check, 0, false, "."); ?></h1>
         <div class="description-text bold" style="color:orange;">Check</div>
      </div>
	</div>
	<div class="col-md-2" style="">
      <div class="description-apply text-center">
         <h1 class="no-margin bold" style="color:green;"><?php echo number_format($active, 0, false, "."); ?></h1>
         <div class="description-text bold" style="color:green;">Active</div>
      </div>
	</div>
	<div class="col-md-2" style="">
      <div class="description-apply text-center">
         <h1 class="no-margin bold" style="color:red;"><?php echo number_format($suspended, 0, false, "."); ?></h1>
         <div class="description-text bold" style="color:red;">Suspended</div>
      </div>
	</div>
	<div class="col-md-2" style="">
      <div class="description-apply text-center">
         <h1 class="no-margin bold" style="color:red;"><?php echo number_format($locked, 0, false, "."); ?></h1>
         <div class="description-text bold" style="color:red;">Locked</div>
      </div>
	</div>
</div>
<!-- <div id="<?php echo $widget_name ?>_<?php echo $uniqid ?>"> 
	<div class="row">
		<div class="col-sm-4 col-xs-4">
			<div class="tile-stats tile-aqua">
				<div class="icon"><i class="fa fa-user"></i></div>
				<div class="num"><?php echo number_format($data['total_acc'], 0, false, "."); ?></div>
				<h3>Total Account</h3>
			</div>
		</div>
		<div class="col-sm-4 col-xs-4">
			<div class="tile-stats tile-aqua">
				<div class="icon"><i class="fa fa-users"></i></div>
				<div class="num">
					<?php 
						$sum = $data['total_followers'];
						if($sum == null){
							$sum = '0';
						}
						echo number_format($sum, 0, false, ".");;
					?>	
				</div>
				<h3>Total Followers</h3>
			</div>
		</div>
		<div class="col-sm-4 col-xs-4">
			<div class="tile-stats tile-aqua">
				<div class="icon"><i class="fa fa-line-chart"></i></div>
				<div class="num">
					<?php 
						$avg = $data['avg_followers'];
						if($avg == null){
							$avg = '0';
						}
						echo number_format($avg, 0, false, ".");
					?>	
				</div>
				<h3>Average Followers</h3>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-4 col-xs-4">
			<div class="tile-stats tile-aqua">
				<div class="icon"><i class="fa fa-minus"></i></div>
				<div class="num"><?php echo number_format($status0['total'], 0, false, "."); ?></div>
				<h3>Total No Action</h3>
			</div>
		</div>
		<div class="col-sm-4 col-xs-4">
			<div class="tile-stats tile-aqua">
				<div class="icon"><i class="fa fa-check"></i></div>
				<div class="num"><?php echo number_format($status1['total'], 0, false, "."); ?></div>
				<h3>Total Active</h3>
			</div>
		</div>
		<div class="col-sm-4 col-xs-4">
			<div class="tile-stats tile-aqua">
				<div class="icon"><i class="fa fa-remove"></i></div>
				<div class="num"><?php echo number_format($status2['total'], 0, false, "."); ?></div>
				<h3>Total Blocked</h3>
			</div>
		</div>
		<div class="col-sm-4 col-xs-4">
			<div class="tile-stats tile-aqua">
				<div class="icon"><i class="fa fa-user"></i></div>
				<div class="num"><?php echo number_format($available, 0, false, "."); ?></div>
				<h3>Available Account</h3>
			</div>
		</div>
	</div>
</div> -->