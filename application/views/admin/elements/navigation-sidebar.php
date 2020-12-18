<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">
	<!-- sidebar menu: : style can be found in sidebar.less -->
	<ul class="sidebar-menu">
		<li class="header">MAIN NAVIGATION</li>
		<li class="treeview <?php echo ($this->uri->segment(1) == 'admin' && $this->uri->segment(2) == '')?'active':''; ?>">
			<a href="<?php echo $this->config->item('admin_url'); ?>">
				<i class="fa fa-dashboard"></i> <span>Dashboard</span>
			</a>
		</li>
		<li class="treeview <?php echo ($this->uri->segment(2) == 'manage_users')?'active':''; ?>">
			<a href="#">
				<i class="fa fa-users"></i>
				<span>Members</span>
				<span class="pull-right-container">
					<i class="fa fa-angle-left pull-right"></i>
				</span>
			</a>
			<ul class="treeview-menu <?php echo ($this->uri->segment(2) == 'manage_users')?'active':''; ?>">
				<li <?php echo ($this->uri->segment(2) == 'manage_users' && $this->uri->segment(3) == '')?'class="active"':''; ?>><a href="<?php echo $this->config->item('admin_url'); ?>manage_users/"><i class="fa fa-circle-o"></i> All Members</a></li>
				<li <?php echo ($this->uri->segment(2) == 'manage_users' && $this->uri->segment(3) == 'add')?'class="active"':''; ?>><a href="<?php echo $this->config->item('admin_url'); ?>manage_users/add/"><i class="fa fa-circle-o"></i> Add Member</a></li>
			</ul>
		</li>
		<li class="treeview <?php echo ($this->uri->segment(2) == 'manage_cms')?'active':''; ?>">
			<a href="#">
				<i class="fa fa-files-o"></i>
				<span>CMS Pages</span>
				<span class="pull-right-container">
					<i class="fa fa-angle-left pull-right"></i>
				</span>
			</a>
			<ul class="treeview-menu">
				<li <?php echo ($this->uri->segment(2) == 'manage_cms' && $this->uri->segment(3) == '')?'class="active"':''; ?>><a href="<?php echo $this->config->item('admin_url'); ?>manage_cms/"><i class="fa fa-circle-o"></i> All Pages</a></li>
				<li <?php echo ($this->uri->segment(2) == 'manage_cms' && $this->uri->segment(3) == 'add')?'class="active"':''; ?>><a href="<?php echo $this->config->item('admin_url'); ?>manage_cms/add/"><i class="fa fa-circle-o"></i> Add Content</a></li>
			</ul>
		</li>
		<li class="treeview <?php echo ($this->uri->segment(2) == 'site_settings')?'active':''; ?>">
			<a href="<?php echo $this->config->item('admin_url'); ?>site_settings/">
				<i class="fa fa-cogs"></i> <span>Site Settings</span>
			</a>
		</li>
		<li class="header">SAMPLE MENU</li>
		<li class="treeview">
			<a href="#">
				<i class="fa fa-files-o"></i>
				<span>Layout Options</span>
				<span class="pull-right-container">
					<span class="label label-primary pull-right">4</span>
				</span>
			</a>
			<ul class="treeview-menu">
				<li><a href="#"><i class="fa fa-circle-o"></i> Top Navigation</a></li>
				<li><a href="#"><i class="fa fa-circle-o"></i> Boxed</a></li>
				<li><a href="#"><i class="fa fa-circle-o"></i> Fixed</a></li>
				<li><a href="#"><i class="fa fa-circle-o"></i> Collapsed Sidebar</a></li>
			</ul>
		</li>
		<li>
			<a href="#">
				<i class="fa fa-th"></i> <span>Widgets</span>
				<span class="pull-right-container">
					<small class="label pull-right bg-green">new</small>
				</span>
			</a>
		</li>
		<li class="treeview">
			<a href="#">
				<i class="fa fa-pie-chart"></i>
				<span>Charts</span>
				<span class="pull-right-container">
					<i class="fa fa-angle-left pull-right"></i>
				</span>
			</a>
			<ul class="treeview-menu">
				<li><a href="#"><i class="fa fa-circle-o"></i> ChartJS</a></li>
				<li><a href="#"><i class="fa fa-circle-o"></i> Morris</a></li>
				<li><a href="#"><i class="fa fa-circle-o"></i> Flot</a></li>
				<li><a href="#"><i class="fa fa-circle-o"></i> Inline charts</a></li>
			</ul>
		</li>
		<li class="treeview">
			<a href="#">
				<i class="fa fa-laptop"></i>
				<span>UI Elements</span>
				<span class="pull-right-container">
					<i class="fa fa-angle-left pull-right"></i>
				</span>
			</a>
			<ul class="treeview-menu">
				<li><a href="#"><i class="fa fa-circle-o"></i> General</a></li>
				<li><a href="#"><i class="fa fa-circle-o"></i> Icons</a></li>
				<li><a href="#"><i class="fa fa-circle-o"></i> Buttons</a></li>
				<li><a href="#"><i class="fa fa-circle-o"></i> Sliders</a></li>
				<li><a href="#"><i class="fa fa-circle-o"></i> Timeline</a></li>
				<li><a href="#"><i class="fa fa-circle-o"></i> Modals</a></li>
			</ul>
		</li>
		<li class="treeview">
			<a href="#">
				<i class="fa fa-edit"></i> <span>Forms</span>
				<span class="pull-right-container">
					<i class="fa fa-angle-left pull-right"></i>
				</span>
			</a>
			<ul class="treeview-menu">
				<li><a href="#"><i class="fa fa-circle-o"></i> General Elements</a></li>
				<li><a href="#"><i class="fa fa-circle-o"></i> Advanced Elements</a></li>
				<li><a href="#"><i class="fa fa-circle-o"></i> Editors</a></li>
			</ul>
		</li>
		<li class="treeview">
			<a href="#">
				<i class="fa fa-table"></i> <span>Tables</span>
				<span class="pull-right-container">
					<i class="fa fa-angle-left pull-right"></i>
				</span>
			</a>
			<ul class="treeview-menu">
				<li><a href="#"><i class="fa fa-circle-o"></i> Simple tables</a></li>
				<li><a href="#"><i class="fa fa-circle-o"></i> Data tables</a></li>
			</ul>
		</li>
		<li>
			<a href="#">
				<i class="fa fa-calendar"></i> <span>Calendar</span>
				<span class="pull-right-container">
					<small class="label pull-right bg-red">3</small>
					<small class="label pull-right bg-blue">17</small>
				</span>
			</a>
		</li>
		<li>
			<a href="#">
				<i class="fa fa-envelope"></i> <span>Mailbox</span>
				<span class="pull-right-container">
					<small class="label pull-right bg-yellow">12</small>
					<small class="label pull-right bg-green">16</small>
					<small class="label pull-right bg-red">5</small>
				</span>
			</a>
		</li>
		<li class="treeview">
			<a href="#">
				<i class="fa fa-folder"></i> <span>Examples</span>
				<span class="pull-right-container">
					<i class="fa fa-angle-left pull-right"></i>
				</span>
			</a>
			<ul class="treeview-menu">
				<li><a href="#"><i class="fa fa-circle-o"></i> Invoice</a></li>
				<li><a href="#"><i class="fa fa-circle-o"></i> Profile</a></li>
				<li><a href="#"><i class="fa fa-circle-o"></i> Login</a></li>
				<li><a href="#"><i class="fa fa-circle-o"></i> Register</a></li>
				<li><a href="#"><i class="fa fa-circle-o"></i> Lockscreen</a></li>
				<li><a href="#"><i class="fa fa-circle-o"></i> 404 Error</a></li>
				<li><a href="#"><i class="fa fa-circle-o"></i> 500 Error</a></li>
				<li><a href="#"><i class="fa fa-circle-o"></i> Blank Page</a></li>
				<li><a href="#"><i class="fa fa-circle-o"></i> Pace Page</a></li>
			</ul>
		</li>
		<li class="treeview">
			<a href="#">
				<i class="fa fa-share"></i> <span>Multilevel</span>
				<span class="pull-right-container">
					<i class="fa fa-angle-left pull-right"></i>
				</span>
			</a>
			<ul class="treeview-menu">
				<li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
				<li>
					<a href="#"><i class="fa fa-circle-o"></i> Level One
						<span class="pull-right-container">
							<i class="fa fa-angle-left pull-right"></i>
						</span>
					</a>
					<ul class="treeview-menu">
						<li><a href="#"><i class="fa fa-circle-o"></i> Level Two</a></li>
						<li>
							<a href="#"><i class="fa fa-circle-o"></i> Level Two
								<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
								</span>
							</a>
							<ul class="treeview-menu">
								<li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
								<li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
							</ul>
						</li>
					</ul>
				</li>
				<li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
			</ul>
		</li>
		<li><a href="#"><i class="fa fa-book"></i> <span>Documentation</span></a></li>
		<li class="header">LABELS</li>
		<li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
		<li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
		<li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>
	</ul>
</section>
<!-- /.sidebar -->