
<?php $this->load->view("partial/header"); ?>

	

<div id="page_title" style="margin-bottom: 8px;"><?php echo $this->lang->line('sales_register'); ?></div>

<?php
if (isset($error))
{
	echo "<div class='error_message'>".$error."</div>";
}

if (isset($warning))
{
	echo "<div class='warning_mesage'>".$warning."</div>";
}

if (isset($success))
{
	echo "<div class='success_message'>".$success."</div>";
}
?>

<div id="register_wrapper">
	<?php echo form_open("sales/change_mode",array('id'=>'mode_form','class'=>'btn btn-warning')); ?>
	<span><?php echo $this->lang->line('sales_mode') ?></span>
	<?php echo form_dropdown('mode',$modes,$mode,'onchange="$(\'#mode_form\').submit();" class="form-control col-xs-2"'); ?>
	<?php
	if (count($stock_locations) > 1)
	{
	?>
		<span><?php echo $this->lang->line('sales_stock_location') ?></span>
		<?php echo form_dropdown('stock_location',$stock_locations,$stock_location,'onchange="$(\'#mode_form\').submit();"'); ?>
	<?php
	}
	?>

	

	</form>

	<?php echo form_open("sales/add",array('id'=>'add_item_form')); ?>
	<div class="row">
        <div class="col-md-2">
            <label id="item_label" for="item">Find/Scan</label>
		</div>
        <div class="col-md-9">
	<?php echo form_input(array('name'=>'item','id'=>'item','size'=>'40','class'=>'form-control')); ?>
            </div>
	</div>
	</form>

	<table id="register">
		<thead>
			<tr>
				<th style="width: 11%;"><?php echo $this->lang->line('common_delete'); ?></th>
				<th style="width: 30%;"><?php echo $this->lang->line('sales_item_name'); ?></th>
				<th style="width: 11%;"><?php echo $this->lang->line('sales_price'); ?></th>
				<th style="width: 11%;"><?php echo $this->lang->line('sales_quantity'); ?></th>
				<th style="width: 11%;"><?php echo $this->lang->line('sales_discount'); ?></th>
				<th style="width: 15%;"><?php echo $this->lang->line('sales_total'); ?></th>
                <th style="width:11%;"><?php echo $this->lang->line('sales_edit'); ?></th>
			</tr>
		</thead>
		<tbody id="cart_contents">
			<?php
			if(count($cart)==0)
			{
			?>
				<tr>
					<td colspan='8'>
						<div class='warning_message' style='padding: 7px;'><?php echo $this->lang->line('sales_no_items_in_cart'); ?></div>
					</td>
				</tr>
			<?php
			}
			else
			{				
				$tabindex = 2;				
				foreach(array_reverse($cart, true) as $line=>$item)
				{					
					if($tabindex == 3) 
					{
						$tabindex = 5;
					}					
					echo form_open("sales/edit_item/$line");
			?>
					<tr>
                    	<td><?php echo anchor("sales/delete_item/$line",'<i class="fa fa-times-circle btn btn-danger"></i>');?></td>
						<td style="align: center;"><?php echo $item['name']; ?><br /> [<?php echo $item['in_stock'] ?> in <?php echo $item['stock_name']; ?>]
							<?php echo form_hidden('location', $item['item_location']); ?>
						</td>

						<?php if ($items_module_allowed)
						{
						?>
							<td><?php echo form_input(array('name'=>'price','value'=>$item['price'],'size'=>'6'));?></td>
						<?php
						}
						else
						{
						?>
							<td><?php echo to_currency($item['price']); ?></td>
							<?php echo form_hidden('price',$item['price']); ?>
						<?php
						}
						?>

						<td>
						<?php
							if($item['is_serialized']==1)
							{
								echo $item['quantity'];
								echo form_hidden('quantity',$item['quantity']);
							}
							else
							{								
				        		echo form_input(array('name'=>'quantity','value'=>$item['quantity'],'size'=>'2','tabindex'=>$tabindex));
							}
						?>
						</td>

						<td><?php echo form_input(array('name'=>'discount','value'=>$item['discount'],'size'=>'3'));?></td>
						<td><?php echo to_currency($item['price']*$item['quantity']-$item['price']*$item['quantity']*$item['discount']/100); ?></td>
						<td><button type="submit" class="btn btn-primary"><i class="fa fa-edit"></i></button></td>
					</tr>
					<tr>
						<?php 
						if($item['allow_alt_description']==1)
						{
						?>
							<td style="color: #2F4F4F;"><?php echo $this->lang->line('sales_description_abbrv').':';?></td>
						<?php 
						}
						?>

						<td colspan=2 style="text-align: left;">
							<?php
							if($item['allow_alt_description']==1)
							{
								echo form_input(array('name'=>'description','value'=>$item['description'],'size'=>'20'));
							}
							else
							{
								if ($item['description']!='')
								{
									echo $item['description'];
									echo form_hidden('description',$item['description']);
								}
								else
								{
									echo $this->lang->line('sales_no_description');
									echo form_hidden('description','');
								}
							}
							?>
						</td>
						<td>&nbsp;</td>
						<td style="color: #2F4F4F;">
							<?php
							if($item['is_serialized']==1)
							{
								echo $this->lang->line('sales_serial').':';
							}
							?>
						</td>
						<td colspan="4" style="text-align: left;">
							<?php
							if($item['is_serialized']==1)
							{
								echo form_input(array('name'=>'serialnumber','value'=>$item['serialnumber'],'size'=>'20'));
							}
							else
							{
								echo form_hidden('serialnumber', '');
							}
							?>
						</td>
					</tr>
					<tr style="height: 3px">
						<td colspan=8 style="background-color: white"></td>
					</tr>
                    

					</form>
			<?php					
					$tabindex = $tabindex + 1;					
				}
			}
			?>
		</tbody>
        
	</table>
</div>

<div id="overall_sale">


        <div id="Cancel_sale">
			<?php echo form_open("sales/cancel_sale", array('id'=>'cancel_sale_form')); ?>
			<div class='btn btn-warning' id='cancel_sale_button'>
				<span><i class="fa  fa-times "></i> <?php echo $this->lang->line('sales_cancel_sale'); ?></span>
			</div>
			
			<div class='btn btn-primary float_right' id='suspend_sale_button' >
				<span><i class="fa fa-history  "></i> <?php echo $this->lang->line('sales_suspend_sale'); ?></span>
			</div>
		</div>
	
		</form>
        <div class="clearfix">&nbsp;</div>
    <div class="select_customer alert alert-warning">
	<?php
	if(isset($customer))
	{
		echo $this->lang->line("sales_customer").': <b>'.$customer. '</b><br />';
		echo anchor("sales/remove_customer",'['.$this->lang->line('common_remove').' '.$this->lang->line('customers_customer').']');
	}
	else
	{
		echo form_open("sales/select_customer",array('id'=>'select_customer_form'));
	?>
		<label id="customer_label" for="customer"><?php echo $this->lang->line('sales_select_customer'); ?></label>
		<?php echo form_input(array('name'=>'customer','id'=>'customer','size'=>'30','class'=>'form-control','value'=>$this->lang->line('sales_start_typing_customer_name')));?>

		</form>
			
            


		<div style="margin-top: 5px; text-align: center;">
			<h3 style="margin: 5px 0 5px 0"><?php echo $this->lang->line('common_or'); ?></h3>
			<?php echo anchor("customers/view/-1/width:400",
			"<div class='btn btn-danger' style='margin:0 auto;'><i class='fa fa-users'></i> <span>Add New Customer</span></div>",
			array('class'=>'thickbox none','title'=>$this->lang->line('sales_new_customer')));
			?>
		</div>
        
        
        
		
		<div class="clearfix">&nbsp;</div>
	<?php
	}
	?>
	</div>
    <div id="payment_details" class="alert alert-info">
			<div>
				<?php echo form_open("sales/add_payment",array('id'=>'add_payment_form')); ?>
				<table width="100%">
					<tr>
						<td>
							<?php echo $this->lang->line('sales_print_after_sale'); ?>
						</td>
						<td>
							<?php
							if ($print_after_sale)
							{
								echo form_checkbox(array('name'=>'sales_print_after_sale','id'=>'sales_print_after_sale','checked'=>'checked'));
							}
							else
							{
								echo form_checkbox(array('name'=>'sales_print_after_sale','id'=>'sales_print_after_sale','checked'=>'checked'));
							}
							?>
						</td>
					</tr>
					<?php
					if ($mode == "sale") 
					{
					?>
					<tr>
						<td>
							<?php echo $this->lang->line('sales_invoice_enable'); ?>
						</td>
						<td>
							<?php if ($invoice_number_enabled)
							{
								echo form_checkbox(array('name'=>'sales_invoice_enable','id'=>'sales_invoice_enable','checked'=>'checked'));
							}
							else
							{
								echo form_checkbox(array('name'=>'sales_invoice_enable','id'=>'sales_invoice_enable'));
							}
							?>
						</td>
					</tr>
					<tr>
						<td>
							<?php echo $this->lang->line('sales_invoice_number').':   ';?>
						</td>
						<td>
							<?php echo form_input(array('name'=>'sales_invoice_number','id'=>'sales_invoice_number','value'=>$invoice_number,'size'=>10));?>
						</td>
					</tr>
					<?php 
					}
					?>
							<input type="hidden" name="payment_type" value="Cash" />
					<tr>
						<td>
							<span id="amount_tendered_label"><?php echo $this->lang->line( 'sales_amount_tendered' ).': '; ?></span>
						</td>
						<td>
							<?php echo form_input( array( 'name'=>'amount_tendered', 'id'=>'amount_tendered', 'value'=>to_currency_no_money($amount_due), 'size'=>'10','tabindex'=>4 ) ); ?>
						</td>
					</tr>
				</table>
				
				<div class='btn btn-danger' id='add_payment_button' style='float: left; margin-top: 5px;'>
					<span><?php echo $this->lang->line('sales_add_payment'); ?></span>
				</div>

				</form>
                <?php
			// Only show this part if there is at least one payment entered.
			if(count($payments) > 0)
			{
			?>
				<table id="register" style="margin-top:10px; float:left">
					<thead>
						<tr>
							<th style="width: 11%;"><?php echo $this->lang->line('common_delete'); ?></th>
							<th style="width: 18%;"><?php echo $this->lang->line('sales_payment_amount'); ?></th>
						</tr>
					</thead>
		
					<tbody id="payment_contents">
						<?php
						foreach($payments as $payment_id=>$payment)
						{
							echo form_open("sales/edit_payment/$payment_id",array('id'=>'edit_payment_form'.$payment_id));
							?>
							<tr>
								<td><?php echo anchor( "sales/delete_payment/$payment_id", '['.$this->lang->line('common_delete').']' ); ?></td>
								<td ><?php echo to_currency( $payment['payment_amount'] ); ?></td>
							</tr>
							
							</form>
						<?php
						}
						?>
					</tbody>
				</table>
				<br />
			<?php
			}
			?>
			</div>
            </div>
            <div class="clearfix" style="margin-bottom: 30px;"> </div>
	<div id="sale_details">
		<div class="float_left" style="width: 55%;padding: 10px;"><?php echo $this->lang->line('sales_sub_total'); ?>:</div>
		<div class="float_left" style="width: 45%; font-weight: bold;padding: 10px;"><?php echo to_currency($this->config->item('tax_included') ? $tax_exclusive_subtotal : $subtotal); ?></div>

		<?php foreach($taxes as $name=>$value) { ?>
		<div class="float_left" style='width: 55%;'><?php echo $name; ?>:</div>
		<div class="float_left" style="width: 45%; font-weight: bold;"><?php echo to_currency($value); ?></div>
		<?php }; ?>
		
		<div class="float_left alert-danger" style='width: 55%; font-size: 25px;'><?php echo $this->lang->line('sales_total'); ?>:</div>
		<div class="float_left alert-danger" style="width: 45%; font-weight: bold; font-size: 25px;"><?php echo to_currency($total); ?></div>
	
	<?php
	// Only show this part if there are Items already in the sale.
	if(count($cart) > 0)
	{
	?>
    	

		<!--<div class="clearfix" style="margin-bottom: 1px;">&nbsp;</div>-->

		<?php
		// Only show this part if there is at least one payment entered.
		if(count($payments) > 0)
		{
		?>
        
			<div id="finish_sale">
				<?php echo form_open("sales/complete", array('id'=>'finish_sale_form')); ?>
				<table width="100%">
					<tr style="padding: 10px;">
						<td style="width: 55%;padding: 10px;"><div class="float_left"><?php echo $this->lang->line('sales_payments_total').':';?></div></td>
						<td style="width: 45%; text-align: right;"><div class="float_left alert-link"
						style="text-align: right; font-weight: bold;"><?php echo to_currency($payments_total); ?></div></td>
					</tr>
					<tr class="alert alert-warning">
						<td style="width: 55%;"><div class="float_left"><?php echo $this->lang->line('sales_amount_due').':';?></div></td>
						<td style="width: 45%; text-align: right; font-size: 20px;"><div class="float_left"
						style="text-align: right; font-weight: bold;"><?php echo to_currency($amount_due); ?></div></td>
					</tr>
			</table>
				<br />
				<br />
				<?php
				if(!empty($customer_email))
				{
					echo $this->lang->line('sales_email_receipt'). ': '
						. form_checkbox(array(
					    'name'    => 'email_receipt',
					    'id'      => 'email_receipt',
					    'value'   => '1',
					    'checked' => (boolean)$email_receipt,
					    )).'<br />('.$customer_email.')<br />';
				}
				 
				if ($payments_cover_total)
				{					
					echo "<div class='btn btn-success btn-lg' id='finish_sale_button' style='float:right; margin-top:5px;' tabindex='3'><span>".$this->lang->line('sales_complete_sale')."</span></div>";
				}
				?>
			</div>

			</form>
            
		<?php
		}
		?>

		</div>

		</div>

	<?php
	}
	?>
</div>

<div class="clearfix" style="margin-bottom: 30px;">&nbsp;</div>

<script type="text/javascript" language="javascript">
$(document).ready(function()
{
	shortcut.add("Ctrl+Shift+S",function() {
		$('#finish_sale_form').submit();
	});
	shortcut.add("Ctrl+Shift+Z",function() {
		$('#add_payment_form').submit();
	});
    $("#item").autocomplete('<?php echo site_url("sales/item_search"); ?>',
    {
    	minChars:0,
    	max:100,
    	selectFirst: false,
       	delay:10,
    	formatItem: function(row) {
			return (row.length > 1 && row[1]) || row[0];
		}
    });

    $("#item").result(function(event, data, formatted)
    {
		$("#add_item_form").submit();
    });

	$('#item').focus();

    $('#item').blur(function()
    {
        $(this).val("<?php echo $this->lang->line('sales_start_typing_item_name'); ?>");
    });

    var clear_fields = function()
    {
        if ($(this).val().match("<?php echo $this->lang->line('sales_start_typing_item_name') . '|' . 
        	$this->lang->line('sales_start_typing_customer_name'); ?>"))
        {
            $(this).val('');
        }
    };

    $('#item, #customer').click(clear_fields);

    $("#customer").autocomplete('<?php echo site_url("sales/customer_search"); ?>',
    {
    	minChars:0,
    	delay:10,
    	max:100,
    	formatItem: function(row) {
			return row[1];
		}
    });

    $("#customer").result(function(event, data, formatted)
    {
		$("#select_customer_form").submit();
    });

    $('#customer').blur(function()
    {
    	$(this).val("<?php echo $this->lang->line('sales_start_typing_customer_name'); ?>");
    });
	
	$('#comment').keyup(function() 
	{
		$.post('<?php echo site_url("sales/set_comment");?>', {comment: $('#comment').val()});
	});

	$('#sales_invoice_number').keyup(function() 
	{
		$.post('<?php echo site_url("sales/set_invoice_number");?>', {sales_invoice_number: $('#sales_invoice_number').val()});
	});

	var enable_invoice_number = function() 
	{
		var enabled = $("#sales_invoice_enable").is(":checked");
		$("#sales_invoice_number").prop("disabled", !enabled).parents('tr').show();
		return enabled;
	}

	enable_invoice_number();

	$("#sales_print_after_sale").change(function() {
		$.post('<?php echo site_url("sales/set_print_after_sale");?>', {sales_print_after_sale: $(this).is(":checked")});
	});
	
	$("#sales_invoice_enable").change(function() {
		var enabled = enable_invoice_number();
		$.post('<?php echo site_url("sales/set_invoice_number_enabled");?>', {sales_invoice_number_enabled: enabled});
	});
	
	$('#email_receipt').change(function() 
	{
		$.post('<?php echo site_url("sales/set_email_receipt");?>', {email_receipt: $('#email_receipt').is(':checked') ? '1' : '0'});
	});
	
	
    $("#finish_sale_button").click(function()
    {
    		$('#finish_sale_form').submit();
    });

	$("#suspend_sale_button").click(function()
	{ 	
		if (confirm('<?php echo $this->lang->line("sales_confirm_suspend_sale"); ?>'))
    	{
			$('#cancel_sale_form').attr('action', '<?php echo site_url("sales/suspend"); ?>');
    		$('#cancel_sale_form').submit();
    	}
	});

    $("#cancel_sale_button").click(function()
    {
    	if (confirm('<?php echo $this->lang->line("sales_confirm_cancel_sale"); ?>'))
    	{
    		$('#cancel_sale_form').submit();
    	}
    });

	$("#add_payment_button").click(function()
	{
	   $('#add_payment_form').submit();
    });

	$("#payment_types").change(check_payment_type_gifcard).ready(check_payment_type_gifcard)
	
	$("#amount_tendered").keyup(function(event){
		if(event.which == 13) {
			$('#add_payment_form').submit();
		}
	});	
	
    $( "#finish_sale_button" ).keypress(function( event ) {
		if ( event.which == 13 ) {
			if (confirm('<?php echo $this->lang->line("sales_confirm_finish_sale"); ?>'))
			{
				$('#finish_sale_form').submit();
			}
		}
	});	    
});

function post_item_form_submit(response, stay_open)
{
	if(response.success)
	{
        var $stock_location = $("select[name='stock_location']").val();
        $("#item_location").val($stock_location);
		$("#item").val(response.item_id);
		if (stay_open)
		{
			$("#add_item_form").ajaxSubmit();
		}
		else
		{
			$("#add_item_form").submit();	
		}
	}
}

function post_person_form_submit(response)
{
	if(response.success)
	{
		$("#customer").val(response.person_id);
		$("#select_customer_form").submit();
	}
}

function check_payment_type_gifcard()
{
	if ($("#payment_types").val() == "<?php echo $this->lang->line('sales_giftcard'); ?>")
	{
		$("#amount_tendered_label").html("<?php echo $this->lang->line('sales_giftcard_number'); ?>");
		$("#amount_tendered").val('').focus();
	}
	else
	{
		$("#amount_tendered_label").html("<?php echo $this->lang->line('sales_amount_tendered'); ?>");
		$("#amount_tendered").val('<?php echo $amount_due; ?>');
	}
}

</script>
<?php $this->load->view("partial/footer"); ?>