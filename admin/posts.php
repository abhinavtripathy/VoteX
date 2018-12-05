<?php
error_reporting(E_ALL);
include("includes/config.php");
include("includes/functions.php");
if(!isset($_COOKIE["admin"])){header("location:login.php?redirect=posts.php");}
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
$Houses=array(0=>"Everyone");
$sql="SELECT * FROM houses";
$result=$conn->query($sql);
if($result->num_rows>0){
	while($row=$result->fetch_assoc()){
		$Houses[$row["hid"]]=$row["HouseName"];
	}
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Posts - Admin Panel | GWH</title>
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
    <!-- Toastr-->
    <link rel="stylesheet" type="text/css" href="plugins/toastr/toastr.min.css">
    <!-- Flag Icons-->
    <link rel="stylesheet" type="text/css" href="plugins/flag-icon-css/css/flag-icon.min.css">
    <!-- Bootstrap Progressbar-->
    <link rel="stylesheet" type="text/css" href="plugins/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css">
    <!-- SpinKit-->
    <link rel="stylesheet" type="text/css" href="plugins/SpinKit/css/spinkit.css">
    <!-- Primary Style-->
    <link rel="stylesheet" type="text/css" href="build/css/third-layout.css">
    <!-- DataTables-->
    <link rel="stylesheet" type="text/css" href="plugins/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="plugins/datatables.net-buttons-bs/css/buttons.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="plugins/datatables.net-colreorder-bs/css/colReorder.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="plugins/datatables.net-keytable-bs/css/keyTable.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="plugins/datatables.net-select-bs/css/select.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="plugins/datatables.net-responsive-bs/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="plugins/datatables.net-fixedcolumns-bs/css/fixedColumns.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="plugins/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css">
	<link rel="shortcut icon" type="image/png" href="build/images/logo/logo-sm-dark.png">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries-->
    <!-- WARNING: Respond.js doesn't work if you view the page via file://--> 
    <!--[if lt IE 9]>
    <script type="text/javascript" src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script type="text/javascript" src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
	<!-- Preloader -->
	<div class="mypreloader"><div class="sk-cube-grid"><div class="sk-cube sk-cube1"></div><div class="sk-cube sk-cube2"></div><div class="sk-cube sk-cube3"></div><div class="sk-cube sk-cube4"></div><div class="sk-cube sk-cube5"></div><div class="sk-cube sk-cube6"></div><div class="sk-cube sk-cube7"></div><div class="sk-cube sk-cube8"></div><div class="sk-cube sk-cube9"></div></div></div>
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
          <li class="panel"><a href="posts.php" class="active"><i class="ti-crown"></i><span class="sidebar-title">Posts</span></a></li>
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
              <h4 class="mt-0 mb-5">Posts</h4>
            </div>
          </div>
        </div>
        <div class="page-content container-fluid">
			<div class="row">
				<div class="col-lg-12">
				  <div class="widget">
					<div class="widget-heading clearfix">
					  <h3 class="widget-title pull-left">Manage Posts</h3>
					  <ul class="widget-tools pull-right list-inline">
						<li><a href="javascript:;" class="btn btn-success" style="color:#fff" id="add_post" data-toggle="modal" data-target="#AddPostModal"><i class="ti-plus"></i> Add</a></li>
					  </ul>
					</div>
					<div class="widget-body">
					  <table id="posts" cellspacing="0" width="100%" class="table table-striped table-bordered">
						<thead>
						  <tr>
							<th>PID</th>
							<th>Post</th>
							<th>Who Can Vote?</th>
							<th>Settings</th>
						  </tr>
						</thead>
						<tfoot>
						  <tr>
							<th>PID</th>
							<th>Post</th>
							<th>Who Can Vote?</th>
							<th>Settings</th>
						  </tr>
						</tfoot>
						<tbody>
						  <?php
						  $sql="SELECT * FROM posts";
						  $result=$conn->query($sql);
						  if($result->num_rows>0){
							  while($row=$result->fetch_assoc()){
								echo '<tr id="post_'.$row['pid'].'"><td>'.$row['pid'].'</td><td>'.$row['post'].'</td><td>'.$Houses[$row['WCV']].'</td><td><button class="btn btn-warning edit_post" id="edit_post_'.$row['pid'].'"><i class="ti-pencil"></i> Edit</button> <button class="btn btn-danger del_post" id="del_post_'.$row['pid'].'"><i class="ti-trash"></i> Delete</button></td></tr>';
							  }
						  }
						  ?>
						</tbody>
					  </table>
					</div>
				  </div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
				  <div class="widget">
					<div class="widget-heading clearfix">
					  <h3 class="widget-title pull-left">Manage Houses</h3>
					  <ul class="widget-tools pull-right list-inline">
						<li><a href="javascript:;" class="btn btn-success" style="color:#fff" id="add_house" data-toggle="modal" data-target="#AddHouseModal"><i class="ti-plus"></i> Add</a></li>
					  </ul>
					</div>
					<div class="widget-body">
					  <table id="houses" cellspacing="0" width="100%" class="table table-striped table-bordered">
						<thead>
						  <tr>
							<th>HID</th>
							<th>House Name</th>
							<th>Settings</th>
						  </tr>
						</thead>
						<tfoot>
						  <tr>
							<th>HID</th>
							<th>House Name</th>
							<th>Settings</th>
						  </tr>
						</tfoot>
						<tbody>
						  <?php
						  $sql="SELECT * FROM houses";
						  $result=$conn->query($sql);
						  if($result->num_rows>0){
							  while($row=$result->fetch_assoc()){
								echo '<tr id="house_'.$row['hid'].'"><td>'.$row['hid'].'</td><td>'.$row['HouseName'].'</td><td><button class="btn btn-warning edit_house" id="edit_house_'.$row['hid'].'"><i class="ti-pencil"></i> Edit</button> <button class="btn btn-danger del_house" id="del_house_'.$row['hid'].'"><i class="ti-trash"></i> Delete</button></td></tr>';
							  }
						  }
						  ?>
						</tbody>
					  </table>
					</div>
				  </div>
				</div>
			</div>
		</div>
        <div class="footer">2018 &copy; GWH</a> by <a href="https://www.manikiran.co" target="_blank">Manikiran</a>.</div>
      </div>
      
    </div>
	<!-- Posts Modification Modals -->
	<div tabindex="-1" role="dialog" aria-labelledby="modalWithForm" class="modal fade" id="AddPostModal">
		<div role="document" class="modal-dialog">
		  <div class="modal-content">
			<div class="modal-header">
			  <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">&times;</span></button>
			  <h4 id="modalWithForm" class="modal-title">Add Post</h4>
			</div>
			<form action="" method="POST" id="AddPostForm">
				<div class="modal-body">
					<div class="form-group">
					  <label for="AddPostPost">Post</label>
					  <input id="AddPostPost" type="text" placeholder="Enter Post" class="form-control">
					</div>
					<div class="form-group">
					  <label for="AddPostWCV">Who Can Vote?</label>
					  <select id="AddPostWCV" class="form-control">
						<?php
						foreach($Houses as $hid => $HouseName){
							if($hid==0){
								echo '<option value="'.$hid.'" selected>'.$HouseName.'</option>';
							}
							else{
								echo '<option value="'.$hid.'">'.$HouseName.'</option>';
							}
						}
						?>
					  </select>
					</div>
				</div>
				<div class="modal-footer">
				  <button type="button" data-dismiss="modal" class="btn btn-raised btn-default">Close</button>
				  <button type="submit" class="btn btn-raised btn-black">Add Post</button>
				</div>
			</form>
		  </div>
		</div>
	</div>
	<div tabindex="-1" role="dialog" aria-labelledby="modalWithForm" class="modal fade" id="EditPostModal">
		<div role="document" class="modal-dialog">
		  <div class="modal-content">
			<div class="modal-header">
			  <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">&times;</span></button>
			  <h4 id="modalWithForm" class="modal-title">Edit Post</h4>
			</div>
			<form action="" method="POST" id="EditPostForm">
				<div class="modal-body">
					<input type="hidden" id="EditPostID" value="0">
					<div class="form-group">
					  <label for="EditPostPost">Post</label>
					  <input id="EditPostPost" type="text" placeholder="Enter Post" class="form-control">
					</div>
					<div class="form-group">
					  <label for="EditPostWCV">Who Can Vote?</label>
					  <select id="EditPostWCV" class="form-control">
						<?php
						foreach($Houses as $hid => $HouseName){
							if($hid==0){
								echo '<option value="'.$hid.'" selected>'.$HouseName.'</option>';
							}
							else{
								echo '<option value="'.$hid.'">'.$HouseName.'</option>';
							}
						}
						?>
					  </select>
					</div>
				</div>
				<div class="modal-footer">
				  <button type="button" data-dismiss="modal" class="btn btn-raised btn-default">Close</button>
				  <button type="submit" class="btn btn-raised btn-black">Update Post</button>
				</div>
			</form>
		  </div>
		</div>
	</div>
	<div tabindex="-1" role="dialog" aria-labelledby="myModalLabel" class="modal fade" id="DelPostModal">
		<div role="document" class="modal-dialog">
		  <div class="modal-content bg-danger">
			<div class="modal-header">
			  <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">&times;</span></button>
			  <h4 id="myModalLabel" class="modal-title">Are you sure you want to delete this post?</h4>
			</div>
			<div class="modal-body">
			  <input type="hidden" id="DelPostID" value="0">
			  <p>THERE IS NO UNDO!</p>
			</div>
			<div class="modal-footer">
			  <button type="button" data-dismiss="modal" class="btn btn-raised btn-default">Close</button>
			  <button type="button" class="btn btn-raised btn-black" id="confirm_delete">Confirm Delete</button>
			</div>
		  </div>
		</div>
	</div>
	<!-- House Modification Modals -->
	<div tabindex="-1" role="dialog" aria-labelledby="modalWithForm" class="modal fade" id="AddHouseModal">
		<div role="document" class="modal-dialog">
		  <div class="modal-content">
			<div class="modal-header">
			  <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">&times;</span></button>
			  <h4 id="modalWithForm" class="modal-title">Add House</h4>
			</div>
			<form action="" method="POST" id="AddHouseForm">
				<div class="modal-body">
					<div class="form-group">
					  <label for="AddHouseName">House Name</label>
					  <input id="AddHouseName" type="text" placeholder="Enter House Name" class="form-control">
					</div>
				</div>
				<div class="modal-footer">
				  <button type="button" data-dismiss="modal" class="btn btn-raised btn-default">Close</button>
				  <button type="submit" class="btn btn-raised btn-black">Add House</button>
				</div>
			</form>
		  </div>
		</div>
	</div>
	<div tabindex="-1" role="dialog" aria-labelledby="modalWithForm" class="modal fade" id="EditHouseModal">
		<div role="document" class="modal-dialog">
		  <div class="modal-content">
			<div class="modal-header">
			  <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">&times;</span></button>
			  <h4 id="modalWithForm" class="modal-title">Edit House</h4>
			</div>
			<form action="" method="POST" id="EditHouseForm">
				<div class="modal-body">
					<input type="hidden" id="EditHouseID" value="0">
					<div class="form-group">
					  <label for="EditHouseName">House Name</label>
					  <input id="EditHouseName" type="text" placeholder="Enter House Name" class="form-control">
					</div>
				</div>
				<div class="modal-footer">
				  <button type="button" data-dismiss="modal" class="btn btn-raised btn-default">Close</button>
				  <button type="submit" class="btn btn-raised btn-black">Update House</button>
				</div>
			</form>
		  </div>
		</div>
	</div>
	<div tabindex="-1" role="dialog" aria-labelledby="myModalLabel" class="modal fade" id="DelHouseModal">
		<div role="document" class="modal-dialog">
		  <div class="modal-content bg-danger">
			<div class="modal-header">
			  <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">&times;</span></button>
			  <h4 id="myModalLabel" class="modal-title">Are you sure you want to delete this house?</h4>
			</div>
			<div class="modal-body">
			  <input type="hidden" id="DelHouseID" value="0">
			  <p>THERE IS NO UNDO!</p>
			</div>
			<div class="modal-footer">
			  <button type="button" data-dismiss="modal" class="btn btn-raised btn-default">Close</button>
			  <button type="button" class="btn btn-raised btn-black" id="confirm_delete_house">Confirm Delete</button>
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
    <!-- DataTables-->
    <script type="text/javascript" src="plugins/datatables.net/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="plugins/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript" src="plugins/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="plugins/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script type="text/javascript" src="plugins/datatables.net-buttons/js/buttons.colVis.min.js"></script>
    <script type="text/javascript" src="plugins/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script type="text/javascript" src="plugins/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="plugins/datatables.net-colreorder/js/dataTables.colReorder.min.js"></script>
    <script type="text/javascript" src="plugins/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script type="text/javascript" src="plugins/datatables.net-select/js/dataTables.select.min.js"></script>
    <script type="text/javascript" src="plugins/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script type="text/javascript" src="plugins/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script type="text/javascript" src="plugins/datatables.net-fixedcolumns/js/dataTables.fixedColumns.min.js"></script>
    <script type="text/javascript" src="plugins/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <!-- Toastr-->
    <script type="text/javascript" src="plugins/toastr/toastr.min.js"></script>
    <!-- Custom JS-->
    <script type="text/javascript" src="build/js/third-layout/app.js"></script>
    <script type="text/javascript" src="build/js/third-layout/demo.js"></script>
	<script type="text/javascript">
	$(document).ready(function(){
		var Houses=<?php echo json_encode($Houses); ?>;
		var PostsTable=$("#posts").DataTable({
			"createdRow" : function( row, data, index ) {
				// Add identity if it specified
				if( data.hasOwnProperty("id") ) {
					row.id = "post_" + data.id;
				}
			}	
		});
		$("#AddPostForm").submit(function(){
			var post=$("#AddPostPost").val();
			var WCV=$("#AddPostWCV").val();
			$(".mypreloader").fadeIn();
			if(post.length<3){
				$(".mypreloader").fadeOut();
				toastr["error"]("Enter a <strong>valid post</strong>","Invalid Post");
				$("#AddPostPost").focus();
			}
			else{
				$.ajax({
					url:"verify.php",
					type:"POST",
					data:{"add_post":true,"post":post,"WCV":WCV},
					success:function(response){
						try{
							var resp=JSON.parse(response);
							if(resp.code=="ADD_POST_SUC"){
								$(".mypreloader").fadeOut();
								$("#AddPostModal").modal("hide");
								var data=[resp.pid,post,Houses[WCV],'<button class="btn btn-warning edit_post" id="edit_post_'+resp.pid+'"><i class="ti-pencil"></i> Edit</button> <button class="btn btn-danger del_post" id="del_post_'+resp.pid+'"><i class="ti-trash"></i> Delete</button>'];
								data.id=resp.pid;
								var rowIndex=PostsTable.row.add(data).draw(false);
								toastr["success"]("Post has been added successfully to database","Post Added Successfully");
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
			return false;
		});
		$("body").on("click",".edit_post",function(){
			var pid=this.id.split("_")[2];
			$(".mypreloader").fadeIn();
			$.ajax({
				url:"verify.php",
				type:"POST",
				data:{"get_post":true,"pid":pid},
				success:function(response){
					try{
						var resp=JSON.parse(response);
						if(resp.code=="GET_POST_SUC"){
							$(".mypreloader").fadeOut();
							$("#EditPostID").val(pid);
							$("#EditPostPost").val(resp.post);
							$("#EditPostWCV").val(resp.WCV);
							$("#EditPostModal").modal("show");
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
		});
		$("#EditPostForm").submit(function(){
			var pid=$("#EditPostID").val();
			var post=$("#EditPostPost").val();
			var WCV=$("#EditPostWCV").val();
			$(".mypreloader").fadeIn();
			if(post.length<3){
				$(".mypreloader").fadeOut();
				toastr["error"]("Enter a <strong>valid post</strong>","Invalid Post");
				$("#EditPostPost").focus();
			}
			else{
				$.ajax({
					url:"verify.php",
					type:"POST",
					data:{"edit_post":true,"pid":pid,"post":post,"WCV":WCV},
					success:function(response){
						try{
							var resp=JSON.parse(response);
							if(resp.code=="EDIT_POST_SUC"){
								$(".mypreloader").fadeOut();
								$("#EditPostModal").modal("hide");
								var temp = PostsTable.row('#post_'+pid).data();
								temp[1] = post;
								temp[2] = Houses[WCV];
								PostsTable.row('#post_'+pid).data(temp).draw();
								toastr["success"]("Post has been updated successfully to database","Post Updated Successfully");
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
			return false;
		});
		$("body").on("click",".del_post",function(){
			$("#DelPostID").val(this.id.split("_")[2]);
			$("#DelPostModal").modal("show");
		});
		$("#confirm_delete").click(function(){
			var pid=$("#DelPostID").val();
			$(".mypreloader").fadeIn();
			$.ajax({
				url:"verify.php",
				type:"POST",
				data:{"del_post":true,"pid":pid},
				success:function(response){
					try{
						var resp=JSON.parse(response);
						if(resp.code=="DEL_POST_SUC"){
							$(".mypreloader").fadeOut();
							$("#DelPostModal").modal("hide");
							$('#post_'+pid).fadeOut();
							toastr["success"]("Post has been deleted successfully from database","Post Deleted Successfully");
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
		});
		var HousesTable=$("#houses").DataTable({
			"createdRow" : function( row, data, index ) {
				// Add identity if it specified
				if( data.hasOwnProperty("id") ) {
					row.id = "house_" + data.id;
				}
			}	
		});
		$("#AddHouseForm").submit(function(){
			var HouseName=$("#AddHouseName").val();
			$(".mypreloader").fadeIn();
			if(HouseName.length<3){
				$(".mypreloader").fadeOut();
				toastr["error"]("Enter a <strong>valid House Name</strong>","Invalid House Name");
				$("#AddHouseName").focus();
			}
			else{
				$.ajax({
					url:"verify.php",
					type:"POST",
					data:{"add_house":true,"HouseName":HouseName},
					success:function(response){
						try{
							var resp=JSON.parse(response);
							if(resp.code=="ADD_HOUSE_SUC"){
								$(".mypreloader").fadeOut();
								$("#AddHouseModal").modal("hide");
								var data=[resp.hid,HouseName,'<button class="btn btn-warning edit_house" id="edit_house_'+resp.hid+'"><i class="ti-pencil"></i> Edit</button> <button class="btn btn-danger del_house" id="del_house_'+resp.hid+'"><i class="ti-trash"></i> Delete</button>'];
								data.id=resp.hid;
								var rowIndex=HousesTable.row.add(data).draw(false);
								toastr["success"]("House has been added successfully to database","House Added Successfully");
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
			return false;
		});
		$("body").on("click",".edit_house",function(){
			var hid=this.id.split("_")[2];
			$(".mypreloader").fadeIn();
			$.ajax({
				url:"verify.php",
				type:"POST",
				data:{"get_house":true,"hid":hid},
				success:function(response){
					try{
						var resp=JSON.parse(response);
						if(resp.code=="GET_HOUSE_SUC"){
							$(".mypreloader").fadeOut();
							$("#EditHouseID").val(pid);
							$("#EditHouseName").val(resp.HouseName);
							$("#EditHouseModal").modal("show");
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
		});
		$("#EditHouseForm").submit(function(){
			var hid=$("#EditHouseID").val();
			var HouseName=$("#EditHouseName").val();
			$(".mypreloader").fadeIn();
			if(HouseName.length<3){
				$(".mypreloader").fadeOut();
				toastr["error"]("Enter a <strong>valid House Name</strong>","Invalid House Name");
				$("#EditHouseName").focus();
			}
			else{
				$.ajax({
					url:"verify.php",
					type:"POST",
					data:{"edit_house":true,"hid":hid,"HouseName":HouseName},
					success:function(response){
						try{
							var resp=JSON.parse(response);
							if(resp.code=="EDIT_HOUSE_SUC"){
								$(".mypreloader").fadeOut();
								$("#EditHouseModal").modal("hide");
								var temp = HousesTable.row('#house_'+hid).data();
								temp[1] = HouseName;
								HousesTable.row('#house_'+hid).data(temp).draw();
								toastr["success"]("House has been updated successfully to database","House Updated Successfully");
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
			return false;
		});
		$("body").on("click",".del_house",function(){
			$("#DelHouseID").val(this.id.split("_")[2]);
			$("#DelHouseModal").modal("show");
		});
		$("#confirm_delete_house").click(function(){
			var hid=$("#DelHouseID").val();
			$(".mypreloader").fadeIn();
			$.ajax({
				url:"verify.php",
				type:"POST",
				data:{"del_house":true,"hid":hid},
				success:function(response){
					try{
						var resp=JSON.parse(response);
						if(resp.code=="DEL_HOUSE_SUC"){
							$(".mypreloader").fadeOut();
							$("#DelHouseModal").modal("hide");
							$('#house_'+hid).fadeOut();
							toastr["success"]("House has been deleted successfully from database","House Deleted Successfully");
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
		});
	});
	</script>
  </body>
</html>