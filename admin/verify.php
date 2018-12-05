<?php
error_reporting(E_ALL);
include("includes/config.php");
include("includes/functions.php");
$response=array("msg"=>"Invalid Request","code"=>"INV_REQ");

if(isset($_POST["login"])){
	$username=$_POST["username"];
	if(preg_match('/[^a-z_\-0-9]/i', $username)){
		$response["msg"]="Invalid Username";
		$response["msg"]="LOGIN_ERR_1";
	}
	else{
		$password=md5($_POST["password"]);
		$remember=$_POST["remember"];
		$sql = "SELECT * FROM admins WHERE username='$username' AND password='$password'";
		$result = $conn->query($sql);
		if($result->num_rows>0){
			while($row=$result->fetch_assoc()){
				$log_time=time();
				$log_hash=md5($log_time);
				$aid=$row["aid"];
				$admin=safe_encrypt($aid,$log_hash);
				$sql="UPDATE admins SET log_time='$log_time' AND log_hash='$log_hash' WHERE aid='$aid'";
				if(mysqli_query($conn,$sql)){
					if($remember=="yes"){
						setcookie("admin",$admin,60*60*24*7);
						setcookie("hash",$log_hash,60*60*24*7);
					}
					else{
						setcookie("admin",$admin);
						setcookie("hash",$log_hash);
					}
					$response["msg"]="Login Successfull";
					$response["code"]="LOGIN_SUC";
				}
				else{
					$response["msg"]="Unable to login";
					$response["code"]="LOGIN_ERR_3";
				}
			}
		}
		else{
			$response["msg"]="Invalid Username/Password";
			$response["code"]="LOGIN_ERR_2";
		}
	}
}
else if(isset($_POST["add_post"])){
	$sql="INSERT INTO posts (post,WCV) VALUES ('$_POST[post]','$_POST[WCV]')";
	if(mysqli_query($conn,$sql)){
		$response["msg"]="Post Added Successfully";
		$response["code"]="ADD_POST_SUC";
		$response["pid"]=mysqli_insert_id($conn);
	}
	else{
		$response["msg"]="Unable to Add New Post";
		$response["code"]="ADD_POST_ERR";
	}
}
else if(isset($_POST["get_post"])){
	$sql="SELECT * FROM posts WHERE pid='$_POST[pid]'";
	$result=$conn->query($sql);
	if($result->num_rows>0){
		while($row=$result->fetch_assoc()){
			$response["post"]=$row["post"];
			$response["WCV"]=$row["WCV"];
			$response["msg"]="Post Fetched Successfully";
			$response["code"]="GET_POST_SUC";
		}
	}
	else{
		$response["msg"]="Unable to Fetch Post";
		$response["code"]="GET_POST_ERR";
	}
}
else if(isset($_POST["edit_post"])){
	$sql="UPDATE posts SET post='$_POST[post]',WCV='$_POST[WCV]' WHERE pid='$_POST[pid]'";
	if(mysqli_query($conn,$sql)){
		$response["msg"]="Post Updated Successfully";
		$response["code"]="EDIT_POST_SUC";
	}
	else{
		$response["msg"]="Unable to Update Post";
		$response["code"]="EDIT_POST_ERR";
	}
}
else if(isset($_POST["del_post"])){
	$sql="DELETE FROM posts WHERE pid='$_POST[pid]'";
	if(mysqli_query($conn,$sql)){
		$response["msg"]="Post Deleted Successfully";
		$response["code"]="DEL_POST_SUC";
	}
	else{
		$response["msg"]="Unable to Delete Post";
		$response["code"]="DEL_POST_ERR";
	}
}
else if(isset($_POST["add_house"])){
	$sql="INSERT INTO houses (HouseName) VALUES ('$_POST[HouseName]')";
	if(mysqli_query($conn,$sql)){
		$response["msg"]="House Added Successfully";
		$response["code"]="ADD_HOUSE_SUC";
		$response["hid"]=mysqli_insert_id($conn);
	}
	else{
		$response["msg"]="Unable to Add New House";
		$response["code"]="ADD_HOUSE_ERR";
	}
}
else if(isset($_POST["get_house"])){
	$sql="SELECT * FROM houses WHERE hid='$_POST[hid]'";
	$result=$conn->query($sql);
	if($result->num_rows>0){
		while($row=$result->fetch_assoc()){
			$response["HouseName"]=$row["HouseName"];
			$response["msg"]="House Fetched Successfully";
			$response["code"]="GET_HOUSE_SUC";
		}
	}
	else{
		$response["msg"]="Unable to Fetch House";
		$response["code"]="GET_HOUSE_ERR";
	}
}
else if(isset($_POST["edit_house"])){
	$sql="UPDATE houses SET HouseName='$_POST[HouseName]' WHERE hid='$_POST[hid]'";
	if(mysqli_query($conn,$sql)){
		$response["msg"]="House Updated Successfully";
		$response["code"]="EDIT_HOUSE_SUC";
	}
	else{
		$response["msg"]="Unable to Update House";
		$response["code"]="EDIT_HOUSE_ERR";
	}
}
else if(isset($_POST["del_house"])){
	$sql="DELETE FROM houses WHERE hid='$_POST[hid]'";
	if(mysqli_query($conn,$sql)){
		$response["msg"]="House Deleted Successfully";
		$response["code"]="DEL_HOUSE_SUC";
	}
	else{
		$response["msg"]="Unable to Delete House";
		$response["code"]="DEL_HOUSE_ERR";
	}
}
else if(isset($_POST["add_candidate"])){
	if(isset($_FILES["CandidatePhoto"])){
		$allowedExts = array("gif", "jpeg", "jpg", "png");
		$temp = explode(".", strtolower($_FILES["CandidatePhoto"]["name"]));
		$extension = end($temp);
		if ((($_FILES["CandidatePhoto"]["type"] == "image/gif") || ($_FILES["CandidatePhoto"]["type"] == "image/jpeg") || ($_FILES["CandidatePhoto"]["type"] == "image/jpg") || ($_FILES["CandidatePhoto"]["type"] == "image/pjpeg") || ($_FILES["CandidatePhoto"]["type"] == "image/x-png") || ($_FILES["CandidatePhoto"]["type"] == "image/png")) && in_array($extension, $allowedExts)) {
			$path="../uploads/";
			$filename=time().".".$extension;
			if(move_uploaded_file($_FILES["CandidatePhoto"]["tmp_name"],$path.$filename)){
				$sql="INSERT INTO candidates (CandidateName,CandidatePost,CandidatePhoto) VALUES ('$_POST[CandidateName]','$_POST[CandidatePost]','$filename')";
				if(mysqli_query($conn,$sql)){
					$response["msg"]="Inserted Successfully into Database";
					$response["code"]="ADD_CANDIDATE_SUC";
					$response["cid"]=mysqli_insert_id($conn);
				}
				else{
					$response["msg"]="Unable to Insert into Database";
					$response["code"]="ADD_CANDIDATE_ERR_4";
				}
			}
			else{
				$response["msg"]="Unable to Upload Photo";
				$response["code"]="ADD_CANDIDATE_ERR_3";
			}
		}
		else{
			$response["msg"]="Invalid Photo Selected";
			$response["code"]="ADD_CANDIDATE_ERR_2";
		}
	}
	else{
		$response["msg"]="Photo Not Uploaded";
		$response["code"]="ADD_CANDIDATE_ERR_1";
	}
}
else if(isset($_POST["get_candidate"])){
	$sql="SELECT * FROM candidates WHERE cid='$_POST[cid]'";
	$result=$conn->query($sql);
	if($result->num_rows>0){
		while($row=$result->fetch_assoc()){
			$response["CandidateName"]=$row["CandidateName"];
			$response["CandidatePost"]=$row["CandidatePost"];
			$response["msg"]="Candidate Fetched Successfully";
			$response["code"]="GET_CANDIDATE_SUC";
		}
	}
	else{
		$response["msg"]="Unable to Fetch Candidate";
		$response["code"]="GET_CANDIDATE_ERR";
	}
}
else if(isset($_POST["edit_candidate"])){
	if(isset($_FILES["CandidatePhoto"])){
		$allowedExts = array("gif", "jpeg", "jpg", "png");
		$temp = explode(".", strtolower($_FILES["CandidatePhoto"]["name"]));
		$extension = end($temp);
		if ((($_FILES["CandidatePhoto"]["type"] == "image/gif") || ($_FILES["CandidatePhoto"]["type"] == "image/jpeg") || ($_FILES["CandidatePhoto"]["type"] == "image/jpg") || ($_FILES["CandidatePhoto"]["type"] == "image/pjpeg") || ($_FILES["CandidatePhoto"]["type"] == "image/x-png") || ($_FILES["CandidatePhoto"]["type"] == "image/png")) && in_array($extension, $allowedExts)) {
			$path="../uploads/";
			$filename=time().".".$extension;
			if(move_uploaded_file($_FILES["CandidatePhoto"]["tmp_name"],$path.$filename)){
				$sql="UPDATE candidates SET CandidateName='$_POST[CandidateName]',CandidatePost='$_POST[CandidatePost]',CandidatePhoto='$filename' WHERE cid='$_POST[cid]'";
				if(mysqli_query($conn,$sql)){
					$response["msg"]="Updated Candidate Successfully";
					$response["code"]="EDIT_CANDIDATE_SUC";
				}
				else{
					$response["msg"]="Unable to Update Candidate";
					$response["code"]="EDIT_CANDIDATE_ERR_1";
				}
			}
			else{
				$response["msg"]="Unable to Upload Photo";
				$response["code"]="EDIT_CANDIDATE_ERR_3";
			}
		}
		else{
			$response["msg"]="Invalid Photo Selected";
			$response["code"]="EDIT_CANDIDATE_ERR_2";
		}
	}
	else{
		$sql="UPDATE candidates SET CandidateName='$_POST[CandidateName]',CandidatePost='$_POST[CandidatePost]' WHERE cid='$_POST[cid]'";
		if(mysqli_query($conn,$sql)){
			$response["msg"]="Candidate Updated Successfully";
			$response["code"]="EDIT_CANDIDATE_SUC";
		}
		else{
			$response["msg"]="Unable to Update Candidate";
			$response["code"]="EDIT_CANDIDATE_ERR_1";
		}
	}
}
else if(isset($_POST["del_candidate"])){
	$sql="DELETE FROM candidates WHERE cid='$_POST[cid]'";
	if(mysqli_query($conn,$sql)){
		$response["msg"]="Candidate Deleted Successfully";
		$response["code"]="DEL_CANDIDATE_SUC";
	}
	else{
		$response["msg"]="Unable to Delete Candidate";
		$response["code"]="DEL_CANDIDATE_ERR";
	}
}
else if(isset($_POST["reset_votes"])){
	if(md5($_POST["password"])==md5("admin@123")){
		$sql="TRUNCATE TABLE votes;TRUNCATE TABLE voters;";
		if(mysqli_multi_query($conn,$sql)){
			$response["msg"]="Votes Reset Successfully";
			$response["code"]="RESET_VOTES_SUC";
		}
		else{
			$response["msg"]="Unable to Reset Votes";
			$response["code"]="RESET_VOTES_ERR";
		}
	}
	else{
		$response["msg"]="Unable to Reset Votes";
		$response["code"]="RESET_VOTES_ERR";
	}
}
else if(isset($_POST["reset_everything"])){
	if(md5($_POST["password"])==md5("admin@123")){
		$sql="TRUNCATE TABLE candidates;TRUNCATE TABLE voters;TRUNCATE TABLE votes;";
		if(mysqli_multi_query($conn,$sql)){
			$response["msg"]="Everything Reset Successfully";
			$response["code"]="RESET_EVERYTHING_SUC";
		}
		else{
			$response["msg"]="Unable to Reset Everything";
			$response["code"]="RESET_EVERYTHING_ERR";
		}
	}
	else{
		$response["msg"]="Unable to Reset Everything";
		$response["code"]="RESET_EVERYTHING_ERR";
	}
}
echo json_encode($response);
?>