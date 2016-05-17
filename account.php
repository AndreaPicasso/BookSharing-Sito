    <?php       
                require("parts/header.php");
                require("parts/banner_account.php");
                require("php/privateSectionsControl.php");
                require("php/parameters.php");
       ?>  

<div id="main">
        <div id="container_home">
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
                <form action="#" method="post">
                    <input type="text" id="isbn" name="isbn" placeholder="ISBN" onclick="">
                    <input type="submit" id="inseriscilibro" name="inseriscilibro" value="Inserisci un nuovo libro"> 
                </form>
            </span>
         </div>
            <div style="width:100%;">
            LIBRI IN LETTURA
            </div>  
            <div style="width:100%;">
            LIBRI IN PRESTITO
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



    
    <script type="text/javascript">
        //--------------- INSERISCI LIBRO
        /*
        1) php, prendo la richiesta
        2) verifico su google se il libro esiste
        3) prendo la posizione corrente
        4) faccio una chiamata AJAX per inserire il libro
        */
        function handleResponse(response) {
        if(response.totalItems!=0){
                isbn = response.items[0].volumeInfo.industryIdentifiers[0].identifier;
                console.log(isbn);
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(asyncCall);
                } else { 
                    window.alert("Geolocazizzazione non supportata.");
                }
        }
        else{
                  window.alert("ISBN non trovato.");
        }
        
    }
        
    function asyncCall(position) {
                    var lat = position.coords.latitude;
                    var lon = position.coords.longitude;
                    //console.log(lat+" "+lon);
                    xhr = getXMLHttpRequestObject();
                    var url = 'php/addBook.php?isbn='+isbn+'&lat='+lat+'&lon='+lon;
                    xhr.onreadystatechange = alertContents;
                    xhr.open('GET', url, true);
                    xhr.send();
    }
        
    function alertContents() {
        if (xhr.readyState == 4) {
                 if (xhr.status == 200) {
                    window.alert(xhr.response);
                  }
                  else {
                    alert('There was a problem with the request.');
                 }    
            }
        }

    </script>

    <?php
    
    if(isset($_POST['inseriscilibro'])){
        $isbn = $_POST['isbn'];
        if(!strcmp(trim($isbn),"")==0){
            echo '<script type="text/javascript" src="https://www.googleapis.com/books/v1/volumes?q=isbn:'.$isbn.'&callback=handleResponse">
            </script>';
        }
        else
        {
            echo '<script type="text/javascript">window.alert("ISBN vuoto")</script>';   
        }
    }
    ?>

  </body>
</html>