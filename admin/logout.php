<?php
setcookie("hash","",time()-3600);
setcookie("admin","",time()-3600);
header("location: login.php");
?>