<div id="<?php echo $widget_name ?>_<?php echo $uniqid ?>"> 
	<div class="col-md-3" style="">
      <div class="description-apply text-center">
         <h1 class="no-margin bold"><?php echo number_format($data['total_acc'], 0, false, "."); ?></h1>
         <div class="description-text bold">Total Account</div>
      </div>
   </div>
   <div class="col-md-3" style="">
      <div class="description-apply text-center">
         <h1 class="no-margin bold" style="color:green;"><?php echo number_format($ready, 0, false, "."); ?></h1>
         <div class="description-text bold" style="color:green;">Ready</div>
      </div>
  	</div>
	<div class="col-md-3" style="">
      <div class="description-apply text-center">
         <h1 class="no-margin bold" style="color:green;"><?php echo number_format($active, 0, false, "."); ?></h1>
         <div class="description-text bold text-success" style="color:green;">Total Active</div>
      </div>
   </div>
   <div class="col-md-3" style="">
      <div class="description-apply text-center">
         <h1 class="no-margin bold" style="color:red;"><?php echo number_format($blocked, 0, false, "."); ?></h1>
         <div class="description-text bold" style="color:red;">Total Blocked</div>
      </div>
  	</div>
</div>