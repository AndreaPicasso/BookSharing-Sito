<?php
    require_once("privateSessionControl.php");
    require_once("parameters.php");
    if(!isset($_POST['isbn'],$_POST['proprietario'])){
           header("Location: ../home.php"); 
        }
    $con = mysqli_connect(SERVER,USER,PSW);
    mysqli_select_db($con,DB);
    $propr = mysqli_real_escape_string($con,$_POST["proprietario"]);
    $tit = mysqli_real_escape_string($con,$_POST["titolo"]);
    $isbn = mysqli_real_escape_string($con,$_POST["isbn"]);
    $text = "Ciao ".$propr."!<br> Mi piacerebbe prendere in prestito il tuo libro ".$tit;
    $query = "INSERT INTO message (datames,mittente,destinatario,testo)
    VALUES (FROM_UNIXTIME(".time()."),'".$_SESSION['email']."','".$propr."','".$text."');";
    $res1 = mysqli_query($con,$query);
    
    $query = "INSERT INTO prestiti (dataprestito,richiedente,proprietario,isbn,stato)
    VALUES (FROM_UNIXTIME(".time()."),'".$_SESSION['email']."','".$propr."','".$isbn."','nonconfermato');";
    $res2 = mysqli_query($con,$query);
    if($res1 && $res2){
        require_once("email.php");
        sendMail($propr,"Richiesta Libro", $text);
        echo "Ok";
    }
    else{
        echo "C'è stato un problema nella richiesta.";
    }
?>