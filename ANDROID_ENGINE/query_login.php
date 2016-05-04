

<?php
    require("../php/parameters.php");
    session_start();

    $con = mysqli_connect(SERVER,USER,PSW);
    mysqli_select_db($con,DB);
    $email = mysqli_real_escape_string($con,$_POST["email"]);
    $psw = trim(mysqli_real_escape_string($con,$_POST["psw"]));    
    $psw = sha1($psw);
   // /!\  MODIFICARE LA TABELLA IN user
    $query = "SELECT * FROM user WHERE email='".$email."' and password= '".$psw."';";
    $res = mysqli_query($con,$query);
    $rowcount = mysqli_num_rows($res);
    if($rowcount!=0){
        $_SESSION["email"]=$email;
        $_SESSION["loginAndroid"]="true";
        $item = array('risultato' => 'ok');
    }
    else
        $item = array('risultato' => 'error');
    echo json_encode($item);
    mysqli_close($con);

    /*
    $item = array('error' =>'?');
    if($rowcount!=0 && strcmp($id,USER)==0 && strcmp($pswAccesso,PSW)==0){
        $item = array();
        for($i=0;$i<$rowcount; $i++){
            
            $row = mysqli_fetch_assoc($res);
            $temp = array(
                    'email' => $row['email'],
                    'nome' => $row['nome'],
                    'cognome' => $row['cognome'],
                    'sesso' => $row['sesso']
            );
            array_push($item, $i, $temp);
        }
    }
    $response = array(
        'number' => $rowcount,
        'items'  =>  $item
    );

    echo json_encode($response);
   */


?>