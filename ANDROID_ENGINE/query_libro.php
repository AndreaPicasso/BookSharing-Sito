
<?php
    session_start()
    if(isset($_SESSION['loginAndroid'])){
    require("../php/parameters.php");
    $con = mysqli_connect(SERVER,USER,PSW);
    mysqli_select_db($con,DB);
    $isbn = mysqli_real_escape_string($con,$_POST["isbn"]);
    $propr = mysqli_real_escape_string($con,$_POST["proprietario"]);


    
   // /!\  MODIFICARE LA TABELLA IN user
    $query = "SELECT * FROM librocondiviso WHERE isbn='".$isbn."';";
    $res = mysqli_query($con,$query);
    $rowcount = mysqli_num_rows($res);
    $item = array('error' =>'Nessun libro con tale ISBN');
    if($rowcount!=0){
        $item = array();
        for($i=0;$i<$rowcount; $i++){
            
            $row = mysqli_fetch_assoc($res);
            $temp = array(
                    'isbn' => $row['isbn'],
                    'proprietario' => $row['proprietario'],
                    'lat' => $row['latitudine'],
                    'lon' => $row['longitudine'],
            );
            array_push($item, $i, $temp);
        }
    }
    $response = array(
        'number' => $rowcount,
        'items'  =>  $item
    );
    }
    else{
        $response = array('error' =>'Non sei connesso al server');
    }
    echo json_encode($response);
   


?>