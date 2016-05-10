<?php
    require("../php/parameters.php");
    $con = mysqli_connect(SERVER,USER,PSW);
    mysqli_select_db($con,DB);
    $email = mysqli_real_escape_string($con,$_POST["email"]);

    $newPsw = generateRandomString();
    $query ="UPDATE user
    SET password = '".sha1($newPsw)."' WHERE email='".$email."';";
    $risultato = mysqli_query($con,$query);
    if(mysqli_affected_rows($con)!=0){
        require("../php/email.php");
        sendMail($email, "Richiesta Nuova Password", "E' avvenuta la richiesta per una nuova password.<br><br><b>Nuova Password:</b> ".$newPsw);
        mysqli_close($con);
        $res = array('risultato' => 'ok');
    }
    else
       $res = array('risultato' => 'Email non trovata');

    echo json_encode($res);

        


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
