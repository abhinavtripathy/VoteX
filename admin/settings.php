<?php
error_reporting(E_ALL);
include("includes/config.php");
include("includes/functions.php");
if(!isset($_COOKIE["admin"])){header("location:login.php?redirect=settings.php");}
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
    <title>Settings - Admin Panel | GWH</title>
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
          <li class="panel"><a href="index.php"><i class="ti-home"></i><span class="sidebar-title">Dashboard</span></a></li>
          <li class="panel"><a href="posts.php"><i class="ti-crown"></i><span class="sidebar-title">Posts</span></a></li>
          <li class="panel"><a href="candidates.php"><i class="ti-user"></i><span class="sidebar-title">Candidates</span></a></li>
          <li class="panel"><a href="votes.php"><i class="ti-bar-chart"></i><span class="sidebar-title">Votes</span></a></li>
          <li class="panel"><a href="voters.php"><i class="ti-user"></i><span class="sidebar-title">Voters</span></a></li>
          <li class="panel"><a href="settings.php" class="active"><i class="ti-settings"></i><span class="sidebar-title">Settings</span></a></li>
          <li class="panel"><a href="logout.php"><i class="ti-power-off"></i><span class="sidebar-title">Logout</span></a></li>
        </ul>
      </aside>
      <!-- Main Sidebar end-->
      <div class="page-container">
        <div class="page-header clearfix">
          <div class="row">
            <div class="col-sm-12">
              <h4 class="mt-0 mb-5">Settings</h4>
            </div>
          </div>
        </div>
        <div class="page-content container-fluid">
			<div class="row">
				<div class="col-sm-6">
					<div class="widget">
						<div class="widget-heading">
						  <h3 class="widget-title">Update Password</h3>
						</div>
						<div class="widget-body">
						  <form>
							<div class="form-group">
							  <label for="old_password">Old Password</label>
							  <input id="old_password" type="password" class="form-control">
							</div>
							<div class="form-group">
							  <label for="new_password">New Password</label>
							  <input id="new_password" type="password" class="form-control">
							</div>
							<div class="form-group">
							  <label for="repeat_password">Repeat Password</label>
							  <input id="repeat_password" type="password" class="form-control">
							</div>
							<button type="submit" class="btn btn-outline btn-warning">Update</button>
						  </form>
						</div>
					</div>
				</div>
				<!-- <div class="col-sm-6">
					<div class="widget">
						<div class="widget-heading">
						  <h3 class="widget-title">Add A New Administrator</h3>
						</div>
						<div class="widget-body">
						  <form>
							<div class="form-group">
							  <label for="add_admin_username">Username</label>
							  <input id="add_admin_username" type="text" class="form-control">
							</div>
							<div class="form-group">
							  <label for="add_admin_password">Password</label>
							  <input id="add_admin_password" type="password" class="form-control">
							</div>
							<div class="form-group">
							  <label for="add_admin_email">Email</label>
							  <input id="add_admin_email" type="email" class="form-control">
							</div>
							<button type="submit" class="btn btn-outline btn-success">Add</button>
						  </form>
						</div>
					</div>
				</div> -->
				<div class="col-sm-12">
					<div class="widget">
						<div class="widget-heading">
						  <h3 class="widget-title">Reset Database</h3>
						</div>
						<div class="widget-body">
							<button type="button" id="reset_votes" class="btn btn-danger">Reset Votes Only</button>
							<button type="button" id="reset_everything" class="btn btn-danger">Reset Everything (Including Posts and Voters Database)</button>
						</div>
					</div>
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
    <!-- Custom JS-->
    <script type="text/javascript" src="build/js/third-layout/app.js"></script>
    <script type="text/javascript" src="build/js/third-layout/demo.js"></script>
	<script type="text/javascript">
	$(document).ready(function(){
		$("#reset_votes").click(function(){
			x=confirm("Are you sure you want to Reset the Votes?");
			if(x){
				y=prompt("Enter the Master Password: ");
				if(y.length<=6){
					alert("Invalid Password");
				}
				else{
					$(".mypreloader").fadeIn();
					$.ajax({
						url:"verify",
						type:"POST",
						data:{"reset_votes":true,"password":y},
						success:function(response){
							try{
								var resp=JSON.parse(response);
								if(resp.code=="RESET_VOTES_SUC"){
									toastr["success"]("The votes have been successfully reset!","Votes Reset Successfull");
								}
								else{
									$(".mypreloader").fadeOut();
									toastr["error"]("Response Code: <strong>"+resp.code+"</strong>","Unknown Error Occured");
								}
							}
							catch(err){
								$(".mypreloader").fadeOut();
								toastr["error"](err,"Unknown Error Occured");
							}
						},
						error:function(text,response,xhr){
							$(".mypreloader").fadeOut();
							toastr["error"]("Please Check Your Internet Connection And Try Again!","Connection Failed");
						}
					});
				}
			}
		});
		$("#reset_everything").click(function(){
			x=confirm("Are you sure you want to Reset Everything?");
			if(x){
				y=prompt("Enter the Master Password: ");
				if(y.length<=6){
					alert("Invalid Password");
				}
				else{
					$(".mypreloader").fadeIn();
					$.ajax({
						url:"verify",
						type:"POST",
						data:{"reset_everything":true,"password":y},
						success:function(response){
							try{
								var resp=JSON.parse(response);
								if(resp.code=="RESET_EVERYTHING_SUC"){
									toastr["success"]("Everything has been successfully reset!","Everything Reset Successfull");
								}
								else{
									$(".mypreloader").fadeOut();
									toastr["error"]("Response Code: <strong>"+resp.code+"</strong>","Unknown Error Occured");
								}
							}
							catch(err){
								$(".mypreloader").fadeOut();
								toastr["error"](err,"Unknown Error Occured");
							}
						},
						error:function(text,response,xhr){
							$(".mypreloader").fadeOut();
							toastr["error"]("Please Check Your Internet Connection And Try Again!","Connection Failed");
						}
					});
				}
			}
		});
	});
	</script>
  </body>
</html>