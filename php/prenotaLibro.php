<?php
    require_once("privateSessionControl.php");
    require_once("parameters.php");
    if(!isset($_POST['isbn'],$_POST['proprietario'])){
           header("Location: ../home.php"); 
        }
    $con = mysqli_connect(SERVER,USER,PSW);
    mysqli_select_db($con,DB);
      $isbn = mysqli_real_escape_string($con,$_POST['isbn']);
      $proprietario = mysqli_real_escape_string($con,$_POST['proprietario']);
    
    $query = "INSERT INTO prenotazione (data,isbn,proprietario,richiedente)
    VALUES (FROM_UNIXTIME(".time()."),'".$isbn."','".$proprietario."','".$_SESSION['email']."');";
    $res = mysqli_query($con,$query);
    echo "Prenotazione effettuata, ti arriverà una mail appena il libro sarà disponibile.";
?>