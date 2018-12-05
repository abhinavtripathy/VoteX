<?php
if(!isset($_COOKIE["vid"])){
	header("location:login");
}
include("admin/includes/config.php");
include("admin/includes/functions.php");
try{
	$vid=intval(safe_decrypt($_COOKIE["vid"],$_COOKIE["hash"]));
	$sql="SELECT * FROM voters WHERE vid='$vid'";
	$result=$conn->query($sql);
	if($result->num_rows==0){
		header("location:logout");
	}
	else{
		while($row=$result->fetch_assoc()){
			$VerificationStatus=$row["VerificationStatus"];
			if($VerificationStatus=="0"){
				header("location:verification?email=".$row["SchoolEmail"]);
			}
			$VotingStatus=$row["VotingStatus"];
			$VotingLastPID=$row["VotingLastPID"];
		}
	}
	if($VotingStatus==1){
		$sql="SELECT * FROM posts WHERE pid>'$VotingLastPID' ORDER BY pid ASC LIMIT 1";
		$result=$conn->query($sql);
		if($result->num_rows>0){
			while($row=$result->fetch_assoc()){
				$pid=$row["pid"];
				$post=$row["post"];
				//$carouselindicators='<li data-target="#VotingCarousel" data-slide-to="0" class="active"></li>';
				//$indicator=0;
				$carouselinner='<div class="row">';
				$candidates_count=0;
				$sql2="SELECT * FROM candidates WHERE CandidatePost='$pid'";
				$result2=$conn->query($sql2);
				if($result2->num_rows>0){
					while($row2=$result2->fetch_assoc()){
						$carouselinner.='<div class="col-md-4 candidate"><div class="img-container votex_tap" id="CandidateImgContainer_'.$row2["cid"].'"><img src="uploads/'.$row2["CandidatePhoto"].'" class="candidate-img"><div class="img-overlay" id="CandidateImgOverlay_'.$row2["cid"].'"><div class="text">Vote</div></div></div><h3 class="votex_tap" id="CandidateName_'.$row2["cid"].'">'.$row2["CandidateName"].'</h3></div>';
						$candidates_count+=1;
					}
				}
				$carouselinner.='</div>';
			}
		}
		else{
			$sql="UPDATE voters SET VotingStatus=2 WHERE vid='$vid'";
			if(mysqli_query($conn,$sql)){
				$VotingStatus=2;
			}
			else{
				die("Database Connection Error");
			}
		}
	}
}
catch(Exception $e){
	header("location:logout");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Welcome to GWH Student Council Election | GWH</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="assets/css/preloader.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	<link href="https://fonts.googleapis.com/css?family=Alfa+Slab+One|Kranky|Permanent+Marker|Quicksand|Raleway" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
	<link rel="stylesheet" href="assets/plugins/jcider/jcider.css">
	<link rel="stylesheet" href="assets/css/main.css?v=1.<?php echo time();?>">
	<link rel="stylesheet" href="assets/plugins/pnotify/pnotify.custom.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>
</head>
<body>
	<div class="preloader-wrapper"><span class="preloader"></span></div>
	<a href="logout" class="logout">LOGOUT <i class="fa fa-power-off"></i></a>
	<div class="container" style="width:100%">
		<div class="row <?php if($VotingStatus!=0){echo 'hidden-xs-up';} ?>" id="welcome">
			<div class="col-md-8 offset-md-2 mt-5 pt-5 text-center">
					<h1>Welcome to GWH Student Council Election</h1>
					<h2 class="mb-5">Shape Tommorow By Voting Today</h2>
					<button class="btn btn-success btn-lg mt-5" id="start"><i class="fa fa-check-square-o"></i> Start</button>
			</div>
		</div>
		<div class="row <?php if($VotingStatus!=1){echo 'hidden-xs-up';} ?>" id="VotingCarouselDiv">
			
			<input type="hidden" id="VotingPID" value="<?php if($VotingStatus==1){echo $pid;}else{echo '0';} ?>">
			<div class="col-md-12">
				<h1 id="page-title"><?php if($VotingStatus==1){echo $post;} ?></h1>
			</div>
			<div class="col-md-12">
				<div id="VotingCarousel">
				  <div id="carouselinner">
					<?php if($VotingStatus==1){echo $carouselinner;} ?>
				  </div>
				</div>
			</div>
			<div class="col-md-12 text-center">
				<button class="btn btn-warning btn-lg" id="proceed">Proceed</button>
			</div>
		</div>
		<div class="row <?php if($VotingStatus!=2){echo 'hidden-xs-up';} ?>" id="thankyou">
			<div class="col-md-8 offset-md-2 mt-5 pt-5 text-center">
					<h1>Thank You</h1>
					<h2 class="mt-5 pt-5">Your votes have been successfully casted. Please logout and hope for your favorite candidate(s) to win!</h2>
			</div>
		</div>
	</div>
	<script src="assets/plugins/jquery/jquery-3.2.1.min.js"></script>
	<script src="assets/plugins/pnotify/pnotify.custom.min.js"></script>
	<script src="assets/plugins/jcider/jcider.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
	<script>
	$(window).on("load",function(){
		$(".preloader-wrapper").fadeOut();
	});
	$(document).ready(function(){
		$.fn.imagesLoaded = function () {
			// Usage: $('#sample').html(resp.data).imagesLoaded().then(function(){ ... });
			var $imgs = this.find('img[src!=""]');
			if (!$imgs.length) {return $.Deferred().resolve().promise();}
			var dfds = [];  
			$imgs.each(function(){
				var dfd = $.Deferred();
				dfds.push(dfd);
				var img = new Image();
				img.onload = function(){dfd.resolve();}
				img.onerror = function(){dfd.resolve();}
				img.src = this.src;
			});
			return $.when.apply($,dfds);
		}
		$("#start").click(function(){
			$(".preloader-wrapper").fadeIn();
			$.ajax({
				url:"verify",
				type:"POST",
				data:{"start_voting":true},
				success:function(response){
					console.log(response);
					try{
						var resp=JSON.parse(response);
						if(resp.code=="START_VOTING_SUC"){
							$("#welcome").fadeOut();
							$("#VotingCarouselDiv").removeClass("hidden-xs-up");
							$("#VotingPID").val(resp.pid);
							$("#page-title").html(resp.post);
							var candidates=JSON.parse(resp.candidates);
							//var carouselindicators='<li data-target="#VotingCarousel" data-slide-to="0" class="active"></li>';
							var indicator=0;
							var carouselinner='<div class="row">';
							var candidates_count=0;
							for(var cid in candidates){
								var cds=JSON.parse(candidates[cid]);
								carouselinner+='<div class="col-md-4 candidate"><div class="img-container votex_tap" id="CandidateImgContainer_'+cid+'"><img src="'+cds.CandidatePhoto+'" class="candidate-img"><div class="img-overlay" id="CandidateImgOverlay_'+cid+'"><div class="text">Vote</div></div></div><h3 class="votex_tap" id="CandidateName_'+cid+'">'+cds.CandidateName+'</h3></div>';
								candidates_count++;
							}
							carouselinner+='</div>';
							//$("#carouselindicators").html(carouselindicators);
							$("#carouselinner").html(carouselinner).imagesLoaded().then(function(){
								$(".preloader-wrapper").fadeOut();
							});
						}
						else{
							$(".preloader-wrapper").fadeOut();
							new PNotify({title: resp.msg,text: "Response Code: <strong>"+resp.code+"</strong>",type:'error'});
						}
					}
					catch(err){
						$(".preloader-wrapper").fadeOut();
						new PNotify({title: "Unknown Error Occured",text: err,type:'error'});
					}
					
				},
				error:function(response){
					$(".preloader-wrapper").fadeOut();
					new PNotify({title: "Connection Failed",text: "Please Check Your Internet Connection And Try Again!",type:'error'});
				}
			});
		});
		$("body").on("click",".votex_tap",function(){
			var cid=this.id.split("_")[1];
			$(".img-overlay").each(function(){$(this).html('<div class="text">Vote</div>');});
			$(".votex_selected").removeClass("votex_selected");
			$("#CandidateImgContainer_"+cid).addClass("votex_selected");
			$("#CandidateImgOverlay_"+cid).html('<img src="assets/img/voted.png" width="150" height="150">');
		});
		$("body").on("click","#proceed",function(){
			if($(".votex_selected").length>0){
				$(".preloader-wrapper").fadeIn();
				var pid=$("#VotingPID").val();
				var cid=0;
				$(".votex_selected").each(function(){
					cid=this.id.split("_")[1];
				});
				$.ajax({
					url:"verify",
					type:"POST",
					data:{"continue_voting":true,"pid":pid,"cid":cid},
					success:function(response){
						console.log(response);
						try{
							var resp=JSON.parse(response);
							if(resp.code=="CONTINUE_VOTING_SUC"){
								$("#VotingPID").val(resp.pid);
								$("#page-title").html(resp.post);
								var candidates=JSON.parse(resp.candidates);
								//var carouselindicators='<li data-target="#VotingCarousel" data-slide-to="0" class="active"></li>';
								//var indicator=0;
								var carouselinner='<div class="row">';
								var candidates_count=0;
								for(var cid in candidates){
									var cds=JSON.parse(candidates[cid]);
									carouselinner+='<div class="col-md-4 candidate"><div class="img-container votex_tap" id="CandidateImgContainer_'+cid+'"><img src="'+cds.CandidatePhoto+'" class="candidate-img"><div class="img-overlay" id="CandidateImgOverlay_'+cid+'"><div class="text">Vote</div></div></div><h3 class="votex_tap" id="CandidateName_'+cid+'">'+cds.CandidateName+'</h3></div>';
									candidates_count++;
								}
								carouselinner+='</div>';
								//$("#carouselindicators").html(carouselindicators);
								$("#carouselinner").html(carouselinner).imagesLoaded().then(function(){
									$(".preloader-wrapper").fadeOut();
								});
							}
							else if(resp.code=="CONTINUE_VOTING_FINISH"){
								$("#VotingCarouselDiv").addClass("hidden-xs-up");
								$("#thankyou").removeClass("hidden-xs-up");
								$(".preloader-wrapper").fadeOut();
							}
							else{
								$(".preloader-wrapper").fadeOut();
								new PNotify({title: resp.msg,text: "Response Code: <strong>"+resp.code+"</strong>",type:'error'});
							}
						}
						catch(err){
							$(".preloader-wrapper").fadeOut();
							new PNotify({title: "Unknown Error Occured",text: err,type:'error'});
						}
						
					},
					error:function(response){
						$(".preloader-wrapper").fadeOut();
						new PNotify({title: "Connection Failed",text: "Please Check Your Internet Connection And Try Again!",type:'error'});
					}
				});
			}
			else{
				new PNotify({title: "No Candidate Selected",text: "Please Select A Candidate And Try Again!",type:'error'});
			}
		});
	});
	</script>
</body>
</html>