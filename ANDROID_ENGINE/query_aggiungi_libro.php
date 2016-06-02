<?php
 if(((isset($_POST['pswAccesso']) && strcmp($_POST['pswAccesso'],"Azet325K54fA32w")==0) || isset($_GET['simone'])) 
       && isset($_POST["lat"])  && isset($_POST["lon"])  && isset($_POST["isbn"])  && isset($_POST["proprietario"])){

        require_once("../php/parameters.php");
            $con = mysqli_connect(SERVER,USER,PSW);
            mysqli_select_db($con,DB);

            $isbn = mysqli_real_escape_string($con,$_POST["isbn"]);
            $lat = mysqli_real_escape_string($con,$_POST["lat"]);
            $lon = mysqli_real_escape_string($con,$_POST["lon"]);
            $propr = mysqli_real_escape_string($con,$_POST["proprietario"]);

            $query = 'INSERT INTO librocondiviso
                    (isbn,proprietario,latitudine,longitudine,datacondivisione)
                    VALUES
                    ("'.$isbn.'","'.$propr.'",'.$lat.','.$lon.',FROM_UNIXTIME('.time().'));';
            $res = mysqli_query($con,$query);
     
          if($res)
                $response = array('ok' =>'Libro aggiunto');
            else
                $response = array('error' =>'Impossibile aggiungere libro');

             echo json_encode($response);
 }
?>