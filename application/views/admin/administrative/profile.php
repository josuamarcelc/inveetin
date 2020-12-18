<section class="content-header">
	<h1>Admin Profile</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo $this->config->item('admin_url'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Admin profile</li>
	</ol>
</section>
<?php
$profilePic = !empty($user['picture'])?$this->config->item('upload_url').'profile_picture/thumb/'.$user['picture']:$this->config->item('public_url').'admin/images/admin-profile-pic.png';
?>
<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-md-3">
			<!-- Profile Image -->
			<div class="box box-primary">
				<div class="box-body box-profile">
					<img class="profile-user-img img-responsive img-circle" src="<?php echo $profilePic; ?>" alt="User profile picture">
					<h3 class="profile-username text-center"><?php echo $user['first_name'].' '.$user['last_name']; ?></h3>
					<p class="text-muted text-center">Administrator</p>
					<ul class="list-group list-group-unbordered">
						<li class="list-group-item">
							<b><?php echo $user['email']; ?></b>
						</li>
						<!--<li class="list-group-item">
							<b>Following</b> <a class="pull-right">543</a>
						</li>-->
					</ul>
					<!--<a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>-->
				</div>
			</div>
		</div>
		<div class="col-md-9">
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<li class="<?php echo $infoTab; ?>"><a href="#timeline" data-toggle="tab">Info</a></li>
					<li class="<?php echo $settingsTab; ?>"><a href="#settings" data-toggle="tab">Settings</a></li>
				</ul>	
				<div class="tab-content">
					<!-- /.tab-pane -->
					<div class="tab-pane <?php echo $infoTab; ?>" id="timeline">
						<!-- The timeline -->
						<form class="form-horizontal">
						<div class="form-group">
							<label for="inputName" class="col-sm-2 control-label">Name</label>
							<div class="col-sm-10">
								<p><?php echo $user['first_name'].' '.$user['last_name']; ?></p>
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail" class="col-sm-2 control-label">Email</label>
							<div class="col-sm-10">
								<p><?php echo $user['email']; ?></p>
							</div>
						</div>
						<div class="form-group">
							<label for="inputName" class="col-sm-2 control-label">Username</label>
							<div class="col-sm-10">
								<p><?php echo $user['username']; ?></p>
							</div>
						</div>
						</form>
					</div>
					<!-- /.tab-pane -->
	
					<div class="tab-pane <?php echo $settingsTab; ?>" id="settings">
						<?php 
							if(!empty($success_msg)){
								echo '<div class="alert alert-success">'.$success_msg.'</div>';
							}elseif(!empty($error_msg)){
								echo '<div class="alert alert-danger">'.$error_msg.'</div>';
							}
						?>
						<h2 class="page-header">
							<i class="fa fa-globe"></i> Update Profile Information
						</h2>
						<form class="form-horizontal" method="post" enctype="multipart/form-data">
						<div class="form-group">
							<label for="inputName" class="col-sm-2 control-label">Profile Picture</label>
							<div class="col-sm-10">
								<input type="file" class="form-control" name="picture">
								<?php echo form_error('picture','<span class="help-block error">','</span>'); ?>
							</div>
						</div>
						<div class="form-group">
							<label for="inputName" class="col-sm-2 control-label">First Name</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="first_name" placeholder="First Name" value="<?php echo !empty($user['first_name'])?$user['first_name']:''; ?>" required="">
								<?php echo form_error('first_name','<span class="help-block error">','</span>'); ?>
							</div>
						</div>
						<div class="form-group">
							<label for="inputName" class="col-sm-2 control-label">Last Name</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="last_name" placeholder="Last Name" value="<?php echo !empty($user['last_name'])?$user['last_name']:''; ?>" required="">
								<?php echo form_error('last_name','<span class="help-block error">','</span>'); ?>
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail" class="col-sm-2 control-label">Email</label>
							<div class="col-sm-10">
								<input id="email" class="form-control" type="email" name="email" placeholder="Email Address" value="<?php echo !empty($user['email'])?$user['email']:''; ?>" required="">
								<?php echo form_error('email','<span class="help-block error">','</span>'); ?>
							</div>
						</div>
						<div class="form-group">
							<label for="inputName" class="col-sm-2 control-label">Username</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="username" id="username" placeholder="Login username" value="<?php echo !empty($user['username'])?$user['username']:''; ?>">
								<?php echo form_error('username','<span class="help-block error">','</span>'); ?>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<input type="submit" name="updateProfile" class="btn btn-danger" value="Submit"/>
							</div>
						</div>
						</form>
						
						<h2 class="page-header">
							<i class="fa fa-globe"></i> Update Password
						</h2>
						<form class="form-horizontal" method="post">
						<div class="form-group">
							<label for="inputName" class="col-sm-2 control-label">Old Password</label>
							<div class="col-sm-10">
								<input type="password" class="form-control" name="old_password" placeholder="Old Password" value="" required="">
								<?php echo form_error('old_password','<span class="help-block error">','</span>'); ?>
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail" class="col-sm-2 control-label">New password</label>
							<div class="col-sm-10">
								<input id="password" class="form-control" type="password" name="password" placeholder="New password" value="" required="">
								<?php echo form_error('password','<span class="help-block error">','</span>'); ?>
							</div>
						</div>
						<div class="form-group">
							<label for="inputName" class="col-sm-2 control-label">Confirm password</label>
							<div class="col-sm-10">
								<input type="password" class="form-control" name="conf_password" id="conf_password" placeholder="Repeat password" value="" required="">
								<?php echo form_error('conf_password','<span class="help-block error">','</span>'); ?>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<input type="submit" name="updatePassword" class="btn btn-danger" value="Submit"/>
							</div>
						</div>
						</form>
						
					</div>
				</div>
			</div>
		</div>
	</div>
</section>