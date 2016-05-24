<?php
    require_once("privateSectionsControl.php");
    require_once("parameters.php");
    $rating = $_POST['rating'];
    $valutato = $_POST['valutato'];
    $email = $_SESSION['email'];
    $con = mysqli_connect(SERVER,USER,PSW);
    mysqli_select_db($con,DB);
   $query = "INSERT INTO valutazione (valutato,valutatore,voto) VALUES ('".$valutato."','".$email."','".$rating."');";

    $res = mysqli_query($con,$query);
    if($res)
        echo "Valutazione effettuata, grazie per il tuo contributo!";
    else
        echo "Errore, impossibile effettuare valutazione.";
    

?>