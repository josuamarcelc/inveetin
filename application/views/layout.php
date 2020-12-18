<!DOCTYPE html>
<html lang="en">
<head>
	<!-- Render head view -->
	<?php echo $head; ?>
</head>
<body>
	<!-- Render top navigation view -->
	<?php echo $navigation; ?>
	
	<?php if($this->uri->segment(1) == ''){ ?>
		<!-- Render header view -->
		<?php echo $header; ?>
	<?php } ?>
	
	<div class="main-container">
		<!-- Render main page content view -->
		<?php echo $maincontent; ?>
	</div>

	<div class="footer">
		<!-- Render footer view -->
		<?php echo $footer; ?>
	</div>
</body>
</html>

