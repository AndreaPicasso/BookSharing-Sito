<?php
    
    $response = array('error' => 'Non sei connesso al server');
     if(((isset($_POST['pswAccesso']) && strcmp($_POST['pswAccesso'],"Azet325K54fA32w")==0)) 
       && isset($_POST["email"])  && isset($_POST["titolo"])  && isset($_POST["proprietario"])  && isset($_POST["isbn"] )){
         
        require_once("../php/parameters.php");
        $con = mysqli_connect(SERVER,USER,PSW);
        mysqli_select_db($con,DB);
        $propr = mysqli_real_escape_string($con,$_POST["proprietario"]);
        $titolo = mysqli_real_escape_string($con,$_POST["titolo"]);
        $isbn = mysqli_real_escape_string($con,$_POST["isbn"]);
        $email = mysqli_real_escape_string($con,$_POST["email"]);
        if(strcmp($email,$propr)==0)
                $response = array('error' => 'Non puoi prendere in prestito i tuoi libri');
        else{
            $text = "Ciao ".$propr."!<br> Mi piacerebbe prendere in prestito il tuo libro ".$titolo;
            $query = "INSERT INTO message (datames,mittente,destinatario,testo)
            VALUES (FROM_UNIXTIME(".time()."),'".$email."','".$propr."','".$text."');";
            $res1 = mysqli_query($con,$query);

            $query = "INSERT INTO prestiti (dataprestito,richiedente,proprietario,isbn,stato)
            VALUES (FROM_UNIXTIME(".time()."),'".$email."','".$propr."','".$isbn."','nonconfermato');";
            $res2 = mysqli_query($con,$query);
        if($res1 && $res2){
            require_once("../php/email.php");
            sendMail($propr,"Richiesta Libro", $text);
             $response = array('ok' => 'Richiesta effettuata, contata '.$propr.' nella chat per lo scambio');
        }
        else{
           $response = array('error' => 'Impossibile effettuare richiesta prestito');
        }
     }
         
     }

    echo json_encode($response);

?>