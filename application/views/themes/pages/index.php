<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="<?php echo config_item('app_desc');?>" />
        <meta name="author" content="<?php echo config_item('app_author')?>" />
        <title>EB CARRIER | Administrator Page</title>
        
	    <?php
        $this->load->view('themes/pages/_css');
        $this->load->view('themes/pages/css');
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
		<div class="loading" style="display:none;">
            <h4>Please Wait...</h4>
        </div>
        <?php $this->load->view('themes/pages/nav'); ?>
		<div class="page-container">
			<?php $this->load->view('themes/pages/header'); ?>
			
			<div class="page-container" style="height: auto;">
        		<div class="page-content-wrapper content-builder active full-height">
        			<div class="content" style="background-color: white;">
			            <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20" id="container-content">
			               <?php
	                        // if(isset($content) && $content){
	                        //     $this->load->view('page/' . $content);
	                        // }
	                        ?>
			            </div>
		          	</div>
		          	<?php $this->load->view('themes/pages/footer'); ?>
		        </div>
    		</div>
		</div>
		<?php
        $this->load->view('themes/pages/js');
        $this->load->view('themes/pages/_js');
        ?>

        <script>
		    var site_url = '<?php echo site_url(); ?>';
		    var base_url = '<?php echo base_url(); ?>';
		</script>

        <script type="text/javascript">

            function status_name(status, style){
                switch(status){
                    case '1':
                        return '<span class="label label-success" '+style+'>In Progress</span>';
                    break;
                    case '2':
                        return '<span class="label label-info" '+style+'>Done</span>';
                    break;
                    case '6':
                        return '<span class="label label-warning" '+style+'>Open</span>';
                    break;
                    case '7':
                        return '<span class="label label-danger" '+style+'>Issue</span>';
                    break;
                    default:
                        return '<span class="label label-default">None</span>';
                }
            }

        	$(function () {
        		// Widget.Loader('dashboard', {}, 'container-content');

        		$(this).on('click', '.menu-items a', function(e) {
        			var url = $(this).attr('href');
    				Widget.Loader(url, {}, 'container-content');
        			e.preventDefault();
        		});
        	});
        </script>
	</body>
</html>