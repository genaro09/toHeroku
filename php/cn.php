<?php
function NameDataBase(){
  $myDB="ascas";
  return $myDB;
}
function cnx(){
    $host="localhost";
    $dbUser="root";
    $dbPass="";
    $myDB="ascas";
    $cnx=mysqli_connect($host,$dbUser,$dbPass,$myDB);
    return $cnx;
}

function pruebaCnx(){
    $host="localhost";
    $dbUser="root";
    $dbPass="";
    $myDB="ascas";
    $cnx=mysqli_connect($host,$dbUser,$dbPass,$myDB);
    $flag=0;
    if (mysqli_connect_errno()) {
        $flag=0;
    }

    if (mysqli_ping($cnx)) {
        $flag=1;
    } else {
        $flag=0;
    }
    mysqli_close($cnx);
    return $flag;
}

?>
<?php
/*function cnx(){
    $url = parse_url(getenv("mysql://b8f8f6119ca584:d8a28425@us-cdbr-iron-east-04.cleardb.net/heroku_6ac98248592533a?reconnect=true"));
    $host="us-cdbr-iron-east-04.cleardb.net";
    $dbUser="b8f8f6119ca584";
    $dbPass="d8a28425";
    $myDB="heroku_6ac98248592533a";
    $cnx=mysqli_connect($host,$dbUser,$dbPass,$myDB);
    return $cnx;
}

function pruebaCnx(){
    $url = parse_url(getenv("mysql://b8f8f6119ca584:d8a28425@us-cdbr-iron-east-04.cleardb.net/heroku_6ac98248592533a?reconnect=true"));
    $host="us-cdbr-iron-east-04.cleardb.net";
    $dbUser="b8f8f6119ca584";
    $dbPass="d8a28425";
    $myDB="heroku_6ac98248592533a";
    $cnx=mysqli_connect($host,$dbUser,$dbPass,$myDB);
    $flag=0;
    if (mysqli_connect_errno()) {
        $flag=0;
    }

    if (mysqli_ping($cnx)) {
        $flag=1;
    } else {
        $flag=0;
    }


    mysqli_close($cnx);
    return $flag;
}
*/
?>
