<!DOCTYPE html>
<html>
<head>
    <title>Book Sharing</title>
    <link rel="stylesheet" href="css/all.css" type="text/css">
    <link rel="stylesheet" href="css/book.css" type="text/css">
</head>
    
<body>
        
        <? php require("php/privateSectionsControl.php"); ?>
        <?php include("parts/header.php") ?>
        <?php
            if(!isset($_GET['isbn']))
               header("Location: index.php");        
        ?>
        
  
    
    <!-- SECONDO ME VERREBBR MEGLIO FATTO CON UNA TABELLA -->
       <div id="content">
           <div id="titolo">Titolo</div>
           <div id="copertina"> copertina</div>
           <div id="descrizione"> Descrizione</div>
           
           
           <div id="info">
               <div id="genere"><b>Genere: </b></div>
                <div id="stato">Stato: </div>
                <div id="luogo">Luogo: </div>
            </div>
        </div>
    
    

    <script type="text/javascript">
        function handleResponse(response) {
        var item = response.items[0];
        // in production code, item.text should have the HTML entities escaped.
            
        document.getElementById("titolo").innerHTML= item.volumeInfo.title;
        document.getElementById("genere").innerHTML += item.volumeInfo.categories[0];
        var w= document.getElementById("copertina").clientWidth;
        var h = document.getElementById("copertina").clientHeight;
            console.log("Titolo: "+w+" "+h);
        document.getElementById("copertina").innerHTML=  '<img alt="copertina" src="'+item.volumeInfo.imageLinks.thumbnail+'" width="'+w+'" height="'+h+'">';


      
    }
    </script>
    <?php
     echo '<script type="text/javascript" src="https://www.googleapis.com/books/v1/volumes?q=isbn:'.$_GET['isbn'].'&callback=handleResponse"></script>';
    ?>
    
</body>


</html>