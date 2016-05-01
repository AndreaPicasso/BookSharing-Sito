

<?php
    require("../php/parameters.php");

    $con = mysqli_connect(SERVER,USER,PSW);
    mysqli_select_db($con,DB);
    $email = mysqli_real_escape_string($con,$_GET["email"]);
    $id = trim(mysqli_real_escape_string($con,$_GET["idAccesso"]));
    $psw = trim(mysqli_real_escape_string($con,$_GET["pswAccesso"]));

    
   // /!\  MODIFICARE LA TABELLA IN user
    $query = "SELECT * FROM user_prova WHERE email='".$email."';";
    $res = mysqli_query($con,$query);
    $rowcount = mysqli_num_rows($res);
    $item = array('error' =>'?');
    if($rowcount!=0 && strcmp($id,USER)==0 && strcmp($psw,PSW)==0){
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
   


?>