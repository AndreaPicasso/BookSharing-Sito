<script>
    function esciAccount(){
        window.location = 'home.php';
          
      }
    function logout(){
         window.location = 'index.php';
    }
        
    
</script>
<link rel="stylesheet" href="css/header.css" type="text/css">
<div id="header">
            <span id ="logo">
            <img src="res/scritta.png" alt="Logo"/> 
             
            </span>
            <span >
                <input type="button" id="movebutton" value="LOGOUT" onClick="logout();">  
               <input id="movebutton" type="button" value="HOME" onClick="esciAccount();">   
                 
            </span>
</div>
