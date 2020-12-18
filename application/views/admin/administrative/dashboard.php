<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>Dashboard<small>Control panel</small></h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo $this->config->item('admin_url'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Dashboard</li>
	</ol>
</section>

<!-- Main content -->
<section class="content">
	<!-- Small boxes (Stat box) -->
	<div class="row">
		<div class="col-lg-3 col-xs-6">
			<div class="small-box bg-aqua">
				<div class="inner">
					<h3><?php echo $totalCmsNum; ?></h3>
					<p>CMS Pages</p>
				</div>
				<div class="icon">
					<i class="ion ion-document-text"></i>
				</div>
				<a href="<?php echo $this->config->item('admin_url'); ?>manage_cms/" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
	  <div class="col-lg-3 col-xs-6">
			<div class="small-box bg-yellow">
				<div class="inner">
					<h3><?php echo $totalMemberNum; ?></h3>
					<p>Members</p>
				</div>
				<div class="icon">
					<i class="ion ion-person-add"></i>
				</div>
				<a href="<?php echo $this->config->item('admin_url'); ?>manage_users/" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
			</div>
	  </div>
	  <div class="col-lg-3 col-xs-6">
			<div class="small-box bg-green">
				<div class="inner">
					<h3>53<sup style="font-size: 20px">%</sup></h3>
					<p>Bounce Rate</p>
				</div>
				<div class="icon">
					<i class="ion ion-stats-bars"></i>
				</div>
				<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
			</div>
	  </div>
	  <div class="col-lg-3 col-xs-6">
			<div class="small-box bg-red">
				<div class="inner">
					<h3>65</h3>
					<p>Unique Visitors</p>
				</div>
				<div class="icon">
					<i class="ion ion-pie-graph"></i>
				</div>
				<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
			</div>
	  </div>
	</div>
	<div class="callout callout-info">
		<h4>Tip!</h4>
		<p>Add the fixed class to the body tag to get this layout. The fixed layout is your best option if your sidebar
		  is bigger than your content because it prevents extra unwanted scrolling.</p>
	</div>
	<!-- Default box -->
	<div class="box">
		<div class="box-header with-border">
			<h3 class="box-title">Title</h3>
			<div class="box-tools pull-right">
				  <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
					<i class="fa fa-minus"></i></button>
				  <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
					<i class="fa fa-times"></i></button>
			</div>
		</div>
		<div class="box-body">
			Start creating your amazing application!
		</div>
		<div class="box-footer">
			Footer
		</div>
	</div>

</section>