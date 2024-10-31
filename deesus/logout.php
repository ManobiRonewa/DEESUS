<?php 
session_start();
session_destroy();
session_start();
echo "<script>	window.location.href='login';</script>";
?>