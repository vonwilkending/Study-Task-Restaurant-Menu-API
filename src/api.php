<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

//Get food from Database
$app->get('/api/food/{filter}', function(Request $request, Response $response, array $args){

    $filter = $args['filter'];

    if($filter == 'all'){
        
        try{
            $db = new db();
            $db = $db->connect();
    
            if(checkUpdate($db,'5b2e2671aa5ad')){
                $scrap = new scraper($db);
                $scrap->run($filter);
            }
    
            $sql = "SELECT f.name as food,f.ingredients,f.price, r.name as restaurant 
                    FROM food f JOIN restaurants r WHERE restID = r.id ORDER BY food ASC";
            $stmt = $db->query($sql);
            $menus = $stmt->fetchAll(PDO::FETCH_OBJ);
    
            return $response->withJson($menus);
    
        } catch(PDOException $e){
            $errorResponse = $response->withStatus(500);
            return $errorResponse->withJson('{"error": {"text": ' .$e->getMessage().'}');
        }
    } 
    else{

        try{
            $db = new db();
            $db = $db->connect();
    
            if(checkUpdate($db,'5b2e2671aa5ad')){
                $scrap = new scraper($db);
                $scrap->run($filter);
            }

            //create sql string 
            if($filter == 'suppe' || $filter == 'brot' || $filter == 'steak'){
                $sql = $db->prepare("SELECT f.name as food,f.ingredients,f.price, r.name as restaurant
                    FROM food f JOIN restaurants r ON restID = r.id 
                    WHERE f.ingredients LIKE '%".?."%' ORDER BY food ASC");
            } 
            else if ($filter == 'fisch'){
                $sql = $db->prepare("SELECT f.name as food,f.ingredients,f.price, r.name as restaurant
                    FROM food f JOIN restaurants r ON restID = r.id 
                    WHERE f.name LIKE '%".?."%' OR f.ingredients LIKE '%Lachs%'
                    OR f.ingredients LIKE '%Brasse%' ORDER BY food ASC");
            }
            else {
                $sql = $db->prepare("SELECT f.name as food,f.ingredients,f.price, r.name as restaurant
                    FROM food f JOIN restaurants r ON restID = r.id 
                    WHERE f.name LIKE '%".?."%' ORDER BY food ASC");
            }          

            $sql->bind_param("s", $filter);
            $result = $sql->get_result();
            $menus = $result->fetchAll(PDO::FETCH_OBJ);
    
            //JSON Response
            return $response->withJson($menus);
    
        } catch(PDOException $e){
            $errorResponse = $response->withStatus(500);
            return $errorResponse->withJson('{"error": {"text": ' .$e->getMessage().'}');
        }
    }
});

//Get Details from Restaurants
$app->get('/api/restaurant/{name}', function(Request $request, Response $response, array $args){

    $filter = $args['name'];

    if($filter == 'fellini'){
    
        try{
            //Get DB Object
            $db = new db();
            //Connect
            $db = $db->connect();

            //check if update is necessary
            if(checkUpdate($db,'5b2e2671aa5ad')){
                //start DOM scraper
                $scrap = new scraper($db);
                $scrap->run($filter);
            }

            //create sql string
            $sql = "SELECT * FROM restaurants WHERE id ='5b2e2671aa5ad'";
            $stmt = $db->query($sql);
            $rest = $stmt->fetchAll(PDO::FETCH_OBJ);
        
            //JSON Response
            return $response->withJson($rest);

        } catch(PDOException $e){
            $errorResponse = $response->withStatus(500);
            return $errorResponse->withJson('{"error": {"text": ' .$e->getMessage().'}');
        }
    }
    else if($filter == 'roma'){
    
        try{
            //Get DB Object
            $db = new db();
            //Connect
            $db = $db->connect();

            //check if update is necessary
            if(checkUpdate($db,'5b2f8ff4aa793')){
                //start DOM scraper
                $scrap = new scraper($db);
                $scrap->run($filter);
            }

            //create sql string
            $sql = "SELECT * FROM restaurants WHERE id ='5b2f8ff4aa793'";
            $stmt = $db->query($sql);
            $rest = $stmt->fetchAll(PDO::FETCH_OBJ);
        
            //JSON Response
            return $response->withJson($rest);

        } catch(PDOException $e){
            $errorResponse = $response->withStatus(500);
            return $errorResponse->withJson('{"error": {"text": ' .$e->getMessage().'}');
        }
    }
    else if($filter == 'montraw'){
    
        try{
            //Get DB Object
            $db = new db();
            //Connect
            $db = $db->connect();

            //check if update is necessary
            if(checkUpdate($db,'5b30b11fb5fe5')){
                //start DOM scraper
                $scrap = new scraper($db);
                $scrap->run($filter);
            }

            //create sql string
            $sql = "SELECT * FROM restaurants WHERE id ='5b30b11fb5fe5'";
            $stmt = $db->query($sql);
            $rest = $stmt->fetchAll(PDO::FETCH_OBJ);
        
            //JSON Response
            return $response->withJson($rest);

        } catch(PDOException $e){
            $errorResponse = $response->withStatus(500);
            return $errorResponse->withJson('{"error": {"text": ' .$e->getMessage().'}');
        }
    }
    else{
        $errorResponse = $response->withStatus(400);
        return $errorResponse->withJson('{"error": {"text": "RestaurantNotFound"}');
    }
});

//Get food from Ristorante Fellini
$app->get('/api/fellini/{filter}', function(Request $request, Response $response, array $args){

    $filter = $args['filter'];
    
    if($filter == 'all'){
        
        try{
            $db = new db();
            $db = $db->connect();
    
            if(checkUpdate($db,'5b2e2671aa5ad')){
                $scrap = new scraper($db);
                $scrap->run($filter);
            }
    
            $sql = "SELECT name,ingredients,price FROM food WHERE restID='5b2e2671aa5ad'";
            $stmt = $db->query($sql);
            $menus = $stmt->fetchAll(PDO::FETCH_OBJ);
    
            return $response->withJson($menus);
    
        } catch(PDOException $e){
            $errorResponse = $response->withStatus(500);
            return $errorResponse->withJson('{"error": {"text": ' .$e->getMessage().'}');
        }
    } 
    else{

        try{
            $db = new db();
            $db = $db->connect();
    
            if(checkUpdate($db,'5b2e2671aa5ad')){
                $scrap = new scraper($db);
                $scrap->run($filter);
            }
    
            //create sql string
            $sql = $db->prepare("SELECT name,ingredients,price FROM food WHERE restID='5b2e2671aa5ad' AND name LIKE '%".?."%'");
            $sql->bind_param("s", $filter);
            $result = $sql->get_result();
            $menus = $result->fetchAll(PDO::FETCH_OBJ);

            //JSON Response
            return $response->withJson($menus);
    
        } catch(PDOException $e){
            $errorResponse = $response->withStatus(500);
            return $errorResponse->withJson('{"error": {"text": ' .$e->getMessage().'}');
        }
    }
});

//Get food from Restaurant Roma
$app->get('/api/roma/{filter}', function(Request $request, Response $response, array $args){

    $filter = $args['filter'];

    if($filter == 'all'){
        try{
            //Get DB Object
            $db = new db();
            //Connect
            $db = $db->connect();

            //check if update is necessary
            if(checkUpdate($db,'5b2f8ff4aa793')){
                //start DOM scraper
                $scrap = new scraper($db);
                $scrap->run();
            }

            //create sql string
            $sql = "SELECT name,ingredients,price FROM food WHERE restID='5b2f8ff4aa793'";
            $stmt = $db->query($sql);
            $menus = $stmt->fetchAll(PDO::FETCH_OBJ);
        
            //JSON Response
            return $response->withJson($menus);

        } catch(PDOException $e){
            echo '{"error": {"text": ' .$e->getMessage().'}';
        }
    }
    else {
        try{
            $db = new db();
            $db = $db->connect();
    
            if(checkUpdate($db,'5b2f8ff4aa793')){
                $scrap = new scraper($db);
                $scrap->run($filter);
            }
    
            //create sql string
            $sql = $dp->prepare("SELECT name,ingredients,price FROM food WHERE restID='5b2f8ff4aa793' AND name LIKE '%".?."%'");
            $sql->bind_param("s", $filter);
            $result = $sql->get_result();
            $menus = $result->fetchAll(PDO::FETCH_OBJ);
    
            //JSON Response
            return $response->withJson($menus);
    
        } catch(PDOException $e){
            $errorResponse = $response->withStatus(500);
            return $errorResponse->withJson('{"error": {"text": ' .$e->getMessage().'}');
        }
    }
});

//Get Food from Restaurant MontRaw
$app->get('/api/montraw/{filter}', function(Request $request, Response $response, array $args){

    $filter = $args['filter'];

    if($filter == 'all'){
        try{
            //Get DB Object
            $db = new db();
            //Connect
            $db = $db->connect();

            //check if update is necessary
            if(checkUpdate($db,'5b30b11fb5fe5')){
                //start DOM scraper
                $scrap = new scraper($db);
                $scrap->run();
            }

            //create sql string
            $sql = "SELECT name,ingredients,price FROM food WHERE restID='5b30b11fb5fe5'";
            $stmt = $db->query($sql);
            $menus = $stmt->fetchAll(PDO::FETCH_OBJ);
        
            //JSON Response
            return $response->withJson($menus);

        } catch(PDOException $e){
            echo '{"error": {"text": ' .$e->getMessage().'}';
        }
    }
    else{
        try{
            $db = new db();
            $db = $db->connect();
    
            if(checkUpdate($db,'5b2f8ff4aa793')){
                $scrap = new scraper($db);
                $scrap->run($filter);
            }
    
            //create sql string
            $sql = $db->prepare("SELECT name,ingredients,price FROM food WHERE restID='5b30b11fb5fe5' AND name LIKE '%".?."%'");
            $sql->bind_param("s", $filter);
            $result = $sql->get_result();
            $menus = $result->fetchAll(PDO::FETCH_OBJ);

            //JSON Response
            return $response->withJson($menus);
    
        } catch(PDOException $e){
            $errorResponse = $response->withStatus(500);
            return $errorResponse->withJson('{"error": {"text": ' .$e->getMessage().'}');
        }
    }
});


//Check if Database Update is necessary
function checkUpdate($conn,$id){

    try{
        //check for last update
        $update = "SELECT lastupdate FROM food WHERE restID = '".$id."' limit 1";
        $stmt = $conn->query($update);
        $date = $stmt->fetchColumn();

    } catch(PDOException $e){
        echo '{"error": {"text": ' .$e->getMessage().'}';
    }

    //format to unix timestamp
    $timearray = explode("-", $date);
    $timestamp = mktime(0, 0, 1, intval($timearray[1]), intval($timearray[2]), intval($timearray[0]));

    //if date is older then 24h return true, else false
    if($timestamp > (time()-(60*60*24))){
        return false;
    }
    else{
        return true;
    }
}
?>