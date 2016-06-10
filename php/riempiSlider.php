<?php
        /* Global */
        $books;
    function riempiSlider($isbn,$titolo,$autore,$disponibili){
        //linko costanti da altro file
        
        require("php/parameters.php");
        $con = mysqli_connect(SERVER,USER,PSW);
        mysqli_select_db($con,DB);
        
        echo '<script type="text/javascript">
                document.getElementById("slider").innerHTML="";</script>';
                
        // ----------------- COSTRUISCO QUERY RICERCA ---------------------
        if(strcmp($isbn,"")!=0){
            $isbn = mysqli_real_escape_string($con,$_POST["isbn"]);
            $isbn = " isbn ='".$isbn."'";
        }
        /*
        //POSIZIONE
        if(strcmp($minLat,"")!=0 &&
            strcmp($maxLat,"")!=0 &&
          strcmp($minLon,"")!=0 &&
          strcmp($maxLon,"")!=0){
            $minLat = mysqli_real_escape_string($con,$_POST["minLat"]);
            $minLon = mysqli_real_escape_string($con,$_POST["minLon"]);
            $maxLat = mysqli_real_escape_string($con,$_POST["maxLat"]);
            $maxLon = mysqli_real_escape_string($con,$_POST["maxLon"]);
            
            $checkPos=" latitudine<= '".$maxLat."' AND latitudine>= '".$minLat."'AND longitudine<= '".$maxLon."' AND longitudine>= '".$minLon."'";
        }
        else{
            $checkPos="";
        }
        */
        $checkPos="";
        if(!strcmp($disponibili,"")==0)
             $disponibili = " isbn NOT IN(SELECT isbn FROM prestiti p WHERE p.proprietario= l.proprietario)";
        else
            $disponibili="";
        
        // Costruisco condizione:
        $isSetIsbn= !strcmp($isbn,"")==0;
        $isSetPos = !strcmp($checkPos,"")==0;
        $isSetDisp = !strcmp($disponibili,"")==0;
        
        if($isSetIsbn && $isSetPos && $isSetDisp)
            $cond = "WHERE ".$isbn." AND ".$checkPos." AND ".$disponibili;
        if($isSetIsbn && $isSetPos && !$isSetDisp)
            $cond = "WHERE ".$isbn." AND ".$checkPos;
        if($isSetIsbn && !$isSetPos && $isSetDisp)
            $cond = "WHERE ".$isbn." AND ".$disponibili;
        if($isSetIsbn && !$isSetPos && !$isSetDisp)
            {$cond = "WHERE ".$isbn;}
        if(!$isSetIsbn && $isSetPos && $isSetDisp)
            $cond = "WHERE ".$checkPos." AND ".$disponibili;
        if(!$isSetIsbn && $isSetPos && !$isSetDisp)
            $cond = "WHERE ".$checkPos;
        if(!$isSetIsbn && !$isSetPos && $isSetDisp)
            $cond = "WHERE ".$disponibili;
        if(!$isSetIsbn && !$isSetPos && !$isSetDisp)
            $cond = "";
        

        $query = "SELECT * FROM librocondiviso l ".$cond.";";
        echo '<script>console.log("'.$query.'");</script>';
        
        
        //-------------------- MANDO UNA RICHIESTA A GOOGLE PER OGNI ISBN, PER OTTENERE LE INFORMAZIONI -------
        /* ho comunque bisogno di mandare una richiesta per ogni libro nel db, in quanto in caso di ricerca devo poter cercare
        nel titolo/autore di ogni libro */
        $res = mysqli_query($con,$query);
        if($res){
            $books=$res;
            $rowcount = mysqli_num_rows($res);
            $rowdim = $rowcount-1;
            $titolo = strtoupper(trim($titolo));
            if(strcmp($titolo,"")!=0){
                $titolo='+intitle:'.$titolo;
            }
             if(strcmp($autore,"")!=0){
                $autore='+inauthor:'.$autore;
            }
            $autore = strtoupper(trim($autore));
            echo    '<script type="text/javascript">nLibri='.$rowdim.'; cont=0; contInSlider=0; go=true;
                    </script>';
            //titolo="'.$titolo.'"; autore="'.$autore.'"; 
            if($rowcount!=0){
                for($i=0;$i<$rowcount; $i++){
                    $row = mysqli_fetch_assoc($res);
                    echo '<script>propr = "'.$row['proprietario'].'"; </script>';
                    echo '<script type="text/javascript" src="https://www.googleapis.com/books/v1/volumes?q=isbn:'.$row['isbn'].$titolo.$autore.'&callback=handleResponse">
                   </script>';
                    // Handle Response NON è un altro thread, è ricorsiva, qui lo script chiama quella funzione, attende la riposta
                    // chiama handleResponse e poi continua
            }
        }

    }
    }
    ?>
    
    
  <script type="text/javascript">
    
        function handleResponse(response) {
        if(go){
           slider = document.getElementById("slider");
            if(response.totalItems!=0){
            var item = response.items[0];
                if(item.volumeInfo.hasOwnProperty("imageLinks"))
                    copertina = item.volumeInfo.imageLinks.thumbnail;
                else
                    copertina = "../res/not_available.png";
                if(item.volumeInfo.industryIdentifiers[0].type =="ISBN_13")
                    i=0;
                else 
                    i=1;
                isbn = item.volumeInfo.industryIdentifiers[i].identifier;
                //console.log(isbn+" "+propr);
                slider.innerHTML += "<div style='display: none;'><a href='book.php?isbn="+isbn+"&propr="+propr+"'><img data-u='image' id='"+isbn+"' src='"+copertina+"'/></a></div>";
                contInSlider++;
            }
            //console.log(cont+" "+nLibri);
            if(cont==nLibri || contInSlider==10 ){
                    jssor_1_slider_init();
                    go=false;
                }
                cont++;
        }

    }
                
                
     
</script>