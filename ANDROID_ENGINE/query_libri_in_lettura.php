<?php
    
    $response = array('error' => 'Non sei connesso al server');
     if(((isset($_POST['pswAccesso']) && strcmp($_POST['pswAccesso'],"Azet325K54fA32w")==0)) 
       && isset($_POST["email"])){
        
        require_once("../php/parameters.php");
        $con = mysqli_connect(SERVER,USER,PSW);
        mysqli_select_db($con,DB);
        $email = mysqli_real_escape_string($con,$_POST["email"]);
        $query = "SELECT * FROM prestiti  WHERE richiedente='".$email."' AND stato='incorso';";
        $res = mysqli_query($con,$query);
        if($res){
            $numrows= mysqli_num_rows($res);
            $item = array();
            for($i = 0; $i<$numrows; $i++){
                $row = mysqli_fetch_assoc($res);
                $temp = array(
                            'isbn' => $row['isbn'],
                            'proprietario' => $row['proprietario'],
                            'dataprestito' => $row['dataprestito'],
                );
                array_push($item, $temp);
            }
        $response = array(
            'number' => $numrows,
            'items'  =>  $item
            );
        }
         
         
     }

    echo json_encode($response);

?>