<section class="content-header">
	<h1>Member Details<small>details information about the user</small></h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo $this->config->item('admin_url'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="<?php echo $this->config->item('admin_url'); ?>manage_users/"><i class="fa fa-users"></i> Members</a></li>
		<li class="active">Member Details</li>
	</ol>
</section>
<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<a href="<?php echo $listURL; ?>" class="btn btn-success pull-right"><i class="fa fa-arrow-left"></i> Back</a>
        </div>
		<div class="col-md-8">
			<div class="box box-widget widget-user-2">
				<div class="widget-user-header bg-yellow">
					<div class="widget-user-image">
						<?php
							$profilePic = !empty($user['picture'])?$this->config->item('upload_url').'profile_picture/thumb/'.$user['picture']:$this->config->item('public_url').'admin/images/profile-pic.png';
						?>
						<img class="img-circle" src="<?php echo $profilePic; ?>" alt="User Avatar">
					</div>
					<h3 class="widget-user-username"><?php echo $user['full_name']; ?></h3>
					<h5 class="widget-user-desc"><?php echo $user['bio']; ?></h5>
				</div>
				<div class="box-footer no-padding">
					<ul class="nav nav-stacked">
					  <li><a href="#">Email <span class="pull-right badge"><?php echo $user['email']; ?></span></a></li>
					  <li><a href="#">Phone <span class="pull-right badge"><?php echo $user['phone']; ?></span></a></li>
					  <li><a href="#">Gender <span class="pull-right badge"><?php echo $user['gender']; ?></span></a></li>
					  <li><a href="#">DOB <span class="pull-right badge"><?php echo $user['dob']; ?></span></a></li>
					  <li>
						<?php
						$stcl_arr = array('1'=>'bg-green','0'=>'bg-red');
						$stcls = $stcl_arr[$user['status']];
						?>
						<a href="#">Status <span class="pull-right badge <?php echo $stcls; ?>"><?php echo ($user['status'] == '1')?'Active':'Inactive'; ?></span></a>
					  </li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</section>