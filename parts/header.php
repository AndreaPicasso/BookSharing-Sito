
<script>
    function entraAccount(){
        window.location = '/HomeSeria/account.php';
          
      }
    function logout(){
         window.location = '/HomeSeria/index.php';
    }
        
    
</script>
<link rel="stylesheet" href="http://localhost/HomeSeria/css/header.css" type="text/css">
<div id="header">
            <span id ="logo">
            <img src="http://localhost/HomeSeria/res/scritta.png" alt="Logo"/> 
             
            </span>
            <span >
                <input type="button" id="movebutton" value="LOGOUT" onClick="logout();">  
               <input id="movebutton" type="button" value="ACCOUNT" onClick="entraAccount();">   
                 
            </span>
</div>
