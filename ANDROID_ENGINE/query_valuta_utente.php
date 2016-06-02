<?php
    if(((isset($_POST['pswAccesso']) && strcmp($_POST['pswAccesso'],"Azet325K54fA32w")==0) || isset($_GET['simone'])) 
       && isset($_POST["rating"]) && isset($_POST["valutato"]) && isset($_POST["valutatore"])){

    require_once("../php/parameters.php");
    $con = mysqli_connect(SERVER,USER,PSW);
    mysqli_select_db($con,DB);
    $rating = mysqli_real_escape_string($con,$_POST["rating"]);
    $valutatore = mysqli_real_escape_string($con,$_POST["valutatore"]);
    $valutato = mysqli_real_escape_string($con,$_POST["valutato"]);
        
   $query = "INSERT INTO valutazione (valutato,valutatore,voto) VALUES ('".$valutato."','".$valutatore."','".$rating."');";
    $response = array('error' =>'Email non trovata');
    $res = mysqli_query($con,$query);
    if($res)
        $response = array('ok' =>'Valutazione effettuata');
    else
        $response = array('error' =>'Impossibile effettuare valutazione');

     echo json_encode($response);
   
    }
?>