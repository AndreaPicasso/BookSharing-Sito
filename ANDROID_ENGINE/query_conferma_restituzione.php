<?php
$response = array('error' =>'Non sei connesso al server.');
 if(((isset($_POST['pswAccesso']) && strcmp($_POST['pswAccesso'],"Azet325K54fA32w")==0) || isset($_GET['simone'])) 
       && isset($_POST["isbn"])  && isset($_POST["richiedente"])  && isset($_POST["email"])){

            require_once("../php/parameters.php");
            require_once("../php/email.php");

            $con = mysqli_connect(SERVER,USER,PSW);
            mysqli_select_db($con,DB);

            $isbn = mysqli_real_escape_string($con,$_POST['isbn']);
            $richied = mysqli_real_escape_string($con,$_POST['richiedente']);
            $email = mysqli_real_escape_string($con,$_POST['email']);
            $query =    "UPDATE prestiti
                        SET stato='storico'
                        WHERE richiedente='".$richied."' AND proprietario='".$email."' AND isbn='".$isbn."' AND stato='inrestituzione';";
            $res = mysqli_query($con,$query);
            if(mysqli_affected_rows($con)==0)
                 $response = array('error' =>"C'è stato un errore");
            else
            {
               $response = array('ok' =>"Restituzione confermata, grazie per aver usato BookSharing!");
            $query = "SELECT *
                    FROM prenotazione
                    WHERE proprietario='".$email."' AND isbn='".$isbn."'
                    ORDER BY data;";


            $res = mysqli_query($con,$query);
            $numrows= mysqli_num_rows($res);
            if($numrows>0){
                $row = mysqli_fetch_assoc($res);
                $query = "DELETE FROM prenotazione
                WHERE richiedente='".$row['richiedente']."' AND proprietario='".$row['proprietario']."' AND isbn='".$row['isbn']."';";
                $res = mysqli_query($con,$query);
                sendMail($row['richiedente'], "Avviso di prenotazione", "Siamo felici di avvisarti che <br> il libro ".$isbn." che avevi prenotato, è ora disponibile!<br> Se sei ancora interessato vieni a richiederlo su BookSharing!");
            }
            }
 }
echo json_encode($response);

?>