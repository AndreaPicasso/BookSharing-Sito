<script>
    function entraAccount(){
        window.location = 'account.php';
          
      }
    function logout(){
         window.location = 'index.php';
          
      }

    function chat(){
         window.location = 'chat.php';
    }
        
    
</script>
<div id="header">
            <span id ="logo">
            <img src="res/scritta.png" alt="Logo"/> 
             
            </span>
            <span >
               <input type="button" class="movebutton" value="LOGOUT" onClick="logout();">

                 <input type="button" class="movebutton" value="CHAT" onClick="chat();"> 
               <input class="movebutton" type="button" value="ACCOUNT" onClick="entraAccount();">  
                  
                 
            </span>
</div>
