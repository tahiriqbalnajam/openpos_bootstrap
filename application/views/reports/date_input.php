<?php $this->load->view("partial/header"); ?>
<div id="page_title" style="margin-bottom:8px;"><?php echo $this->lang->line('reports_report_input'); ?></div>
<?php
if(isset($error))
{
	echo "<div class='error_message'>".$error."</div>";
}
?>
	<?php echo form_label($this->lang->line('reports_date_range'), 'report_date_range_label', array('class'=>'required')); ?>
	<div id='report_date_range_simple'>
		<input type="radio" name="report_type" id="simple_radio" value='simple' checked='checked'/>
		<?php echo form_dropdown('report_date_range_simple',$report_date_range_simple, '', 'id="report_date_range_simple" class="form-controll"'); ?>
	</div>
	
	<div id='report_date_range_complex'>
		<input type="radio" name="report_type" id="complex_radio" value='complex' />
		<span>
		<?php echo form_dropdown('start_month',$months, $selected_month, 'id="start_month" class="form-controll"'); ?>
		<?php echo form_dropdown('start_day',$days, $selected_day, 'id="start_day" class="form-controll"'); ?>
		<?php echo form_dropdown('start_year',$years, $selected_year, 'id="start_year" class="form-controll"'); ?>
		-
		<?php echo form_dropdown('end_month',$months, $selected_month, 'id="end_month" class="form-controll"'); ?>
		<?php echo form_dropdown('end_day',$days, $selected_day, 'id="end_day" class="form-controll"'); ?>
		<?php echo form_dropdown('end_year',$years, $selected_year, 'id="end_year" class="form-controll"'); ?>
		</span>
		<?php 
		if (isset($discount_input)) {
			?>
			<div>
				<span>
				<?php echo $this->lang->line('reports_discount_prefix') .'&nbsp;' .form_input(array(
					'name'=>'selected_discount',
					'id'=>'selected_discount',
					'value'=>'0')). '&nbsp;'. $this->lang->line('reports_discount_suffix')
				?>
				</span>
			</div>
			<?php
		}
		?>
	</div>
	
	<?php
	if($mode == 'sale')
    {
    ?>
    	<?php echo form_label($this->lang->line('reports_sale_type'), 'reports_sale_type_label', array('class'=>'required')); ?>
    	<div id='report_sale_type'>
    		<?php echo form_dropdown('sale_type',array('all' => $this->lang->line('reports_all'), 
    		'sales' => $this->lang->line('reports_sales'), 
    		'returns' => $this->lang->line('reports_returns')), 'all', 'id="input_type" class="form-controll"'); ?>
    	</div>
		<?php
    }
    elseif($mode == 'receiving')
    {
    ?>
        <?php echo form_label($this->lang->line('reports_receiving_type'), 'reports_receiving_type_label', array('class'=>'required')); ?>
        <div id='report_receiving_type'>
     	   <?php echo form_dropdown('receiving_type',array('all' => $this->lang->line('reports_all'),
        'receiving' => $this->lang->line('reports_receivings'), 
        'returns' => $this->lang->line('reports_returns'),
        'requisitions' => $this->lang->line('reports_requisitions')), 'all', 'id="input_type" class="form-controll"'); ?>
        </div>
		<?php
    }
	if (!empty($stock_locations) && count($stock_locations) > 1)
	{
		?>
		<?php echo form_label($this->lang->line('reports_stock_location'), 'reports_stock_location_label', array('class'=>'required')); ?>
		<div id='report_stock_location'>
			<?php echo form_dropdown('stock_location',$stock_locations,'all','id="location_id" class="form-controll"'); ?>
		</div>
		<?php
	}
    ?>
    <div class="clearfix">&nbsp;</div>
<?php
echo form_button(array(
	'name'=>'generate_report',
	'id'=>'generate_report',
	'content'=>$this->lang->line('common_submit'),
	'class'=>'btn btn-primary')
);
?>

<?php $this->load->view("partial/footer"); ?>

<script type="text/javascript" language="javascript">
$(document).ready(function()
{
	$("#generate_report").click(function()
	{		
		var input_type = $("#input_type").val();
		var location_id = $("#location_id").val();
		var location = window.location;
		if ($("#simple_radio").attr('checked'))
		{
			location += '/'+$("#report_date_range_simple option:selected").val() + '/' + input_type;
		}
		else
		{
			var start_date = $("#start_year").val()+'-'+$("#start_month").val()+'-'+$('#start_day').val();
			var end_date = $("#end_year").val()+'-'+$("#end_month").val()+'-'+$('#end_day').val();
	        if(!input_type)
	        {
	            location += '/'+start_date + '/'+ end_date;
	        }
	        else
	        {
				location += '/'+start_date + '/'+ end_date+ '/' + input_type;
			}
		}
		if (location_id)
		{
			location += '/' + location_id;
		}
		window.location = location;
	});
	
	$("#start_month, #start_day, #start_year, #end_month, #end_day, #end_year").click(function()
	{
		$("#complex_radio").attr('checked', 'checked');
	});
	
	$("#report_date_range_simple").click(function()
	{
		$("#simple_radio").attr('checked', 'checked');
	});
	
});
</script>