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
			$empresa=new empresa_class();
			$empresa=getInfoEmpresa(getNitEmpresa($usuario));
			if($empresa->getTipoempresa()==2){
				echo "3";
			}
			session_start();
			$_SESSION["usuario_sesion"]=$usuario;
			$_SESSION["empresa"]=getNitEmpresa($usuario);
			echo "2";
		}else{
			echo "1";
		}
	}else{
		echo "0";
	}
?>
