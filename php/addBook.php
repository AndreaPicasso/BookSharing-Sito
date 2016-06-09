<?php
require_once("privateSessionControl.php");
require_once("parameters.php");

if(isset($_GET['isbn'],$_GET['lat'],$_GET['lon'])){
    $isbn=$_GET['isbn'];
    $lat = $_GET['lat'];
    $lon = $_GET['lon'];
    $email = $_SESSION['email'];
    $con = mysqli_connect(SERVER,USER,PSW);
    mysqli_select_db($con,DB);
    
    $isbn = mysqli_real_escape_string($con,$isbn);
    $lat = mysqli_real_escape_string($con,$lat);
    $lon = mysqli_real_escape_string($con,$lon);
    
    $query = 'INSERT INTO librocondiviso
            (isbn,proprietario,latitudine,longitudine,datacondivisione)
            VALUES
            ("'.$isbn.'","'.$email.'",'.$lat.','.$lon.',FROM_UNIXTIME('.time().'));';
    $res = mysqli_query($con,$query);
    if(!$res){
        echo 'Impossibile aggiungere libro, forse lo hai già inserito?';
    }
    else
    {
        echo 'Libro inserito!';
    }
}
?>