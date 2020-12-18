<section class="content-header">
	<h1>Page Details<small>cms page content</small></h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo $this->config->item('admin_url'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="<?php echo $this->config->item('admin_url'); ?>manage_cms/"><i class="fa files-o"></i> CMS</a></li>
		<li class="active">Details</li>
	</ol>
</section>
<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<a href="<?php echo $listURL; ?>" class="btn btn-success pull-right"><i class="fa fa-arrow-left"></i> Back</a>
        </div>
		<div class="col-md-9">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title"><?php echo $cms['title']; ?></h3>
					<div class="pull-right box-tools">
						<a href="<?php echo base_url('cms/'.$cms['page_slug']); ?>" target="_blank"><span class="label label-primary">View Page</span></a>
					</div>
				</div>
				<div class="box-body pad">
					<strong>URL Slug</strong>
					<p class="text-muted"><?php echo $cms['page_slug']; ?></p>
					<hr>
					<strong>Content</strong>
					<?php echo $cms['content']; ?>
					<hr>
					<strong>Status</strong>
					<?php
					$stcl_arr = array('1'=>'label-success','0'=>'label-danger');
					$stcls = $stcl_arr[$cms['status']];
					?>
					<p><span class="label <?php echo $stcls; ?>"><?php echo ($cms['status'] == '1')?'Active':'Inactive'; ?></span></p>
				</div>
			</div>
		</div>
	</div>
</section>