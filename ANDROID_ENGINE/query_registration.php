   

<?php
    require("../php/parameters.php");
    $con = mysqli_connect(SERVER,USER,PSW);
    mysqli_select_db($con,DB);
    $email = mysqli_real_escape_string($con,$_POST["email"]);
    $psw = trim(mysqli_real_escape_string($con,$_POST["psw"]));
    $repsw = trim(mysqli_real_escape_string($con,$_POST["repsw"]));
    $nome = trim(mysqli_real_escape_string($con,$_POST["nome"]));
    $cognome = trim(mysqli_real_escape_string($con,$_POST["cognome"]));    
    
    $res = array('risultato' => 'ok');
    $ok=true;
     if(trim($email)==""){
         $res = array('risultato' => 'false');
         $ok = false;
    }
    if($ok && trim($nome)==""){
            $res = array('risultato' => 'false');
            $ok = false;
    }
       if($ok && trim($cognome)==""){
            $res = array('risultato' => 'false');
            $ok = false;   
       }
    if($ok && trim($psw)==""){
         $res = array('risultato' => 'false');
         $ok = false;
    }
    if($ok && strcmp(trim($psw),trim($repsw))!=0){
         $res = array('risultato' => 'Le password non corrispondono');
         $ok = false;
    }
if($ok)
{
    $psw = sha1($psw);
    $control = "SELECT * FROM user WHERE email='".$email."';";
    $check = mysqli_query($con,$control);
    if(mysqli_num_rows($check)==0){
        $query = "INSERT INTO user (email,nome,cognome,password) VALUES ('".$email."','".$nome."','".$cognome."','".$psw."');";
        mysqli_query($con,$query);
        require("../php/email.php");
        sendMail($email, "Iscrizione", "Congratulazioni!<br>".$nome." ".$cognome."ti sei iscritto a BookSharing.");
        /*
        DA APP ANDROID LOGGO ANCHE:
        */
        session_start();
        $_SESSION["email"]=$email;
        $_SESSION["loginAndroid"]="true";
    }
    else
    {
         $res = array('risultato' => 'Email gia esistente');
    }
    mysqli_close($con);
}
    echo json_encode($res);
?>