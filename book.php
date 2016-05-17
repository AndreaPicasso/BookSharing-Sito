<?php     
        if(!isset($_GET['isbn'])){
               header("Location: ../index.php"); 
            }
        require("parts/header.php");
        require("parts/banner_account.php");
        require("php/privateSectionsControl.php");
        require("php/parameters.php");
        ?>


       <div id="content_book">
           <div id="titolo">Titolo</div>
           <div id="copertina"> copertina</div>

           
           
           <div id="info">
            <div id="autore"><span class="infoItem">Autore:</span> </div>
               <div id="genere"><span class="infoItem">Genere:</span> </div>
                <div id="stato"><span class="infoItem">Stato:</span> </div>
                <div id="luogo"><span class="infoItem">Luogo:</span> </div>
            </div>
           
           <div id=prenotazione>
               Prenota
           </div>
        </div>
    
    
    
    <script type="text/javascript">
        function handleResponse(response) {
        var item = response.items[0];
            
        document.getElementById("titolo").innerHTML= item.volumeInfo.title;
        document.getElementById("genere").innerHTML += item.volumeInfo.categories[0];
            
        document.getElementById("autore").innerHTML += item.volumeInfo.authors[0];
        var w= document.getElementById("copertina").clientWidth;
        var h = document.getElementById("copertina").clientHeight;
        document.getElementById("copertina").innerHTML=  '<img alt="copertina" src="'+item.volumeInfo.imageLinks.thumbnail+'" width="'+w+'" height="'+h+'">';
      
        }
        
    </script>
    <?php
     echo '<script type="text/javascript" src="https://www.googleapis.com/books/v1/volumes?q=isbn:'.$_GET['isbn'].'&callback=handleResponse"></script>';
    $con = mysqli_connect(SERVER,USER,PSW);
    mysqli_select_db($con,DB);
    $email = $_SESSION["email"];
    $query = "SELECT * FROM librocondiviso  WHERE isbn='".$_GET['isbn']."' AND proprietario='".$email."';";
    $res = mysqli_query($con,$query);
    $libro = mysqli_fetch_assoc($res);
    
    //----- OTTENGO INDIRIZZO------
    $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=".$libro['latitudine'].",".$libro['longitudine'];
    $resp_json = file_get_contents($url);
    $resp = json_decode($resp_json, true);
    $formatted_address = $resp['results'][0]['formatted_address'];
    echo '<script>document.getElementById("luogo").innerHTML += "'.$formatted_address.'";</script>';

    //----OTTENGO STATO PRESTITATO/NO -----
    $query = "SELECT *
    FROM librocondiviso INNER JOIN prestiti
    ON librocondiviso.isbn = prestiti.isbn AND librocondiviso.proprietario = prestiti.proprietario
    WHERE librocondiviso.isbn='".$_GET['isbn']."' AND librocondiviso.proprietario='".$email."';";
    $res = mysqli_query($con,$query);
    $rowcount = mysqli_num_rows($res);
    if($rowcount!=0){
        echo '<script>document.getElementById("stato").innerHTML += "Prestato";
        document.getElementById("prenotazione").innerHTML = "Avvisami appena disponibile";
        </script>';
    }
    else{
        echo '<script>document.getElementById("stato").innerHTML += "Disponibile";
        document.getElementById("prenotazione").innerHTML = "Prenota";</script>';
    }

    ?>
    
</body>
</html>