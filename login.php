<!DOCTYPE html>
<html>
<head>
    <title>Book Sharing</title>
    <link rel="stylesheet" href="css/all.css" type="text/css">
    <link rel="stylesheet" href="css/login.css" type="text/css">
</head>
    
<body>
    <?php session_start() ?>
    <a href="index.php">
                <div id="home">
                     &lt; Home
                </div>
            </a>
    <div id="login">
    <h1>Login</h1><br>
    <form action="#" method="post">
    <table>
        <tr>
            <td>
                <input type="email" placeholder="Email" name="email" value=<?php if(isset($_POST["email"])) echo $_POST["email"]; ?>>
            </td>
        </tr>
        <tr>
            <td>
                <input type="password" placeholder="Password" name="psw">
            </td>
        </tr>
        <tr>
            <td>
                <!-- div, per dare l'effetto ingrandimento -->
                <div><input type="image" src="res/login-button.png" alt="Login button" name="submit" ></div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="singlelink"><a href="login.php/?pswDim=true">Password Dimenticata</a></div>
            </td>
        </tr>
    </table>
    </form>
    <br>
    
    </div>
    
    <?php
          require("php/parameters.php");
        if(isset($_POST['email'],$_POST['psw'])){
            $ok= true;
            if(trim($_POST["email"])==""){
                $ok=false;
                echo '<script type="text/javascript">window.alert("Campo email vuoto")</script>';
            }
            if(trim($_POST["psw"])==""){
                $ok=false;
                echo '<script type="text/javascript">window.alert("Campo password vuoto")</script>';
            }
            if($ok){
                $con = mysqli_connect(SERVER,USER,PSW);
                mysqli_select_db($con,DB);
                $myEmail = mysqli_real_escape_string($con,$_POST["email"]);
                $myPsw = mysqli_real_escape_string($con,$_POST["psw"]);
                $myPsw =sha1($myPsw);
                $query = "SELECT * FROM user WHERE email='".$myEmail."' and password='".$myPsw."';";
                $res = mysqli_query($con,$query);
                if(mysqli_num_rows($res)!=0){
                     $_SESSION["email"]=$myEmail;
                    $_SESSION["login"]="true";
                    header("Location: home.php");
                }
                else{
                    echo '<script type="text/javascript">window.alert("Email o password errati.")</script>';
                }
                mysqli_close($con);
            }
        }
                     
        /*
        if(isset($_GET('pswDim'))){
            $email = prompt("Inserisci l'email", "");
            $con = mysqli_connect(SERVER,USER,PSW);
            mysqli_select_db($con,DB);
            $newPsw = generateRandomString();
            $query ="UPDATE user
            SET password = '".sha1($newPsw)."' WHERE email='".$email."';";
            $res = mysqli_query($con,$query);
            require("php/email.php");
            sendMail($email, "Richiesta Nuova Password", "E' avvenuta la richiesta per una nuova password.<br><br><b>Nuova Password:</b> ".$newPsw);
            echo '<script type="text/javascript">window.alert("E stata inviata una mail contenente la nuova password.")</script>';
            mysqli_close($con);

        }*/
                     
    function generateRandomString() {
        $length = 6;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    ?>
    
</body>


</html>