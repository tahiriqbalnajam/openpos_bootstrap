<?php $this->load->view("partial/header"); ?>
<div id="page_title" style="margin-bottom:8px;"><?php echo $this->lang->line('reports_reports'); ?></div>
<div id="welcome_message"><?php echo $this->lang->line('reports_welcome_message'); ?>
<ul id="report_list">

	<li><h3><?php echo $this->lang->line('reports_detailed_reports'); ?></h3>
		<ul>
		<?php 			
			$person_id = $this->session->userdata('person_id');
			show_report_if_allowed('detailed', 'sales', $person_id, '', 'btn btn-danger');
			show_report_if_allowed('detailed', 'receivings',  $person_id, '', 'btn btn-success');
			show_report_if_allowed('specific', 'customer', $person_id, 'reports_customers', 'btn btn-success');
			show_report_if_allowed('specific', 'discount', $person_id, 'reports_discounts', 'btn btn-success');
			show_report_if_allowed('specific', 'employee', $person_id, 'reports_employees','btn btn-success');
		?>
		</ul>
	</li>
    
    
    <?php 
	if ($this->Employee->has_grant('reports_inventory', $this->session->userdata('person_id')))
	{
	?>
	<li><h3><?php echo $this->lang->line('reports_inventory_reports'); ?></h3>
		<ul>
		<?php 
			show_report('', 'reports_inventory_low','','btn btn-danger');	
			show_report('', 'reports_inventory_summary', '','btn btn-success');
		?>
		</ul>
	</li>
    
    

    
    
    
    <li><h3><?php echo $this->lang->line('reports_summary_reports'); ?></h3>
		<ul>
			<?php
			  $arrcolor = array("btn-primary", "btn-success", "btn-warning", "btn-info", "btn-danger"); 
			  $count= 0; 
			foreach($grants as $grant) 
			{
				if (!preg_match('/reports_(inventory|receivings)/', $grant['permission_id']))
				{
					show_report('summary',$grant['permission_id'], '', 'btn '.$arrcolor[$count]);
				}
				$count++;
				if($count%4==0)
					$count = 0;
			}
			?>
		</ul>
	</li>
    
    
    
    <li><h3><?php echo $this->lang->line('reports_graphical_reports'); ?></h3>
		<ul>
			<?php
			
			$arrcolor = array("btn-primary", "btn-success", "btn-warning", "btn-info", "btn-danger"); 
			  $count= 0; 
			foreach($grants as $grant) 
			{
				if (!preg_match('/reports_(inventory|receivings)/', $grant['permission_id']))
				{
					show_report('graphical_summary',$grant['permission_id'],'', 'btn '.$arrcolor[$count]);
				}
				$count++;
				if($count%4==0)
				$count=0;
				
			}
			?>
		</ul>
	</li>
     
	
	<?php 
	}
	?>
</ul>
<?php
if(isset($error))
{
	echo "<div class='error_message'>".$error."</div>";
}
?>
<?php $this->load->view("partial/footer"); ?>