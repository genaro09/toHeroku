<?php
    session_start();
    //echo $_SESSION['usuario_sesion']." te esperamos pronto...";
    echo "Cerrando sesion...";
    session_unset();
    session_destroy();
    header("refresh:3;../index.php");
?>