<?php if(isset($_COOKIE["admin"])){if(verify_admin_login()){header("location:index.php");}} ?>
<!DOCTYPE html>
<html lang="en" style="height: 100%">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GWH | Admin Panel</title>
    <!-- PACE-->
    <link rel="stylesheet" type="text/css" href="plugins/PACE/themes/blue/pace-theme-flash.css">
    <script type="text/javascript" src="plugins/PACE/pace.min.js"></script>
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" type="text/css" href="plugins/bootstrap/dist/css/bootstrap.min.css">
    <!-- Fonts-->
    <link rel="stylesheet" type="text/css" href="plugins/themify-icons/themify-icons.css">
    <!-- Toastr-->
    <link rel="stylesheet" type="text/css" href="plugins/toastr/toastr.min.css">
    <!-- SpinKit-->
    <link rel="stylesheet" type="text/css" href="plugins/SpinKit/css/spinkit.css">
    <!-- Primary Style-->
    <link rel="stylesheet" type="text/css" href="build/css/third-layout.css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries-->
    <!-- WARNING: Respond.js doesn't work if you view the page via file://--> 
    <!--[if lt IE 9]>
    <script type="text/javascript" src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script type="text/javascript" src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body style="background-image: url(build/images/backgrounds/24.jpg)" class="body-bg-full v2">
	<!-- Preloader -->
	<div class="mypreloader"><div class="sk-cube-grid"><div class="sk-cube sk-cube1"></div><div class="sk-cube sk-cube2"></div><div class="sk-cube sk-cube3"></div><div class="sk-cube sk-cube4"></div><div class="sk-cube sk-cube5"></div><div class="sk-cube sk-cube6"></div><div class="sk-cube sk-cube7"></div><div class="sk-cube sk-cube8"></div><div class="sk-cube sk-cube9"></div></div></div>
    <div class="container page-container">
      <div class="page-content">
        <div class="v2">
          <div class="logo"><img src="build/images/logo/logo-sm-dark.png" alt="" width="80"></div>
          <form method="POST" action="#" class="form-horizontal" id="login">
            <div class="form-group">
              <div class="col-xs-12">
                <input type="text" placeholder="Username" class="form-control" id="username" autofocus="autofocus">
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-12">
                <input type="password" placeholder="Password" class="form-control" id="password">
              </div>
            </div>
            <button type="submit" class="btn-lg btn btn-primary btn-rounded btn-block">Sign in</button>
          </form>
        </div>
      </div>
    </div>
    <!-- jQuery-->
    <script type="text/javascript" src="plugins/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap JavaScript-->
    <script type="text/javascript" src="plugins/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Toastr-->
    <script type="text/javascript" src="plugins/toastr/toastr.min.js"></script>
	<script type="text/javascript">
	$(document).ready(function(){
		$("#login").submit(function(){
			var username=$("#username").val();
			var password=$("#password").val();
			var remember="no";
			$(".mypreloader").fadeIn();
			if($("#remember").is(":checked")){remember="yes";}
			if(username.length<3){
				$("#username").focus();
				$(".mypreloader").fadeOut();
				toastr["warning"]("Please enter a <strong>valid username</strong>","Invalid Username");
			}
			else if(!username.match(/^[0-9a-z]+$/)){
				$("#username").focus();
				$(".mypreloader").fadeOut();
				toastr["warning"]("Please enter a <strong>valid username</strong>","Invalid Username");
			}
			else if(password.length<3){
				$("#password").focus();
				$(".mypreloader").fadeOut();
				toastr["warning"]("Please enter a <strong>valid password</strong>","Invalid Password");
			}
			else{
				$.ajax({
					url:"verify.php",
					type:"POST",
					data:{"login":true,"username":username,"password":password,"remember":remember},
					success:function(response){
						try{
							var resp=JSON.parse(response);
							if(resp.code=="LOGIN_SUC"){
								window.location="index.php";
							}
							else if(resp.code=="LOGIN_ERR_1"){
								$("#username").focus();
								$(".mypreloader").fadeOut();
								toastr["error"]("Please enter a <strong>valid username</strong>","Invalid Username");
							}
							else if(resp.code=="LOGIN_ERR_2"){
								$("#username").focus();
								$(".mypreloader").fadeOut();
								toastr["error"]("Please enter a <strong>valid username/password</strong>", "Invalid Username/Password");
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
	});
	</script>
  </body>
</html>