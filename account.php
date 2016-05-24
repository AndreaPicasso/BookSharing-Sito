    <?php       
                require("parts/header.php");
                require("parts/banner_account.php");
                require("php/privateSectionsControl.php");
                require("php/parameters.php");
       ?>  

<div id="main">
        <div id="container_home">
        <div id="account">
            <span id="details">
                <form  action="#" method="post" >
                <table><tr>
                <?php
                    $con = mysqli_connect(SERVER,USER,PSW);
                    mysqli_select_db($con,DB);
                    $email = $_SESSION["email"];
                    $query = "SELECT * FROM user  WHERE email='".$email."';";
                    $res = mysqli_query($con,$query);
                    $user = mysqli_fetch_assoc($res);
                echo '<td><input type="text" id="nome" name="nome" value="'.$user["nome"].'" placeholder="Nome"></td>';
                echo '<td><input type="text" id="cognome" name="cognome" value="'.$user["cognome"].'" placeholder="Cognome"></td>';
                echo '</tr><tr>';
                if(strcmp($user["sesso"],"")==0)
                    echo '<td>Sesso:<input type="text" id="sesso" name="sesso" placeholder="Sesso"></td>';
                else
                    echo '<td>Sesso:<input type="text" id="sesso" name="sesso" value="'.$user["sesso"].'" placeholder="Sesso"></td>';

                 if(strcmp($user["genere"],"")==0)
                    echo '<td>Genere preferito:<input type="text" id="genere" name="genere" placeholder="Genere"></td>';
                else
                    echo '<td>Genere preferito:<input type="text" id="genere" name="genere" value="'.$user["genere"].'" placeholder="Genere"></td>';
                echo '</tr>';
                echo '<tr><td><input type="password" id="password" name="password" placeholder="Password"></td></tr>';
                ?>
                </table>
                <br>   
                <input type="submit" id="modifica" name="modifica" value="Modifica"> 
            </form>
            </span>
            <span id="insertbook">
                <form action="#" method="post">
                    <input type="text" id="isbn" name="isbn" placeholder="ISBN" onclick="">
                    <input type="submit" id="inseriscilibro" name="inseriscilibro" value="Inserisci un nuovo libro"> 
                </form>
            </span>
         </div>
        <div style="width:100%;">
            <div id="libri">
                LIBRI IN LETTURA
                <table>
                    <tr>
                        <td>ISBN</td><td>Data</td><td>Proprietario</td><td>Valuta</td><td>Restituisci</td>
                    </tr>
            <?php
            //-- Libri in lettura 
                $con = mysqli_connect(SERVER,USER,PSW);
                mysqli_select_db($con,DB);
                $email = $_SESSION["email"];
                $query = "SELECT * FROM prestiti  WHERE richiedente='".$email."' AND stato!='storico';";
                $res = mysqli_query($con,$query);
                $numrows= mysqli_num_rows($res);
                for($i = 0; $i<$numrows; $i++){
                    $row = mysqli_fetch_assoc($res);
                     $starsHtml ='<span class="rating">
                            <input type="radio" class="rating-input"
                                id="rating-input-1-5" name="rating-input-1" onclick="valuta(5,'.$row['proprietario'].')">
                            <label for="rating-input-1-5" class="rating-star"></label>
                            <input type="radio" class="rating-input"
                                id="rating-input-1-4" name="rating-input-1" onclick="valuta(4,'.$row['proprietario'].')">
                            <label for="rating-input-1-4" class="rating-star"></label>
                            <input type="radio" class="rating-input"
                                id="rating-input-1-3" name="rating-input-1" onclick="valuta(3,'.$row['proprietario'].')">
                            <label for="rating-input-1-3" class="rating-star"></label>
                            <input type="radio" class="rating-input"
                                id="rating-input-1-2" name="rating-input-1" onclick="valuta(2,'.$row['proprietario'].')">
                            <label for="rating-input-1-2" class="rating-star"></label>
                            <input type="radio" class="rating-input"
                                id="rating-input-1-1" name="rating-input-1" onclick="valuta(1,'.$row['proprietario'].')">
                            <label for="rating-input-1-1" class="rating-star"></label>
                        </span>';
                    
                    echo    '<tr>
                            <td>'.$row['isbn'].'</td>
                            <td>'.$row['dataprestito'].'</td>
                            <td>'.$row['proprietario'].'</td>
                            <td>'.$starsHtml.'</td>
                            <td><input type="button" id="restituisciLibro" onclick="restituisci('.$row['isbn'].')" value="Restituisci"> </td>
                            </tr>';
                
                }
                    
                
                
            ?>
                    </table>
            </div>  
            <div id="libri">
            LIBRI IN PRESTITO
                            <table>
                    <tr>
                        <td>ISBN</td><td>Data</td><td>Richiedente</td><td>Valuta</td><td>Conferma Restituzione</td>
                    </tr>
            <?php
            //-- Libri in prestito 
                $con = mysqli_connect(SERVER,USER,PSW);
                mysqli_select_db($con,DB);
                $email = $_SESSION["email"];
                $query = "SELECT * FROM prestiti  WHERE richiedente='".$email."' AND stato!='storico';";
                $res = mysqli_query($con,$query);
                $numrows= mysqli_num_rows($res);
                for($i = 0; $i<$numrows; $i++){
                    $row = mysqli_fetch_assoc($res);
                     $starsHtml ='<span class="rating">
                            <input type="radio" class="rating-input"
                                id="rating-input-1-5" name="rating-input-1" onclick="valuta(5,'.$row['proprietario'].')">
                            <label for="rating-input-1-5" class="rating-star"></label>
                            <input type="radio" class="rating-input"
                                id="rating-input-1-4" name="rating-input-1" onclick="valuta(4,'.$row['proprietario'].')">
                            <label for="rating-input-1-4" class="rating-star"></label>
                            <input type="radio" class="rating-input"
                                id="rating-input-1-3" name="rating-input-1" onclick="valuta(3,'.$row['proprietario'].')">
                            <label for="rating-input-1-3" class="rating-star"></label>
                            <input type="radio" class="rating-input"
                                id="rating-input-1-2" name="rating-input-1" onclick="valuta(2,'.$row['proprietario'].')">
                            <label for="rating-input-1-2" class="rating-star"></label>
                            <input type="radio" class="rating-input"
                                id="rating-input-1-1" name="rating-input-1" onclick="valuta(1,'.$row['proprietario'].')">
                            <label for="rating-input-1-1" class="rating-star"></label>
                        </span>';
                    
                    echo    '<tr>
                            <td>'.$row['isbn'].'</td>
                            <td>'.$row['dataprestito'].'</td>
                            <td>'.$row['proprietario'].'</td>
                            <td>'.$starsHtml.'</td>
                            <td><input type="button" id="restituisciLibro" onclick="restituisci('.$row['isbn'].')" value="Restituisci"> </td>
                            </tr>';
                
                }
                    
                
                
            ?>
                
                
            </div>  
        </div>
    </div>
</div>
    <?php
    require("php/accountModificaDati.php");
    require("php/accountInserisciLibro.php");
    ?>




    





  </body>
</html>