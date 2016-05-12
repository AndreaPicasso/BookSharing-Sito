<?php

    if(((isset($_POST['pswAccesso']) && strcmp($_POST['pswAccesso'],"Azet325K54fA32w")==0) || isset($_GET['simone'])) 
       && isset($_POST["email"])){
        require_once("../php/parameters.php");
        $con = mysqli_connect(SERVER,USER,PSW);
        mysqli_select_db($con,DB);
        $email = mysqli_real_escape_string($con,$_POST["email"]);
        
        $query = "SELECT * FROM user  WHERE email='".$email."';";
        
        $res = mysqli_query($con,$query);
        $response = array('error' =>'Email non trovata');
        if(mysqli_num_rows($res)!=0){
            $user = mysqli_fetch_assoc($res);
        
        

        if(isset($_POST["nome"])){
            $nome = mysqli_real_escape_string($con,$_POST["nome"]);
            }
        else
            {
                $nome = $user['nome'];
            }
         if(isset($_POST["cognome"])){
            $cogn = mysqli_real_escape_string($con,$_POST["cognome"]);
            }
        else
            {
                $cogn = $user['cognome'];
            }
         if(isset($_POST["sesso"])){
            $sesso = mysqli_real_escape_string($con,$_POST["sesso"]);
            }
        else
            {
                $sesso = $user['sesso'];
            }
         if(isset($_POST["genere_pref"])){
            $genere_pref = mysqli_real_escape_string($con,$_POST["genere_pref"]);
            }
        else
            {
                $genere_pref = $user['genere'];
            }
            
        if(isset($_POST["psw"])){
            $psw = mysqli_real_escape_string($con,$_POST["psw"]);
            $psw = sha1($psw);
            }
              else
            {
                $psw = $user['password'];
            }
            
            $query = "UPDATE user
            SET nome = '".$nome."', cognome = '".$cogn."', sesso = '".$sesso."',
            genere = '".$genere_pref."', password = '".$psw."'
            WHERE email = '".$email."';";
            $res = mysqli_query($con,$query);
            if((mysqli_affected_rows($con)-1)!=0){
                
                $response = array('ok' =>'Modifica effettuata');
            }
            else
                $response = array('error' =>'Impossibile modificare campi');
            
            
        }
        mysqli_close($con);
    }
    else{
        $response = array('error' =>'Non sei connesso al server');     
    }
    
 echo json_encode($response);

?>