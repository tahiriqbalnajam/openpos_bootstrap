<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('common_first_name').':', 'first_name',array('class'=>'required')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'first_name',
		'id'=>'first_name',
		'class'=>'form-control',
		'value'=>$person_info->first_name)
	);?>
	</div>
</div>
<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('common_last_name').':', 'last_name',array('class'=>'required')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'last_name',
		'id'=>'last_name',
		'class'=>'form-control',
		'value'=>$person_info->last_name)
	);?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('common_gender').':', 'gender',
!empty($basic_version) ? array('class'=>'required') : array()); ?>
	<div class='form_field'>
	<?php echo form_radio(array(
		'name'=>'gender',
		'type'=>'radio',
		'id'=>'gender',
		'value'=>1,
		'checked'=>$person_info->gender === '1')
	);
	echo '&nbsp;' . $this->lang->line('common_gender_male') . '&nbsp;';
	echo form_radio(array(
		'name'=>'gender',
		'type'=>'radio',
		'id'=>'gender',
		'value'=>0,
		'checked'=>$person_info->gender === '0')
	);
	echo '&nbsp;' . $this->lang->line('common_gender_female');
	?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('common_email').':', 'email'); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'email',
		'id'=>'email',
		'class'=>'form-control',
		'value'=>$person_info->email)
	);?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('common_phone_number').':', 'phone_number'); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'phone_number',
		'id'=>'phone_number',
		'class'=>'form-control',
		'value'=>$person_info->phone_number));?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('common_address_1').':', 'address_1'); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'address_1',
		'id'=>'address_1',
		'class'=>'form-control',
		'value'=>$person_info->address_1));?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('common_address_2').':', 'address_2'); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'address_2',
		'id'=>'address_2',
		'class'=>'form-control',
		'value'=>$person_info->address_2));?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('common_city').':', 'city'); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'city',
		'id'=>'city',
		'class'=>'form-control',
		'value'=>$person_info->city));?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('common_state').':', 'state'); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'state',
		'id'=>'state',
		'class'=>'form-control',
		'value'=>$person_info->state));?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('common_zip').':', 'zip'); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'zip',
		'id'=>'postcode',
		'class'=>'form-control',
		'value'=>$person_info->zip));?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('common_country').':', 'country'); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'country',
		'id'=>'country',
		'class'=>'form-control',
		'value'=>$person_info->country));?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('common_comments').':', 'comments'); ?>
	<div class='form_field'>
	<?php echo form_textarea(array(
		'name'=>'comments',
		'id'=>'comments',
		'class'=>'form-control',
		'value'=>$person_info->comments,
		'rows'=>'5',
		'cols'=>'17')		
	);?>
	</div>
</div>

<script type='text/javascript' language="javascript">
//validation and submit handling
$(document).ready(function()
{
	nominatim.init({
		fields : {
			postcode : {  
				dependencies :  ["postcode", "city", "state", "country"], 
				response : {  
					field : 'postalcode', 
					format: ["postcode", "village|town|hamlet|city_district|city", "state", "country"] 
				}
			},
	
			city : {
				dependencies :  ["postcode", "city", "state", "country"], 
				response : {  
					format: ["postcode", "village|town|hamlet|city_district|city", "state", "country"] 
				}
			},
	
			state : {
				dependencies :  ["state", "country"]
			},
	
			country : {
				dependencies :  ["state", "country"] 
			}
			
		},
		language : '<?php echo $this->config->item('language');?>'
	});

});
</script>