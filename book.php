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
        function handleMapsResponse(response){
            var item = response.results[0];
            document.getElementById("luogo").innerHTML += item.formatted_address;
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
    echo '<script type="text/javascript" src="https://maps.googleapis.com/maps/api/geocode/json?latlng='.$libro['latitudine'].','.$libro['longitudine'].'&callback=handleMapsResponse"></script>';
        
    ?>
    
</body>


</html>