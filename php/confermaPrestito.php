<?php
    require_once("privateSessionControl.php");
    require_once("parameters.php");
    require_once("email.php");
   
    $con = mysqli_connect(SERVER,USER,PSW);
    mysqli_select_db($con,DB);
    $isbn = mysqli_real_escape_string($con,$_POST['isbn']);
    $richied = mysqli_real_escape_string($con,$_POST['richiedente']);
    $email = $_SESSION['email'];
    
    $query =    "UPDATE prestiti
                SET stato='incorso'
                WHERE richiedente='".$richied."' AND proprietario='".$email."' AND isbn='".$isbn."' AND stato='nonconfermato';";
    $res = mysqli_query($con,$query);
    if($res)
        echo "Hai confermato il prestito, l'utente ti contatterà quando vorrà restituirti il libro";
    else
        echo "C'è stato un errore";
    

?>