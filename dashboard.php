<?php
require_once "config/helper.php";
if (!isset($_SESSION['login'])) {
    header("Location: login.php");

    exit;
}
?>

<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<!-- Tell the browser to be responsive to screen width -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<!-- Favicon icon -->
	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url() ?>ltr/assets/images/favicon.png?<?= date('YmdHis') ?>">
	<title>IoT Monitoring</title>
	<!-- Custom CSS -->
	<script src="<?php echo base_url() ?>ltr/assets/vendor/datatables/jquery-3.5.1.js"></script>
	<link href="<?php echo base_url() ?>ltr/assets/extra-libs/css-chart/css-chart.css" rel="stylesheet">
	<link href="<?php echo base_url() ?>ltr/assets/extra-libs/jvector/jquery-jvectormap-2.0.2.css" rel="stylesheet" />
	<!-- Custom CSS -->
	<link href="<?php echo base_url() ?>ltr/assets/libs/jquery-steps/jquery.steps.css" rel="stylesheet">
	<link href="<?php echo base_url() ?>ltr/assets/libs/jquery-steps/steps.css" rel="stylesheet">
	<link href="<?php echo base_url() ?>ltr/dist/css/style.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>ltr/assets/offline/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>ltr/assets/offline/buttons.bootstrap4.min.css">

	<link
	  rel="stylesheet"
	  href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css"
	/>
	<link href="<?= base_url()?>ltr/assets/libs/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">
	<link href="<?php echo base_url() ?>ltr/assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
	<link href="<?php echo base_url() ?>ltr/assets/vendor/datatables/responsive.bootstrap4.min.css" rel="stylesheet">
	<link href="<?php echo base_url() ?>ltr/assets/offline/select2.min.css" rel="stylesheet" />
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">

	
	<script src="<?php echo base_url() ?>ltr/assets/libs/jquery/dist/jquery.min.js"></script>
	<script src="<?php echo base_url() ?>ltr/assets/libs/popper.js/dist/umd/popper.min.js"></script>
	<script src="<?php echo base_url() ?>ltr/assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
	<!-- apps -->
	<script src="<?php echo base_url() ?>ltr/dist/js/app.min.js"></script>
	<script src="<?php echo base_url() ?>ltr/dist/js/app.init.js"></script>
	<script src="<?php echo base_url() ?>ltr/dist/js/app-style-switcher.js"></script>
	<!-- slimscrollbar scrollbar JavaScript -->
	<script src="<?php echo base_url() ?>ltr/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
	<script src="<?php echo base_url() ?>ltr/assets/extra-libs/sparkline/sparkline.js"></script>
	<!--Wave Effects -->
	<script src="<?php echo base_url() ?>ltr/dist/js/waves.js"></script>
	<!--Menu sidebar -->
	<script src="<?php echo base_url() ?>ltr/dist/js/sidebarmenu.js"></script>
	<!--Custom JavaScript -->
	<script src="<?php echo base_url() ?>ltr/dist/js/custom.js"></script>
	<!--This page JavaScript -->
	<script src="<?php echo base_url() ?>ltr/assets/extra-libs/jvector/jquery-jvectormap-2.0.2.min.js"></script>
	<script src="<?php echo base_url() ?>ltr/assets/extra-libs/jvector/jquery-jvectormap-world-mill-en.js"></script>
	<script src="<?php echo base_url() ?>ltr/assets/vendor/datatables/jquery.dataTables.min.js"></script>
	<script src="<?php echo base_url() ?>ltr/assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>
	<script src="<?php echo base_url() ?>ltr/assets/vendor/datatables/dataTables.responsive.min.js"></script>
	<script src="<?php echo base_url() ?>ltr/assets/vendor/datatables/responsive.bootstrap4.min.js"></script>
	<script src="<?php echo base_url() ?>ltr/assets/offline/select2.min.js"></script>
	
	<script src="<?= base_url() ?>ltr/assets/libs/sweetalert2/dist/sweetalert2.all.min.js"></script>
	<script type="text/javascript" language="javascript" src="<?php echo base_url() ?>ltr/assets/offline/dataTables.bootstrap4.min.js"></script>
	<script type="text/javascript" language="javascript" src="<?php echo base_url() ?>ltr/assets/offline/dataTables.buttons.min.js"></script>
	<script type="text/javascript" language="javascript" src="<?php echo base_url() ?>ltr/assets/offline/buttons.bootstrap4.min.js"></script>
	<script type="text/javascript" language="javascript" src="<?php echo base_url() ?>ltr/assets/offline/jszip.min.js"></script>
	<script type="text/javascript" language="javascript" src="<?php echo base_url() ?>ltr/assets/offline/pdfmake.min.js"></script>
	<script type="text/javascript" language="javascript" src="<?php echo base_url() ?>ltr/assets/offline/vfs_fonts.js"></script>
	
	<script type="text/javascript" language="javascript" src="<?php echo base_url() ?>ltr/assets/offline/buttons.print.min.js"></script>
	<script type="text/javascript" language="javascript" src="<?php echo base_url() ?>ltr/assets/offline/buttons.colVis.min.js"></script>
	<script type="text/javascript" language="javascript" src="<?php echo base_url() ?>ltr/assets/offline/table2excel.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">

	<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
	<script>
		$(document).ready(function() {
			
		});
	</script>
	<style type="text/css" media="screen">
		html, body{
		  /*font-size: 100%;*/
/*		 font-family: 'Courier', sans-serif;*/
		  scroll-behavior: smooth;
		  --pink : #f5b2e7 !important;
		}
		th{
			font-weight: 900 !important;
		}
		body{
			font-size:0.800rem;
		}
		.btn-flat{
			border-radius: 0px;
		}
		.bg-dark{
			color: white;
		}
		.btn-primary {
			background-color: #035f9f!important;
			border-color: #035f9f!important;
		}
		.bg-primary{
			background-color: #035f9f!important;
			color: white;
			border-bottom: 3px solid #ffc107;
		}
		.bg-dark{
			background-color: #035f9f!important;
			color: white;
			border-bottom: 3px solid #ffc107;
		}
		.page-item.active .page-link{
			background-color: #035f9f!important;
			border-color:#035f9f!important;
		}

		#main-wrapper[data-layout=vertical] .topbar .navbar-collapse[data-navbarbg=skin1], #main-wrapper[data-layout=vertical] .topbar[data-navbarbg=skin1], #main-wrapper[data-layout=horizontal] .topbar .navbar-collapse[data-navbarbg=skin1], #main-wrapper[data-layout=horizontal] .topbar[data-navbarbg=skin1]{
			background:var(--pink) !important;
		}
		#main-wrapper[data-layout=vertical] .topbar .top-navbar .navbar-header[data-logobg=skin6], #main-wrapper[data-layout=horizontal] .topbar .top-navbar .navbar-header[data-logobg=skin6]{
			background:#ffffff!important;
		}
		#main-wrapper[data-layout=vertical] .topbar .top-navbar .navbar-header[data-logobg=skin6] .nav-toggler, #main-wrapper[data-layout=vertical] .topbar .top-navbar .navbar-header[data-logobg=skin6] .topbartoggler, #main-wrapper[data-layout=horizontal] .topbar .top-navbar .navbar-header[data-logobg=skin6] .nav-toggler, #main-wrapper[data-layout=horizontal] .topbar .top-navbar .navbar-header[data-logobg=skin6] .topbartoggler{
			color: white;
		}
		.input-group-text{
			background-color:#e9ecef;
		}
	   /* #main-wrapper[data-layout=vertical] .left-sidebar[data-sidebarbg=skin6], #main-wrapper[data-layout=vertical] .left-sidebar[data-sidebarbg=skin6] .sidebar-nav ul, #main-wrapper[data-layout=horizontal] .left-sidebar[data-sidebarbg=skin6], #main-wrapper[data-layout=horizontal] .left-sidebar[data-sidebarbg=skin6] .sidebar-nav ul{
			background: #414755;
		}*/
		.dataTables_processing{
			background: #2424246b;
			color: white;
		}
		.bg-icon{
			padding: 10px;
		}
		.card{
			box-shadow: rgba(0, 0, 0, 0.15) 8px 8px 0px 0px;
			border: solid 1px var(--pink);
			border-radius: 10px;
/*			box-shadow: rgba(0, 0, 0, 0.15) 0px 2px 8px;*/
		}
		.material-icons {
		  font-family: 'Material Icons';
		  font-weight: normal;
		  font-style: normal;
		  font-size: 24px;  /* Preferred icon size */
		  display: inline-block;
		  line-height: 1;
		  text-transform: none;
		  letter-spacing: normal;
		  word-wrap: normal;
		  white-space: nowrap;
		  direction: ltr;

		  /* Support for all WebKit browsers. */
		  -webkit-font-smoothing: antialiased;
		  /* Support for Safari and Chrome. */
		  text-rendering: optimizeLegibility;

		  /* Support for Firefox. */
		  -moz-osx-font-smoothing: grayscale;

		  /* Support for IE. */
		  font-feature-settings: 'liga';
		}
		.text-info{
			color: var(--pink) !important;
		}
		circle{
			fill: var(--pink) !important;
		}
		path{
			stroke: var(--pink) !important;
		}

		/*Chrome*/
		@media screen and (-webkit-min-device-pixel-ratio:0) {
		    input[type='range'] {
		      overflow: hidden;
		      -webkit-appearance: none;
		    }
		    
		    input[type='range']::-webkit-slider-runnable-track {
		      height: 10px;
		      -webkit-appearance: none;
		      color: #13bba4;
		      margin-top: -1px;
		    }
		    
		    input[type='range']::-webkit-slider-thumb {
		      width: 10px;
		      -webkit-appearance: none;
/*		      height: 10px;*/
		      cursor: ew-resize;
		      box-shadow: -250px 0 0 250px var(--pink);
		    }

		}
		/** FF*/
		input[type="range"]::-moz-range-progress {
		  background-color: #43e5f7; 
		}
		input[type="range"]::-moz-range-track {  
		  background-color: #9a905d;
		}
		/* IE*/
		input[type="range"]::-ms-fill-lower {
		  background-color: #43e5f7; 
		}
		input[type="range"]::-ms-fill-upper {  
		  background-color: #9a905d;
		}
		
		.btn-pink{
			background-color:var(--pink) !important;
			border-color:var(--pink) !important;
			color: white;
		}
		.btn-pink:hover{
			background-color:var(--pink) !important;
			border-color:var(--pink) !important;
			color: white;
		}

	</style>


	<script type='text/javascript' src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
	<script src="<?php echo base_url() ?>ltr/assets/libs/jquery-steps/build/jquery.steps.min.js"></script>
	<script src="<?php echo base_url() ?>ltr/assets/libs/jquery-validation/dist/jquery.validate.min.js"></script>

	<link href="https://fonts.googleapis.com/icon?family=Material+Icons"rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
</head>

<body>
	<!-- ============================================================== -->
	<!-- Preloader - style you can find in spinners.css -->
	<!-- ============================================================== -->
	<div class="preloader">
		<div class="lds-ripple">
			<div class="lds-pos"></div>
			<div class="lds-pos"></div>
		</div>
	</div>

	<!-- ============================================================== -->
	<!-- Main wrapper - style you can find in pages.scss -->
	<!-- ============================================================== -->
	<div id="main-wrapper">
		<!-- ============================================================== -->
		<!-- Topbar header - style you can find in pages.scss -->
		<!-- ============================================================== -->
		<header class="topbar">
			<nav class="navbar top-navbar navbar-expand-md ">
				<div class="navbar-header" data-logobg="skin5">
					<!-- This is for the sidebar toggle which is visible on mobile only -->
					<a class="nav-toggler waves-effect waves-light d-block d-md-none"  style="color: black;" onclick="return false"><i class="ti-menu ti-close"></i></a>
					<!-- ============================================================== -->
					<!-- Logo -->
					<!-- ============================================================== -->
					<a class="navbar-brand" href="">
                        <!-- Logo icon -->
                        <b class="logo-icon">
                        	<center>
                        		 <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
	                            <!-- Dark Logo icon -->
	                            <img src="<?= base_url() ?>ltr/assets/images/logo-text-1.png" alt="homepage" class="dark-logo" style="width: 70%;">
	                            <!-- Light Logo icon -->
	                            <img src="<?= base_url() ?>ltr/assets/images/logo-text-1.png" alt="homepage" class="light-logo" width="100%">
                        	</center>
                        </b>
                        <!--End Logo icon -->
                        <!-- Logo text -->
                    </a>
					<!-- ============================================================== -->
					<!-- End Logo -->
					<!-- ============================================================== -->
					<!-- ============================================================== -->
					<!-- Toggle which is visible on mobile only -->
					<!-- ============================================================== -->
					<a class="topbartoggler d-block d-md-none waves-effect waves-light" onclick="return false" aria-label="Toggle navigation"><i class="ti-more"></i></a>
				</div>
				<!-- ============================================================== -->
				<!-- End Logo -->
				<!-- ============================================================== -->
				<div class="navbar-collapse collapse" id="navbarSupportedContent">
					<!-- ============================================================== -->
					<!-- toggle and nav items -->
					<!-- ============================================================== -->
					<ul class="navbar-nav float-left mr-auto">
						<li class="nav-item d-none d-md-block"><a class="nav-link sidebartoggler waves-effect waves-light" style="color: black;" onclick="return false" data-sidebartype="mini-sidebar"><i class="mdi mdi-menu font-24"></i></a></li>
					</ul>
						
					</ul>
				</div>
			</nav>
		</header>
		<!-- ============================================================== -->
		<!-- End Topbar header -->
		<!-- ============================================================== -->
		<!-- ============================================================== -->
		<!-- Left Sidebar - style you can find in sidebar.scss  -->
		<!-- ============================================================== -->
		<aside class="left-sidebar" data-sidebarbg="skin6">
			<!-- Sidebar scroll-->
			<div class="scroll-sidebar">
				<!-- Sidebar navigation-->
				<nav class="sidebar-nav">
					<ul id="sidebarnav">
						<!-- User Profile-->
						<li>
							<!-- User Profile-->
							<div class="user-profile d-flex no-block dropdown mt-3">
								<div class="user-pic"><img src="<?php echo base_url() ?>ltr/assets/images/users/1.1.jpg" alt="users" class="rounded-circle" width="40" /></div>
								<div class="user-content hide-menu ml-2">
									<a onclick="return false" class="" id="Userdd" role="button" aria-haspopup="true" aria-expanded="false">
										<h5 class="mb-0 user-name font-medium"> <?= $_SESSION['username'] ?></h5>
									</a>
								</div>
							</div>
							<!-- End User Profile-->
						</li>
						<!-- User Profile-->
						
						<li class="sidebar-item"><a href="<?php echo site_url('dashboard')?>" class="sidebar-link"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu"> Home</span></a></li>
						
						<li class="sidebar-item"><a href="<?= site_url('logout') ?>" class="sidebar-link"><i class="mdi mdi-logout"></i><span class="hide-menu"> Keluar</span></a></li>

						
					
						
						
					</ul>
				</nav>
				<!-- End Sidebar navigation -->
			</div>
			<!-- End Sidebar scroll-->
		</aside>
		<!-- ============================================================== -->
		<!-- End Left Sidebar - style you can find in sidebar.scss  -->
		<!-- ============================================================== -->
		<!-- ============================================================== -->
		<!-- Page wrapper  -->
		<!-- ============================================================== -->
		<div class="page-wrapper">
			<!-- ============================================================== -->
			<!-- Bread crumb and right sidebar toggle -->
			<!-- ============================================================== -->
			<div class="page-breadcrumb" style="display: none;">
				<div class="row">
					<div class="col-12 align-self-center">
						
					</div>

				</div>
			</div>
			<!-- ============================================================== -->
			<!-- End Bread crumb and right sidebar toggle -->
			<!-- ============================================================== -->
			<!-- ============================================================== -->
			<!-- Container fluid  -->
			<!-- ============================================================== -->
			<div class="container-fluid">
				<!-- ============================================================== -->
				<!-- User Data, Visits -->
				<!-- ============================================================== -->
				<div class="row">
					<!-- column -->
					<!-- content -->
						<div class="col-md-12">
							<div class="row">
								<div class="col-lg-3 col-md-6">
	                                <div class="card">
	                                    <div class="card-body">
	                                    	<div class="d-flex no-block align-items-center" >
	                                            <div class="text-black">
	                                                <h3 id="num_b_suhu"></h3>
                                                	<h6 class="card-subtitle">Batas Suhu</h6>
                                                	<input type="range" value="20" style="width: 100%;border: solid 1px #c7c7c7;" oninput="console.log();$('#num_b_suhu').html(this.value+`° C`)" id="batas_suhu">
	                                            </div>
	                                            
	                                            <div class="ml-auto">
	                                            	<span class="text-info display-5 material-icons" style="">tune</span>
	                                            </div>
	                                        </div>
	                                        <!-- <div class="row">
	                                            <div class="col-12">
	                                                <h3 id="num_b_suhu"></h3>
	                                                <h6 class="card-subtitle">Batas Suhu</h6>
	                                            </div>
	                                            <div class="col-12">
	                                                <div class="progress" style="height: auto;">
	                                                	<input type="range" value="20" style="width: 100%;border: solid 1px #c7c7c7;" oninput="console.log();$('#num_b_suhu').html(this.value+`° C`)" id="batas_suhu">
	                                                </div>
	                                            </div>
	                                        </div> -->
	                                    </div>
	                                </div>
	                            </div>
	                            <div class="col-lg-3 col-md-6">
	                                <div class="card">
	                                    <div class="card-body">
	                                        <div class="d-flex no-block align-items-center" >
	                                            <div class="text-black">
	                                                <input type="checkbox" checked data-toggle="toggle" data-size="lg" name="relay_1" id="relay_1" data-onstyle="pink">
                                                	<h6 class="card-subtitle" style="margin-top: 6px;">Saklar 1</h6>
	                                            </div>
	                                            <div class="ml-auto">
	                                            	<span class="text-info display-5 material-icons" style="">tungsten</span>
	                                            </div>
	                                        </div>
	                                    </div>
	                                </div>
	                            </div>

	                            <div class="col-lg-3 col-md-6">
	                                <div class="card">
	                                    <div class="card-body">
	                                        <div class="d-flex no-block align-items-center" >
	                                            <div class="text-black">
	                                                <input type="checkbox" checked data-toggle="toggle" data-size="lg" name="relay_2" id="relay_2" data-onstyle="pink">
                                                	<h6 class="card-subtitle" style="margin-top: 6px;">Saklar 2</h6>
	                                            </div>
	                                            <div class="ml-auto">
	                                            	<span class="text-info display-5 material-icons" style="">tungsten</span>
	                                            </div>
	                                        </div>
	                                    </div>
	                                </div>
	                            </div>

	                            <div class="col-lg-3 col-md-6">
	                                <div class="card">
	                                    <div class="card-body">
	                                        <div class="d-flex no-block align-items-center" >
	                                            <div class="text-black">
	                                                <input type="checkbox" checked data-toggle="toggle" readonly data-size="lg" name="kipas" id="kipas" data-onstyle="pink">
                                                	<h6 class="card-subtitle" style="margin-top: 6px;">Kipas</h6>
	                                            </div>
	                                            <div class="ml-auto">
	                                            	<i class="text-info display-5  mdi mdi-fan"></i>
	                                            	<!-- <span class="text-info display-5 material-icons" style="">fan</span> -->
	                                            </div>
	                                        </div>
	                                    </div>
	                                </div>
	                            </div>	

								<div class="col-lg-6 col-md-6">
	                                <div class="card">
	                                    <div class="card-body">
	                                        <div class="d-flex no-block align-items-center" style="background: var(--pink) !important;color: white;padding: 10px;border-radius: 10px;box-shadow: rgb(0 0 0 / 42%) 8px 7px 1px 1px;">
	                                            <div class="text-black">
	                                                <h1 id="num_tem"></h1>
	                                                <h6>Suhu</h6>
	                                            </div>
	                                            <div class="ml-auto">
	                                                <span class="text-info display-5 material-icons" style="color: white !important;">thermostat</span>
	                                            </div>
	                                        </div>
	                                        <div class="col-md-12">
	                                        	<hr>
	                                        	<div class="col-md-12" id="tem_grf">
	                                        		
	                                        	</div>
	                                        </div>
	                                    </div>
	                                </div>
	                            </div>
	                            <div class="col-lg-6 col-md-6">
	                                <div class="card">
	                                    <div class="card-body">
	                                        <div class="d-flex no-block align-items-center" style="background: var(--pink) !important;color: white;padding: 10px;border-radius: 10px;box-shadow: rgb(0 0 0 / 42%) 8px 7px 1px 1px;">
	                                            <div class="text-black">
	                                                <h1 id="num_hum"></h1>
	                                                <h6>Kelembapan</h6>
	                                            </div>
	                                            <div class="ml-auto">
	                                            	<span class="text-info display-5 material-icons" style="color: white !important;">water_drop</span>
	                                            </div>
	                                        </div>
	                                        <div class="col-md-12">
	                                        	<hr>
	                                        	<div class="col-md-12" id="hum_grf">
	                                        		
	                                        	</div>
	                                        </div>
	                                    </div>
	                                </div>
	                            </div>

	                            
							</div>
						</div>					
					<!-- END content -->
				</div>
				<!-- ============================================================== -->
				<!-- Locations -->
				<!-- ============================================================== -->
			   
				<!-- ============================================================== -->
				<!-- Activity, Referrals -->
				<!-- ============================================================== -->
				
				<!-- ============================================================== -->
				<!-- Task, Feeds -->
				<!-- ============================================================== -->
				
			</div>
			<!-- ============================================================== -->
			<!-- End Container fluid  -->
			<!-- ============================================================== -->
			<!-- ============================================================== -->
			<!-- footer -->
			<!-- ============================================================== -->
			<footer class="footer text-center">
				   Designed and Developed use <a href="#;">💜</a>  - Page rendered in <strong>{elapsed_time}</strong> seconds..
			</footer>
			<!-- ============================================================== -->
			<!-- End footer -->
			<!-- ============================================================== -->
		</div>
		<!-- ============================================================== -->
		<!-- End Page wrapper  -->
		<!-- ============================================================== -->
	</div>
	
	<script>
		

		
		$("button[data-toggle='modal']").attr({'data-backdrop':'static', 'data-keyboard':'false'});
		$("a[data-toggle='modal']").attr({'data-backdrop':'static', 'data-keyboard':'false'});
	</script>		
	<!-- ============================================================== -->
	<!-- End Wrapper -->
	<!-- ============================================================== -->
	<!-- ============================================================== -->
	<!-- customizer Panel -->
	<!-- ============================================================== -->
	
	<!-- <div class="chat-windows"></div> -->
	<!-- ============================================================== -->
	<!-- All Jquery -->
	<!-- ============================================================== -->
	<script>
		let datas_hum = [];
		let datas_tem = [];

		

		function update_data_hum(){
			$('#hum_grf').html('');
			datas_hum.push({year: Date.now(), value: Math.floor(Math.random() * 100)});
			new Morris.Line({
				// ID of the element in which to draw the chart.
				element: 'hum_grf',
				// Chart data records -- each entry in this array corresponds to a point on
				// the chart.
				data: datas_hum.slice(-10),
				// The name of the data record attribute that contains x-values.
				xkey: 'year',
				// A list of names of data record attributes that contain y-values.
				ykeys: ['value'],
				// Labels for the ykeys -- will be displayed when you hover over the
				// chart.
				labels: ['Value']
			})
			$('#num_hum').html(datas_hum.slice(-1)[0].value+"");
		}

		function update_data_tem(){
			let batas_suhu = $('#batas_suhu').val();
			$('#tem_grf').html('');
			datas_tem.push({year: Date.now(), value: Math.floor(Math.random() * 100)});
			new Morris.Line({
				// ID of the element in which to draw the chart.
				element: 'tem_grf',
				// Chart data records -- each entry in this array corresponds to a point on
				// the chart.
				data: datas_tem.slice(-10),
				// The name of the data record attribute that contains x-values.
				xkey: 'year',
				// A list of names of data record attributes that contain y-values.
				ykeys: ['value'],
				// Labels for the ykeys -- will be displayed when you hover over the
				// chart.
				labels: ['value']
			});

			// console.log(datas_tem.slice(-1)[0].value)

			$('#num_tem').html(datas_tem.slice(-1)[0].value+"° C");

			if (datas_tem.slice(-1)[0].value > batas_suhu)
			{
				$('#kipas').bootstrapToggle('on');
				console.log(batas_suhu)
			}
			else
			{
				$('#kipas').bootstrapToggle('off');
			}

		}

	</script>

	<script>

		$(document).ready(function() {
			
			// 
			setInterval(update_data_hum, 1000);
			setInterval(update_data_tem, 1000);
			$('#num_b_suhu').html($('#batas_suhu').val()+`° C`)
			$('aside[class="left-sidebar"]').removeAttr('data-sidebarbg');
			$('aside[class="left-sidebar"]').attr('data-sidebarbg', 'skin5');
		});
		



		
	</script>
	<script>
	$('.fancybox__button--close').click(function () {
		return false;
	});
	
</script>
<script>
	$('[data-toggle="popover"]').popover()
	$("button[data-toggle='modal']").attr({'data-backdrop':'static', 'data-keyboard':'false'});
	 /** add active class and stay opened when selected */
	var url = window.location;

	// for sidebar menu entirely but not cover treeview
	$('ul>li.nav-item a').filter(function() {
	   return this.href == url;
	}).parent().addClass('active');

	// $('li.dropdown>.dropdown-menu').filter(function() {
	//    return this.href == url;
	// }).parent().addClass('tes');

	// for treeview
	$('div.dropdown-menu>a.dropdown-item').filter(function() {
	   return this.href == url;
	}).parentsUntil().addClass('active');

	$('div.dropdown-menu>a.dropdown-item').filter(function() {
	   return this.href == url;
	}).parent().addClass('active');
	
	//$('.dt').DataTable();

	$(document).ready(function() {
		var table = $('.dt').DataTable({
			responsive: true,
			"language": {
             "url": "<?php echo base_url() ?>assets/vendor/datatables/id.json?date=<?= date('YmdHis'); ?>"
         },
         pagingType: 'numbers'
		});
		$('.left-sidebar').removeAttr('data-sidebarbg');
	$('.left-sidebar').attr('data-sidebarbg','skin6');

		//new $.fn.dataTable.FixedHeader(table);
	});

	
</script>    
<script>
  // Mencetak teks dengan ukuran dan animasi
  console.log("%cTidak Ada Apa Apa Disini 🤪", "font-size: 36px; animation: blink 1s infinite; color:red;");
  // console.log("%cIni adalah teks berukuran kecil dan berkedip", "font-size: 12px; animation: blink 1s infinite;");
</script>    
</body>

</html>