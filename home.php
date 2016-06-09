    <?php require("php/privateSessionControl.php");
            require("parts/header.php");
            require("parts/banner.php");?>

    <div id="main">
            <div id="container_home">
            <div id="content_home">
               <?php include("parts/slider.php"); ?>
            </div>
                <div id="cerca">

                   <form class="form_home"  action="" method="post" >
                        <input class="input_home" type="text" name="titolo" placeholder="Titolo">
                        <input class="input_home" type="text" name="autore" placeholder="Autore">       
                        <input class="input_home" type="text" name="isbn" placeholder="ISBN">
                        Solo disponibili: <input class="input_home" type="checkbox" value="Solo disponibili" name="disponibile" >
                        <br>   
                        <input  type="submit" class="movebutton" name="cerca" value="Cerca" >   
                    </form>
                </div>
        </div>
        
        <?php
            if(isset($_POST['cerca'])){
                if(isset($_POST['disponibile']))
                    $disp=true;
                else
                    $disp="";

            riempiSlider($_POST['isbn'], $_POST["titolo"],$_POST["autore"],$disp);
            }
        else
            riempiSlider("","","","");
        ?>
    
</body>
</html>