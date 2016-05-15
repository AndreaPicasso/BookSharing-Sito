<?php   
require("php/privateSectionsControl.php");
require("parts/header.php");
 require("php/parameters.php");?>

   <div id="main">
        <?php require("parts/banner_account.php"); ?>
        <div id="container_home">
            <span id="chat_container">
                 <span id="chat_content">
                     <!--
                    <div class="chatmessagesend">
                        Messaggio inviato
                    </div>
                    <div class="chatmessagerecieved">
                        Messaggio ricevuto
                    </div>
                     -->
                </span>
                <div id="writemessage">
                    <form  action="" method="post" >
                        <input type="text" id="message" name="message" placeholder="Scrivi qui il tuo messaggio">
                       
                        <br>   
                        <input type="submit" id="sendbutton" name="sendbutton" value="Invia" >   
                    </form>
                </div>
            </span>
            <span id="chatlist">
                <?php addChat(); ?>
            </span>
    
        </div>
    
         
    </div>

    <script type="text/javascript">
        /* CHIAMATA AJAX */
        function riempiChat(other) {
        var chat = document.getElementById("chat_content");
        chat.innerHTML = synchcall(other);  
    }

        function synchcall(other) {  
            
        xhr = getXMLHttpRequestObject();

        xhr.open("POST", "php/riempiChat.php/?other="+other, false);

            xhr.send(); 
 

        if (xhr.readyState==4 && xhr.status==200) { 
              out = xhr.responseText; 
              return out;
            }
        else 
            return "Error<br/><strong>Code:</strong> " + xhr.status + "<br/><strong>Reason:<strong> " + xhr.statusText;
    }
        
        
    </script>
  </body>

<?php
    function addChat(){
        $con = mysqli_connect(SERVER,USER,PSW);
        mysqli_select_db($con,DB);
        $email = $_SESSION['email'];
        $query_mittente = 'SELECT DISTINCT destinatario
                FROM message
                WHERE mittente="'.$email.'" ;';
         $query_destinatario = 'SELECT DISTINCT mittente
                FROM message
                WHERE destinatario="'.$email.'"
                AND mittente NOT IN
                    (SELECT DISTINCT destinatario
                    FROM message
                    WHERE mittente="'.$email.'");';
        $res = mysqli_query($con,$query_mittente);
        $numrows= mysqli_num_rows($res);
        for($i = 0; $i<$numrows; $i++){
            $row = mysqli_fetch_assoc($res);
            $mod = $i%2;
            echo '<div class="listelement'.$mod.'" onclick="riempiChat(\''.$row['destinatario'].'\')">'.$row['destinatario'].'</div>';
        }
        $res = mysqli_query($con,$query_destinatario);
        $numrows= mysqli_num_rows($res);
        for($i = 0; $i<$numrows; $i++){
            $row = mysqli_fetch_assoc($res);
            $mod = $i%2;
            echo '<div class="listelement'.$mod.'" onclick="riempiChat(\''.$row['mittente'].'\')">'.$row['mittente'].'</div>';
        }
    }



    /*
    function ajaxRiempiChat($other){
        $email = $_SESSION['email'];
        $query = 'SELECT *
        FROM message
        WHERE (mittente="'.$email.'" AND destinatario="'.$other.'")
        OR (destinatario="'.$email.'" AND mittente="'.$other.'")
        ORDER BY datames;';
        $res = mysqli_query($con,$query);
        $numrows= mysqli_num_rows($res);
        for($i = 0; $i<$numrows; $i++){
            $row = mysqli_fetch_assoc($res);
            if(strcmp($row['destinatario'],$email)==0){
                $id="chatmessagerecieved";
            }
            else{   
                $id="chatmessagesend";
            }
            echo '<div id="'.$id.'">'.$row['testo'].'</div>';
        }
    }
    */
?>
</html>