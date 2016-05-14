<?php   
require("php/privateSectionsControl.php");
require("parts/header.php"); ?>

   <div id="main">
        <?php require("parts/banner_account.php"); ?>
        <div id="container_home">
            <span id="chat">
                <div id="chatmessagesend">
                    Messaggio inviato
                </div>
                <div id="chatmessagerecieved">
                    Messaggio ricevuto
                </div>
                <div id="writemessage">
                    <form  action="" method="post" >
                        <input type="text" id="message" name="message" placeholder="Scrivi qui il tuo messaggio">
                       
                        <br>   
                        <input type="submit" id="sendbutton" name="sendbutton" value="Invia" >   
                    </form>
                </div>
            </span>
            <span id="chatlist">
                <div id="listelement1">
                    Mario Rossi
                </div>
                 <div id="listelement2">
                    Alessio Merlo
                </div>
            </span>
    
        </div>
    
         
    </div>
    
    
        
    
    
  </body>
</html>