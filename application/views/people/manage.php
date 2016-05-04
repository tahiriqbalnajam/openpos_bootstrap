<?php $this->load->view("partial/header"); ?>
<script type="text/javascript">
$(document).ready(function() 
{ 
    init_table_sorting();
    enable_select_all();
    enable_row_selection();
    enable_search({ suggest_url : '<?php echo site_url("$controller_name/suggest")?>',
		confirm_search_message : '<?php echo $this->lang->line("common_confirm_search")?>'});
    enable_email('<?php echo site_url("$controller_name/mailto")?>');
    enable_delete('<?php echo $this->lang->line($controller_name."_confirm_delete")?>','<?php echo $this->lang->line($controller_name."_none_selected")?>');
});

function init_table_sorting()
{
	//Only init if there is more than one row
	if($('.tablesorter tbody tr').length >1)
	{
		$("#sortable_table").tablesorter(
		{ 
			sortList: [[1,0]], 
			headers: 
			{ 
				0: { sorter: false}, 
				5: { sorter: false} 
			} 

		}); 
	}
}

function post_person_form_submit(response)
{
	if(!response.success)
	{
		set_feedback(response.message,'error_message',true);	
	}
	else
	{
		//This is an update, just update one row
		if(jQuery.inArray(response.person_id,get_visible_checkbox_ids()) != -1)
		{
			update_row(response.person_id,'<?php echo site_url("$controller_name/get_row")?>');
			set_feedback(response.message,'success_message',false);	
			
		}
		else //refresh entire table
		{
			do_search(true,function()
			{
				//highlight new row
				hightlight_row(response.person_id);
				set_feedback(response.message,'success_message',false);		
			});
		}
	}
}
</script>

<div id="title_bar">
	<div id="title" class="float_left"><?php echo $this->lang->line('common_list_of').' '.$this->lang->line('module_'.$controller_name); ?></div>
	<div id="new_button">
		<?php echo anchor("$controller_name/view/-1/width:$form_width",
		"<div class='btn btn-danger' style='float: left;'><i class='fa fa-users'></i> <span>Add New Customer</span></div>",
		array('class'=>'thickbox none','title'=>$this->lang->line($controller_name.'_new')));
		?>
		<?php if ($controller_name =='customers') {?>
			<?php echo anchor("$controller_name/excel_import/width:$form_width",
			"<div class='btn btn-primary' style='float: left;'><i class='fa fa-arrow-circle-up'></i> <span>" . $this->lang->line('common_import_excel') . "</span></div>",
				array('class'=>'thickbox none','title'=>'Import Items from Excel'));
			?>	
		<?php } ?>
	</div>
</div>
<div id="pagination"><?= $links ?></div>
<div id="table_action_header">
	<ul>
    	<div class="btn btn-group">
		<li class="btn btn-danger"><i class="fa fa-trash-o"></i> <?php echo anchor("$controller_name/delete",$this->lang->line("common_delete"),array('id'=>'delete')); ?></li>
		<li class="btn btn-primary"><i class="fa fa-envelope "></i> <a href="#" id="email"> <?php echo $this->lang->line("common_email");?></a></li>
        </div>
		<li class="float_right">
		<img src='<?php echo base_url()?>images/spinner_small.gif' alt='spinner' id='spinner' />
		<?php echo form_open("$controller_name/search",array('id'=>'search_form')); ?>
		<input type="text" name ='search' id='search' class="form-control"/>
		<input type="hidden" name ='limit_from' id='limit_from'/>
		</form>
		</li>
	</ul>
</div>
<div id="table_holder">
<?php echo $manage_table; ?>
</div>
<div id="feedback_bar"></div>
<?php $this->load->view("partial/footer"); ?>
