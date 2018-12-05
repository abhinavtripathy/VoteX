<?php
unset($_COOKIE["vid"]);
unset($_COOKIE["hash"]);
setcookie("vid", "", time() - 3600);
setcookie("hash", "", time() - 3600);
header("location:login");
?>