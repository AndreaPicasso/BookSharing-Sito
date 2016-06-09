<?php
    require_once("privateSessionControl.php");
    require_once("parameters.php");


    $con = mysqli_connect(SERVER,USER,PSW);
    mysqli_select_db($con,DB);
    $email = $_SESSION['email'];
    if(isset($_GET['other'])){
    
    $other=$_GET['other'];

    $query =    'SELECT * FROM `message` 
                WHERE (mittente="'.$email.'" AND destinatario ="'.$other.'") OR
                (destinatario="'.$email.'" AND mittente ="'.$other.'")
                ORDER BY datames ; ';
    $res = mysqli_query($con,$query);
    $numrows= mysqli_num_rows($res);
    for($i = 0; $i<$numrows; $i++){
        $row = mysqli_fetch_assoc($res);
       if(strcmp($row['destinatario'],$email)==0){
                $id="chatmessagerecieved";
            }
            else{   
                $id="chatmessagesend";
            }
        echo '<div class="'.$id.'">'.$row['testo'].'</div>';
    } 
}
?>