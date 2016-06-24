
<?php
    $response = array('error' => 'Non sei connesso al server');
      if((isset($_POST['pswAccesso']) && strcmp($_POST['pswAccesso'],"Azet325K54fA32w")==0)) {
         require_once("../php/parameters.php");
        $con = mysqli_connect(SERVER,USER,PSW);
        mysqli_select_db($con,DB);
        $proprietario = mysqli_real_escape_string($con,$_POST["proprietario"]);
        $query = "SELECT AVG(voto) as rating
            FROM valutazione
            WHERE valutato='".$proprietario."';";
        $res = mysqli_query($con,$query);
        $row = mysqli_fetch_assoc($res);
        if($res){
          $response = array('rating' => $row['rating']);   
        }
        else{
        $response = array('error' => 'Proprietario non trovato');
    }
      }
         echo json_encode($response);
?>
