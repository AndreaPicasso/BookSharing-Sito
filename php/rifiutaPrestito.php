<?php

    require_once("privateSessionControl.php");
    require_once("parameters.php");
    require_once("email.php");
    $isbn = $_POST['isbn'];
    $richied = $_POST['richiedente'];
    $email = $_SESSION['email'];
    $con = mysqli_connect(SERVER,USER,PSW);
    mysqli_select_db($con,DB);
    $query = "DELETE FROM prestiti
        WHERE richiedente='".$richied."' AND proprietario='".$email."' AND isbn='".$isbn."' AND stato='nonconfermato';";
    $res=mysqli_query($con,$query);
    
     $text = "Ciao ".$richied."!<br> Mi dispiace, ma il libro che volevi (isbn: ".$isbn.") <br>Non è al momento disponibile.";
    $query = "INSERT INTO message (mittente, destinatario, testo, datames) VALUES ('".$email."','".$richied."','".$text."',FROM_UNIXTIME(".time()."));";
    $res = mysqli_query($con,$query);
    


    //Se c'è qualche prenotazione, avvisa
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

    
    

?>