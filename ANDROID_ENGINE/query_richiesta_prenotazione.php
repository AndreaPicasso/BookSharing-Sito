<?php
  
    $response = array('error' => 'Non sei connesso al server');
     if(((isset($_POST['pswAccesso']) && strcmp($_POST['pswAccesso'],"Azet325K54fA32w")==0)) 
       && isset($_POST["email"]) && isset($_POST["proprietario"])  && isset($_POST["isbn"] )){
         
        require_once("../php/parameters.php");
        $con = mysqli_connect(SERVER,USER,PSW);
        mysqli_select_db($con,DB);
        $propr = mysqli_real_escape_string($con,$_POST["proprietario"]);
        $isbn = mysqli_real_escape_string($con,$_POST["isbn"]);
        $email = mysqli_real_escape_string($con,$_POST["email"]);
        if(strcmp($email,$propr)==0)
                $response = array('error' => 'Non puoi prenotare i tuoi libri');
        else{
            $query = "INSERT INTO prenotazione (data,isbn,proprietario,richiedente)
            VALUES (FROM_UNIXTIME(".time()."),'".$isbn."','".$propr."','".$email."');";
            $res = mysqli_query($con,$query);
        if($res){
             $response = array('ok' => 'Prenotazione effettuata, ti arriverà una mail appena il libro sarà disponibile.');
        }
        else{
           $response = array('error' => 'Impossibile effettuare prenotazione');
        }
     }
         
     }

    echo json_encode($response);


?>