<html>
  <head>
    <title>Account</title>
      <link rel="stylesheet" href="css/all.css" type="text/css">
      <link rel="stylesheet" href="css/home.css" type="text/css">
    <link rel="stylesheet" href="css/account.css" type="text/css">
  </head>
  <body>
   <div id="main">
        
        <?php include("parts/headeraccount.php") ?>
        <div id="container">
        <div id="account">
            <span id="details">
                <form  action="" method="post" >
                <input type="text" id="nome" name="nome" placeholder="Nome">
                <input type="text" id="cognome" name="cognome" placeholder="Cognome">
                <input type="text" id="sesso" name="sesso" placeholder="Sesso">
                <input type="text" id="genere" name="genere" placeholder="Genere">
                <input type="password" id="password" name="password" placeholder="Password">
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
    
    
        
    
    
  </body>
</html>