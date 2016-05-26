<?php
// FINIRE
    require_once("privateSectionsControl.php");
    require_once("parameters.php");
    require_once("email.php");
    $isbn = $_POST['isbn'];
    $richied = $_POST['richiedente'];
    $email = $_SESSION['email'];
    $con = mysqli_connect(SERVER,USER,PSW);
    mysqli_select_db($con,DB);
    $query = "DELETE FROM prestiti
        WHERE richiedente='".$row['richiedente']."' AND proprietario='".$row['proprietario']."' AND isbn='".$row['isbn']."';";
    $res=mysqli_query($con,$query);
    if($res)
        echo "Restituzione confermata, grazie per aver usato BookSharing!";
    else
        echo "C'è stato un errore";
    
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