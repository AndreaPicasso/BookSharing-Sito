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
            <div style="width:100%;">
            LIBRI IN LETTURA
            </div>  
            <div style="width:100%;">
            LIBRI IN PRESTITO
            </div>  
        </div>
    </div>
</div>
    <?php
    require("php/accountModificaDati.php");
    require("php/accountInserisciLibro.php");
    ?>
    
    <?php
    //----Riempi tabelle-------------------
    <?



    





  </body>
</html>