<html>
<head>
  <script src="../dist/sweetalert.js"></script>
  <link rel="stylesheet" href="../dist/sweetalert.css">
</head>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ini_set('max_execution_time', 300);
require '../upload/phpmussel/loader.php';
include '../php/funciones.php';
include '../php/verificar_sesion.php';
//ver si es un codigo correcto y de donde viene el codigo
if(isset($_POST["idupload"])){
  $cod=$_POST["idupload"];
  $cod=explode("%", $cod);
  if($cod[0]==1){
    //Part 1 is 1=idIncapacidad
    if(isIncapExist($cod[1])){
      define("UPLOAD_DIR", "../upload/Incapacidades/");
    }else{
      header("Location: menu.php");
      die();
    }
  }elseif ($cod[0]==2) {
    //Part 2 is 1=idAusencia
    if(isAusenExist($cod[1])){
      define("UPLOAD_DIR", "../upload/Ausencias/");
    }else{
      header("Location: menu.php");
      die();
    }
    # code...
  }else{
    header("Location: menu.php");
    die();
  }
}else{
  //menu.php
  header("Location: menu.php");
  die();
}
//Fin del cod


$flag=1;
if (!empty($_FILES["myFile"])) {
    $myFile = $_FILES["myFile"];

    if ($myFile["error"] !== UPLOAD_ERR_OK) {
        echo "<p>An error occurred.</p>";
        exit;
    }

    // ensure a safe filename
    $name = preg_replace("/[^A-Z0-9._-]/i", "_", $myFile["name"]);
    // verify the file is a GIF, JPEG, or PNG
    $fileType = exif_imagetype($_FILES["myFile"]["tmp_name"]);
    $allowed = array(IMAGETYPE_JPEG, IMAGETYPE_PNG);
    if (!in_array($fileType, $allowed)) {
      $flag=0;
    }
    if ($flag==0) {
      $finfo = finfo_open(FILEINFO_MIME_TYPE);
      $mime = finfo_file($finfo, $_FILES['myFile']['tmp_name']);
      switch ($mime) {
         case 'application/pdf':
          $flag=1;
         break;
         default:
          $flag=0;
          break;
      }
    }




    $source_file = $_FILES["myFile"]["name"];
    $nombreAux= uniqid().rand(100,100000);
    $filename  = basename($_FILES["myFile"]["name"]);
    $extension = pathinfo($filename, PATHINFO_EXTENSION);
    $new       = $nombreAux.'.'.$extension;



    // don't overwrite an existing file
    $i = 0;
    $name=$new;
    $parts = pathinfo($name);
    while (file_exists(UPLOAD_DIR . $name)) {
        $i++;
        $name = $parts["filename"] . "-" . $i . "." . $parts["extension"];
    }

    // preserve file from temporary directory
    $success = move_uploaded_file($myFile["tmp_name"],
        UPLOAD_DIR . $name);
    if (!$success) {
        echo "<p>Unable to save file.</p>";
        exit;
    }

    // set proper permissions on the new file
    chmod(UPLOAD_DIR . $name, 0644);
    if($flag==1){
      if($cod[0]==1){
        insertarDocumentoIncapacidades($cod[1],$name,$extension);
        echo '
          <form action="Descuentos.php" id="loginForm" name="loginForm" method="post">
            <input type="hidden" id="isUpload" name="isUpload" value="'.$flag.'">
          </form>
        ';

        echo '
          <script>
            window.onload = function() {
              document.getElementById("loginForm").submit();
            };
          </script>
          ';

      }elseif ($cod[0]==2) {
        insertarDocumentoAusencia($cod[1],$name,$extension);
        echo '
          <form action="Descuentos.php" id="loginForm" name="loginForm" method="post">
            <input type="hidden" id="isUpload" name="isUpload" value="'.$flag.'">
          </form>
        ';

        echo '
          <script>
            window.onload = function() {
              document.getElementById("loginForm").submit();
            };
          </script>
          ';
      }
    }

}
?>
</html>
