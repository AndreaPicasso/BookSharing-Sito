<script>
    function valuta(rating,utente){
         $.ajax({
            type: 'POST',
            url: "php/valuta.php",
            data: { 
                'rating':rating, 
                'valutato': utente,
            },
            success: function(msg){
               window.alert(msg); 
            }
        });
        
    }
    
    function restituisci(isbn,propr){
         $.ajax({
            type: 'POST',
            url: "php/restituisci.php",
            data: { 
                'isbn':isbn,
                'proprietario': propr,
            },
            success: function(msg){
               window.alert(msg); 
            }
        });
        window.location.href="account.php";
    }
        
    
    
    //Il proprietario è l'utente che clicca
    function confermaPrestito(isbn,richiedente){
            $.ajax({
            type: 'POST',
            url: "php/confermaPrestito.php",
            data: { 
                'isbn':isbn,
                'richiedente': richiedente,
            },
            success: function(msg){
               window.alert(msg); 
            }
        });
        window.location.href="account.php";
    }
    
        function rifiutaPrestito(isbn,richiedente){
            $.ajax({
            type: 'POST',
            url: "php/rifiutaPrestito.php",
            data: { 
                'isbn':isbn,
                'richiedente': richiedente,
            },
            success: function(msg){
               window.alert(msg); 
            }
        });
        window.location.href="account.php";
    }
    
    function confermaRestituzione(isbn,richiedente){
            //Qui devo controllare se ci sono prenotazioni per il libro
             $.ajax({
            type: 'POST',
            url: "php/confermaRestituzione.php",
            data: { 
                'isbn':isbn,
                'richiedente': richiedente,
            },
            success: function(msg){
               window.alert(msg); 
            }
        });
        window.location.href="account.php";
    }
    
</script>

<div id="libri">
        LIBRI IN LETTURA
        <table>
            <tr>
                <td>ISBN</td><td>Data</td><td>Proprietario</td><td>Valuta</td><td>Restituisci</td>
            </tr>
    <?php
    require_once("php/privateSectionsControl.php");
    require_once("php/parameters.php");
    //-- Libri in lettura 
        $con = mysqli_connect(SERVER,USER,PSW);
        mysqli_select_db($con,DB);
        $email = $_SESSION["email"];
        $query = "SELECT * FROM prestiti  WHERE richiedente='".$email."' AND stato='incorso';";
        $res = mysqli_query($con,$query);
        $numrows= mysqli_num_rows($res);
        for($i = 0; $i<$numrows; $i++){
            $row = mysqli_fetch_assoc($res);
            $prop = $row['proprietario'];
            
             $starsHtml ='<span class="rating">
                    <input type="radio" class="rating-input"
                        id="rating-input-1-5" name="rating-input-1">
                    <label for="rating-input-1-5" class="rating-star" onclick="valuta(5,\''.$row['proprietario'].'\');"></label>
                    <input type="radio" class="rating-input"
                        id="rating-input-1-4" name="rating-input-1">
                    <label for="rating-input-1-4" class="rating-star" onclick="valuta(4,\''.$row['proprietario'].'\');"></label>
                    <input type="radio" class="rating-input"
                        id="rating-input-1-3" name="rating-input-1">
                    <label for="rating-input-1-3" class="rating-star" onclick="valuta(3,\''.$row['proprietario'].'\');"></label>
                    <input type="radio" class="rating-input"
                        id="rating-input-1-2" name="rating-input-1">
                    <label for="rating-input-1-2" class="rating-star" onclick="valuta(2,\''.$row['proprietario'].'\');"></label>
                    <input type="radio" class="rating-input"
                        id="rating-input-1-1" name="rating-input-1">
                    <label for="rating-input-1-1" class="rating-star" onclick="valuta(1,\''.$row['proprietario'].'\');"></label>
                </span>';

            echo    '<tr>
                    <td>'.$row['isbn'].'</td>
                    <td>'.$row['dataprestito'].'</td>
                    <td>'.$row['proprietario'].'</td>
                    <td>'.$starsHtml.'</td>
                    <td><input type="button" id="restituisciLibro" onclick="restituisci('.$row['isbn'].',\''.$row['proprietario'].'\')" value="Restituisci"> </td>
                    </tr>';

        }



    ?>
            </table>
    </div>  
    <div id="libri">
    LIBRI IN PRESTITO
                    <table>
            <tr>
                <td>ISBN</td><td>Data</td><td>Richiedente</td><td>Valuta</td><td>Azione</td>
            </tr>
    <?php
    //-- Libri in prestito 
        $con = mysqli_connect(SERVER,USER,PSW);
        mysqli_select_db($con,DB);
        $email = $_SESSION["email"];
        $query = "SELECT * FROM prestiti  WHERE proprietario='".$email."' AND stato!='storico';";
        $res = mysqli_query($con,$query);
        $numrows= mysqli_num_rows($res);
        for($i = 0; $i<$numrows; $i++){
            $row = mysqli_fetch_assoc($res);
            $starsHtml ='<span class="rating">
                    <input type="radio" class="rating-input"
                        id="rating-input-1-5" name="rating-input-1">
                    <label for="rating-input-1-5" class="rating-star" onclick="valuta(5,\''.$row['richiedente'].'\');"></label>
                    <input type="radio" class="rating-input"
                        id="rating-input-1-4" name="rating-input-1">
                    <label for="rating-input-1-4" class="rating-star" onclick="valuta(4,\''.$row['richiedente'].'\');"></label>
                    <input type="radio" class="rating-input"
                        id="rating-input-1-3" name="rating-input-1">
                    <label for="rating-input-1-3" class="rating-star" onclick="valuta(3,\''.$row['richiedente'].'\');"></label>
                    <input type="radio" class="rating-input"
                        id="rating-input-1-2" name="rating-input-1">
                    <label for="rating-input-1-2" class="rating-star" onclick="valuta(2,\''.$row['richiedente'].'\');"></label>
                    <input type="radio" class="rating-input"
                        id="rating-input-1-1" name="rating-input-1">
                    <label for="rating-input-1-1" class="rating-star" onclick="valuta(1,\''.$row['richiedente'].'\');"></label>
                </span>';
            
            $azione="<td></td>";
            if(strcmp($row['stato'],"nonconfermato")==0)
                $azione = ' <td><input type="button" id="restituisciLibro" onclick="confermaPrestito('.$row['isbn'].',\''.$row['richiedente'].'\')" value="Conferma Prestito"> <input type="button" id="rifiutaPrestito" onclick="rifiutaPrestito('.$row['isbn'].',\''.$row['richiedente'].'\')" value="Rifiuta"> </td>';
            if(strcmp($row['stato'],"inrestituzione")==0)
                $azione = ' <td><input type="button" id="restituisciLibro" onclick="confermaRestituzione('.$row['isbn'].',\''.$row['richiedente'].'\')" value="Conferma Restituzione"> </td>';

            echo    '<tr>
                    <td>'.$row['isbn'].'</td>
                    <td>'.$row['dataprestito'].'</td>
                    <td>'.$row['richiedente'].'</td>
                    <td>'.$starsHtml.'</td>
                   '.$azione.'
                    </tr>';

        }

    ?>


    </div>