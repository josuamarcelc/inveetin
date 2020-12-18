<div class="login-box">
	<div class="login-logo">
	  <a href="<?php echo $this->config->item('admin_url'); ?>"><b><?php echo $siteSettings['name']; ?></b>Admin</a>
	</div>
	<div class="login-box-body">
		<h2>Recover Admin Account Password</h2>
		<?php 
			if(!empty($success_msg)){
				echo '<p class="statusMsg success">'.$success_msg.'</p>';
			}elseif(!empty($error_msg)){
				echo '<p class="statusMsg error">'.$error_msg.'</p>';
			}
		?>
		<?php if($frmDis == 1){ ?>
		<h5>Enter the email address of admin and we'll send you a link to reset your password.</h5>
		<form action="" method="post">
			<div class="form-group has-feedback">
				<input type="text" name="email" placeholder="Email"class="form-control" required="">
				<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
				<?php echo form_error('email','<span class="help-block error">','</span>'); ?>
			</div>
			<div class="row">
				<div class="col-xs-8">
					<a href="<?php echo $this->config->item('admin_url'); ?>administrative/" class="btn btn-default btn-block btn-flat">Back to Login</a>
				</div>
				<div class="col-xs-4">
					  <input type="submit" name="forgotSubmit" value="Continue" class="btn btn-primary btn-block btn-flat">
				</div>
			</div>
		</form>
		<?php }else{ ?>
		<div class="social-auth-links text-center">
			<p>- Email Not Received -</p>
			<a href="<?php echo $this->config->item('admin_url'); ?>administrative/forgotPassword" class="btn btn-primary">Request reset link</a>
		</div>
		<?php } ?>
	</div>
</div>