<div class="login-box">
	<div class="login-logo">
	  <a href="<?php echo $this->config->item('admin_url'); ?>"><b><?php echo $siteSettings['name']; ?></b>Admin</a>
	</div>
	<div class="login-box-body">
		<p class="login-box-msg">Sign In to Access Admin Panel</p>
		<?php 
			if(!empty($success_msg)){
				echo '<p class="statusMsg success">'.$success_msg.'</p>';
			}elseif(!empty($error_msg)){
				echo '<p class="statusMsg error">'.$error_msg.'</p>';
			}
		?>
		<form action="" method="post">
			<div class="form-group has-feedback">
				<input type="text" name="username" class="form-control" placeholder="Username" required="">
				<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
				<?php echo form_error('username','<span class="help-block error">','</span>'); ?>
			</div>
			<div class="form-group has-feedback">
				<input type="password" name="password" class="form-control" placeholder="Password" required="">
				<span class="glyphicon glyphicon-lock form-control-feedback"></span>
				<?php echo form_error('password','<span class="help-block error">','</span>'); ?>
			</div>
			<div class="row">
				<div class="col-xs-8">
					<div class="checkbox icheck">
						<label>
							<input type="checkbox" name="rememberMe" value="1"> Remember Me
						</label>
					</div>
				</div>
				<div class="col-xs-4">
					  <input type="submit" name="loginSubmit" value="Sign In" class="btn btn-primary btn-block btn-flat">
				</div>
			</div>
		</form>
		<a href="<?php echo $this->config->item('admin_url'); ?>administrative/forgotPassword">Forgot password?</a>
	</div>
</div>