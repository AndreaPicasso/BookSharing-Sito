<?php
    session_start();
    //if((isset($_SESSION['loginAndroid']) && strcmp($_SESSION['loginAndroid'],"true")==0) || isset($_GET['simone'])){
    if(isset($_POST['pswAccesso']) && strcmp($_POST['pswAccesso'],"Azet325K54fA32w")==0){
        require_once("../php/parameters.php");
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
            
            $checkPos=" latitudine<= '".$maxLat."' AND latitudine>= '".$minLat."' AND longitudine<= '".$maxLon."' AND longitudine>= '".$minLon."';";
        }
        else{
            $checkPos="";
        }
        
        if(isset($_POST["disponibili"]) && strcmp(trim($_POST["disponibili"]),'true')==0){
            $disponibili = " isbn NOT IN(SELECT isbn FROM prestiti p WHERE p.proprietario= l.proprietario)";
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
            {$cond = "WHERE ".$isbn;}
        if(!$isSetIsbn && $isSetPos && $isSetDisp)
            $cond = "WHERE ".$checkPos." AND ".$disponibili;
        if(!$isSetIsbn && $isSetPos && !$isSetDisp)
            $cond = "WHERE ".$checkPos;
        if(!$isSetIsbn && !$isSetPos && $isSetDisp)
            $cond = "WHERE ".$disponibili;
        if(!$isSetIsbn && !$isSetPos && !$isSetDisp)
            $cond = "";
        
        
        

        
        $query = "SELECT * FROM librocondiviso l ".$cond.";";
        $res = mysqli_query($con,$query);
        if($res){
        $rowcount = mysqli_num_rows($res);
        $item = array('error' =>'Nessun libro trovato');
        if($rowcount!=0){
            $item = array();
            for($i=0;$i<$rowcount; $i++){

                $row = mysqli_fetch_assoc($res);
                $query_prestato = "SELECT *
                                    FROM librocondiviso INNER JOIN prestiti
                                    ON librocondiviso.isbn = prestiti.isbn AND librocondiviso.proprietario = prestiti.proprietario
                                    WHERE librocondiviso.isbn='".$row['isbn']."' AND librocondiviso.proprietario='".$row['proprietario']."'  AND prestiti.stato!='storico';";
                $prest = mysqli_query($con,$query_prestato);

                if(mysqli_num_rows($prest)!=0){
                    $prest="no";
                    //Non è disponibile
                }
                else{
                    $prest="si";
                }
                $temp = array(
                        'isbn' => $row['isbn'],
                        'proprietario' => $row['proprietario'],
                        'lat' => $row['latitudine'],
                        'lon' => $row['longitudine'],
                        'datacondivisione' => $row['datacondivisione'],
                        'disponibile' => $prest
                );
                array_push($item, $temp);
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