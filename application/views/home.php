<?php $this->load->view("partial/header"); ?>
<br />

<div id="home_module_list">
<div class="row">

	<?php
	$panels = array('panel-green','panel-yellow','panel-red','panel-primary','panel-warning');
	$count = 1;
	foreach($allowed_modules->result() as $module)
	{
		
	?>
    	<div class="col-lg-4 col-md-6">
                    <div class="panel <?php echo $panels[$count];?>">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa <?php echo menu_icon($module->module_id)?> fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $this->lang->line("module_".$module->module_id) ?></div>
                                    <div class="small"><?php echo $this->lang->line('module_'.$module->module_id.'_desc');?></div>
                                </div>
                            </div>
                        </div>
                        <a href="<?php echo site_url("$module->module_id");?>">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
    
<!--		<div class="module_item">
			<a href="<?php echo site_url("$module->module_id");?>">
			<img src="<?php echo base_url().'images/menubar/'.$module->module_id.'.png';?>" border="0" alt="Menubar Image" /></a><br />
			<a href="<?php echo site_url("$module->module_id");?>"><?php echo $this->lang->line("module_".$module->module_id) ?></a>
			 - <?php echo $this->lang->line('module_'.$module->module_id.'_desc');?>
		</div>-->
	<?php
	$count++;
	if($count%5 == 0)
		$count = 0;
	}
	?>
</div>
<?php $this->load->view("partial/footer"); ?>