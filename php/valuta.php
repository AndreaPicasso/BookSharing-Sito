<?php
    require_once("privateSessionControl.php");
    require_once("parameters.php");
    $email = $_SESSION['email'];
    $con = mysqli_connect(SERVER,USER,PSW);
    mysqli_select_db($con,DB);
    $rating = mysqli_real_escape_string($con,$_POST['rating']);
    $valutato = mysqli_real_escape_string($con,$_POST['valutato']);
    
   $query = "INSERT INTO valutazione (valutato,valutatore,voto) VALUES ('".$valutato."','".$email."','".$rating."');";

    $res = mysqli_query($con,$query);
    if($res)
        echo "Valutazione effettuata, grazie per il tuo contributo!";
    else
        echo "Hai già valutato questo utente.";
    

?>