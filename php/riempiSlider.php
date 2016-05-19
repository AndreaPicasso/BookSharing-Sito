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
            echo    '<script type="text/javascript">nLibri='.$rowdim.'; cont=0;
                    </script>';
            //titolo="'.$titolo.'"; autore="'.$autore.'"; 
            if($rowcount!=0){
                for($i=0;$i<$rowcount; $i++){
                    $row = mysqli_fetch_assoc($res);
                    echo '<script type="text/javascript" src="https://www.googleapis.com/books/v1/volumes?q=isbn:'.$row['isbn'].$titolo.$autore.'&callback=handleResponse"></script>';
                    $ISBNs[$row['isbn']] = $row['proprietario'];
                    /*
                    $url = "https://www.googleapis.com/books/v1/volumes?q=isbn:".$row['isbn'].$titolo.$autore;
                    $resp_json = file_get_contents($url);
                    $resp = json_decode($resp_json, true);
                    echo '<script type="text/javascript">handleResp2("'.$row['isbn'].'","'.$row['proprietario'].'");</script>';
            */
            }
        }

    }
    }
    ?>
    
    
  <script type="text/javascript">
      /*
     function handleResp2(isbn,propr) {
            response = <
           slider = document.getElementById("slider");
            if(response.totalItems!=0){
            var item = response.items[0];
                if(item.volumeInfo.hasOwnProperty("imageLinks"))
                    copertina = item.volumeInfo.imageLinks.thumbnail;
                else
                    copertina = "../res/not_available.png"; 
                slider.innerHTML += "<div style='display: none;'><a href='book.php?isbn="+isbn+"&proprietario="+propr+"'><img data-u='image' id='"+isbn+"' src='"+copertina+"'/></a></div>";
            }
        if(cont!=nLibri)
            cont++;
        else
            jssor_1_slider_init();

    }
      
      */
      // ---- DEVO INVIARE ANCHE IL PROPRIETARIO, E L'ISBN SAREBBE MEGLIO FOSSE QUELLO DEL LIBRO.
        function handleResponse(response) {
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
                slider.innerHTML += "<div style='display: none;'><a href='book.php?isbn="+isbn+"'><img data-u='image' id='"+isbn+"' src='"+copertina+"'/></a></div>";
            }
        if(cont!=nLibri)
            cont++;
        else
            jssor_1_slider_init();

    }
                
                
     
</script>