<section class="content-header">
	<h1><?php echo $action; ?> Site Settings<small>configuration <?php echo strtolower($action); ?></small></h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo $this->config->item('admin_url'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="<?php echo $listURL; ?>"><i class="fa files-o"></i> Settings</a></li>
		<li class="active"><?php echo $action; ?></li>
	</ol>
</section>
<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<a href="<?php echo $this->config->item('admin_url'); ?>" class="btn btn-success pull-right"><i class="fa fa-arrow-left"></i> Back</a>
        </div>
		<div class="col-xs-12">
		<?php 
			if(!empty($success_msg)){
				echo '<div class="alert alert-success">'.$success_msg.'</div>';
			}elseif(!empty($error_msg)){
				echo '<div class="alert alert-danger">'.$error_msg.'</div>';
			}
		?>
		</div>
		<form role="form" method="post" action="">
		<div class="col-md-9">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title"><?php echo $action; ?> Site Settings</h3>
				</div>
				<div class="box-body">
					<div class="form-group">
						<label for="title">Site Title</label>
						<input type="text" class="form-control" name="title" placeholder="Welcome to My Site" value="<?php echo !empty($settings['title'])?$settings['title']:''; ?>" required="">
						<?php echo form_error('title','<p class="help-block error">','</p>'); ?>
					</div>
					<div class="form-group">
						<label for="name">Site Name</label>
						<input type="text" class="form-control" name="name" placeholder="My Site" value="<?php echo !empty($settings['name'])?$settings['name']:''; ?>" required="">
						<?php echo form_error('name','<p class="help-block error">','</p>'); ?>
					</div>
					<div class="form-group">
						<label for="admin_email">Admin Email</label>
						<input type="text" class="form-control" name="admin_email" placeholder="admin@example.com" value="<?php echo !empty($settings['admin_email'])?$settings['admin_email']:''; ?>" required="">
						<?php echo form_error('admin_email','<p class="help-block error">','</p>'); ?>
					</div>
					<div class="form-group">
						<label for="contact_email">Contact Email</label>
						<input type="text" class="form-control" name="contact_email" placeholder="contact@example.com" value="<?php echo !empty($settings['contact_email'])?$settings['contact_email']:''; ?>" required="">
						<?php echo form_error('contact_email','<p class="help-block error">','</p>'); ?>
					</div>
					<div class="form-group">
						<label for="email_type">Email Type</label>
						<div>
							<label class="radio-inline">
							  <input type="radio" name="email_type" value="1" <?php echo (empty($settings['email_type']) || !empty($settings['email_type']) && $settings['email_type'] == '1')?'checked=""':''; ?>>
							  Default Mail
							</label>
							<label class="radio-inline">
							  <input type="radio" name="email_type" value="2" <?php echo (isset($settings['email_type']) && $settings['email_type'] == '2')?'checked=""':''; ?>>
							  SMTP
							</label>
						</div>
					</div>
					<div class="smtpDiv <?php echo (isset($settings['email_type']) && $settings['email_type'] == '2')?'':'none'; ?>">
						<div class="form-group">
							<label for="smtp_host">SMTP Host</label>
							<input type="text" class="form-control" name="smtp_host" placeholder="ssl://smtp.example.com" value="<?php echo !empty($settings['smtp_host'])?$settings['smtp_host']:''; ?>">
							<?php echo form_error('smtp_host','<p class="help-block error">','</p>'); ?>
						</div>
						<div class="form-group">
							<label for="smtp_port">SMTP Port</label>
							<input type="text" class="form-control" name="smtp_port" placeholder="465" value="<?php echo !empty($settings['smtp_port'])?$settings['smtp_port']:''; ?>">
							<?php echo form_error('smtp_port','<p class="help-block error">','</p>'); ?>
						</div>
						<div class="form-group">
							<label for="smtp_user">SMTP User</label>
							<input type="text" class="form-control" name="smtp_user" placeholder="email@example.com" value="<?php echo !empty($settings['smtp_user'])?$settings['smtp_user']:''; ?>">
							<?php echo form_error('smtp_user','<p class="help-block error">','</p>'); ?>
						</div>
						<div class="form-group">
							<label for="smtp_pass">SMTP Password</label>
							<input type="text" class="form-control" name="smtp_pass" placeholder="*****" value="<?php echo !empty($settings['smtp_pass'])?$settings['smtp_pass']:''; ?>">
							<?php echo form_error('smtp_pass','<p class="help-block error">','</p>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="facebook_url">Facebook URL</label>
						<input type="text" class="form-control" name="facebook_url" placeholder="https://www.facebook.com" value="<?php echo !empty($settings['facebook_url'])?$settings['facebook_url']:''; ?>">
						<?php echo form_error('facebook_url','<p class="help-block error">','</p>'); ?>
					</div>
					<div class="form-group">
						<label for="twitter_url">Twitter URL</label>
						<input type="text" class="form-control" name="twitter_url" placeholder="https://twitter.com" value="<?php echo !empty($settings['twitter_url'])?$settings['twitter_url']:''; ?>">
						<?php echo form_error('twitter_url','<p class="help-block error">','</p>'); ?>
					</div>
					<div class="form-group">
						<label for="linkedin_url">LinkedIn URL</label>
						<input type="text" class="form-control" name="linkedin_url" placeholder="https://www.linkedin.com" value="<?php echo !empty($settings['linkedin_url'])?$settings['linkedin_url']:''; ?>">
						<?php echo form_error('linkedin_url','<p class="help-block error">','</p>'); ?>
					</div>
					
				</div>

				<div class="box-footer">
					<input type="submit" name="siteSubmit" class="btn btn-primary" value="Update"/>
				</div>
			</div>
		</div>
		</form>
	</div>
</section>

<script>
$(document).ready(function(){
	$('input').on('ifChecked', function(event){
		if($(this).val() == 2){
				$('.smtpDiv').removeClass('none');
		}else{
				$('.smtpDiv').addClass('none');
		}
	});
});
</script>