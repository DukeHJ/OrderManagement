
<!DOCTYPE html>
<!--[if IE 8]><html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
	<meta charset="utf-8" />
	<title>华铸ERP订单管理系统 | 首页</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />

	<link href="vendor/jquery-ui/themes/base/minified/jquery-ui.min.css" rel="stylesheet"/>
	<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
	<link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet"/>
	<link href="vendor/css/animate.min.css" rel="stylesheet"/>
	<link href="vendor/css/style.min.css" rel="stylesheet"/>
	<link href="vendor/css/style-responsive.min.css" rel="stylesheet"/>
	<link href="vendor/css/theme/default.css" rel="stylesheet" id="theme"/>

	<script src="vendor/pace/pace.min.js"></script>
	<script src="vendor/jquery/jquery-1.9.1.min.js"></script>
</head>
<body>
	<?php include_once 'template/pageloader.php';?>

	<div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
		<?php include_once 'template/header.php';?>
		<?php include_once 'template/sidebar.php';?>

		<div id="content" class="content">

			<ol class="breadcrumb pull-right">
				<button type="button" class="btn btn-default" aria-label="Left Align">
					<span class="glyphicon glyphicon-align-left" aria-hidden="true"></span>
				</button>
				<li><a href="javascript:;">首页</a></li>
				<li class="active"></li>
			</ol>
			<h1 class="page-header"> <small>首页</small></h1>
			<!-- end page-header -->


			<div class="col-center-block col-md-9">
				<div>
					<h1 class="text-success"><small  style="color: #0e0e0e;">欢迎使用</small>华铸ERP<small style="color: #0e0e0e;">网上管理系统!</small></h1>
				</div>

				<ul id="myTab" class="nav nav-tabs">
					<li class="active"><a href="#liucheng" data-toggle="tab" >总体功能框架</a></li>
				</ul>
				<div id="myTabContent" class="tab-content">
					<div class="tab-pane fade in active" id="liucheng">
						<img width="640px" height="300px" src="images/总体功能框架.png" alt="">
					</div>
				</div>
			</div>

		</div>


		<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>

	</div>


	<script src="vendor/jquery/jquery-migrate-1.1.0.min.js"></script>
	<script src="vendor/jquery-ui/ui/minified/jquery-ui.min.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
	<!--[if lt IE 9]>
	<script src="vendor/crossbrowserjs/html5shiv.js"></script>
	<script src="vendor/crossbrowserjs/respond.min.js"></script>
	<script src="vendor/crossbrowserjs/excanvas.min.js"></script>
	<![endif]-->

	<script src="vendor/slimscroll/jquery.slimscroll.min.js"></script>
	<script src="vendor/jquery-cookie/jquery.cookie.js"></script>
	<script src="vendor/js/apps.min.js"></script>

	<script>
		$(document).ready(function() {
			App.init();
		});
		$("#index").addClass("active");
	</script>

</body>
</html>
