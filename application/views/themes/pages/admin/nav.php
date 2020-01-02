<style type="text/css">
  /*.page-sidebar a{
    color:red;
  }*/
</style>

<nav class="page-sidebar" data-pages="sidebar">
	<div class="sidebar-header">
        <img src="<?php echo base_url('assets/img/logo_white.png') ?>" alt="logo" class="brand" data-src="<?php echo base_url('assets/img/logo_white.png') ?>" width="78" height="22">
        <div class="sidebar-header-controls">
          <button type="button" class="btn btn-xs sidebar-slide-toggle btn-link m-l-20" data-pages-toggle="#appMenu"><i class="fa fa-angle-down fs-16"></i>
          </button>
          <button type="button" class="btn btn-link visible-lg-inline" data-toggle-pin="sidebar"><i class="fa fs-12"></i>
          </button>
        </div>
  	</div>
  	<div class="sidebar-menu">
  		<!-- <ul class="menu-items">
  			<li class="m-t-30 ">
          <a href="index.html" class="detailed">
            <span class="title">Dashboard</span>
            <span class="details">12 New Updates</span>
          </a>
          <span class="bg-success icon-thumbnail"><i class="pg-home"></i></span>
      	</li>
  		</ul> -->
      <?php
         echo Modules::run('base_menu');
      ?>
  		<div class="clearfix"></div>
  	</div>
</nav>