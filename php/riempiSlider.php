<?php
        
    function riempiSlider($isbn, $minLat,$maxLat,$minLon,$maxLon,$disponibili){
        require("php/parameters.php");
        $con = mysqli_connect(SERVER,USER,PSW);
        mysqli_select_db($con,DB);
        
        echo '<script type="text/javascript">
                document.getElementById("slider").innerHTML="";</script>';
        if(strcmp($isbn,"")!=0){
            $isbn = mysqli_real_escape_string($con,$_POST["isbn"]);
            $isbn = " isbn ='".$isbn."'";
        }
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
        
        if(!strcmp($disponibili,""))
            $disponibili = " NOT EXISTS(SELECT * FROM prestiti)";
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
        $query = "SELECT * FROM librocondiviso ".$cond.";";
        
        $res = mysqli_query($con,$query);
        if($res){
            $rowcount = mysqli_num_rows($res);
            $rowdim = $rowcount-1;
            echo '<script type="text/javascript">nLibri='.$rowdim.'; cont=0;</script>';
            if($rowcount!=0){
                for($i=0;$i<$rowcount; $i++){
                    $row = mysqli_fetch_assoc($res);
                     echo '<script type="text/javascript" src="https://www.googleapis.com/books/v1/volumes?q=isbn:',$row['isbn'].'&callback=handleResponse"></script>';
            }
        }

    }
    }
    ?>
    

  <script type="text/javascript">
        function handleResponse(response) {
           slider = document.getElementById("slider");
            var item = response.items[0];
            if(item.volumeInfo.hasOwnProperty("imageLinks"))
                copertina = item.volumeInfo.imageLinks.thumbnail;
            else
                copertina = "../res/not_available.png";
        isbn = item.volumeInfo.industryIdentifiers[0].identifier;
        slider.innerHTML += "<div style='display: none;'><img data-u='image' id='"+isbn+"' src='"+copertina+"' onclick='bookHandler(this)'/></div>";
        /*
        console.log("nLibri: "+nLibri);                    console.log("cont: "+cont);
        */
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
      
      function bookHandler(book){
        window.location = 'book.php/?isbn='+book.id;
          
      }
      
</script>