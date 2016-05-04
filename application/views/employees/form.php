<?php
echo form_open('employees/save/'.$person_info->person_id,array('id'=>'employee_form'));
?>
<div id="required_fields_message"><?php echo $this->lang->line('common_fields_required_message'); ?></div>
<ul id="error_message_box" class="error_message_box"></ul>
<fieldset id="employee_basic_info">
<legend><?php echo $this->lang->line("employees_basic_information"); ?></legend>
<?php $this->load->view("people/form_basic_info"); ?>
</fieldset>

<fieldset id="employee_login_info">
<legend><?php echo $this->lang->line("employees_login_info"); ?></legend>
<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('employees_username').':', 'username',array('class'=>'required')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'username',
		'id'=>'username',
		'class'=>'form-control',
		'value'=>$person_info->username));?>
	</div>
</div>

<?php
$password_label_attributes = $person_info->person_id == "" ? array('class'=>'required'):array();
?>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('employees_password').':', 'password',$password_label_attributes); ?>
	<div class='form_field'>
	<?php echo form_password(array(
		'name'=>'password',
		'class'=>'form-control',
		'id'=>'password'
		
	));?>
	</div>
</div>


<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('employees_repeat_password').':', 'repeat_password',$password_label_attributes); ?>
	<div class='form_field'>
	<?php echo form_password(array(
		'name'=>'repeat_password',
		'class'=>'form-control',
		'id'=>'repeat_password'
	));?>
	</div>
</div>
</fieldset>

<fieldset id="employee_permission_info">
<legend><?php echo $this->lang->line("employees_permission_info"); ?></legend>
<p><?php echo $this->lang->line("employees_permission_desc"); ?></p>

<ul id="permission_list">
<?php
foreach($all_modules->result() as $module)
{
?>
<li>	
<?php echo form_checkbox("grants[]",$module->module_id,$this->Employee->has_grant($module->module_id,$person_info->person_id),"class='module'"); ?>
<span class="medium"><?php echo $this->lang->line('module_'.$module->module_id);?>:</span>
<span class="small"><?php echo $this->lang->line('module_'.$module->module_id.'_desc');?></span>
<?php
	foreach($all_subpermissions->result() as $permission)
	{
		$exploded_permission = explode('_', $permission->permission_id);
		if ($permission->module_id == $module->module_id)
		{
			$lang_key = $module->module_id.'_'.$exploded_permission[1];
			$lang_line = $this->lang->line($lang_key);
			$lang_line = ($this->lang->line_tbd($lang_key) == $lang_line) ? $exploded_permission[1] : $lang_line;
			if (empty($lang_line))
			{
				continue;
			} 
			?>
		<ul>
			<li>
			<?php echo form_checkbox("grants[]",$permission->permission_id,$this->Employee->has_grant($permission->permission_id,$person_info->person_id)); ?>
			<span class="medium"><?php echo $lang_line ?></span>
			</li>
		</ul>
			<?php 
		}
	}
}
?>
</li>
</ul>
<?php
echo form_submit(array(
	'name'=>'submit',
	'id'=>'submit',
	'value'=>$this->lang->line('common_submit'),
	'class'=>'btn btn-danger')
);

?>
</fieldset>
<?php 
echo form_close();
?>
<script type='text/javascript'>

//validation and submit handling
$(document).ready(function()
{

	$.validator.addMethod("module", function (value, element) {
		var result = true;
		$(".module").each(function(index, element)
		{
			var parent = $(element).parent();
			var checked =  $(element).is(":checked");
			if ($("ul", parent).length > 0 && result)
			{
				result &= !checked || (checked && $("ul > li > input:checked", parent).length > 0);
			}
		});
		return result;
	}, '<?php echo $this->lang->line('employees_subpermission_required'); ?>');

	$("ul#permission_list > li > input[name='grants[]']").each(function() 
	{
	    var $this = $(this);
	    $("ul > li > input", $this.parent()).each(function() 
	    {
		    var $that = $(this);
	        var updateCheckboxes = function (checked) 
	        {
				$that.prop("disabled", !checked);
	         	!checked && $that.prop("checked", false);
	        }
	       $this.change(function() {
	            updateCheckboxes($this.is(":checked"));
	        });
			updateCheckboxes($this.is(":checked"));
	    });
	});
	
	$('#employee_form').validate({
		submitHandler:function(form)
		{
			$(form).ajaxSubmit({
			success:function(response)
			{
				tb_remove();
				post_person_form_submit(response);
			},
			dataType:'json'
		});

		},
		errorLabelContainer: "#error_message_box",
 		wrapper: "li",
		rules: 
		{
			first_name: "required",
			last_name: "required",
			username:
			{
				required:true,
				minlength: 5
			},
			
			password:
			{
				<?php
				if($person_info->person_id == "")
				{
				?>
				required:true,
				<?php
				}
				?>
				minlength: 8
			},	
			repeat_password:
			{
 				equalTo: "#password"
			},
    		email: "email"
   		},
		messages: 
		{
     		first_name: "<?php echo $this->lang->line('common_first_name_required'); ?>",
     		last_name: "<?php echo $this->lang->line('common_last_name_required'); ?>",
     		username:
     		{
     			required: "<?php echo $this->lang->line('employees_username_required'); ?>",
     			minlength: "<?php echo $this->lang->line('employees_username_minlength'); ?>"
     		},
     		
			password:
			{
				<?php
				if($person_info->person_id == "")
				{
				?>
				required:"<?php echo $this->lang->line('employees_password_required'); ?>",
				<?php
				}
				?>
				minlength: "<?php echo $this->lang->line('employees_password_minlength'); ?>"
			},
			repeat_password:
			{
				equalTo: "<?php echo $this->lang->line('employees_password_must_match'); ?>"
     		},
     		email: "<?php echo $this->lang->line('common_email_invalid_format'); ?>"
		}
	});
});
</script>