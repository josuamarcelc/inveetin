<!-- bootstrap wysihtml5 - text editor -->
<link rel="stylesheet" href="<?php echo $this->config->item('public_url'); ?>admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  
<section class="content-header">
	<h1><?php echo $action; ?> Page<small>cms page content <?php echo strtolower($action); ?></small></h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo $this->config->item('admin_url'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="<?php echo $this->config->item('admin_url'); ?>manage_cms/"><i class="fa files-o"></i> CMS</a></li>
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
		<div class="col-md-9">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title"><?php echo $action; ?> Page Content</h3>
				</div>
				<div class="box-body">
					<div class="form-group">
						<label for="title">Page Title</label>
						<input type="text" class="form-control" name="title" placeholder="Enter title" value="<?php echo !empty($cms['title'])?$cms['title']:''; ?>" required="">
						<?php echo form_error('title','<p class="help-block error">','</p>'); ?>
					</div>
					<div class="form-group">
						<label for="content">Page Content</label>
						<textarea name="content" id="content" class="textarea" placeholder="Place page content here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo !empty($cms['content'])?$cms['content']:''; ?></textarea>
					</div>
					<div class="form-group">
						<label for="page_slug">Page Slug <small class="text-muted">leave blank for automatic url</small></label>
						<input type="text" class="form-control" name="page_slug" value="<?php echo !empty($cms['page_slug'])?$cms['page_slug']:''; ?>">
						<?php echo form_error('page_slug','<p class="help-block error">','</p>'); ?>
					</div>
					<div class="form-group">
						<label for="status">Status</label>
						<div>
							<label class="radio-inline">
							  <input type="radio" id="status" name="status" value="1" <?php echo (empty($cms['status']) || !empty($cms['status']) && $cms['status'] == '1')?'checked=""':''; ?>>
							  Active
							</label>
							<label class="radio-inline">
							  <input type="radio" id="status" name="status" value="0" <?php echo (isset($cms['status']) && $cms['status'] == '0')?'checked=""':''; ?>>
							  Inactive
							</label>
						</div>
					</div>
				</div>

				<div class="box-footer">
					<input type="submit" name="cmsSubmit" class="btn btn-primary" value="Submit"/>
				</div>
			</div>
		</div>
		</form>
	</div>
</section>

<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo $this->config->item('public_url'); ?>admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script>
$(function () {
	//bootstrap WYSIHTML5 - text editor
	$(".textarea").wysihtml5();
});
</script>