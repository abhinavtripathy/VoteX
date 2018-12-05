<?php
error_reporting(E_ALL);
include("admin/includes/config.php");
include("admin/includes/functions.php");
$response=array("msg"=>"Invalid Request","code"=>"INV_REQ");
function SendVerifyEmail($SchoolEmail,$VerificationCode){
	$base="http://robocode.in/votex/";
	//$base="http://localhost/votex/";
	require 'phpmailer/PHPMailerAutoload.php';
	$mail = new PHPMailer;
	$mail->isSMTP();
	$mail->SMTPDebug = 0;
	$mail->Debugoutput = 'html';
	$mail->Host = 'cp-48.webhostbox.net';
	$mail->Port = 465;
	$mail->SMTPSecure = 'ssl';
	$mail->SMTPAuth = true;
	$mail->Username = "votex@robocode.in";
	$mail->Password = "votex@123";
	$mail->setFrom('votex@robocode.in', 'VoteX Admin',0);
	$mail->addAddress($SchoolEmail, 'VoteX User');
	$mail->Subject = 'Welcome to GWH';
	$mail->msgHTML('<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/><title>Welcome to GWH</title><meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"><link href="https://fonts.googleapis.com/css?family=Raleway:400,500,700,300,600" rel="stylesheet"><style>html,body{font-family:Raleway, Arial, Helvetica, sans-serif !important;text-align:center !important;display:block !important;color:#f0f0f0 !important}.container{width:80% !important;position:absolute !important;top:0 !important;left:10% !important;margin:0 !important;padding:0 !important;background-color:#303030 !important;box-sizing:border-box !important}section{width:100% !important;margin:0 !important;padding:0 !important;box-sizing:border-box !important}h1,h2,h3{margin:0 !important}.intro{background:url('.$base.'assets/img/mailbg.jpg) no-repeat !important;background-size:cover !important;color:#000 !important;padding:100px 0px !important}.intro img{width:100px !important;height:100px !important;margin:10px !important}.intro h1{font-size:36px !important;font-weight:300 !important}.intro h2{font-size:16px !important;font-weight:800 !important}.body{padding:20px !important;border-bottom:1px solid #fff !important;box-sizing:border-box !important}.body h1{font-size:36px !important;color:#f0f0f0 !important;font-weight:700 !important}.body h2{font-size:23px !important;color:#cecece !important;font-weight:500 !important}.body h2 span{font-weight:bold !important}.body p{font-size:12px !important;color:#cecece !important}.body .code{color:#ccc !important;font-size:32px !important;padding:5px !important;margin:40px !important;font-family:Arial, Helvetica, sans-serif !important;font-weight:700 !important;background:#000 !important;border-radius:5px !important}.body a{font-size:16px !important;font-weight:500 !important;color:#a4a4a4 !important;text-decoration:none !important;width:120px !important;height:38px !important;display:block !important;background:#ededed !important;border-radius:2px !important;padding:0 !important;padding-top:20px !important}.body .regards{text-align:left !important;font-weight:400 !important;font-size:15px !important}.footer{padding:20px !important;padding-bottom:40px !important}.footer h3{float:left !important}.footer-links{float:right !important}.footer-links a{padding-right:10px !important}</style></head><body><div class="container"><section class="intro"><img src="'.$base.'assets/img/logo-sm-dark.png"><h1>GWH</h1><h2>Shape Tommorow By Voting Today</h2></section><section class="body"><h1>Welcome</h1><h2>to GWH</span></h2><p>Your account activation code is: </p><span class="code">'.$VerificationCode.'</span><p align="center"><a href="'.$base.'verification?email='.$SchoolEmail.'&code='.$VerificationCode.'">VERIFY NOW</a></p><p class="regards">Regards,<br><strong>GWH Admin</strong><br><em>GWH@robocode.in</em></p></section><section class="footer"><h3>&copy; GWH 2018</h3><div class="footer-links"></div></section></div></body></html>');
	return $mail->send();
}
function get_WCV($vid){
	global $conn;
	$sql="SELECT * FROM voters WHERE vid='$vid'";
	$result=$conn->query($sql);
	if($result->num_rows>0){
		while($row=$result->fetch_assoc()){
			return $row["hid"];
		}
	}
	return '0';
}
if(isset($_POST["login"])){
	if(!empty($_POST["SchoolEmail"])) {
		$SchoolEmail = test_input($_POST["SchoolEmail"]);
		if(filter_var($SchoolEmail, FILTER_VALIDATE_EMAIL)) {
			$sql="SELECT * FROM voters WHERE SchoolEmail='$SchoolEmail'";
			$result=$conn->query($sql);
			if($result->num_rows>0){
				while($row=$result->fetch_assoc()){
					if(!SendVerifyEmail($row["SchoolEmail"],$row["VerificationCode"])) {
						$response["msg"]="Email Delivery Failed";
						$response["code"]="LOGIN_ERR_4";
						$response["err"]=$mail->ErrorInfo;
					}
					else{
						$response["msg"]="Verfication Pending";
						$response["code"]="LOGIN_VERIFY";
						$response["loc"]="verification?email=".$SchoolEmail;
					}
				}
			}
			else{
				$VerificationCode=GenerateCode();
				$sql="INSERT INTO voters (SchoolEmail,VerificationCode) VALUES ('$SchoolEmail','$VerificationCode')";
				if(mysqli_query($conn,$sql)){
					if (!SendVerifyEmail($SchoolEmail,$VerificationCode)) {
						$response["msg"]="Email Delivery Failed";
						$response["code"]="LOGIN_ERR_4";
						$response["err"]=$mail->ErrorInfo;
					}
					else
					{
						$response["msg"]="Verfication Pending";
						$response["code"]="LOGIN_VERIFY";
						$response["loc"]="verification?email=".$SchoolEmail;
					}
				}
				else{
					$response["msg"]="Database Connection Error";
					$response["code"]="LOGIN_ERR_3";
				}
			}
		}
		else{
			$response["msg"]="Invalid School Email";
			$response["code"]="LOGIN_ERR_2";
		}
	}
	else{
		$response["msg"]="Invalid School Email";
		$response["code"]="LOGIN_ERR_1";
	}
}
else if(isset($_POST["verification"])){
	if(!empty($_POST["VerificationCode"])){
		$VerificationCode = test_input($_POST["VerificationCode"]);
		if((preg_match("/^[a-zA-Z0-9]*$/",$VerificationCode))&&strlen($VerificationCode)==10) {
			if(!empty($_POST["SchoolEmail"])) {
				$SchoolEmail = test_input($_POST["SchoolEmail"]);
				if(filter_var($SchoolEmail, FILTER_VALIDATE_EMAIL)) {
					$sql="SELECT * FROM voters WHERE SchoolEmail='$SchoolEmail' AND VerificationCode='$VerificationCode'";
					$result=$conn->query($sql);
					if($result->num_rows>0){
						while($row=$result->fetch_assoc()){
							$LogTime=time();
							$LogHash=md5($LogTime);
							$vid=$row["vid"];
							$vid_hashed=safe_encrypt($vid,$LogHash);
							$sql="UPDATE voters SET VerificationStatus=1,LogTime='$LogTime',LogHash='$LogHash' WHERE vid='$vid'";
							if(mysqli_query($conn,$sql)){
								setcookie("vid",$vid_hashed);
								setcookie("hash",$LogHash);
								$response["msg"]="Verification Successful";
								$response["code"]="VERIFICATION_SUC";
								$response["loc"]="welcome";
							}
							else{
								$response["msg"]="Database Connection Error";
								$response["code"]="VERIFICATION_ERR_6";
							}
						}
					}
					else{
						$response["msg"]="Invalid Verification Code";
						$response["code"]="VERIFICATION_ERR_5";
					}
				}
				else{
					$response["msg"]="Invalid School Email";
					$response["code"]="VERIFICATION_ERR_4";
				}
			}
			else{
				$response["msg"]="Invalid School Email";
				$response["code"]="VERIFICATION_ERR_3";
			}
		}
		else{
			$response["msg"]="Invalid Verification Code";
			$response["code"]="VERIFICATION_ERR_2";
		}
	}
	else{
		$response["msg"]="Invalid Verification Code";
		$response["code"]="VERIFICATION_ERR_1";
	}
}
else if(isset($_POST["start_voting"])){
	$vid=safe_decrypt($_COOKIE["vid"],$_COOKIE["hash"]);
	$WCV=get_WCV($vid);
	$sql="UPDATE voters SET VotingStatus=1 WHERE vid='$vid'";
	if(mysqli_query($conn,$sql)){
		$sql="SELECT * FROM posts WHERE WCV='0' OR WCV='$WCV' ORDER BY pid ASC LIMIT 1";
		$result=$conn->query($sql);
		if($result->num_rows>0){
			while($row=$result->fetch_assoc()){
				$pid=$row["pid"];
				$response["msg"]="Started Voting Successfully";
				$response["code"]="START_VOTING_SUC";
				$response["pid"]=$pid;
				$response["post"]=$row["post"];
				$candidates=array();
				$sql2="SELECT * FROM candidates WHERE CandidatePost='$pid'";
				$result2=$conn->query($sql2);
				if($result2->num_rows>0){
					while($row2=$result2->fetch_assoc()){
						$candidates[$row2["cid"]]=json_encode(array("CandidateName"=>$row2["CandidateName"],"CandidatePhoto"=>"uploads/".$row2["CandidatePhoto"]));
					}
				}
				else{
					$response["msg"]="Unable to Start Voting";
					$response["code"]="START_VOTING_ERR_3";
				}
				$response["candidates"]=json_encode($candidates);
			}
		}
		else{
			$response["msg"]="Unable to Start Voting";
			$response["code"]="START_VOTING_ERR_2";
		}
	}
	else{
		$response["msg"]="Unable to Start Voting";
		$response["code"]="START_VOTING_ERR_1";
	}
}
else if(isset($_POST["continue_voting"])){
	$vid=safe_decrypt($_COOKIE["vid"],$_COOKIE["hash"]);
	$WCV=get_WCV($vid);
	$pid=$_POST["pid"];
	$cid=$_POST["cid"];
	$voted_at=time();
	$sql="INSERT INTO votes (vid,pid,cid,voted_at) VALUES ('$vid','$pid','$cid','$voted_at')";
	if(mysqli_query($conn,$sql)){
		$sql="SELECT * FROM posts WHERE pid>'$pid' AND (WCV='0' OR WCV='$WCV') ORDER BY pid ASC LIMIT 1";
		$result=$conn->query($sql);
		if($result->num_rows>0){
			while($row=$result->fetch_assoc()){
				$pid=$row["pid"];
				$sql="UPDATE voters SET VotingLastPID='$pid' WHERE vid='$vid'";
				if(mysqli_query($conn,$sql)){
					$response["msg"]="Continue Voting Successfully";
					$response["code"]="CONTINUE_VOTING_SUC";
					$response["pid"]=$pid;
					$response["post"]=$row["post"];
					$candidates=array();
					$sql2="SELECT * FROM candidates WHERE CandidatePost='$pid'";
					$result2=$conn->query($sql2);
					if($result2->num_rows>0){
						while($row2=$result2->fetch_assoc()){
							$candidates[$row2["cid"]]=json_encode(array("CandidateName"=>$row2["CandidateName"],"CandidatePhoto"=>"uploads/".$row2["CandidatePhoto"]));
						}
					}
					else{
						$response["msg"]="Unable to Continue Voting";
						$response["code"]="CONTINUE_VOTING_ERR_4";
					}
					$response["candidates"]=json_encode($candidates);
				}
				else{
					$response["msg"]="Unable to Continue Voting";
					$response["code"]="CONTINUE_VOTING_ERR_3";
				}
			}
		}
		else{
			$sql="UPDATE voters SET VotingStatus=2 WHERE vid='$vid'";
			if(mysqli_query($conn,$sql)){
				$response["msg"]="Voting Successfully Completed";
				$response["code"]="CONTINUE_VOTING_FINISH";
			}
			else{
				$response["msg"]="Unable to Continue Voting";
				$response["code"]="CONTINUE_VOTING_ERR_2";
			}
		}
	}
	else{
		$response["msg"]="Unable to Cast Vote";
		$response["code"]="CONTINUE_VOTING_ERR_1";
	}
}
echo json_encode($response);
?>