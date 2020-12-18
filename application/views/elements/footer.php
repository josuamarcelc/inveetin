<!-- Footer -->
<footer class="footer bg-dark">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 h-100 text-center text-lg-left my-auto">
				<ul class="list-inline mb-2">
					<li class="list-inline-item">
						<a href="#">About</a>
					</li>
					<li class="list-inline-item text-white-50">⋅</li>
					<li class="list-inline-item">
						<a href="#">Contact</a>
					</li>
					<li class="list-inline-item text-white-50">⋅</li>
					<li class="list-inline-item">
						<a href="#">Terms of Use</a>
					</li>
					<li class="list-inline-item text-white-50">⋅</li>
					<li class="list-inline-item">
						<a href="#">Privacy Policy</a>
					</li>
				</ul>
				<p class="text-white-50 small mb-4 mb-lg-0">&copy; <?php echo $siteSettings['name'].' '.date("Y"); ?>. All Rights Reserved.</p>
			</div>
			<div class="col-lg-6 h-100 text-center text-lg-right my-auto">
				<ul class="list-inline mb-0">
					<?php if(!empty($siteSettings['facebook_url'])){ ?>
					<li class="list-inline-item mr-3">
						<a href="<?php echo $siteSettings['facebook_url']; ?>" target="_blank">
							<i class="fa-facebook"></i>
						</a>
					</li>
					<?php } ?>
					<?php if(!empty($siteSettings['twitter_url'])){ ?>
					<li class="list-inline-item mr-3">
						<a href="<?php echo $siteSettings['twitter_url']; ?>" target="_blank">
							<i class="fa-twitter"></i>
						</a>
					</li>
					<?php } ?>
					<?php if(!empty($siteSettings['linkedin_url'])){ ?>
					<li class="list-inline-item">
						<a href="<?php echo $siteSettings['linkedin_url']; ?>" target="_blank">
							<i class="fa-linkedin"></i>
						</a>
					</li>
					<?php } ?>
				</ul>
			</div>
		</div>
	</div>
</footer>



<!--<footer class="py-5 bg-dark">
	<div class="container">
		<p class="m-0 text-center text-white">Copyright &copy; <?php //echo date("Y"); ?> CodeIgniter Admin Panel. All Rights Reserved | Developed by <a href="http://www.codexworld.com" target="_blank">CodexWorld</p>
	</div>
</footer>-->