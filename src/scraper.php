<?php
require '../simplehtmldom_1_5/simple_html_dom.php';

Class scraper{

    //connection object
    public $db;

    //Constructor
    public function __construct($conn) {
        $this->db = $conn;
    }

    public function run($name){

        if($name == 'fellini'){
            $this->scrapFellini();
        }
        else if ($name == 'roma'){
            $this->scrapRoma();
        }
        else if($name == 'montraw'){
            $this->scrapMontraw();
        }
        else{
            $this->scrapFellini();
            $this->scrapRoma();
            $this->scrapMontraw();
        }
       
        //Just for Comparison Purposes
        //$this->scrapChilihot();
    } 

    private function scrapFellini(){
        
        // Create DOM from URLs
        $felliniMenu = file_get_html('http://www.fellini-goettingen.de/karte.php');
        $felliniContact = file_get_html('http://www.fellini-goettingen.de/kontakt.php');

        if(!(empty($felliniMenu) && empty($felliniContact))){

            //scrap Restaurant Details
            foreach($felliniContact->find('.adress dt') as $element){
                $data[] = $element->innertext;
            }
           
            foreach($felliniContact->find('.adress dd') as $element){
                $restData[] = $element->innertext;
            }
        
            $adress = array(
                "id"        => "5b2e2671aa5ad",
                "name"      => substr(explode("<br>",$data[0])[0], 0, 18),
                "street"    => explode("<br>",$data[0])[1],
                "plz"       => explode(" ",explode("<br>",$data[0])[2])[0],
                "city"      => explode(" ",explode("<br>",$data[0])[2])[1],
                "tel"       => explode(">",explode(":",$restData[0])[1])[1],
                "fax"       => explode(">",explode(":",$restData[1])[1])[1],
                "email"     => explode("<",explode(">",explode(":",$restData[2])[2])[1])[0],
                "opening"   => $restData[4] . "<br>" . $restData[5]
            );

            //Create SQL Insert String
            /*$sqlInsert = "INSERT INTO restaurants (id,name,street,plz,city,tel,fax,email,opening)
            VALUES('".$adress["id"]."','".$adress["name"]."','".$adress["street"]."',
            '".$adress["plz"]."','".$adress["city"]."','".$adress["tel"]."','".$adress["fax"]."',
            '".$adress["email"]."', '".$adress["opening"]."')";*/

            //Create SQL Update String
            $sqlupdate = "UPDATE restaurants SET 
                    name = '".$adress["name"]."',
                    street = '".$adress["street"]."',
                    plz = '".$adress["plz"]."',
                    city = '".$adress["city"]."',
                    tel = '".$adress["tel"]."'
                    WHERE id = '5b2e2671aa5ad'";

            //Write to DB
            $this->writeDB($sqlupdate);

            //scrap menu
            foreach($felliniMenu->find('.title') as $element){
                $names[] = str_replace("'"," ",$element->plaintext);
            }

            foreach($felliniMenu->find('.subtitle') as $element){
                $ingredients[] = $element->plaintext;
            }
            
            foreach($felliniMenu->find('.price') as $element){
                $prices[] = $element->plaintext;
            }

            //create SQL Insert String for food
            $foodsql = 'INSERT INTO food (id,name,ingredients,price,restID) VALUES';
            for($i = 0;$i < count($names);$i++){
                if($i >= 49 && $i <= 68){
                    $foodsql = $foodsql ."('" .uniqid(). "','Pizza ".$names[$i]."','".$ingredients[$i]."','".substr($prices[$i], 0, -2)."','5b2e2671aa5ad'),";
                }
                else{
                    $foodsql = $foodsql ."('" .uniqid(). "','".$names[$i]."','".$ingredients[$i]."','".substr($prices[$i], 0, -2)."','5b2e2671aa5ad'),";
                }
            }
            $foodsql = substr($foodsql, 0, -1);

            //create SQL Delete String
            $sqldel = "DELETE FROM food WHERE restID = '5b2e2671aa5ad'";
            $this->writeDB($sqldel);
            //Write to DB
            $this->writeDB($foodsql);
            return true;

        } else{ return false; }   
    }

    private function scrapRoma(){

        $html = file_get_html('https://roma-erfurt.de/speisekarte/');
        $htmlContact = file_get_html('https://roma-erfurt.de/impressum/');

        if(!(empty($htmlContact) && empty($html))){

            //scrap Restaurant Details
            $plzcity = explode("<br />",$htmlContact->find('.et_pb_blurb_description p')[1]);
            $telfax = explode("<br />",$htmlContact->find('.et_pb_blurb_description p')[6]);

            $adress = array(
                "id"        => "5b2f8ff4aa793",
                "name"      => $htmlContact->find('.et_pb_blurb_description p')[0]->plaintext,
                "street"    => explode("<br />",$htmlContact->find('.et_pb_blurb_description p')[1])[1],
                "plz"       => explode(" ",$plzcity[2])[1],
                "city"      => explode("<",explode(" ",$plzcity[2])[2])[0],
                "tel"       => explode(">",$telfax[0])[1],
                "fax"       => explode("<",$telfax[1])[0],
                "email"     => $htmlContact->find('.et_pb_blurb_description p')[7]->plaintext,
                "opening"   => $html->find(".et_pb_text_inner p")[1]->plaintext
            ); 
            
             //Create SQL Insert String
            /*$sqlInsert = "INSERT INTO restaurants (id,name,street,plz,city,tel,fax,email,opening)
            VALUES('".$adress["id"]."','".$adress["name"]."','".$adress["street"]."',
            '".$adress["plz"]."','".$adress["city"]."','".$adress["tel"]."','".$adress["fax"]."',
            '".$adress["email"]."', '".$adress["opening"]."')";*/

             //Create SQL Update String
             $sqlupdate = "UPDATE restaurants SET 
                        name = '".$adress["name"]."',
                        street = '".$adress["street"]."',
                        plz = '".$adress["plz"]."',
                        city = '".$adress["city"]."',
                        tel = '".$adress["tel"]."'
                        WHERE id = '5b2f8ff4aa793'";

            //Write to DB
            $this->writeDB($sqlupdate);
            
            //scrap food
            foreach($html->find('.et_pb_column_5 .divi-catalogue-item, .et_pb_column_6 .divi-catalogue-item, 
                                .et_pb_column_13 .divi-catalogue-item, .et_pb_column_16 .divi-catalogue-item,
                                .et_pb_column_17 .divi-catalogue-item, .et_pb_column_19 .divi-catalogue-item,
                                .et_pb_column_20 .divi-catalogue-item, .et_pb_column_29 .divi-catalogue-item,
                                .et_pb_column_33 .divi-catalogue-item, .et_pb_column_48 .divi-catalogue-item,
                                .et_pb_column_49 .divi-catalogue-item, .et_pb_column_51 .divi-catalogue-item,
                                .et_pb_column_52 .divi-catalogue-item, .et_pb_column_55 .divi-catalogue-item,
                                .et_pb_column_56 .divi-catalogue-item, .et_pb_column_60 .divi-catalogue-item') as $element){
                
                $names[] = $element->find('.divi-catalogue-title strong')[0]->plaintext;
                $ingredient = $element->find('.divi-catalogue-title em')[0]->plaintext;
                if(strpos($ingredient,'(')!== false){
                    $ingredients[] = explode("(",$ingredient)[0];
                }
                else{
                    $ingredients[] = $ingredient;
                }
                $prices[] = explode("€",$element->find('.divi-catalogue-price')[0]->plaintext)[1];
            }

            //tagliatelle
            foreach($html->find('.et_pb_column_25 .divi-catalogue-item') as $element){
                $names[] = "Tagliatelle " . $element->find('.divi-catalogue-title strong')[0]->plaintext;
                $ingredient = $element->find('.divi-catalogue-title em')[0]->plaintext;
                if(strpos($ingredient,'(')!== false){
                    $ingredients[] = explode("(",$ingredient)[0];
                }
                else{
                    $ingredients[] = $ingredient;
                }
                $prices[] = explode("€",$element->find('.divi-catalogue-price')[0]->plaintext)[1];
            }

            //Spaghetti
            foreach($html->find('.et_pb_column_24  .divi-catalogue-item') as $element){
                $names[] = "Spaghetti " . $element->find('.divi-catalogue-title strong')[0]->plaintext;
                $ingredient = $element->find('.divi-catalogue-title em')[0]->plaintext;
                if(strpos($ingredient,'(')!== false){
                    $ingredients[] = explode("(",$ingredient)[0];
                }
                else{
                    $ingredients[] = $ingredient;
                }
                $prices[] = explode("€",$element->find('.divi-catalogue-price')[0]->plaintext)[1];
            }
            
            //Tortellini
            foreach($html->find('.et_pb_column_28  .divi-catalogue-item') as $element){
                $names[] = "Tortellini " . $element->find('.divi-catalogue-title strong')[0]->plaintext;
                $ingredient = $element->find('.divi-catalogue-title em')[0]->plaintext;
                if(strpos($ingredient,'(')!== false){
                    $ingredients[] = explode("(",$ingredient)[0];
                }
                else{
                    $ingredients[] = $ingredient;
                }
                $prices[] = explode("€",$element->find('.divi-catalogue-price')[0]->plaintext)[1];
            }
            
            //Maccheroni
            foreach($html->find('.et_pb_column_32  .divi-catalogue-item') as $element){
                $names[] = "Maccheroni " . $element->find('.divi-catalogue-title strong')[0]->plaintext;
                $ingredient = $element->find('.divi-catalogue-title em')[0]->plaintext;
                if(strpos($ingredient,'(')!== false){
                    $ingredients[] = explode("(",$ingredient)[0];
                }
                else{
                    $ingredients[] = $ingredient;
                }
                $prices[] = explode("€",$element->find('.divi-catalogue-price')[0]->plaintext)[1];
            }

            //Pizza
            foreach($html->find('.et_pb_column_35  .divi-catalogue-item, .et_pb_column_36  .divi-catalogue-item,
                                .et_pb_column_43  .divi-catalogue-item') as $element){

                $name = $element->find('.divi-catalogue-title strong')[0]->plaintext;                    
                if(strpos($name,'Pizzabrot')!== false){
                    $names[] = $name;
                    $ingredients[] = "";
                }   
                else{
                    $names[] = "Pizza " .$name; 

                    $ingredient = $element->find('.divi-catalogue-title em')[0]->plaintext;
                    if(strpos($ingredient,'(')!== false){
                        $ingredients[] = explode("(",$ingredient)[0];
                    }
                    else{
                        $ingredients[] = $ingredient;
                    }
                }
                $prices[] = explode("€",$element->find('.divi-catalogue-price')[0]->plaintext)[1];
            }

            //create SQL Insert String for food
            $foodsql = 'INSERT INTO food (id,name,ingredients,price,restID) VALUES';
            for($i = 0;$i < count($names);$i++){
                $foodsql = $foodsql ."('" .uniqid(). "','".$names[$i]."','".$ingredients[$i]."','".$prices[$i]."','5b2f8ff4aa793'),";
            }
            $foodsql = substr($foodsql, 0, -1);

            //create SQL Delete String
            $sqldel = "DELETE FROM food WHERE restID = '5b2f8ff4aa793'";
            $this->writeDB($sqldel);
            //Write to DB
            $this->writeDB($foodsql);

            return true;
            
        } else{ return false; }
    }

    private function scrapMontraw(){
        
        $montraw = file_get_html('http://montraw.com/de/');

        if(!empty($montraw)){

            //scrap Restaurant Details
            $data = $montraw->find('.address p');
            $adress = array(
                "id"        => "5b30b11fb5fe5",
                "name"      => $montraw->find('.mid h1')[0]->plaintext,
                "street"    => substr($data[0]->plaintext,0,23),
                "plz"       => substr($data[0]->plaintext,24,6),
                "city"      => substr($data[0]->plaintext,30,7),
                "tel"       => $montraw->find('.address a')[0]->plaintext,
                "fax"       => "",                                          //Information not on Website
                "email"     => $montraw->find('.address a')[1]->plaintext,
                "opening"   => "Dienstag - Sonntag	18:00–23:00"            //Information not on Website
            ); 

             //Create SQL Insert String
            $sqlInsert = "INSERT INTO restaurants (id,name,street,plz,city,tel,fax,email,opening)
            VALUES('".$adress["id"]."','".$adress["name"]."','".$adress["street"]."',
            '".$adress["plz"]."','".$adress["city"]."','".$adress["tel"]."','".$adress["fax"]."',
            '".$adress["email"]."', '".$adress["opening"]."')";

            //Create SQL Update String
            $sqlupdate = "UPDATE restaurants SET 
                        name = '".$adress["name"]."',
                        street = '".$adress["street"]."',
                        plz = '".$adress["plz"]."',
                        city = '".$adress["city"]."',
                        tel = '".$adress["tel"]."'
                        WHERE id = '5b30b11fb5fe5'";

            //Write to DB
            $this->writeDB($sqlupdate);

            //scrap food
            foreach($montraw->find('.list_item') as $e){
                $name = ucwords(strtolower($e->find('h3')[0]->plaintext));
                if(strpos($name,'Ä')!== false){
                    $names[] = substr_replace($name,'ä',strpos($name,'Ä'),2);
                }
                else if(strpos($name,'Ü')!== false){
                    $names[] = substr_replace($name,'ü',strpos($name,'Ü'),2);
                } 
                else $names[] = $name;

                $ingredient = $e->find('p')[0]->plaintext;
                if(strpos($ingredient,'(')!== false){
                    $ingredients[] = explode("(",$e->find('p')[0]->plaintext)[0];
                } else { $ingredients[] = $ingredient; }

                $price = substr($e->find('span')[0]->plaintext,3);
                if(strpos($price,'pro Person')!== false){
                    $price = substr($price,0,1);
                }

                if(strpos($price,'/')!== false){
                    $price = explode("/",$price)[0] . " ";
                }

                if(strpos($price,'.')!== false){
                    $prices[] = substr_replace($price,'0',-1);
                }  else{ $prices[] = $price;}
            }

            //create SQL Insert String for food
            $foodsql = 'INSERT INTO food (id,name,ingredients,price,restID) VALUES';
            for($i = 0;$i < count($names);$i++){
                $foodsql = $foodsql ."('" .uniqid(). "','".$names[$i]."','".$ingredients[$i]."','".$prices[$i]."','5b30b11fb5fe5'),";
            }
            $foodsql = substr($foodsql, 0, -1);

            //create SQL Delete String
            $sqldel = "DELETE FROM food WHERE restID = '5b30b11fb5fe5'";
            $this->writeDB($sqldel);
            //Write to DB
            $this->writeDB($foodsql);
            
            return true;

        } else{ return false; }
    }

    function scrapChilihot(){

        $chilihot = file_get_html('https://www.pizzeriachilihot.de/');

        if(!empty($chilihot)){
    
            //Scrap adress and tel from Website
            $rest = $chilihot->find('div[itemtype=http://schema.org/Restaurant]',0);
            $adress = array(
                "id"        => '5b263857b1e99',
                "name"      => $rest->find('h2[itemprop=name]',0)->plaintext,
                "street"    => str_replace("&nbsp;"," ",$rest->find('span[itemprop=streetAddress]',0)->plaintext),
                "plz"       => $rest->find('span[itemprop=postalCode]',0)->plaintext,
                "city"      => $rest->find('span[itemprop=addressLocality]',0)->plaintext,
                "tel"       => $rest->find('span[itemprop=telephone]',0)->plaintext
            );
            
            //Create SQL Insert String
            /*$sqlinsert = "INSERT INTO restaurants (id,name,street,plz,city,tel)
                        VALUES('".$adress["id"]."','".$adress["name"]."','".$adress["street"]."',
                        '".$adress["plz"]."','".$adress["city"]."','".$adress["tel"]."')";*/
            
            //Create SQL Update String
            $sqlupdate = "UPDATE restaurants SET 
                        name = '".$adress["name"]."',
                        street = '".$adress["street"]."',
                        plz = '".$adress["plz"]."',
                        city = '".$adress["city"]."',
                        tel = '".$adress["tel"]."'
                        WHERE id = '5b263857b1e99'";
            
            //Write to DB
            $this->writeDB($sqlupdate);
    
            //Scrap food,ingredients and prices from Website
            foreach($chilihot->find('#cat1 li[itemtype=http://schema.org/Product],
                                #cat2 li[itemtype=http://schema.org/Product],
                                #cat4 li[itemtype=http://schema.org/Product],
                                #cat5 li[itemtype=http://schema.org/Product],
                                #cat6 li[itemtype=http://schema.org/Product],
                                #cat7 li[itemtype=http://schema.org/Product],
                                #cat8 li[itemtype=http://schema.org/Product],
                                #cat9 li[itemtype=http://schema.org/Product],
                                #cat10 li[itemtype=http://schema.org/Product],
                                #cat11 li[itemtype=http://schema.org/Product],
                                #cat12 li[itemtype=http://schema.org/Product],
                                #cat13 li[itemtype=http://schema.org/Product],') as $e){
                
                $names[] = $e->find('b',0)->plaintext;
                $prices[] = $e->find('span[itemprop=price]',0)->plaintext;
    
                if($e->find('span[itemprop=description]',0)){
                    $ingredients[] = $e->find('span[itemprop=description]',0)->plaintext;
                }
                else{
                    $ingredients[] = "";
                }
            }
    
            //create SQL Delete String
            $sqldel = "DELETE FROM food WHERE restID = '5b263857b1e99'";
            $this->writeDB($sqldel);
    
            //create SQL Insert String for food
            $foodsql = 'INSERT INTO food (id,name,ingredients,price,restID) VALUES';
            for($i = 0;$i < count($names);$i++){
                $foodsql = $foodsql ."('" .uniqid(). "','".$names[$i]."','".$ingredients[$i]."','".substr($prices[$i], 0, -2)."','5b263857b1e99'),";
            }
            $foodsql = substr($foodsql, 0, -1);
    
            //Write to DB
            $this->writeDB($foodsql);
            return true;
        }
        else{
            return false;
        }   
    }
    
    private function writeDB($sql){

        try{

            $stmt = $this->db->prepare($sql);
            $stmt->execute();

        } catch(PDOException $e){
            echo '{"error": {"text": ' .$e->getMessage().'}';
        }
    }
}

