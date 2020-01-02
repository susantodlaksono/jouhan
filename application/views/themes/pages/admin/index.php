<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="<?php echo config_item('app_desc');?>" />
        <meta name="author" content="<?php echo config_item('app_author')?>" />
        <link href="<?php echo base_url('favicon.png'); ?>" rel="shortcut icon"/>
        <title>EB CARRIER | Administrator Page</title>
        
	    <?php
        $this->load->view('themes/pages/admin/_css');
        $this->load->view('themes/pages/admin/css');
        ?>
        <style type="text/css">
            .btn-danger{
                background-color: #f11818;
            }
            .text-danger{
                color: #f11818 !important;
            }
            .bg-danger{
                background-color: #f11818;
            }
        </style>
	    <script src="<?php echo base_url('assets/plugins/jquery/jquery-1.11.1.min.js') ?>" type="text/javascript"></script>
    </head>
	<body class="fixed-header windows menu-behind desktop pace-done horizontal-menu">

		<div class="loading"></div>
        <?php $this->load->view('themes/pages/admin/nav'); ?>
		<div class="page-container">
			<?php $this->load->view('themes/pages/admin/header'); ?>
			
			<div class="page-container">
        		<div class="page-content-wrapper">
        			<div class="content">
			            <div class="container-fluid container-fixed-lg" id="container-content"></div>
		          	</div>
                </div>
    		</div>
		</div>
        <input type="hidden" id="csrf" value="<?php echo $this->security->get_csrf_hash(); ?>">
        
		<?php
        $this->load->view('themes/pages/admin/js');
        $this->load->view('themes/pages/admin/_js');
        ?>

        <script>
		    var site_url = '<?php echo site_url(); ?>';
            var base_url = '<?php echo base_url(); ?>';
		    var loading = '<h5 class="font-arial" style="font-size:15px;"></h5>';
		</script>

        <script type="text/javascript">

        	$(function () {
                <?php if($role_id == 1){ ?>
                    Widget.Loader('dashboard_admin', {}, 'container-content', true);
                <?php }else if($role_id == 3){ ?>
                    Widget.Loader('dashboard_evaluator', {}, 'container-content', true);
                <?php } ?>

        		$(this).on('click', '.menu-items a', function(e) {
        			var url = $(this).attr('href');
                    if(url == 'javascript:;'){
                        return false;
                    }else{
                        Widget.Loader(url, {}, 'container-content');
                    }
        			e.preventDefault();
        		});
        	});
        </script>
	</body>
</html>