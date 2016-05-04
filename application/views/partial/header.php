<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<base href="<?php echo base_url();?>" />
	<title><?php echo $this->config->item('company');?></title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>
    <link href="css/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
     <link href="css/sb-admin-2.css" rel="stylesheet">
     <link href="css/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="css/ospos.css"/>
	<link rel="stylesheet" type="text/css" href="css/ospos_print.css" media="print" />

	<script type="text/javascript" src="js/jquery-1.8.3.js" language="javascript"></script>
	<script type="text/javascript" src="js/jquery-ui-1.11.4.js" language="javascript"></script>
	<script type="text/javascript" src="js/jquery-ui-timepicker-addon.js" language="javascript"></script>
	<script type="text/javascript" src="js/jquery.ajax_queue.js" language="javascript"></script>
	<script type="text/javascript" src="js/jquery.autocomplete.js" language="javascript"></script>
	<script type="text/javascript" src="js/jquery.bgiframe.min.js" language="javascript"></script>
	<script type="text/javascript" src="js/jquery.color.js" language="javascript"></script>
	<script type="text/javascript" src="js/jquery.form-3.51.js" language="javascript"></script>
	<script type="text/javascript" src="js/jquery.jkey-1.1.js" language="javascript"></script>
	<script type="text/javascript" src="js/jquery.metadata.js" language="javascript"></script>
	<script type="text/javascript" src="js/jquery.tablesorter-2.20.1.js" language="javascript"></script>
	<script type="text/javascript" src="js/jquery.tablesorter.staticrow.js" language="javascript"></script>
	<script type="text/javascript" src="js/jquery.validate-1.13.1-min.js" language="javascript"></script>
	<script type="text/javascript" src="js/common.js" language="javascript"></script>
	<script type="text/javascript" src="js/date.js" language="javascript"></script>
	<script type="text/javascript" src="js/imgpreview.full.jquery.js" language="javascript"></script>
	<script type="text/javascript" src="js/manage_tables.js" language="javascript"></script>
	<script type="text/javascript" src="js/nominatim.autocomplete.js" language="javascript"></script>
	<script type="text/javascript" src="js/swfobject.js" language="javascript"></script>
	<script type="text/javascript" src="js/tabcontent.js" language="javascript"></script>
	<script type="text/javascript" src="js/thickbox.js" language="javascript"></script>
    <script type="text/javascript" src="js/shortcut.js" language="javascript"></script>

	<script type="text/javascript">
		function logout(logout)
		{
			logout = logout;
			if (logout && confirm("Do you really want to logout"))
			{
				//window.location = "<?php echo site_url('config/backup_db'); ?>";
				window.location = "<?php echo site_url('home/logout'); ?>";
			}
		}
	</script>	
<style type="text/css">
html {
    overflow: auto;
}
</style>

</head>

<body>
<div id="wrapper">
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php"><?php echo $this->config->item('company'); ?><span class="small"> Point of sale (Powerd by IDLBridge)  
                
                 
                </span></a>
               
               
                
            </div>
            
            <!-- /.navbar-header -->
				
            <ul class="nav navbar-top-links navbar-right">
           		 <li>
                 	 <a href="<?=site_url($controller_name . '/manage')?>" class="btn btn-warning"><i class="fa fa-list-alt"></i> <?php echo $this->lang->line('sales_takings'); ?></a>
              	 </li>
            	 <li>
                    <?php echo anchor("sales/suspended/width:400",
					'<i class="fa fa-history"></i> '.
                    $this->lang->line('sales_suspended_sales'),
                    array('class'=>'btn btn-success ', 'title'=>$this->lang->line(' sales_suspended_sales')));
                    ?>
                </li>
            	<li>
                <strong><?php echo date($this->config->item('dateformat')) ?></strong>
                </li>
                <li>
                    <a href="javascript:logout(true);">
                        <i class="fa fa-user fa-fw"></i> Logout
                    </a>
                </li>
                
            </ul>
            <!-- /.navbar-top-links -->
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                        	<?php echo $this->lang->line('common_welcome')." $user_info->first_name $user_info->last_name "; ?>
                            
                            <!-- /input-group -->
                        </li>
                        
                         <li>
                            <a href="index.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <?php
						
						foreach($allowed_modules->result() as $module)
						{
						?>
							<li>
								<a href="<?php echo site_url("$module->module_id");?>" class="<?php echo activate_menu($module->module_id); ?>"><i class="fa <?php echo menu_icon($module->module_id)?> fa-fw"></i> <?php echo $this->lang->line("module_".$module->module_id) ?>
								</a>
							</li>
						<?php
						}
						?>
                        <li>
                        	</br>
                        </li>
                       <li>
                        	<p class="alert-danger">&nbsp; Shortcuts <br/>
                             &nbsp; Add Payment (Ctrl+Shift+z)<br/>
                             &nbsp; Complete Sale (Ctrl+Shift+s)
                            </p>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

<div id="page-wrapper">
	<div id="content_area_wrapper">
	<div id="content_area">
 