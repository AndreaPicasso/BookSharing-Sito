
    <script type="text/javascript">
        //--------------- INSERISCI LIBRO ----------------------------------------------
        /*
        1) php, prendo la richiesta
        2) verifico su google se il libro esiste
        3) prendo la posizione corrente
        4) faccio una chiamata AJAX per inserire il libro
        */
        function handleResponse(response) {
        if(response.totalItems!=0){
                j=-1;
                if(response.items[0].volumeInfo.industryIdentifiers[0].type == "ISBN_13")
                    j=0;
                else if(response.items[0].volumeInfo.industryIdentifiers[1].type == "ISBN_13")
                    j=1;
                if(j!=-1){
                        isbn = response.items[0].volumeInfo.industryIdentifiers[j].identifier;
                        console.log(isbn);
                    if (navigator.geolocation) {
                        //PER ESSERE CHIAMATA RICHIEDE IL PROTOCOLLO HTTPS
                        navigator.geolocation.getCurrentPosition(asyncCall);
                    } else { 
                        window.alert("Geolocazizzazione non supportata.");
                    }
                }
            else{
                  window.alert("ISBN non trovato.");
            }     
        }
        else{
                  window.alert("ISBN non trovato.");
        }
        
    }
        
    function asyncCall(position) {
                    var lat = position.coords.latitude;
                    var lon = position.coords.longitude;
                    //console.log(lat+" "+lon);
                    xhr = getXMLHttpRequestObject();
                    console.log("ok");
                    var url = 'php/addBook.php?isbn='+isbn+'&lat='+lat+'&lon='+lon;
                    xhr.onreadystatechange = alertContents;
                    xhr.open('GET', url, true);
                    xhr.send();
    }
        
    function alertContents() {
        if (xhr.readyState == 4) {
                 if (xhr.status == 200) {
                    window.alert(xhr.response);
                  }
                  else {
                    alert('There was a problem with the request.');
                 }    
            }
        }

    </script>

    <?php
    require_once("php/privateSessionControl.php");
    
    if(isset($_POST['inseriscilibro'])){
        $isbn = $_POST['isbn'];
        if(!strcmp(trim($isbn),"")==0){
            echo '<script type="text/javascript" src="https://www.googleapis.com/books/v1/volumes?q=isbn:'.$isbn.'&key='.APIkey.'&callback=handleResponse">
            </script>';
        }
        else
        {
            echo '<script type="text/javascript">window.alert("ISBN vuoto")</script>';   
        }
    }
    ?>