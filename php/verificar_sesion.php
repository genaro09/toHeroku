<?php
	session_start();
	if(!isset($_SESSION["usuario_sesion"])){
		header("location:../index.php");
		exit();
	}
 ?>
