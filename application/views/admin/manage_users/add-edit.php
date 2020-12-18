<section class="content-header">
	<h1><?php echo $action; ?> Member<small>user information <?php echo strtolower($action); ?></small></h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo $this->config->item('admin_url'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="<?php echo $this->config->item('admin_url'); ?>manage_users/"><i class="fa fa-users"></i> Members</a></li>
		<li class="active"><?php echo $action; ?></li>
	</ol>
</section>
<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<a href="<?php echo $listURL; ?>" class="btn btn-success pull-right"><i class="fa fa-arrow-left"></i> Back</a>
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
		<form role="form" method="post" action="" enctype="multipart/form-data">
		<div class="col-md-6">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title"><?php echo $action; ?> Profile Info</h3>
				</div>
				<div class="box-body">
					<div class="form-group">
						<label for="exampleInputFile">Profile Picture</label>
						<?php if(!empty($user['picture'])){ ?>
						<img src="<?php echo base_url().'uploads/profile_picture/'.$user['picture']; ?>" width="120" height="120" />
						<?php } ?>
						<input type="file" id="picture" name="picture">
					</div>
					<div class="form-group">
						<label for="first_name">First Name</label>
						<input type="text" class="form-control" name="first_name" placeholder="Enter first name" value="<?php echo !empty($user['first_name'])?$user['first_name']:''; ?>" required="">
						<?php echo form_error('first_name','<p class="help-block error">','</p>'); ?>
					</div>
					<div class="form-group">
						<label for="last_name">Last Name</label>
						<input type="text" class="form-control" name="last_name" placeholder="Enter last name" value="<?php echo !empty($user['last_name'])?$user['last_name']:''; ?>" required="">
						<?php echo form_error('last_name','<p class="help-block error">','</p>'); ?>
					</div>
					<div class="form-group">
						<label for="email">Email address</label>
						<input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value="<?php echo !empty($user['email'])?$user['email']:''; ?>" required="">
						<?php echo form_error('email','<p class="help-block error">','</p>'); ?>
					</div>
					<div class="form-group">
						<label for="phone">Phone</label>
						<input type="text" class="form-control" name="phone" placeholder="Enter phone" value="<?php echo !empty($user['phone'])?$user['phone']:''; ?>" >
						<?php echo form_error('phone','<p class="help-block error">','</p>'); ?>
					</div>
					<div class="form-group">
						<label for="gender">Gender</label>
						<div>
							<label class="radio-inline">
							  <input type="radio" id="gender" name="gender" value="Male" <?php echo (empty($user['gender']) || !empty($user['gender']) && $user['gender'] == 'Male')?'checked=""':''; ?>>
							  Male
							</label>
							<label class="radio-inline">
							  <input type="radio" id="gender" name="gender" value="Female" <?php echo (!empty($user['gender']) && $user['gender'] == 'Female')?'checked=""':''; ?>>
							  Female
							</label>
						</div>
					</div>
					<div class="form-group">
						<label for="dob">Date of Birth</label>
						<input type="date" class="form-control" id="dob" name="dob" value="<?php echo !empty($user['dob'])?date("Y-m-d",strtotime($user['dob'])):''; ?>">
					</div>
					<div class="form-group">
						<label for="bio">About Me</label>
						<textarea name="bio" id="bio" cols="50" rows="8" class="form-control"><?php echo !empty($user['bio'])?$user['bio']:''; ?></textarea>
					</div>
					<div class="form-group">
						<label for="status">Status</label>
						<div>
							<label class="radio-inline">
							  <input type="radio" id="status" name="status" value="1" <?php echo (empty($user['status']) || !empty($user['status']) && $user['status'] == '1')?'checked=""':''; ?>>
							  Active
							</label>
							<label class="radio-inline">
							  <input type="radio" id="status" name="status" value="0" <?php echo (isset($user['status']) && $user['status'] == '0')?'checked=""':''; ?>>
							  Inactive
							</label>
						</div>
					</div>
				</div>

				<div class="box-footer">
					<input type="submit" name="userSubmit" class="btn btn-primary" value="Submit"/>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title"><?php echo $action; ?> Password</h3>
				</div>
				<form role="form" method="post" action="" >
				<div class="box-body">
					<div class="form-group">
						<label for="password">New Password</label>
						<input type="password" name="password" class="form-control" id="password" placeholder="Password">
						<?php echo form_error('password','<p class="help-block error">','</p>'); ?>
					</div>
					<div class="form-group">
						<label for="conf_password">Confirm Password</label>
						<input type="password" name="conf_password" class="form-control" id="conf_password" placeholder="Repeat Password">
						<?php echo form_error('conf_password','<p class="help-block error">','</p>'); ?>
					</div>
				</div>
				<div class="box-footer">
					<input type="submit" name="userSubmit" class="btn btn-primary" value="Submit"/>
				</div>
			</div>
		</div>
		</form>
	</div>
</section>