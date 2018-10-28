<html>
<title>Foodscout 42</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-indigo.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
body,h1,h2,h3,h4,h5,h6,p, button {font-family: "Raleway", sans-serif}

.dynamic-content {display:none;}

</style>
<body class="w3-light-grey w3-content" style="max-width:1600px">
<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-collapse w3-white w3-bar-block w3-animate-left" style="z-index:3;width:300px; height: 100%; position:absolute;" id="mySidebar"><br>
    <div class="w3-container w3-dark-grey dynamic-content default">
        <h5>Menu</h5>
    </div>
    <div class="w3-container dynamic-content montraw roma fellini">
        <div id=fellini-logo class="dynamic-content fellini">
            <img src="imgs\fellini.jpg" style="width:80%;" class="w3-round"><br><br>
        </div>
        <div id=roma-logo class="dynamic-content roma">
            <img src="imgs\roma.jpg" style="width:100%;" class="w3-round"><br><br>
        </div>
        <div id=montraw-logo class="dynamic-content montraw">
            <img src="imgs\montraw.jpg" style="width:80%;" class="w3-round"><br><br>
        </div>
    </div>
     <!--Dynamic Section Food Classes for every Restaurant-->
    <div id="detailsDefault" class="dynamic-content default w3-margin-right" style ="width:300px;">
        <button onclick="requestData('all')" class="w3-bar-item w3-button w3-opacity">ALLE SPEISEN</button>
        <button class="w3-button w3-block w3-left-align w3-opacity" onclick="AccFunc('vorspeisen')">VORSPEISEN & BEILAGEN <i class="fa fa-caret-down"></i></button>
        <div id="vorspeisen" class="w3-hide w3-white w3-card">
            <button onclick="requestData('brot')" class="w3-bar-item w3-button w3-opacity">BROT</button>
            <button onclick="requestData('salat')" class="w3-bar-item w3-button w3-opacity">SALAT</button>
            <button onclick="requestData('suppe')" class="w3-bar-item w3-button w3-opacity">SUPPE</button>
            <button onclick="requestData('antipast')" class="w3-bar-item w3-button w3-opacity">ANTIPASTO</button>
        </div>
        <button class="w3-button w3-block w3-left-align w3-opacity" onclick="AccFunc('nudel')">NUDELGERICHTE <i class="fa fa-caret-down"></i></button>
        <div id="nudel" class="w3-hide w3-light-grey w3-card">
            <button onclick="requestData('penne')" class="w3-bar-item w3-button w3-opacity">PENNE</button>
            <button onclick="requestData('tagliatelle')" class="w3-bar-item w3-button w3-opacity">TAGLIATELLE</button>
            <button onclick="requestData('spaghetti')" class="w3-bar-item w3-button w3-opacity">SPAGHETTI</button>
            <button onclick="requestData('rigatoni')" class="w3-bar-item w3-button w3-opacity">RIGATONI</button>
            <button onclick="requestData('tortellini')" class="w3-bar-item w3-button w3-opacity">TORTELLINI</button>
            <button onclick="requestData('papperdelle')" class="w3-bar-item w3-button w3-opacity">PAPPERDELLE</button>
            <button onclick="requestData('linguine')" class="w3-bar-item w3-button w3-opacity">LINGUINE</button>
            <button onclick="requestData('maccheroni')" class="w3-bar-item w3-button w3-opacity">MACCHERONI</button>
            <button onclick="requestData('paccheri')" class="w3-bar-item w3-button w3-opacity">PACCHERI</button>
            <button onclick="requestData('ravioli')" class="w3-bar-item w3-button w3-opacity">RAVIOLI</button>
            <button onclick="requestData('Gnocchi')" class="w3-bar-item w3-button w3-opacity">GNOCCHI</button>
        </div>
        <button onclick="requestData('döner')" class="w3-bar-item w3-button w3-opacity">DÖNER</button>
        <button onclick="requestData('baguette')" class="w3-bar-item w3-button w3-opacity">BAGUETTE</button>
        <button onclick="requestData('calzone')" class="w3-bar-item w3-button w3-opacity">CALZONE</button>
        <button onclick="requestData('pizza')" class="w3-bar-item w3-button w3-opacity">PIZZA</button>
        <button onclick="requestData('auflauf')" class="w3-bar-item w3-button w3-opacity">AUFLAUF</button>
        <button onclick="requestData('lasagne')" class="w3-bar-item w3-button w3-opacity">LASAGNE</button>
        <button onclick="requestData('risotto')" class="w3-bar-item w3-button w3-opacity">RISOTTO</button>
        <button onclick="requestData('schnitzel')" class="w3-bar-item w3-button w3-opacity">SCHNITZEL</button>
        <button onclick="requestData('steak')" class="w3-bar-item w3-button w3-opacity">STEAK</button>
        <button onclick="requestData('fisch')" class="w3-bar-item w3-button w3-opacity">FISCH</button>
        <button onclick="requestData('chicken')" class="w3-bar-item w3-button w3-opacity">GEFLÜGEL</button>
    </div>
    <!--Dynamic Section Restaurant Fellini-->
    <div id="detailsFellini" class=" w3-container dynamic-content fellini w3-margin-top">
        <?php
                $unparsed_json = file_get_contents("http://foodscout/api/restaurant/fellini");
                $json_object = json_decode($unparsed_json,true);

                foreach($json_object as $row){
                    echo '<h4><b>' .$row["name"]. '</b></h4>';
                    echo '<p class="w3-text-grey">' .$row["street"] .'<br/>';
                    echo $row["plz"] . ' ' . $row["city"] .'<br/>';
                    echo 'Tel.: ' .$row["tel"] .'<br/>';
                    echo 'Fax: ' .$row["fax"] .'<br/>';
                    echo 'Email: ' .$row["email"].'<br/><br/>'; 
                    echo 'Öffnungszeiten: <br/>'.substr($row["opening"],20).'</p>';
                }    
            ?>
    </div>
     <!--Dynamic Section Restaurant Roma-->
    <div id="detailsRoma" class=" w3-container dynamic-content roma w3-margin-top">
        <?php   //Get Restaurant Details from API
                $unparsed_json = file_get_contents("http://foodscout/api/restaurant/roma");
                $json_object = json_decode($unparsed_json,true);

                foreach($json_object as $row){
                    echo '<h4><b>' .substr($row["name"], 0, 15). '</b></h4>';
                    echo '<h5>' .substr($row["name"], 16). '</h5>';
                    echo '<p class="w3-text-grey">' .$row["street"] .'<br/>';
                    echo $row["plz"] . ' ' . $row["city"] .'<br/>';
                    echo 'Tel.: ' .$row["tel"] .'<br/>';
                    echo 'Fax: ' .$row["fax"] .'<br/>';
                    echo 'Email: ' .$row["email"].'<br/><br/>'; 
                    echo 'Öffnungszeiten: <br/>'.$row["opening"].'</p>';
                }    
            ?>
    </div>
    <!--Dynamic Section Restaurant Montraw-->
    <div id="detailsMontraw" class=" w3-container dynamic-content montraw w3-margin-top">
        <?php   //Get Restaurant Details from API
                $unparsed_json = file_get_contents("http://foodscout/api/restaurant/montraw");
                $json_object = json_decode($unparsed_json,true);

                foreach($json_object as $row){
                    echo '<h4><b>' .$row["name"]. '</b></h4>';
                    echo '<p class="w3-text-grey">' .$row["street"] .'<br/>';
                    echo $row["plz"] . ' ' . $row["city"] .'<br/>';
                    echo 'Tel.: ' .$row["tel"] .'<br/>';
                    echo 'Email: ' .$row["email"].'<br/><br/>'; 
                    echo 'Öffnungszeiten: <br/>'.$row["opening"].'</p>';
                }    
            ?>
    </div>
</nav>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px">

  <!-- Header -->
  <header id="header">
    <span class="w3-button w3-hide-large w3-xxlarge w3-hover-text-grey" onclick="w3_open()"><i class="fa fa-bars"></i></span>
    <div class="w3-container">
        <h1><b>FoodScout <b class="w3-black w3-circle w3-center">42</b> </b></h1>  
        <div class="w3-section w3-bottombar w3-padding-16">
            <span class="w3-margin-right">Filter:</span> 
            <button class="w3-button w3-black" onclick="window.location.href = 'http://foodscout/index.php';"><i class="fa fa-home w3-xlarge"></i></button>
            <button class="w3-button w3-white" onclick="window.location.href = 'http://foodscout/index.php?page=fellini';">Ristorante Fellini</button>
            <button class="w3-button w3-white w3-hide-small" onclick="window.location.href = 'http://foodscout/index.php?page=roma';">Restaurant Roma</button>
            <button class="w3-button w3-white w3-hide-small" onclick="window.location.href = 'http://foodscout/index.php?page=montraw';">Restaurant MontRaw</button>
            <div class="w3-right">
                <form>
                    <select id="Searchsettings" class="w3-select w3-border w3-hide-small" name="option" style="width:250px; display:none;">
                        <option value="1">nach Speisen suchen</option>
                        <option value="2">nach Zutaten suchen</option>
                    </select>
                </form>
            </div> 
        </div>
    </div>
  </header>
    <!-- Default Dynamic Content Section -->
    <div id="default-content" class="w3-container dynamic-content default">
        <input class="w3-input w3-border w3-padding" style="display:none;" type="text" placeholder="Search ..." id="SearchInput" onkeyup="doSearch()">
        <img id="background" src="imgs\foodscout_background.jpg" class="w3-opacity" style="max-width:100%; max-height:100%;">
        <table id="food" class="w3-table-all w3-hoverable w3-margin-top" style="display:none;">
            <tr class="w3-light-grey">
                <th>Name</th>
                <th>Zutaten</th>
                <th>Preis</th>
                <th>Restaurant</th>
            </tr>
        </table>
    </div>

    <!-- Dynamic Section Content Fellini -->
    <div id="fellini" class="w3-container dynamic-content fellini">
        <input id= "fellini-input" class="w3-input w3-border w3-padding" type="text" placeholder="Search ..."  onkeyup="doSearch()">
        
        <table id="fellini-food" class="w3-table-all w3-hoverable w3-margin-top">
            <tr class="w3-light-grey">
                <th>Name</th>
                <th>Zutaten</th>
                <th>Preis</th>
            </tr>
        </table>
    </div>

    <!-- Dynamic Section Content Roma -->
    <div id="roma" class="w3-container dynamic-content roma">
        <input id= "roma-input" class="w3-input w3-border w3-padding" type="text" placeholder="Search ..."  onkeyup="doSearch()">
        
        <table id="roma-food" class="w3-table-all w3-hoverable w3-margin-top">
            <tr class="w3-light-grey">
                <th>Name</th>
                <th>Zutaten</th>
                <th>Preis</th>
            </tr>
        </table>
    </div>

    <!-- Dynamic Section Content MontRaw -->
    <div id="montraw" class="w3-container dynamic-content montraw">
        <input id= "montraw-input" class="w3-input w3-border w3-padding" type="text" placeholder="Search ..."  onkeyup="doSearch()">
        
        <table id="montraw-food" class="w3-table-all w3-hoverable w3-margin-top">
            <tr class="w3-light-grey">
                <th>Name</th>
                <th>Zutaten</th>
                <th>Preis</th>
            </tr>
        </table>
    </div>

<!-- End page content -->
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script src="frontend.js"></script>
</body>
</html>