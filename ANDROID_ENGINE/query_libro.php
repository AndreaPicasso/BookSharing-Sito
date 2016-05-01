
<?php
    require("../php/parameters.php");

    $con = mysqli_connect(SERVER,USER,PSW);
    mysqli_select_db($con,DB);
    $isbn = mysqli_real_escape_string($con,$_GET["isbn"]);
    $id = trim(mysqli_real_escape_string($con,$_GET["idAccesso"]));
    
    $pswAccesso = trim(mysqli_real_escape_string($con,$_GET["pswAccesso"]));

    
   // /!\  MODIFICARE LA TABELLA IN user
    $query = "SELECT * FROM librocondiviso WHERE isbn='".$isbn."';";
    $res = mysqli_query($con,$query);
    $rowcount = mysqli_num_rows($res);
    $item = array('error' =>'?');
    if($rowcount!=0 && strcmp($id,USER)==0 && strcmp($pswAccesso,PSW)==0){
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

    echo json_encode($response);
   


?>