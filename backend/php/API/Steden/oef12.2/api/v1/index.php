<?php

    require_once "../../lib/autoload.php";
    
    $method = $_SERVER["REQUEST_METHOD"];
    $uri = $_SERVER["REQUEST_URI"];

    $dbm = $container->getDbManager();
    $return = ["status_code" => "", "msg"=>"", "data"=>[]];

    // GET
    if( $method == "GET" && $uri == "/api/v1/btwcodes"){
        $data = $dbm->GetData("select * from eu_btw_codes");
        // return json_encode( $data );
    }
    elseif($method == "GET" && strpos($uri, "/api/v1/btwcode/") !== false ){

        $id = explode("/api/v1/btwcode/", $uri)[1];
        print("<pre>");
        // var_dump($id);
        if( is_numeric($id)){
            $data = $dbm->GetData( "select * from eu_btw_codes where eu_id = $id");

            if(count($data) > 0){
                $return["status_code"] = 200;
                $return["msg"] = "success";
                $return["data"] = $data;
            }
            else{
                $return["status_code"] = 404;
                $return["msg"] = "not found";
                $return["data"] = $data;
            }

            print(json_encode($return));
            return json_encode( $return );    
        }
        print("</pre>");
    }

    //POST
    elseif( $method == "POST" && $uri == "/api/v1/btwcodes"){
        $data = $_POST["data"];
        $data_stream = [];

        foreach($data as $key => $value){
            $data_stream[] = "$key = '$value'";
        }
        
        print("creating new");
            // return;
    }

    //PUT
    elseif( $method == "PUT" && strpos($uri, "/api/v1/btwcode/") !== false ){
        $id = explode("/api/v1/btwcode/", $uri);
        print("update code $id");
    } 

    // DELETE
    elseif( $method == "DELETE" && strpos($uri, "/api/v1/btwcode/") !== false){
        $id = explode("/api/v1/btwcode/", $uri);
        print("delete code $id");
    }
    else print("bad request");

    print(json_encode( $data ));

    print("<pre>");
    var_dump($_SERVER);
    print("</pre>");