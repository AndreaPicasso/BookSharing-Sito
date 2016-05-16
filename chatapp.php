<?php   

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
                    <form  action="#" method="post" >
                        Destinatario: <input readonly="text" id="destinatario" name="destinatario" value="">
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
        var dest = document.getElementById("destinatario");
            dest.value =other;
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
    //set up page
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
             //Riempi la chat con il primo
            /*
            if($i==0)
                $toShow = $row['destinatario'];
                */
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

?>

<?php
 //send message
if(isset($_POST['sendbutton'])){
    $text = $_POST['message'];
    $dest = $_POST['destinatario'];
    $email = $_SESSION['email'];
    $ok=true;
    if(strcmp($dest,"")==0){
        echo '<script type="text/javascript">window.alert("Nessun destinatario selezionato")</script>';
        $ok = false;
    }
    if(strcmp($text,"")==0){
        echo '<script type="text/javascript">window.alert("Impossibile inviare un messaggio vuoto")</script>';
        $ok=false;
    }
    if($ok){
         $con = mysqli_connect(SERVER,USER,PSW);
        mysqli_select_db($con,DB);
        $text = mysqli_real_escape_string($con,$text);
        $query = "INSERT INTO message (mittente, destinatario, testo, datames) VALUES ('".$email."','".$dest."','".$text."',FROM_UNIXTIME(".time()."));";
        $res = mysqli_query($con,$query);
        echo '<script type="text/javascript">riempiChat(\''.$dest.'\')</script>';
    }
}

?>
</html>