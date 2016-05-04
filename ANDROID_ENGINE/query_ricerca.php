<?php
    session_start();
    if(isset($_SESSION['loginAndroid']) && strcmp($_SESSION['loginAndroid'],"true")==0){
        require("../php/parameters.php");
        $con = mysqli_connect(SERVER,USER,PSW);
        mysqli_select_db($con,DB);
        
        //ISBN
        if(isset($_POST["isbn"])){
            $isbn = mysqli_real_escape_string($con,$_POST["isbn"]);
            $isbn = " isbn ='".$isbn."'";
        }
        else
            $isbn="";
        
        
        //POSIZIONE
        if(isset($_POST['minLat'], $_POST["minLon"], $_POST['maxLat'], $_POST["maxLon"])){
            $minLat = mysqli_real_escape_string($con,$_POST["minLat"]);
            $minLon = mysqli_real_escape_string($con,$_POST["minLon"]);
            $maxLat = mysqli_real_escape_string($con,$_POST["maxLat"]);
            $maxLon = mysqli_real_escape_string($con,$_POST["maxLon"]);
            
            $checkPos=" latitudine<= '".$maxLat."' AND latitudine>= '".$minLat."'AND longitudine<= '".$maxLon."' AND longitudine>= '".$minLon."'";
        }
        else{
            $checkPos="";
        }
        
        if(isset($_POST["disponibili"]) && strcmp(trim($_POST["disponibili"]),'true')==0){
            $disponibili = " NOT EXISTS(SELECT * FROM prestiti)";
            }
        else
            $disponibili="";
        
        // Costruisco condizione:
        $isSetIsbn= !strcmp($isbn,"")==0;
        $isSetPos = !strcmp($checkPos,"")==0;
        $isSetDisp = !strcmp($disponibili,"")==0;
        
        if($isSetIsbn && $isSetPos && $isSetDisp)
            $cond = "WHERE ".$isbn." AND ".$checkPos." AND ".$disponibili;
        if($isSetIsbn && $isSetPos && !$isSetDisp)
            $cond = "WHERE ".$isbn." AND ".$checkPos;
        if($isSetIsbn && !$isSetPos && $isSetDisp)
            $cond = "WHERE ".$isbn." AND ".$disponibili;
        if($isSetIsbn && !$isSetPos && !$isSetDisp)
            {$cond = "WHERE ".$isbn; echo "ok";}
        if(!$isSetIsbn && $isSetPos && $isSetDisp)
            $cond = "WHERE ".$checkPos." AND ".$disponibili;
        if(!$isSetIsbn && $isSetPos && !$isSetDisp)
            $cond = "WHERE ".$checkPos;
        if(!$isSetIsbn && !$isSetPos && $isSetDisp)
            $cond = "WHERE ".$disponibili;
        if(!$isSetIsbn && !$isSetPos && !$isSetDisp)
            $cond = "";
        
        
        

        
        $query = "SELECT * FROM librocondiviso ".$cond.";";
        
        
        echo $query;
        
        $res = mysqli_query($con,$query);
        if($res){
        $rowcount = mysqli_num_rows($res);
        $item = array('error' =>'Nessun libro trovato');
        if($rowcount!=0){
            $item = array();
            for($i=0;$i<$rowcount; $i++){

                $row = mysqli_fetch_assoc($res);
                $temp = array(
                        'isbn' => $row['isbn'],
                        'proprietario' => $row['proprietario'],
                        'lat' => $row['latitudine'],
                        'lon' => $row['longitudine'],
                        'datacondivisione' => $row['datacondivisione']
                );
                array_push($item, $i, $temp);
            }
        }
        $response = array(
            'number' => $rowcount,
            'items'  =>  $item
        );
        }
        else
            $response = array('error' =>'Query Error');
    }
    else{
        $response = array('error' =>'Non sei connesso al server');
    }
    echo json_encode($response);
   


?>