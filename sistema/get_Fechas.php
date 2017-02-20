<?php
include '../php/funciones.php';
include '../php/verificar_sesion.php';
$cnx=cnx();
if($_POST['id']){
    $idTurno=$_POST['id'];
    $NitEmpresa=getNitEmpresa($_SESSION['usuario_sesion']);
    $annio=$_POST['anio'];
    $semana=$_POST['semana'];
    echo "
    <div class='header'>
        <h4 class='title'>Turno: ".$idTurno."  Semana:".$semana."  Año: ".$annio."</h4>
    </div>
    ";
    $queryP=sprintf("SELECT * FROM htrabajo where idTurno='%s' ",mysqli_real_escape_string($cnx,$idTurno));
    $resultP=mysqli_query($cnx,$queryP);
    $rowP=mysqli_fetch_array($resultP);
    if($rowP[0]!=""){
        if(ExisteSP($semana,$annio,$NitEmpresa,$idTurno)){
            $query=sprintf("SELECT * FROM semanal where NitEmpresa='%s' and nSemana='%s' and anno='%s' and idTurno='%s' ",mysqli_real_escape_string($cnx,$NitEmpresa),mysqli_real_escape_string($cnx,$semana),mysqli_real_escape_string($cnx,$annio),mysqli_real_escape_string($cnx,$idTurno));
            $result=mysqli_query($cnx,$query);
            $row=mysqli_fetch_array($result);
            $query2=sprintf("SELECT * FROM col_semanal where idSemanal='%s' ",mysqli_real_escape_string($cnx,$row["idSemanal"]));
            $result2=mysqli_query($cnx,$query2);
            $row2=mysqli_fetch_array($result2);
        }else{
            $result=InsertarSemanal($semana,$annio,$NitEmpresa,$idTurno);
            if($result){
                echo "SE CREO";
            }else   echo "ERROR EN BASE";
        }
        $query=sprintf("SELECT * FROM semanal where NitEmpresa='%s' and nSemana='%s' and anno='%s' and idTurno='%s' ",mysqli_real_escape_string($cnx,$NitEmpresa),mysqli_real_escape_string($cnx,$semana),mysqli_real_escape_string($cnx,$annio),mysqli_real_escape_string($cnx,$idTurno));
        $result=mysqli_query($cnx,$query);
        $row=mysqli_fetch_array($result);
        $query2=sprintf("SELECT * FROM col_semanal where idSemanal='%s' ",mysqli_real_escape_string($cnx,$row["idSemanal"]));
        $result2=mysqli_query($cnx,$query2);
        $row2=mysqli_fetch_array($result2);
        echo "<div class='row'>";
        //Datos necesario
        echo "
            <input id='idTurno' style='hidden' class='hidden' value =".$idTurno.">
            <input id='semana' style='hidden' class='hidden' value =".$semana.">
            <input id='annio' style='hidden' class='hidden' value =".$annio.">
            <input id='NitEmpresa' style='hidden' class='hidden' value =".$NitEmpresa.">
            <input id='idSemanal' style='hidden' class='hidden' value =".$row["idSemanal"].">
        ";
        echo "<div class='col-md-4'>";
        echo "<label for='exampleInputEmail1'>Lunes</label> <br>";
        echo "<select id='SLunes' name='SLunes' class='selectpicker'>";
        if($row2["Lunes"]==1){
            echo "<option selected value='1'>Jornada Completa</option>";
        }   else  echo "<option value='1'>Jornada Completa</option>";
        if($row2["Lunes"]==2){
            echo "<option selected value='2'>Media Jornada</option>";
        }   else  echo "<option value='2'>Media Jornada</option>";
        if($row2["Lunes"]==3){
            echo "<option selected value='3'>Descanso</option>";
        }   else  echo "<option value='3'>Descanso</option>";
        echo "</select>";
        echo "</div>";

        echo "<div class='col-md-4'>";
        echo "<label for='exampleInputEmail1'>Martes</label> <br>";
        echo "<select id='SMartes' name='SMartes' class='selectpicker'>";
            if($row2["Martes"]==1){
                echo "<option selected value='1'>Jornada Completa</option>";
            }   else  echo "<option value='1'>Jornada Completa</option>";
            if($row2["Martes"]==2){
                echo "<option selected value='2'>Media Jornada</option>";
            }   else  echo "<option value='2'>Media Jornada</option>";
            if($row2["Martes"]==3){
                echo "<option selected value='3'>Descanso</option>";
            }   else  echo "<option value='3'>Descanso</option>";
        echo "</select>";
        echo "</div>";

        echo "<div class='col-md-4'>";
        echo "<label for='exampleInputEmail1'>Miercoles</label> <br>";
        echo "<select id='SMiercoles' name='SMiercoles' class='selectpicker'>";
            if($row2["Miercoles"]==1){
                echo "<option selected value='1'>Jornada Completa</option>";
            }   else  echo "<option value='1'>Jornada Completa</option>";
            if($row2["Miercoles"]==2){
                echo "<option selected value='2'>Media Jornada</option>";
            }   else  echo "<option value='2'>Media Jornada</option>";
            if($row2["Miercoles"]==3){
                echo "<option selected value='3'>Descanso</option>";
            }   else  echo "<option value='3'>Descanso</option>";
        echo "</select>";
        echo "</div>";

        echo "<div class='col-md-4'>";
        echo "<label for='exampleInputEmail1'>Jueves</label> <br>";
        echo "<select id='SJueves' name='SJueves' class='selectpicker'>";
            if($row2["Jueves"]==1){
                echo "<option selected value='1'>Jornada Completa</option>";
            }   else  echo "<option value='1'>Jornada Completa</option>";
            if($row2["Jueves"]==2){
                echo "<option selected value='2'>Media Jornada</option>";
            }   else  echo "<option value='2'>Media Jornada</option>";
            if($row2["Jueves"]==3){
                echo "<option selected value='3'>Descanso</option>";
            }   else  echo "<option value='3'>Descanso</option>";
        echo "</select>";
        echo "</div>";

        echo "<div class='col-md-4'>";
        echo "<label for='exampleInputEmail1'>Viernes</label> <br>";
        echo "<select id='SViernes' name='SViernes' class='selectpicker'>";
            if($row2["Viernes"]==1){
                echo "<option selected value='1'>Jornada Completa</option>";
            }   else  echo "<option value='1'>Jornada Completa</option>";
            if($row2["Viernes"]==2){
                echo "<option selected value='2'>Media Jornada</option>";
            }   else  echo "<option value='2'>Media Jornada</option>";
            if($row2["Viernes"]==3){
                echo "<option selected value='3'>Descanso</option>";
            }   else  echo "<option value='3'>Descanso</option>";
        echo "</select>";
        echo "</div>";

        echo "<div class='col-md-4'>";
        echo "<label for='exampleInputEmail1'>Sabado</label> <br>";
        echo "<select id='SSabado' name='SSabado' class='selectpicker'>";
            if($row2["Sabado"]==1){
                echo "<option selected value='1'>Jornada Completa</option>";
            }   else  echo "<option value='1'>Jornada Completa</option>";
            if($row2["Sabado"]==2){
                echo "<option selected value='2'>Media Jornada</option>";
            }   else  echo "<option value='2'>Media Jornada</option>";
            if($row2["Sabado"]==3){
                echo "<option selected value='3'>Descanso</option>";
            }   else  echo "<option value='3'>Descanso</option>";
        echo "</select>";
        echo "</div>";

        echo "<div class='col-md-4'>";
        echo "<label for='exampleInputEmail1'>Domingo</label> <br>";
        echo "<select id='SDomingo' name='SDomingo' class='selectpicker'>";
            if($row2["Domingo"]==1){
                echo "<option selected value='1'>Jornada Completa</option>";
            }   else  echo "<option value='1'>Jornada Completa</option>";
            if($row2["Domingo"]==2){
                echo "<option selected value='2'>Media Jornada</option>";
            }   else  echo "<option value='2'>Media Jornada</option>";
            if($row2["Domingo"]==3){
                echo "<option selected value='3'>Descanso</option>";
            }   else  echo "<option value='3'>Descanso</option>";
        echo "</select>";
        echo "</div>
            </div>
            <br>
            <div class='row'>
        ";
        if(ExisteSP($semana-1,$annio,$NitEmpresa,$idTurno)){
            echo "
                <div class='col-md-4'>
                <a href='#' id='btnAnteriorSemana' class='btn btn-fill btn-primary btn-wd'>Guardar con formato pasado</a>
                </div>
            ";
        }
        echo "
                <div class='col-md-4'>
                <a href='#' id='btnGuardarSemana' class='btn btn-info btn-fill pull-right'>Guardar Modificacion</a>
                </div>
        ";

        echo "</div>";
        echo "<div calss='row'>";
        echo "
                <div class='text-center' id='respuestaAlert'></div>
                <div class='clearfix'></div>
        ";
        echo "</div>";

    }else echo "Se necesita al menos un empleado en el Turno";

}

?>
    <!-- Main js -->
    <script src="../js/main.js"></script>
