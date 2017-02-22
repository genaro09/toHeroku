<?php
include '../php/funciones.php';
if($_POST['id']){
	$year=$_POST['id'];
	for ($i = 1; $i <= 52; $i++) {
        $j=$i;
        if($i<10){
            $j='0'.$i;
        };
        echo "<option value='".$i."'";
        if ($i == date('W')) {
        	echo "selected='selected' >";
        }else echo ">";
        $valor="Semana ".$i."  Lunes:".date('Y-m-d', strtotime($year.'W'.$j.'-'.'1'))."-Domingo:".date('Y-m-d', strtotime($year.'W'.$j.'-'.'7'))."";
        echo $valor."</option>";
    }
}

?>
