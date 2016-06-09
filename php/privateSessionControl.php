<?php
    session_start();
    if(!isset($_SESSION["login"], $_SESSION['email']) || strcmp($_SESSION["login"], "true")!=0){
            header("Location: index.php");

    }   
?>