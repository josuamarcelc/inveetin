<div class="container">
	<div class="row">
		<div class="col-lg-12 mx-auto mt-5">
			<?php if(!empty($page)){ ?>
				<h1><?php echo $page['title']; ?></h1>
				<div class="page-content">
					<?php echo $page['content']; ?>
				</div>
			<?php }else{ ?>
				<h3>Page not found!</h3>
			<?php } ?>
		</div>
	</div>
</div>