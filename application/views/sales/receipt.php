<?php $this->load->view("partial/header"); ?>

<?php $this->load->view('partial/print_receipt', array('print_after_sale', $print_after_sale, 
		'selected_printer' => 'receipt_printer')); ?>

<?php
if (isset($error_message))
{
	echo '<h1 style="text-align: center;">'.$error_message.'</h1>';
	exit;
}
?>
<div id="receipt_wrapper">
	<div id="receipt_header">
    	<table align="left">
        	<tr>
            	<td>
        			<?php if ($this->Appconfig->get('company_logo') == '') 
        { 
        ?>
        
        <div id="company_name"><?php echo $this->config->item('company'); ?></div>
		<?php 
		}
		else 
		{ 
		?>
		<div id="company_name"><img id="image" src="<?php echo base_url('uploads/' . $this->Appconfig->get('company_logo')); ?>" alt="company_logo" /></div>			
		<?php
		}
		?>
    	    </td>
        </tr>
        <tr>
        	<td><div id="company_address"><?php echo nl2br($this->config->item('address')); ?></div></td>
        </tr>
        <tr>
        	<td><div id="company_phone"><?php echo $this->config->item('phone'); ?></div></td>
        </tr>
        <tr>
        	<td><div id="sale_receipt"><?php echo $receipt_title; ?></div></td>
        </tr>
        <tr>
        	<td><div id="sale_time"><?php echo $transaction_time ?></div></td>
        </tr>
        <tr>
        	<td><div id="sale_id"><?php echo $this->lang->line('sales_id').": ".$sale_id; ?></div></td>
        </tr>
        <tr>
        	<td>
            	<?php if(isset($customer))
					{
					?>
					<div id="customer"><?php echo $this->lang->line('customers_customer').": ".$customer; ?></div>
					<?php
					}
				?>
            </td>
        </tr>
        <tr>
        	<td>
            	<?php if (!empty($invoice_number))
					{
					?>
					<div id="invoice_number"><?php echo $this->lang->line('recvs_invoice_number').": ".$invoice_number; ?></div>	
					<?php 
					}
				?>
            </td>
        </tr>
        </table>
		
		
		
	</div>
	<!--<div id="receipt_general_info">
		
		
		
		<div id="employee"><?php echo $this->lang->line('employees_employee').": ".$employee; ?></div>
	</div>-->

	<table id="receipt_items">
	<tr>
	<th style="width:40%;"><?php echo $this->lang->line('sales_description_abbrv'); ?></th>
	<th style="width:20%;"><?php echo $this->lang->line('sales_price'); ?></th>
	<th style="width:20%;"><?php echo $this->lang->line('sales_quantity'); ?></th>
	<th style="width:20%;" class="total-value"><?php echo $this->lang->line('sales_total'); ?></th>
	</tr>
	<?php
	foreach(array_reverse($cart, true) as $line=>$item)
	{
	?>
		<tr>
			<td><span class='long_name'> <?php echo ucfirst($item['name']); ?></span></td>
		
		
			<td><?php echo to_currency($item['price']); ?></td>
			<td><?php 
				echo $item['quantity'] . " " . ($show_stock_locations ? " [" . $item['stock_name'] . "]" : ""); 
			?></td>
			<td><div class="total-value"><?php echo to_currency($item[($this->Appconfig->get('show_total_discount') ? 'total' : 'discounted_total')]); ?></div></td>
		</tr>
	    <tr>
	    <td colspan="2"><?php echo $item['description']; ?></td>
		<td ><?php echo $item['serialnumber']; ?></td>
	    </tr>
	    <?php if ($item['discount'] > 0) : ?>
		<tr>
			<td colspan="3" class="discount"> <?php echo number_format($item['discount'], 0) . " " . $this->lang->line("sales_discount_included")?> </td>
		</tr>
		<?php endif; ?>

	<?php
	}
	?>
	
	<?php if ($this->Appconfig->get('show_total_discount') && $discount > 0): ?> 
	<tr>
	<td colspan="3" style='text-align:right;border-top:2px solid #000000;'><?php echo $this->lang->line('sales_sub_total'); ?></td>
	<td style='text-align:right;border-top:2px solid #000000;'><?php echo to_currency($subtotal); ?></td>
	</tr>
	<tr>
		<td colspan="3" class="total-value"><?php echo $this->lang->line('sales_discount'); ?>:</td>
		<td class="total-value"><?php echo to_currency($discount*-1); ?></td>
	</tr>
	<?php endif; ?>
	<?php if ($this->Appconfig->get('receipt_show_taxes')): ?> 
	<tr>
		<td colspan="3" style='text-align:right;border-top:2px solid #000000;'><?php echo $this->lang->line('sales_sub_total'); ?></td>
		<td style='text-align:right;border-top:2px solid #000000;'><?php echo to_currency($this->config->item('tax_included') ? $tax_exclusive_subtotal : $discounted_subtotal); ?></td>
	</tr>
	<?php foreach($taxes as $name=>$value) { ?>
		<tr>
			<td colspan="3" class="total-value"><?php echo $name; ?>:</td>
			<td class="total-value"><?php echo to_currency($value); ?></td>
		</tr>
	<?php }; ?>
	<?php endif; ?>
	<tr>
	</tr>
	<?php $border = (!$this->Appconfig->get('receipt_show_taxes') && !($this->Appconfig->get('show_total_discount') && $discount > 0)); ?> 
	<tr>
	<td colspan="3" style='<?php echo $border? 'border-top: 2px solid black;' :''; ?>text-align:right;'><?php echo $this->lang->line('sales_total'); ?></td>
	<td style='<?php echo $border? 'border-top: 2px solid black;' :''; ?>text-align:right'><?php echo to_currency($total); ?></td>
	</tr>

   <!-- <tr><td colspan="4">&nbsp;</td></tr>-->

	<?php
	$only_sale_check = TRUE;
	$show_giftcard_remainder = FALSE;
	foreach($payments as $payment_id=>$payment)
	{ 
		$only_sale_check &= $payment['payment_type'] == $this->lang->line('sales_check');
		$splitpayment=explode(':',$payment['payment_type']);
		$show_giftcard_remainder |= $splitpayment[0] == $this->lang->line('sales_giftcard');
  		?>
		<tr>
		<td colspan="3" style="text-align:right;"><?php echo $splitpayment[0]; ?> </td>
		<td><div class="total-value"><?php echo to_currency( $payment['payment_amount'] * -1 ); ?></div></td>
	    </tr>
	<?php
	}
	?>

    <tr><!--<td colspan="4">&nbsp;</td>--></tr>

    <?php 
	    if (isset($cur_giftcard_value) && $show_giftcard_remainder)
	    {
	    ?>
	    <tr>
			<td colspan="3" style='text-align:right;'><?php echo $this->lang->line('sales_giftcard_balance'); ?></td>
	    	<td style='text-align:right'><?php echo to_currency($cur_giftcard_value); ?></td>
	    </tr>
	    <?php 
	    }
    ?>
	<tr>
		<td colspan="3" style='text-align:right;'> <?php echo $this->lang->line($amount_change >= 0 ? ($only_sale_check ? 'sales_check_balance' : 'sales_change_due') : 'sales_amount_due') ; ?> </td>
		<td style='text-align:right'><?php echo to_currency($amount_change); ?></td>
	</tr>

	</table>

	<div id="sale_return_policy">
		<?php // echo nl2br($this->config->item('return_policy')); ?>
	</div>
	<!--<div id='barcode'>
		<img src='data:image/png;base64,<?php echo $barcode; ?>' /><br>
		<?php echo $sale_id; ?>
	</div>-->
</div>
<?php $this->load->view("partial/footer"); ?>

