    

<?php
            require("parts/header.php");
           ?>

    <script>
    function registrati(){
        window.location = 'registration.php';
          
      }
</script>
<style>
    li{
    margin: 1vh 0;
    }
    .container_comefunziona{
        position:absolute;
                        top:50%;
                        left:50%;
                        /* uso margini negativi pari a metà altezza/larghezza
                        per avere riferimento al centro del form */
                        margin-top:-20vh;
                        margin-left:-18vw;
    }
</style>
    <div id="main">
        <div id="header">
            <div id ="logo">
            <img src="res/scritta.png" alt="Logo"/>  
            </div>
            <div id="container_home">
            <div class="container_comefunziona">
                <div class="title">Come funziona:</div>
                <ul>
                    <li class="singlelink">Registrati</li>
                    <li class="singlelink">Trova i libri che più ti piacciono</li>
                    <li class="singlelink">Contatta gli altri utenti per averli in prestito</li>
                    <li class="singlelink">Condividi i tuoi libri</li>
                
                </ul>
                
                <input type="button" class="movebutton" value="Registrati" onClick="registrati();">
                </div>
        </div>
        
    
</body>
</html>