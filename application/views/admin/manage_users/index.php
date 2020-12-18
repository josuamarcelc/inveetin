<section class="content-header">
	<h1>Manage Members<small>manage all users of the site</small></h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo $this->config->item('admin_url'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Manage members</li>
	</ol>
</section>
<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<a href="<?php echo $addURL; ?>" class="btn btn-success pull-right"><i class="fa fa-user-plus"></i> Add New</a>
        </div>
		<?php if(!empty($success_msg)){ ?>
		<div class="col-xs-12">
			<div class="alert alert-success"><?php echo $success_msg; ?></div>
		</div>
		<?php }elseif(!empty($error_msg)){ ?>
		<div class="col-xs-12">
			<div class="alert alert-danger"><?php echo $error_msg; ?></div>
		</div>
		<?php } ?>
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">All Members</h3>
					<div class="box-tools">
						<form name="search_form" action="<?php echo $listURL; ?>" method="post"/>
						<div class="input-group input-group-sm" style="width: 350px;">
							<input type="text" name="searchKeyword" placeholder="Enter keywords..." value="<?php echo !empty($searchKeyword)?$searchKeyword:''; ?>" class="form-control pull-right">
							<div class="input-group-btn">
								<input type="submit" name="submitSearch" class="btn btn-default" value="SEARCH">
								<input type="submit" name="submitSearchReset" class="btn btn-default" value="RESET">
							</div>
						</div>
						</form>
					</div>
				</div>
				<div class="box-body table-responsive no-padding">
					<table class="table table-hover">
						<tr>
							<th>ID</th>
							<th>Name</th>
							<th>Email</th>
							<th>Phone</th>
							<th>Created</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
						<?php if(!empty($users)){ foreach($users as $urow){?>
                        <?php
						$stcl_arr = array('1'=>'label-success','0'=>'label-danger');
						$stcls = $stcl_arr[$urow['status']];
						?>
						<tr>
							<td><?php echo '#'.$urow['id']; ?></td>
							<td><?php echo $urow['full_name']; ?></td>
							<td><?php echo $urow['email']; ?></td>
							<td><?php echo $urow['phone']; ?></td>
							<td><?php echo date("M d, Y", strtotime($urow['created'])); ?></td>
							<td><span class="label <?php echo $stcls; ?>"><?php echo ($urow['status'] == '1')?'Active':'Deactive'; ?></span></td>
							<td class="action-links">
                                <a href="<?php echo str_replace('{ID}',$urow['id'],$detailsURL); ?>" title="View Details" data-skin="skin-yellow" class="btn btn-warning btn-xs"><i class="fa fa-eye" aria-hidden="true"></i></a>
								<a href="<?php echo str_replace('{ID}',$urow['id'],$editURL); ?>" title="Edit" data-skin="skin-purple" class="btn bg-purple btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
								<?php if($urow['status'] == '1'){ ?>
								<a href="<?php echo str_replace('{ID}',$urow['id'],$blockURL); ?>" onclick="return confirm('Are you sure to block?')" title="Click to deactivate" data-skin="skin-blue" class="btn btn-primary btn-xs"><i class="fa fa-ban" aria-hidden="true"></i></a>
								<?php }else{ ?>
								<a href="<?php echo str_replace('{ID}',$urow['id'],$unblockURL); ?>" onclick="return confirm('Are you sure to unblock?')" title="Click to activate" data-skin="skin-blue" class="btn btn-primary btn-xs"><i class="fa fa-check-square-o" aria-hidden="true"></i></a>
								<?php } ?>
                                <a href="<?php echo str_replace('{ID}',$urow['id'],$deleteURL); ?>" onclick="return confirm('Are you sure to delete?')" title="Delete" data-skin="skin-red" class="btn btn-danger btn-xs"><i class="fa fa-trash" aria-hidden="true"></i></a>
							</td>
						</tr>
						<?php } }else{ ?>
                         <tr><td colspan="7">Member(s) not found....</td></tr>    
                        <?php } ?>
					</table>
				</div>
				<div class="box-footer clearfix">
					<ul class="pagination pagination-sm no-margin pull-right">
						<?php echo $this->pagination->create_links(); ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</section>