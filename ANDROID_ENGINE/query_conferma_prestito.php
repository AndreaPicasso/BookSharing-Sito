<?php
    
    $response = array('error' => 'Non sei connesso al server');
     if(((isset($_POST['pswAccesso']) && strcmp($_POST['pswAccesso'],"Azet325K54fA32w")==0)) 
       && isset($_POST["email"]) && isset($_POST["richiedente"]) && isset($_POST["isbn"])){
        
        require_once("../php/parameters.php");
        require_once("../php/email.php");
        $con = mysqli_connect(SERVER,USER,PSW);
        mysqli_select_db($con,DB);
        $email = mysqli_real_escape_string($con,$_POST["email"]);
        $isbn = mysqli_real_escape_string($con,$_POST['isbn']);
        $richied = mysqli_real_escape_string($con,$_POST['richiedente']);
    
    $query =    "UPDATE prestiti
                SET stato='incorso'
                WHERE richiedente='".$richied."' AND proprietario='".$email."' AND isbn='".$isbn."' AND stato='nonconfermato';";
    $res = mysqli_query($con,$query);
    if(mysqli_affected_rows($con)!=0)
        $response = array('ok' => 'Prestito confermato');
    else
        $response = array('error' => 'Impossibile confermare prestito');
         
         
     }

    echo json_encode($response);

?>