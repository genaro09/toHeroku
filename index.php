<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title>ASCAS, S.A. DE C.V.</title>
    <!-- Bootstrap Core CSS -->
    <link href="./bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="./css/customCSS.css" rel="stylesheet">
    <!--  Light Bootstrap Dashboard core CSS    -->
    <link href="./css/light-bootstrap-dashboard.css" rel="stylesheet" />
    <!--  Material Dashboard CSS  -->
    <link href="./css/material-dashboard.css" rel="stylesheet"/>

    <!-- Custom Fonts -->
    <link href="./bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
</head>
<body class="full">

            <div class="col-md-4 col-md-offset-4">
                <div style="background-color:#FFF;padding-right:10px;padding-left:10px;padding-top:0.1px; background: rgba(228, 224, 245, 0.73  );">
                        <form role="form">
                        <!--   if you want to have the card without animation please remove the ".card-hidden" class   -->
                                <div class="header text-center"><h3>Iniciar Sesion
                                    <?php
                            include 'php/funciones.php';
                            $flag=estadoCnx();
                            if($flag)
                                    echo '<span class="label label-success">*</span>';
                                else
                                    echo '<span class="label label-danger">*</span>';
                            ?>


                                </h3></div>
                                <div class="content">
                                    <div class="form-group">
                                        <h6><strong>Documento unico de identidad</strong></h6>
                                        <input  type="text" id="DUI" placeholder="123569842" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <h6><strong>Contraseña</strong></h6>
                                        <input type="password" id="password" placeholder="Contraseña" class="form-control">
                                    </div>
                                </div>
                                <div class="text-center">
                                    <a href="#" id="btnLogin" class="btn btn-fill btn-primary btn-wd">Login</a>

                                </div>
                                <div class="text-center" id="respuestaAlert"></div>
																<br>      
                        </form>

                    </div>
                </div>

</body>
    <!--   Core JS Files   -->
    <script src="./js/jquery-3.1.1.min.js" type="text/javascript"></script>
    <script src="./js/jquery-ui.min.js" type="text/javascript"></script>
    <script src="./js/bootstrap.min.js" type="text/javascript"></script>
    <script src="./js/material.min.js" type="text/javascript"></script>
    <script src="./js/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>
    <!-- Forms Validations Plugin -->
    <script src="./js/jquery.validate.min.js"></script>
    <!-- Material Dashboard javascript methods -->
    <script src="./js/material-dashboard.js"></script>
    <!-- Main js -->
    <script src="./js/main.js"></script>

</html>
