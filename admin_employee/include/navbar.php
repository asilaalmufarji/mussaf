<body class="sidebar-xs">
	<script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>

	<script>
		$(document).ready(function() {
			$(".hidload").show();
			$("#loadpage").hide();
		});
	</script>
	<style type="text/css">
		#loadpage {
			position: fixed;
			top: 50%;
			left: 50%;
			transform: translate(-50%, -50%);
			transform: -webkit-translate(-50%, -50%);
			transform: -moz-translate(-50%, -50%);
			transform: -ms-translate(-50%, -50%);
			color: darkred;
		}
	</style>
	<div id="loadpage" height="100%">
		<img src="../icon/loading_page.gif" />
	</div>

	<div class="navbar navbar-expand-md navbar-light hidload" style="display: none;">
		<div class="navbar-header navbar-dark d-none d-md-flex align-items-md-center">
			<div class="navbar-brand navbar-brand-md">
				<a href="../index.php" class="d-inline-block">
					<img src="upload/logo.png" alt="">
				</a>
			</div>
			<div class="navbar-brand navbar-brand-xs">
				<a href="../index.php" class="d-inline-block">
					<img src="upload/logo_icon_light.png" alt="">
				</a>
			</div>
		</div>
		<div class="d-flex flex-1 d-md-none">
			<div class="navbar-brand mr-auto">
				<a href="../index.php" class="d-inline-block">
					<img src="upload/logo-dark.png" alt="">
				</a>
			</div>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">
				<i class="icon-tree5"></i>
			</button>
			<button class="navbar-toggler sidebar-mobile-main-toggle" type="button">
				<i class="icon-paragraph-justify3"></i>
			</button>
		</div>
		<div class="collapse navbar-collapse  pl-0" id="navbar-mobile">
			<ul class="navbar-nav">
				<li class="nav-item">
					<a href="#" class="navbar-nav-link sidebar-control sidebar-main-toggle d-none d-md-block">
						<i class="icon-paragraph-justify3"></i>
					</a>
				</li>
			</ul>
			<ul class="navbar-nav ms-auto">
				<li class="nav-item dropdown dropdown-user">
					<a href="#" class="navbar-nav-link d-flex align-items-center dropdown-toggle" data-toggle="dropdown">
						<img src="upload/user.png" class="rounded-circle mr-2" height="34" alt="">
						<span> <?php echo $_SESSION['emp_name'];?> </span>
					</a>
					<div class="dropdown-menu dropdown-menu-right">
						<a href="setting.php" class="dropdown-item"><i class="icon-cog5"></i>settings</a>
						<div class="dropdown-divider"></div>
						<a href="logout.php" class="dropdown-item"><i class="icon-switch2"></i> Logout</a>
					</div>
				</li>
			</ul>
		</div>
	</div>
	<div class="page-content hidload" style="display: none;">
		<div class="sidebar sidebar-dark sidebar-main sidebar-expand-md">
			<div class="sidebar-mobile-toggler text-center">
				<a href="#" class="sidebar-mobile-main-toggle">
					<i class="icon-arrow-left8"></i>
				</a>
				Navigation
				<a href="#" class="sidebar-mobile-expand">
					<i class="icon-screen-full"></i>
					<i class="icon-screen-normal"></i>
				</a>
			</div>
			<div class="sidebar-content">
				<div class="card card-sidebar-mobile">
					<span style="height:40px"></span>
					<ul class="nav nav-sidebar" data-nav-type="accordion" id="sidebar">
						<li class="nav-item  "><a href="index.php" target="" class="nav-link" id="menu_home"><i class="icon-home4" title="Dashboard" data-toggle="tooltip" data-placement="right"></i><span>Dashboard</span></a></li>
						<li class="nav-item  "><a href="index.php?module=customer" target="" class="nav-link  " id="menu_class"><i class="icon-stack2" title="Instances" data-toggle="tooltip" data-placement="right"></i><span>Ticket</span></a></li>


							<li class="nav-item  "><a href="index.php?module=insurance" target="" class="nav-link  " id="menu_class"><i class="icon-stack2" title="Instances" data-toggle="tooltip" data-placement="right"></i><span>Insurance</span></a></li>


								<li class="nav-item  "><a href="index.php?module=health_care" target="" class="nav-link  " id="menu_class"><i class="icon-stack2" title="Instances" data-toggle="tooltip" data-placement="right"></i><span>Health care</span></a></li>


									<li class="nav-item  "><a href="index.php?module=worker" target="" class="nav-link  " id="menu_class"><i class="icon-stack2" title="Instances" data-toggle="tooltip" data-placement="right"></i><span>Worker</span></a></li>


										<li class="nav-item  "><a href="index.php?module=study_outside" target="" class="nav-link  " id="menu_class"><i class="icon-stack2" title="Instances" data-toggle="tooltip" data-placement="right"></i><span>Study out side</span></a></li>

						<!--<li class="nav-item nav-item-submenu ">
							<a href="#" class="nav-link text-capitalize   ">
								<i class="icon-folder5"></i>
								<span>instance</span>
							</a>
							<ul class="nav nav-group-sub" data-submenu-title="instance" style="">
								<li class="nav-item text-uppercase ">
									<a href="status.php" class="nav-link ">
										<span class="badge badge-primary mr-2 text-uppercase">get</span>
										Status </a>
								</li>
							</ul>
						</li> -->
						<li class="nav-item-header">
							<div class="text-uppercase font-size-xs line-height-xs">Support</div> <i class="icon-menu" title="Support"></i>
						</li>
						<li class="nav-item  "><a href="logout.php" target="" class="nav-link  "><i class="icon-envelop" title="Contact US" data-toggle="tooltip" data-placement="right"></i><span>Log out</span></a></li>
					</ul>
				</div>
			</div>
		</div>