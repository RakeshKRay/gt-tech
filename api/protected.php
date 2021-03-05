<?php
include_once 'config/database.php';
include_once 'model/users.php';
require "vendor/autoload.php";
use \Firebase\JWT\JWT;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


$secret_key = "GTTECH_Admin";
$jwt = null;
$database = new Database();
$db = $database->getConnection();

$data = json_decode(file_get_contents("php://input"));

$headers = apache_request_headers();
$authHeader = $headers['Authorization'];
//$authHeader = $_SERVER['Auth'];

$arr = explode(" ", $authHeader);

$jwt = $arr[1];

if($jwt){

    try {

        $decoded = JWT::decode($jwt, $secret_key, array('HS256'));

        // Access is granted. Add code of the operation here 

        echo json_encode(array("message" => "Access granted:", ));

    }catch (Exception $e){

    http_response_code(401);

    echo json_encode(array(
        "message" => "Access denied.",
        "error" => $e->getMessage()
    ));
}

}
?>