<script>
    function esciAccount(){
        window.location = 'home.php';
          
      }
    function logout(){
         window.location = 'index.php';
    }
    
        
    
</script>
<div id="header">
            <span id ="logo">
            <img src="res/scritta.png" alt="Logo"/> 
             
            </span>
            <span >
                <input type="button" class="movebutton" value="LOGOUT" onClick="logout();"> 
                 
               <input class="movebutton" type="button" value="HOME" onClick="esciAccount();">   
                 
            </span>
</div>
