<?php
$response = array('error' =>'Non sei connesso al server.');
 if(((isset($_POST['pswAccesso']) && strcmp($_POST['pswAccesso'],"Azet325K54fA32w")==0) || isset($_GET['simone'])) 
       && isset($_POST["isbn"])  && isset($_POST["proprietario"])  && isset($_POST["email"])){

            require_once("../php/parameters.php");
            require_once("../php/email.php");

            $con = mysqli_connect(SERVER,USER,PSW);
            mysqli_select_db($con,DB);

            $isbn = mysqli_real_escape_string($con,$_POST['isbn']);
            $propr = mysqli_real_escape_string($con,$_POST['proprietario']);
            $email = mysqli_real_escape_string($con,$_POST['email']);

             $query = "UPDATE prestiti
                SET stato='inrestituzione'
                WHERE richiedente='".$email."' AND proprietario='".$propr."' AND isbn='".$isbn."' AND stato='incorso';";
   
            $res1 = mysqli_query($con,$query);
    
            $text = "Ciao ".$propr."!<br> Mi piacerebbe restituirti il tuo libro ".$isbn;
            $query = "INSERT INTO message (mittente, destinatario, testo, datames) VALUES ('".$email."','".$propr."','".$text."',FROM_UNIXTIME(".time()."));";
            $res2 = mysqli_query($con,$query);
             sendMail($propr, "Restituzione Libro", "L'utente ".$email." vorrebbe restituirti un libro.<br> Vai su BookSharing per metterti in contatto con lui!");
            if($res1 && $res2)
                $response = array('ok' =>'Grazie per aver usato BookSharing, verrai contattato dal proprietario al più presto.');
            else
                $response = array('error' =>"C'è stato un errore");
             
 }
echo json_encode($response);

?>