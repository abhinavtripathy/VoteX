<?php
error_reporting(E_ALL);
include("includes/config.php");
include("includes/functions.php");
if(!isset($_COOKIE["admin"])){header("location:login.php?redirect=candidates.php");}
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
    <title>Candidates - Admin Panel | Votex</title>
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
    <!-- Header end -->
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
          <li class="panel"><a href="candidates.php" class="active"><i class="ti-user"></i><span class="sidebar-title">Candidates</span></a></li>
          <li class="panel"><a href="votes.php"><i class="ti-bar-chart"></i><span class="sidebar-title">Votes</span></a></li>
          <li class="panel"><a href="settings.php"><i class="ti-settings"></i><span class="sidebar-title">Settings</span></a></li>
          <li class="panel"><a href="logout.php"><i class="ti-power-off"></i><span class="sidebar-title">Logout</span></a></li>
        </ul>
      </aside>
      <!-- Main Sidebar end-->
      <div class="page-container">
        <div class="page-header clearfix">
          <div class="row">
            <div class="col-sm-12">
              <h4 class="mt-0 mb-5">Candidates</h4>
            </div>
          </div>
        </div>
        <div class="page-content container-fluid">
			<div class="row">
				<div class="col-lg-12">
				  <div class="widget">
					<div class="widget-heading clearfix">
					  <h3 class="widget-title pull-left">Manage Candidates</h3>
					  <ul class="widget-tools pull-right list-inline">
						<li><a href="javascript:;" class="btn btn-success" style="color:#fff" id="add_candidate" data-toggle="modal" data-target="#AddCandidateModal"><i class="ti-plus"></i> Add</a></li>
					  </ul>
					</div>
					<div class="widget-body">
					  <table id="candidates" cellspacing="0" width="100%" class="table table-striped table-bordered table-responsive">
						<thead>
						  <tr>
							<th>CID</th>
							<th>Candidate</th>
							<th>Post</th>
							<th>Settings</th>
						  </tr>
						</thead>
						<tfoot>
						  <tr>
							<th>CID</th>
							<th>Candidate</th>
							<th>Post</th>
							<th>Settings</th>
						  </tr>
						</tfoot>
						<tbody>
						  <?php
						  $sql="SELECT * FROM candidates";
						  $result=$conn->query($sql);
						  if($result->num_rows>0){
							  while($row=$result->fetch_assoc()){
								echo '<tr id="candidate_'.$row['cid'].'"><td>'.$row['cid'].'</td><td>'.$row['CandidateName'].'</td><td>'.get_post_title($row['CandidatePost']).'</td><td><button class="btn btn-warning edit_candidate" id="edit_candidate_'.$row['cid'].'"><i class="ti-pencil"></i> Edit</button> <button class="btn btn-danger del_candidate" id="del_candidate_'.$row['cid'].'"><i class="ti-trash"></i> Delete</button></td></tr>';
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
      
      </div>
      
    </div>
	<div tabindex="-1" role="dialog" aria-labelledby="AddCandidateModalLabel" class="modal fade" id="AddCandidateModal">
		<div role="document" class="modal-dialog">
		  <div class="modal-content">
			<div class="modal-header">
			  <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">&times;</span></button>
			  <h4 id="AddCandidateModalLabel" class="modal-title">Add Candidate</h4>
			</div>
			<form action="" method="POST" id="AddCandidateForm" enctype="multipart/form-data">
				<div class="modal-body">
					<div class="form-group">
					  <label for="AddCandidateName">Name</label>
					  <input id="AddCandidateName" type="text" placeholder="Enter Name" class="form-control">
					</div>
					<div class="form-group">
					  <label for="AddCandidatePost">Post</label>
					  <select id="AddCandidatePost" class="form-control">
						<option value="null" selected disabled>Select Post</option>
						<?php
						$sql="SELECT * FROM posts";
						$result=$conn->query($sql);
						if($result->num_rows>0){
							while($row=$result->fetch_assoc()){
								echo '<option value="'.$row["pid"].'">'.$row["post"].'</option>';
							}
						}
						?>
					  </select>
					</div>
					<div class="form-group">
					  <label for="AddCandidatePhoto">Photo</label>
					  <input id="AddCandidatePhoto" type="file" class="form-control">
					</div>
				</div>
				<div class="modal-footer">
				  <button type="button" data-dismiss="modal" class="btn btn-raised btn-default">Close</button>
				  <button type="submit" class="btn btn-raised btn-black">Add Candidate</button>
				</div>
			</form>
		  </div>
		</div>
	</div>
	<div tabindex="-1" role="dialog" aria-labelledby="EditCandidateModalLabel" class="modal fade" id="EditCandidateModal">
		<div role="document" class="modal-dialog">
		  <div class="modal-content">
			<div class="modal-header">
			  <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">&times;</span></button>
			  <h4 id="EditCandidateModalLabel" class="modal-title">Edit Candidate</h4>
			</div>
			<form action="" method="POST" id="EditCandidateForm" enctype="multipart/form-data">
				<div class="modal-body">
					<input type="hidden" id="EditCandidateID" value="0">
					<div class="form-group">
					  <label for="EditCandidateName">Name</label>
					  <input id="EditCandidateName" type="text" placeholder="Enter Name" class="form-control">
					</div>
					<div class="form-group">
					  <label for="EditCandidatePost">Post</label>
					  <select id="EditCandidatePost" class="form-control">
						<option value="null" selected disabled>Select Post</option>
						<?php
						$sql="SELECT * FROM posts";
						$result=$conn->query($sql);
						if($result->num_rows>0){
							while($row=$result->fetch_assoc()){
								echo '<option value="'.$row["pid"].'">'.$row["post"].'</option>';
							}
						}
						?>
					  </select>
					</div>
					<div class="form-group">
					  <label for="EditCandidatePhoto">Photo (Opt)</label>
					  <input id="EditCandidatePhoto" type="file" class="form-control">
					</div>
				</div>
				<div class="modal-footer">
				  <button type="button" data-dismiss="modal" class="btn btn-raised btn-default">Close</button>
				  <button type="submit" class="btn btn-raised btn-black">Update</button>
				</div>
			</form>
		  </div>
		</div>
	</div>
	<div tabindex="-1" role="dialog" aria-labelledby="DelCandidateModalLabel" class="modal fade" id="DelCandidateModal">
		<div role="document" class="modal-dialog">
		  <div class="modal-content bg-danger">
			<div class="modal-header">
			  <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">&times;</span></button>
			  <h4 id="DelCandidateModalLabel" class="modal-title">Are you sure you want to delete this candidate?</h4>
			</div>
			<div class="modal-body">
			  <input type="hidden" id="DelCandidateID" value="0">
			  <p>THERE IS NO UNDO!</p>
			</div>
			<div class="modal-footer">
			  <button type="button" data-dismiss="modal" class="btn btn-raised btn-default">Close</button>
			  <button type="button" class="btn btn-raised btn-black" id="confirm_delete">Confirm Delete</button>
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
	<?php 
	$posts=array();
	$sql="SELECT * FROM posts";
	$result=$conn->query($sql);
	if($result->num_rows>0){
		while($row=$result->fetch_assoc()){
			$posts[$row["pid"]]=$row["post"];
		}
	}
	?>
	<script type="text/javascript">
	$(document).ready(function(){
		var Posts=<?php echo json_encode($posts); ?>;
		var CandidatesTable=$("#candidates").DataTable({
			"createdRow" : function( row, data, index ) {
				// Add identity if it specified
				if( data.hasOwnProperty("id") ) {
					row.id = "candidate_" + data.id;
				}
			}	
		});
		$("#AddCandidateForm").submit(function(){
			$(".mypreloader").fadeIn();
			var CandidateName=$("#AddCandidateName").val();
			var CandidatePost=$("#AddCandidatePost").val();
			var CandidatePhoto=$("#AddCandidatePhoto").val();
			if(CandidateName.length<3){
				toastr["error"]("Enter a <strong>valid Candidate Name</strong>","Invalid Candidate Name");
				$("#AddCandidateName").focus();
				$(".mypreloader").fadeOut();
			}
			else if(CandidatePost==null){
				toastr["error"]("Select a <strong>valid Candidate Post</strong>","Invalid Candidate Post");
				$("#AddCandidatePost").focus();
				$(".mypreloader").fadeOut();
			}
			else if(!CandidatePhoto){
				toastr["error"]("Select a <strong>valid Candidate Photo</strong>","Invalid Candidate Photo");
				$("#AddCandidatePhoto").focus();
				$(".mypreloader").fadeOut();
			}
			else{
				var formData = new FormData();
				formData.append('add_candidate', true);
				formData.append('CandidateName', CandidateName);
				formData.append('CandidatePost', CandidatePost);
				formData.append('CandidatePhoto', $('#AddCandidatePhoto')[0].files[0]);
				$.ajax({
					url : 'verify.php',
					type : 'POST',
					data : formData,
					processData: false,
					contentType: false,
					success : function(data) {
						console.log(data);
						try{
							var resp=JSON.parse(data);
							if(resp.code=="ADD_CANDIDATE_SUC"){
								var data=[resp.cid,CandidateName,Posts[CandidatePost],'<button class="btn btn-warning edit_candidate" id="edit_candidate_'+resp.cid+'"><i class="ti-pencil"></i> Edit</button> <button class="btn btn-danger del_candidate" id="del_candidate_'+resp.cid+'"><i class="ti-trash"></i> Delete</button>'];
								data.id=resp.cid;
								var rowIndex=CandidatesTable.row.add(data).draw(false);
								$(".mypreloader").fadeOut();
								toastr["success"]("Candidate has been added successfully to database","Candidate Added Successfully");
								$("#AddCandidateModal").modal("hide");
							}
							else{
								$(".mypreloader").fadeOut();
								toastr["error"]("Response Code: <strong>"+resp.code+"</strong>",resp.msg);
							}
						}
						catch(err){
							$(".mypreloader").fadeOut();
							toastr["error"](err,"Unknown Error Occured");
						}
					},
					error: function(data){
						toastr["error"]("Please Check Your Internet Connection And Try Again!","Connection Failed");
						$(".mypreloader").fadeOut();
					}
				});
			}
			return false;
		});
		$("body").on("click",".edit_candidate",function(){
			var cid=this.id.split("_")[2];
			$(".mypreloader").fadeIn();
			$.ajax({
				url:"verify.php",
				type:"POST",
				data:{"get_candidate":true,"cid":cid},
				success:function(response){
					try{
						var resp=JSON.parse(response);
						if(resp.code=="GET_CANDIDATE_SUC"){
							$(".mypreloader").fadeOut();
							$("#EditCandidateID").val(cid);
							$("#EditCandidateName").val(resp.CandidateName);
							$("#EditCandidatePost").val(resp.CandidatePost);
							$("#EditCandidateModal").modal("show");
						}
						else{
							$(".mypreloader").fadeOut();
							toastr["error"]("Response Code: <strong>"+resp.code+"</strong>",resp.msg);
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
		$("#EditCandidateForm").submit(function(){
			var cid=$("#EditCandidateID").val();
			var CandidateName=$("#EditCandidateName").val();
			var CandidatePost=$("#EditCandidatePost").val();
			var CandidatePhoto=$("#EditCandidatePhoto").val();
			if(CandidateName.length<3){
				toastr["error"]("Enter a <strong>valid Candidate Name</strong>","Invalid Candidate Name");
				$("#EditCandidateName").focus();
				$(".mypreloader").fadeOut();
			}
			else if(CandidatePost==null){
				toastr["error"]("Select a <strong>valid Candidate Post</strong>","Invalid Candidate Post");
				$("#EditCandidatePost").focus();
				$(".mypreloader").fadeOut();
			}
			else{
				var formData = new FormData();
				formData.append('edit_candidate', true);
				formData.append('cid', cid);
				formData.append('CandidateName', CandidateName);
				formData.append('CandidatePost', CandidatePost);
				if(CandidatePhoto){
					formData.append('CandidatePhoto', $('#EditCandidatePhoto')[0].files[0]);
				}
				$.ajax({
					url : 'verify.php',
					type : 'POST',
					data : formData,
					processData: false,
					contentType: false,
					success : function(data) {
						console.log(data);
						try{
							var resp=JSON.parse(data);
							if(resp.code=="EDIT_CANDIDATE_SUC"){
								$("#EditCandidateModal").modal("hide");
								var temp = CandidatesTable.row('#candidate_'+cid).data();
								temp[1] = CandidateName;
								temp[2] = Posts[CandidatePost];
								CandidatesTable.row('#candidate_'+cid).data(temp).draw();
								toastr["success"]("Candidate has been updated successfully to database","Candidate Updated Successfully");
							}
							else{
								$(".mypreloader").fadeOut();
								toastr["error"]("Response Code: <strong>"+resp.code+"</strong>",resp.msg);
							}
						}
						catch(err){
							$(".mypreloader").fadeOut();
							toastr["error"](err,"Unknown Error Occured");
						}
					},
					error: function(data){
						toastr["error"]("Please Check Your Internet Connection And Try Again!","Connection Failed");
						$(".mypreloader").fadeOut();
					}
				});
			}
			return false;
		});
		$("body").on("click",".del_candidate",function(){
			$("#DelCandidateID").val(this.id.split("_")[2]);
			$("#DelCandidateModal").modal("show");
		});
		$("#confirm_delete").click(function(){
			var cid=$("#DelCandidateID").val();
			$(".mypreloader").fadeIn();
			$.ajax({
				url:"verify.php",
				type:"POST",
				data:{"del_candidate":true,"cid":cid},
				success:function(response){
					try{
						var resp=JSON.parse(response);
						if(resp.code=="DEL_CANDIDATE_SUC"){
							$(".mypreloader").fadeOut();
							$("#DelCandidateModal").modal("hide");
							$('#candidate_'+cid).fadeOut();
							toastr["success"]("Candidate has been deleted successfully from database","Candidate Deleted Successfully");
						}
						else{
							$(".mypreloader").fadeOut();
							toastr["error"]("Response Code: <strong>"+resp.code+"</strong>",resp.msg);
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