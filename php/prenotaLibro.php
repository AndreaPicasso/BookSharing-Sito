<?php
    require_once("privateSessionControl.php");
    require_once("parameters.php");
    if(!isset($_POST['isbn'],$_POST['proprietario'])){
           header("Location: ../home.php"); 
        }
    $con = mysqli_connect(SERVER,USER,PSW);
    mysqli_select_db($con,DB);
    $query = "INSERT INTO prenotazione (data,isbn,proprietario,richiedente)
    VALUES (FROM_UNIXTIME(".time()."),'".$_POST['isbn']."','".$_POST['proprietario']."','".$_SESSION['email']."');";
    $res = mysqli_query($con,$query);
    echo "Prenotazione effettuata, ti arriverà una mail appena il libro sarà disponibile.";
?>