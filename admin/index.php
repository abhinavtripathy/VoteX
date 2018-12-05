<?php
error_reporting(E_ALL);
include("includes/config.php");
include("includes/functions.php");
if(!isset($_COOKIE["admin"])){header("location:login.php");}
$aid=safe_decrypt($_COOKIE["admin"],$_COOKIE["hash"]);
$sql="SELECT * FROM admins WHERE aid='$aid'";
$result=$conn->query($sql);
if($result->num_rows>0){
	while($row=$result->fetch_assoc()){
		$username=$row["username"];
		$email=$row["email"];
		$gravatar=get_gravatar($email,$s=128);
	}
}
else{
	header("location:logout.php");
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - Admin Panel | GWH</title>
    <!-- PACE-->
    <link rel="stylesheet" type="text/css" href="plugins/PACE/themes/blue/pace-theme-flash.css">
    <script type="text/javascript" src="plugins/PACE/pace.min.js"></script>
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" type="text/css" href="plugins/bootstrap/dist/css/bootstrap.min.css">
    <!-- Fonts-->
    <link rel="stylesheet" type="text/css" href="plugins/themify-icons/themify-icons.css">
    <!-- Malihu Scrollbar-->
    <link rel="stylesheet" type="text/css" href="plugins/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css">
    <!-- Animo.js-->
    <link rel="stylesheet" type="text/css" href="plugins/animo.js/animate-animo.min.css">
    <!-- Flag Icons-->
    <link rel="stylesheet" type="text/css" href="plugins/flag-icon-css/css/flag-icon.min.css">
    <!-- Bootstrap Progressbar-->
    <link rel="stylesheet" type="text/css" href="plugins/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css">
    <!-- SpinKit-->
    <link rel="stylesheet" type="text/css" href="plugins/SpinKit/css/spinners/7-three-bounce.css">
    <!-- Morris Chart-->
    <link rel="stylesheet" type="text/css" href="plugins/morris.js/morris.css">
    <!-- DataTables-->
    <link rel="stylesheet" type="text/css" href="plugins/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="plugins/datatables.net-buttons-bs/css/buttons.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="plugins/datatables.net-colreorder-bs/css/colReorder.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="plugins/datatables.net-responsive-bs/css/responsive.bootstrap.min.css">
    <!-- Primary Style-->
    <link rel="stylesheet" type="text/css" href="build/css/third-layout.css">
	<link rel="shortcut icon" type="image/png" href="build/images/logo/logo-sm-dark.png">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries-->
    <!-- WARNING: Respond.js doesn't work if you view the page via file://--> 
    <!--[if lt IE 9]>
    <script type="text/javascript" src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script type="text/javascript" src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <!-- Header start-->
    <header>
      <div class="search-bar closed">
        <form>
          <div class="input-group input-group-lg">
            <input type="text" placeholder="Search for..." class="form-control"><span class="input-group-btn">
              <button type="button" class="btn btn-default search-bar-toggle"><i class="ti-close"></i></button></span>
          </div>
        </form>
      </div><a href="index.php" class="brand pull-left"><img src="build/images/logo/logo-light.png" alt="" width="100" class="logo"><img src="build/images/logo/logo-sm-light.png" alt="" width="28" class="logo-sm"></a><a href="javascript:;" role="button" class="hamburger-menu pull-left"><span></span></a>
      <ul class="notification-bar list-inline pull-right">
        <li class="visible-xs"><a href="javascript:;" role="button" class="header-icon search-bar-toggle"><i class="ti-search"></i></a></li>
        <li class="dropdown hidden-xs"><a id="dropdownMenu2" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle header-icon lh-1 pt-15 pb-15">
            <div class="media mt-0">
              <div class="media-left avatar"><img src="build/images/users/white.jpg" alt="" class="media-object img-circle"></div>
              <div class="media-right media-middle pl-0">
                <p class="fs-12 text-base mb-0">Hi, <?php echo $username; ?></p>
              </div>
            </div></a>
          <ul aria-labelledby="dropdownMenu2" class="dropdown-menu fs-12 animated fadeInDown">
            <li><a href="settings.php"><i class="ti-settings mr-5"></i> Settings</a></li>
            <li><a href="logout.php"><i class="ti-power-off mr-5"></i> Logout</a></li>
          </ul>
        </li>
      </ul>
    </header>
    <!-- Header end-->
    <div class="main-container">
      <!-- Main Sidebar start-->
      <aside class="main-sidebar">
        <div class="user">
          
          <h4 class="fs-16 text-white mt-15 mb-5 fw-300"><?php echo $username; ?></h4>
          <p class="mb-0 text-muted">Admin</p>
        </div>
        <ul class="list-unstyled navigation mb-0">
          <li class="sidebar-category">Main</li>
          <li class="panel"><a href="index.php" class="active"><i class="ti-home"></i><span class="sidebar-title">Dashboard</span></a></li>
          <li class="panel"><a href="posts.php"><i class="ti-crown"></i><span class="sidebar-title">Posts</span></a></li>
          <li class="panel"><a href="candidates.php"><i class="ti-user"></i><span class="sidebar-title">Candidates</span></a></li>
          <li class="panel"><a href="votes.php"><i class="ti-bar-chart"></i><span class="sidebar-title">Votes</span></a></li>
          <li class="panel"><a href="voters.php"><i class="ti-user"></i><span class="sidebar-title">Voters</span></a></li>
          <li class="panel"><a href="settings.php"><i class="ti-settings"></i><span class="sidebar-title">Settings</span></a></li>
          <li class="panel"><a href="logout.php"><i class="ti-power-off"></i><span class="sidebar-title">Logout</span></a></li>
        </ul>
      </aside>
      <!-- Main Sidebar end-->
      <div class="page-container">
        <div class="page-header clearfix">
          <div class="row">
            <div class="col-sm-12">
              <h4 class="mt-0 mb-5">Dashboard</h4>
            </div>
          </div>
        </div>
        <div class="page-content container-fluid">
          <div class="row">
            <div class="col-md-12">
              <h1>Welcome to GWH Student Council Election System Admin Panel</h1>
            </div>
          </div>
        </div>
        
      </div>
    </div>
    <!-- jQuery-->
    <script type="text/javascript" src="plugins/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap JavaScript-->
    <script type="text/javascript" src="plugins/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Malihu Scrollbar-->
    <script type="text/javascript" src="plugins/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
    <!-- Animo.js-->
    <script type="text/javascript" src="plugins/animo.js/animo.min.js"></script>
    <!-- Bootstrap Progressbar-->
    <script type="text/javascript" src="plugins/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- jQuery Easy Pie Chart-->
    <script type="text/javascript" src="plugins/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js"></script>
    <!-- jQuery BlockUI-->
    <script type="text/javascript" src="plugins/blockUI/jquery.blockUI.js"></script>
    <!-- Flot Charts-->
    <script type="text/javascript" src="plugins/flot/jquery.flot.js"></script>
    <script type="text/javascript" src="plugins/flot/jquery.flot.resize.js"></script>
    <script type="text/javascript" src="plugins/flot.tooltip/js/jquery.flot.tooltip.min.js"></script>
    <!-- Morris Chart-->
    <script type="text/javascript" src="plugins/raphael/raphael-min.js"></script>
    <script type="text/javascript" src="plugins/morris.js/morris.min.js"></script>
    <!-- DataTables-->
    <script type="text/javascript" src="plugins/datatables.net/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="plugins/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript" src="plugins/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="plugins/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script type="text/javascript" src="plugins/jszip/dist/jszip.min.js"></script>
    <script type="text/javascript" src="plugins/pdfmake/build/pdfmake.min.js"></script>
    <script type="text/javascript" src="plugins/pdfmake/build/vfs_fonts.js"></script>
    <script type="text/javascript" src="plugins/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script type="text/javascript" src="plugins/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="plugins/datatables.net-colreorder/js/dataTables.colReorder.min.js"></script>
    <script type="text/javascript" src="plugins/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script type="text/javascript" src="plugins/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <!-- Custom JS-->
    <script type="text/javascript" src="build/js/third-layout/app.js"></script>
    <script type="text/javascript" src="build/js/third-layout/demo.js"></script>
    <script type="text/javascript">
	$(document).ready(function(){
		//$.plot($("#votes"),[{label:"votes",data:[[0,1021],[1,1370],[2,904],[3,690],[4,904],[5,929],[6,789],[7,579],[8,1039],[9,1204],[10,1120],[11,809]],color:"#0667D6"}],{series:{bars:{show:!0,fill:.2,align:"center",barWidth:.5,lineWidth:2}},grid:{borderWidth:0,hoverable:!0,tickColor:"#fff",labelMargin:15},xaxis:{font:{color:"#9a9a9a",size:11},ticks:[[0,"Jan"],[1,"Feb"],[2,"Mar"],[3,"Apr"],[4,"May"],[5,"Jun"],[6,"Jul"],[7,"Aug"],[8,"Sep"],[9,"Oct"],[10,"Nov"],[11,"Dec"]]},yaxis:{font:{color:"#9a9a9a",size:11},tickFormatter:function(e,o){return e.toString().replace(/\B(?=(?:\d{3})+(?!\d))/g,",")}},tooltip:{show:!0,content:"%x: %y",defaultTheme:!1},legend:{show:!1}});
	});
	</script>
  </body>
</html>