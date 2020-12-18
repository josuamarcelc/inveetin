<!DOCTYPE html>
<html>
<head>
	<!-- render head view -->
	<?php echo $head; ?>
</head>
<body class="hold-transition skin-blue fixed sidebar-mini">
<div class="wrapper">
	<!-- render header view -->
	<?php echo $header; ?>
	<!-- Left side column. contains the sidebar -->
	<aside class="main-sidebar">
		<!-- render navigation bar content view -->
		<?php echo $navigation_sidebar; ?>
	</aside>
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- render main page content view -->
		<?php echo $maincontent; ?>
	</div>
	<!-- /.content-wrapper -->
	<footer class="main-footer">
		<!-- render footer view -->
		<?php echo $footer; ?>
	</footer>
</div>
</body>
</html>

