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
        
        if(!strcmp($disponibili,""))
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
                    

            }
        }

    }
    }
    ?>
    

  <script type="text/javascript">
        function handleResponse(response) {
           slider = document.getElementById("slider");
            if(response.totalItems!=0){
            var item = response.items[0];
                if(item.volumeInfo.hasOwnProperty("imageLinks"))
                    copertina = item.volumeInfo.imageLinks.thumbnail;
                else
                    copertina = "../res/not_available.png";
                isbn = item.volumeInfo.industryIdentifiers[0].identifier;
                    slider.innerHTML += "<div style='display: none;'><a href='book.php?isbn="+isbn+"'><img data-u='image' id='"+isbn+"' src='"+copertina+"'/></a></div>";
            }
        if(cont!=nLibri)
            cont++;
        else
            jssor_1_slider_init();

        
                
                /*
        document.getElementById("titolo").innerHTML= item.volumeInfo.title;
        document.getElementById("genere").innerHTML += item.volumeInfo.categories[0];
        var w= document.getElementById("copertina").clientWidth;
        var h = document.getElementById("copertina").clientHeight;
            console.log("Titolo: "+w+" "+h);
        document.getElementById("copertina").innerHTML=  '<img alt="copertina" src="'+item.volumeInfo.imageLinks.thumbnail+'" width="'+w+'" height="'+h+'">';
            */
    }
     
      /* AJAX
      function bookHandler(book){
          var xhttp = new XMLHttpRequest();
          if (xhttp.readyState == 4 && xhttp.status == 200) {
       // Action to be performed when the document is read;
        }
      };
      xhttp.open("GET", "filename", true);
      xhttp.send();
        window.location = 'book.php/?isbn='+book.id;
          
      }
      */
</script>