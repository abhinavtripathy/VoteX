<?php
if(isset($_COOKIE["vid"])){
	header("location:welcome");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login | GWH</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="assets/css/preloader.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
	<link rel="stylesheet" href="assets/css/login.css">
	<link rel="stylesheet" href="assets/plugins/pnotify/pnotify.custom.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>
</head>
<body>
	<div class="preloader-wrapper"><span class="preloader"></span></div>
	<div class="wrapper">
		<form class="login">
			<p class="title">Welcome</p>
			<input type="email" id="SchoolEmail" placeholder="School Email Address" autofocus required/>
			<i class="fa fa-envelope"></i>
			<button>
				<span class="state">Proceed</span>
			</button>
		</form>
	</div>
	<script src="assets/plugins/jquery/jquery-3.2.1.min.js"></script>
	<script src="assets/plugins/pnotify/pnotify.custom.min.js"></script>
	<script>
	$(window).on("load",function(){
		$(".preloader-wrapper").fadeOut();
	});
	</script>
	<script>
	$(document).ready(function(){
		function isEmail(email) {
			return /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))$/i.test(email);
		}
		$('.login').on('submit', function(e) {
			e.preventDefault();
			$(".preloader-wrapper").fadeIn();
			var SchoolEmail=$("#SchoolEmail").removeClass("invalid").val();
			if(!isEmail(SchoolEmail)){
				$("#SchoolEmail").addClass("invalid").focus();
				$(".preloader-wrapper").fadeOut();
				new PNotify({title: "Invalid School Email",text: "Please Enter a Valid School Email Address!",type:'error'});
			}
			else{
				$.ajax({
					url:"verify",
					type:"POST",
					data:{"login":true,"SchoolEmail":SchoolEmail},
					success:function(response){
						console.log(response);
						try{
							var resp=JSON.parse(response);
							if(resp.code=="LOGIN_VERIFY"){
								window.location=resp.loc;
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
		});
	});
	</script>
</body>
</html>