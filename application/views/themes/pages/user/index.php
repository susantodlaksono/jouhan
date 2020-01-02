<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="<?php echo config_item('app_desc');?>" />
        <meta name="author" content="<?php echo config_item('app_author')?>" />
        <link href="<?php echo base_url('favicon.png'); ?>" rel="shortcut icon"/>
        <title>EB CAREER</title>
        
	    <?php
        $this->load->view('themes/pages/user/_css');
        $this->load->view('themes/pages/user/css');
        ?>
        <style type="text/css">
            .table.table-condensed tbody tr td{
                white-space: unset;
                overflow: unset;
            }
        </style>

	    <script src="<?php echo base_url('assets/plugins/jquery/jquery-1.11.1.min.js') ?>" type="text/javascript"></script>
    </head>
	<body class="fixed-header windows menu-behind desktop pace-done horizontal-menu"><!-- fixed-header   windows desktop pace-done menu-behind -->
		<div class="loading" style="display:none;"><h4>Please Wait...</h4></div>
        
        <?php $this->load->view('themes/pages/user/nav'); ?>

        <div class="page-container">
            <?php $this->load->view('themes/pages/user/header'); ?>
            <div class="page-container" style="min-height: 120px;">
                <div class="page-content-wrapper content-builder active full-height">
                    <div class="content" style="background-color: white;">
                        <div class="container-fluid container-fixed-lg" id="container-content" style="min-height: 590px;"></div>
                    </div>
                </div>
            </div>
        </div>
        
        <input type="hidden" id="csrf" value="<?php echo $this->security->get_csrf_hash(); ?>">
        
        <?php
            $this->load->view('themes/pages/user/js');
            $this->load->view('themes/pages/user/_js');
        ?>

        <script>
		    var site_url = '<?php echo site_url(); ?>';
            var base_url = '<?php echo base_url(); ?>';
		</script>

        <script type="text/javascript">
        	$(function () {
        		Widget.Loader('dashboard', {}, 'container-content', false);
        	});
        </script>
	</body>
</html>