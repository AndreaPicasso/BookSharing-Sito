<?php session_start();
    if(!isset($_SESSION["login"], $_SESSION['email']) || strcmp($_SESSION["login"], "true")){
            header("Location: index.php");

    }   
?>