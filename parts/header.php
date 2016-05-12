
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
<link rel="stylesheet" href="css/header.css" type="text/css">
<div id="header">
            <span id ="logo">
            <img src="res/scritta.png" alt="Logo"/> 
             
            </span>
            <span >
               <input type="button" id="movebutton" value="LOGOUT" onClick="logout();">

                 <input type="button" id="movebutton" value="CHAT" onClick="chat();"> 
               <input id="movebutton" type="button" value="ACCOUNT" onClick="entraAccount();">  
                  
                 
            </span>
</div>
