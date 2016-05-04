<?php
    session_start()
    if(isset($_SESSION['loginAndroid'])){
        require("../php/parameters.php");
        $con = mysqli_connect(SERVER,USER,PSW);
        mysqli_select_db($con,DB);
        
        //ISBN
        if(isset($_POST["isbn"]))
            $isbn = mysqli_real_escape_string($con,$_POST["isbn"]);
            isbn = "isbn ='".$isbn."'";
        else
            $isbn="";
        
        
        //POSIZIONE
        if(isset($_POST['minLat'], $_POST["minLon"], $_POST['maxLat'], $_POST["maxLon"])){
            $minLat = mysqli_real_escape_string($con,$_POST["minLat"]);
            $minLon = mysqli_real_escape_string($con,$_POST["minLon"]);
            $maxLat = mysqli_real_escape_string($con,$_POST["maxLat"]);
            $maxLon = mysqli_real_escape_string($con,$_POST["maxLon"]);
            
            $checkPos=" AND latitudine<= '".$maxLat."' AND latitudine>= '".$minLat."'AND longitudine<= '".$maxLon."' AND longitudine>= '".$minLon."'";
        }
        else{
            $checkPos="";
        }
        
        
        if(isset($_POST["disponibili"]) && strcmp(trim($_POST["disponibili"]),"true"))
            $disponibili = " AND NOT EXIST(SELECT * FROM prestiti WHERE ".$isbn.$checkPos.")"
        else
            $disponibili="";
        


        $query = "SELECT * FROM librocondiviso WHERE ".$isbn.$checkPos.$disponibili.";";
        
        
        
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