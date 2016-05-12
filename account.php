<html>
  <head>
    <title>Account</title>
      <link rel="stylesheet" href="css/all.css" type="text/css">
      <link rel="stylesheet" href="css/home.css" type="text/css">
    <link rel="stylesheet" href="css/account.css" type="text/css">
  </head>
  <body>
   <div id="main">
        
        <?php require("parts/headeraccount.php");
                require("php/privateSectionsControl.php");
                require("php/parameters.php");
       ?>
        <div id="container">
        <div id="account">
            <span id="details">
                <form  action="#" method="post" >
                <table><tr>
                <?php
                    require_once("php/parameters.php");
                    $con = mysqli_connect(SERVER,USER,PSW);
                    mysqli_select_db($con,DB);
                    $email = $_SESSION["email"];
                    $query = "SELECT * FROM user  WHERE email='".$email."';";
                    $res = mysqli_query($con,$query);
                    $user = mysqli_fetch_assoc($res);
                echo '<td><input type="text" id="nome" name="nome" value="'.$user["nome"].'" placeholder="Nome"></td>';
                echo '<td><input type="text" id="cognome" name="cognome" value="'.$user["cognome"].'" placeholder="Cognome"></td>';
                echo '</tr><tr>';
                if(strcmp($user["sesso"],"")==0)
                    echo '<td>Sesso:<input type="text" id="sesso" name="sesso" placeholder="Sesso"></td>';
                else
                    echo '<td>Sesso:<input type="text" id="sesso" name="sesso" value="'.$user["sesso"].'" placeholder="Sesso"></td>';

                 if(strcmp($user["genere"],"")==0)
                    echo '<td>Genere preferito:<input type="text" id="genere" name="genere" placeholder="Genere"></td>';
                else
                    echo '<td>Genere preferito:<input type="text" id="genere" name="genere" value="'.$user["genere"].'" placeholder="Genere"></td>';
                echo '</tr>';
                echo '<tr><td><input type="password" id="password" name="password" placeholder="Password"></td></tr>';
                ?>
                </table>
                <br>   
                <input type="submit" id="modifica" name="modifica" value="Modifica"> 
            </form>
            </span>
            <span id="insertbook">
                <form action="" method="post">
                    <input type="text" id="isbn" name="isbn" placeholder="ISBN">
                    <input type="submit" id="inseriscilibro" name="inseriscilibro" value="Inserisci un nuovo libro"> 
                </form>
            </span>
         </div>
        <p> "LIBRI IN LETTURA</p>  
            <div >
            </div>  
        <p> "LIBRI IN PRESTITO</p> 
            <div >
            </div>    
   
    
    
    </div>
         
    </div>
    
      <?php
      //---------------- MODIFICA DATI -----------------------
      if(isset($_POST['modifica'])){
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
         if(isset($_POST["genere"])){
            $genere_pref = mysqli_real_escape_string($con,$_POST["genere"]);
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
          
          // -1 perche non devo contare la row contattata prima
            if((mysqli_affected_rows($con)-1)!=0)
                echo '<script type="text/javascript">window.alert("Modifica dati effettuata.")</script>';
            else
                echo '<script type="text/javascript">window.alert("Impossibile modificare i dati, forse il formato è sbagliato?")</script>';
        mysqli_close($con);
      }
      ?>
  </body>
</html>