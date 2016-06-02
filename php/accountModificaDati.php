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