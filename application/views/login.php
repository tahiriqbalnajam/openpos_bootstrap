<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" rev="stylesheet" href="<?php echo base_url();?>css/login.css" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Open Source Point Of Sale <?php echo $this->lang->line('login_login'); ?></title>
<link rel="stylesheet" rev="stylesheet" href="<?php echo base_url();?>/css/bootstrap.min.css" />

<script src="<?php echo base_url();?>js/jquery-1.8.3.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
<script type="text/javascript">
$(document).ready(function()
{
	$("#login_form input:first").focus();
});
</script>
</head>
<body>

<div align="center" style="margin-top:100px">

</div>

<?php echo form_open('login') ?>
<div id="container">

<div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
            <?php echo validation_errors(); ?>
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Sign In To Your Shop</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form">
                            <fieldset>
                                <div class="form-group">
                                	<?php echo form_input(array(
															'name'=>'username',
															'id'=>'username',
															'size'=>'20',
															'class'=>'form-control',
															'placeholder'=>'Enter Username')); ?>
                                 
                                </div>
                                <div class="form-group">
                                	<?php echo form_password(array(
														'name'=>'password',
														'id' => 'password',
														'size'=>'20',
														'class'=>'form-control',
														'placeholder'=>'Enter Password')); ?>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <input type="submit" class="btn btn-lg btn-success btn-block" value="Log In" />
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>	
</div>
<?php echo form_close(); ?> 
</body>
</html>
