<?php     
        if(!isset($_GET['isbn'])){
               header("Location: ../index.php"); 
            }
        require("php/privateSectionsControl.php");
        ?>
<!DOCTYPE html>
<html>
<head>
    <title>Book Sharing</title>
    <link rel="stylesheet" href="../css/all.css" type="text/css">    
    <link rel="stylesheet" href="../css/book.css" type="text/css">
    <link rel="stylesheet" href="../css/header.css" type="text/css">

    
</head>
    
<body>
<script>
    function entraAccount(){
        window.location = '../account.php';
          
      }
    function logout(){
         window.location = '../index.php';
          
      }

    function chat(){
         window.location = '../chat.php';
    }
        
    
</script>
<div id="header">
            <span id ="logo">
            <img src="../res/scritta.png" alt="Logo"/> 
             
            </span>
            <span >
               <input type="button" class="movebutton" value="LOGOUT" onClick="logout();">

                 <input type="button" class="movebutton" value="CHAT" onClick="chat();"> 
               <input class="movebutton" type="button" value="ACCOUNT" onClick="entraAccount();">  
                  
                 
            </span>
</div>
        

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
    
    
    
    ?>
    
</body>


</html>