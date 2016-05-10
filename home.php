<!DOCTYPE html>
<html>
<head>
   <title>Book Sharing</title>
    <link rel="stylesheet" href="css/all.css" type="text/css">
    <link rel="stylesheet" href="css/home.css" type="text/css">
</head>
<body>
      
    <div id="main">
        
        <?php include("parts/header.php") ?>
        <div id="container">
            <div id="content">
               <?php include("parts/slider.php") ?>
            </div>
                <div id="cerca">
                   <form  action="" method="post" >
                        <input type="text" id="titolo" name="titolo" placeholder="Titolo">
                        <input type="text" id="autore" name="autore" placeholder="Autore">       
                        <input type="text" id="isbn" name="isbn" placeholder="ISBN">
                        <input type="checkbox" id="disponibile" value="Solo disponibili" name="disponibile" >
                        <br>   
                        <input  type="submit" id="movebutton" name="cerca" value="Cerca" >   
                    </form>
                </div>
         
        </div>
    </div>
    
</body>
</html>