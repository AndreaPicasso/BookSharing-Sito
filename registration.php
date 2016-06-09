<!DOCTYPE html>
<html>
<head>
    <title>Book Sharing</title>
    <link rel="stylesheet" href="css/all.css" type="text/css">
    <link rel="stylesheet" href="css/registration.css" type="text/css">
    <link rel="icon" href="res/icona.ico">

</head>
    
<body>
    <a href="index.php">
                <div id="home">
                     &lt; Home
                </div>
            </a>
    <div id="login">
    <h1>Iscriviti</h1><br>
    <form method="post" action="#">
    <table>
        <tr>
            <td>
                <input type="email" placeholder="Email" name="email" value=<?php if(isset($_POST["email"])) echo $_POST["email"]; ?>>
            </td>
        </tr>
        <tr>
            <td>
                <input type="text" placeholder="Nome" name="nome" pattern="[A-Za-z]*" value=<?php if(isset($_POST["nome"])) echo $_POST["nome"]; ?>>
            </td>
        </tr>
        <tr>
            <td>
                <input type="text" placeholder="Cognome" name="cognome" pattern="[A-Za-z]*" value=<?php if(isset($_POST["cognome"])) echo $_POST["cognome"]; ?>>
            </td>
        </tr>
        <tr>
            <td>
                <input type="password" placeholder="Password" name="psw">
            </td>
        </tr>
        <tr>
            <td>
                <input type="password" placeholder="Re-Password" name="repsw">
            </td>
        <tr>
            <td>
                <!-- div, per dare l'effetto ingrandimento -->
                <div><input type="image" src="res/login-button.png" alt="Login button" ></div>
            </td>
        </tr>
    </table>
    </form>
    <br>
    
    </div>
</body>
    

<?php
  
    
    $submit =isset($_POST["email"], $_POST["nome"], $_POST["cognome"], $_POST["psw"], $_POST["repsw"]);
    $ok=true;
     if($submit && trim($_POST["email"])==""){
        $ok=false;
        echo '<script type="text/javascript">window.alert("Campo email vuoto")</script>';
    }
    if($submit && trim($_POST["nome"])==""){
        $ok=false;
        echo '<script type="text/javascript">window.alert("Campo nome vuoto")</script>';
    }
       if($submit && trim($_POST["cognome"])==""){
        $ok=false;
        echo '<script type="text/javascript">window.alert("Campo cognome vuoto")</script>';
    }
    if($submit && trim($_POST["psw"])==""){
        $ok=false;
        echo '<script type="text/javascript">window.alert("Campo password vuoto")</script>';
    }
    if($submit && strcmp(trim($_POST["psw"]),trim($_POST["repsw"]))!=0){
        $ok=false;
        echo '<script type="text/javascript">window.alert("Le password non corrispondono")</script>';
    }
if($ok && $submit)
{

    require("php/parameters.php");
    $con = mysqli_connect(SERVER,USER,PSW);
    mysqli_select_db($con,DB);
       
    $myEmail = mysqli_real_escape_string($con,$_POST["email"]);
    $myName = mysqli_real_escape_string($con,$_POST["nome"]);
    $mySurname = mysqli_real_escape_string($con,$_POST["cognome"]);
    $myPsw = mysqli_real_escape_string($con,$_POST["psw"]);
    $myPsw =sha1($myPsw);
    $control = "SELECT * FROM user WHERE email='".$myEmail."';";
    $res = mysqli_query($con,$control);
    if(mysqli_num_rows($res)==0){
        $query = "INSERT INTO user (email,nome,cognome,password) VALUES ('".$myEmail."','".$myName."','".$mySurname."','".$myPsw."');";
        $res = mysqli_query($con,$query);
        require("php/email.php");
        sendMail($myEmail, "Iscrizione", "Congratulazioni!<br>".$myName." ".$mySurname." ti sei iscritto a BookSharing.");
       header("Location: index.php");
    }
    else
    {
        echo '<script type="text/javascript">window.alert("Email gia utilizzata")</script>';
    }
    mysqli_close($con);
}
?>
    
    
    
    
    
    
</html>