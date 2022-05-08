<?php

$db = new PDO("mysql:dbname=productdb;host=localhost", $user = "root", $password = "");

$uri = $_SERVER["REQUEST_URI"];

if ($uri === "/api/v1/products") {
    $result = $db->query("SELECT * FROM product");
    $data = $result->fetchAll(PDO::FETCH_ASSOC);

    print(json_encode($data));
} elseif (str_contains("/api/v1/product", $uri)) {
    $id = explode("/api/v1/product", $uri)[1];
}
