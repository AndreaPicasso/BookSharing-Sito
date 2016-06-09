<?php
    require_once("privateSessionControl.php");
    require_once("parameters.php");
    require_once("email.php");
    $isbn = $_POST['isbn'];
    $richied = $_POST['richiedente'];
    $email = $_SESSION['email'];
    $con = mysqli_connect(SERVER,USER,PSW);
    mysqli_select_db($con,DB);
    $query =    "UPDATE prestiti
                SET stato='incorso'
                WHERE richiedente='".$richied."' AND proprietario='".$email."' AND isbn='".$isbn."' AND stato='nonconfermato';";
    $res = mysqli_query($con,$query);
    if($res)
        echo "Hai confermato il prestito, l'utente ti contatterà quando vorrà restituirti il libro";
    else
        echo "C'è stato un errore";
    

?>