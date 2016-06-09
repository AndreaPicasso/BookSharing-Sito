<?php
    require_once("php/privateSessionControl.php");
    require("parameters.php");
    $email = $_POST['email'];
    $con = mysqli_connect(SERVER,USER,PSW);
    mysqli_select_db($con,DB);
    $newPsw = generateRandomString();
    $query ="UPDATE user
    SET password = '".sha1($newPsw)."' WHERE email='".$email."';";
    $res = mysqli_query($con,$query);
    if($res){
        require("email.php");
        sendMail($email, "Richiesta Nuova Password", "E' avvenuta la richiesta per una nuova password.<br><br><b>Nuova Password:</b> ".$newPsw);
        echo "E' stata inviata una mail contenente la nuova password.";
    }
    else{        
        echo "Email non trovata";
    }
        mysqli_close($con);
    

        function generateRandomString() {
        $length = 6;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
?>
