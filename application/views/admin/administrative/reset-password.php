<div class="login-box">
	<div class="login-logo">
		<a href="<?php echo $this->config->item('admin_url'); ?>"><b><?php echo $this->config->item('site_name'); ?></b>Admin</a>
	</div>
	<!-- /.login-logo -->
	<div class="login-box-body">
		<h2>Reset Admin Account Password</h2>
		<?php 
			if(!empty($success_msg)){
				echo '<p class="statusMsg success">'.$success_msg.'</p>';
			}elseif(!empty($error_msg)){
				echo '<p class="statusMsg error">'.$error_msg.'</p>';
			}
		?>
		<form action="" method="post">
			<div class="form-group has-feedback">
				<input type="password" class="form-control" name="password" placeholder="Password" required="">
				<span class="glyphicon glyphicon-lock form-control-feedback"></span>
				<?php echo form_error('password','<span class="help-block error">','</span>'); ?>
			</div>
			<div class="form-group has-feedback">
				<input type="password" class="form-control" name="conf_password" placeholder="Retype password" required="">
				<span class="glyphicon glyphicon-log-in form-control-feedback"></span>
				<?php echo form_error('conf_password','<span class="help-block error">','</span>'); ?>
			</div>
			<div class="row">
				<div class="col-xs-8">
				
				</div>
				<div class="col-xs-4">
					  <input type="submit" name="resetSubmit" value="Update" class="btn btn-primary btn-block btn-flat">
				</div>
			</div>
		</form>
		<div class="social-auth-links text-center">
			<p>- Don't Want to Reset -</p>
			<a href="<?php echo $this->config->item('admin_url'); ?>login" class="hvr-shutter-in-horizontal">Back to login</a>
		</div>
	</div>
</div>