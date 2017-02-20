<?php 
	include 'funciones.php';
	$user=$_POST["user"];
	$pass=$_POST["password"];
	if(isUserExist($user)){
		if(isLoginOk($user,$pass)){
			//usuario
			$usuario=new empleado_class();
			$usuario=getInfoUser($user);
			//var_dump($usuario);
			session_start();
			$_SESSION["usuario_sesion"]=$usuario;

			echo "2";
		}else{
			echo "1";
		}
	}else{
		echo "0";
	}
?>