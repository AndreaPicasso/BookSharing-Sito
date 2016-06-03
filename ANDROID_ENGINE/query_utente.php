

<?php
    require("../php/parameters.php");
    
    $response = array ( 'error' => 'Non sei connesso al server.');
    if((isset($_POST["email"]) && isset($_POST["pswAccesso"]) && strcmp($_POST['pswAccesso'],"Azet325K54fA32w")==0) && isset($_POST["psw"])){
    $con = mysqli_connect(SERVER,USER,PSW);
    mysqli_select_db($con,DB);
    $email = mysqli_real_escape_string($con,$_POST["email"]);
    $psw = trim(mysqli_real_escape_string($con,$_POST["psw"]));
    $psw=sha1($psw);
   
    
   // /!\  MODIFICARE LA TABELLA IN user
        
    $query = "SELECT * FROM user WHERE email='".$email."' AND password='".$psw."';";
    $res = mysqli_query($con,$query);
    $rowcount = mysqli_num_rows($res);
    if($rowcount!=0){
    $row = mysqli_fetch_assoc($res);
   $response = array(
       'email' => $row['email'],
       'nome' => $row['nome'],
       'cognome' => $row['cognome'],
       'sesso' => $row['sesso'],
       'genere' => $row['genere'],
            );
        }
        else{
            $response = array('error' => 'Utente non valido.');
        }
    }
    echo json_encode($response);
   


?>