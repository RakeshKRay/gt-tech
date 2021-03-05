<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

include_once 'config/database.php';
include_once 'model/users.php';
require "vendor/autoload.php";
use \Firebase\JWT\JWT;
$response = array( 
    'status' => 0, 
    'message' => 'Login failed, please try again.' 
); 
$database = new Database();
$db = $database->getConnection();
$item = new Users($db);
// If form is submitted 
$data = json_decode(file_get_contents("php://input"));
    
    $item->email = $data->email;
    $item->password = $data->password;
    
    if(!empty($item->email) && !empty($item->password) ){
        // validate login 
        if($item->checkLogin()){
            $secret_key = "GTTECH_Admin";
            $issuer_claim = $_SERVER['SERVER_NAME']; // this can be the servername
            //$audience_claim = "THE_AUDIENCE";
            $issuedat_claim = time(); // issued at
            $notbefore_claim = $issuedat_claim + 10; //not before in seconds
            $expire_claim = $issuedat_claim + 60*60; // expire time in seconds
            $token = array(
                "iss" => $issuer_claim,
                //"aud" => $audience_claim,
                "iat" => $issuedat_claim,
                "nbf" => $notbefore_claim,
                "exp" => $expire_claim,
                "data" => array(
                    "id" => $item->id,
                    "firstname" => $item->fname,
                    "lastname" => $item->lname,
                    "email" => $item->email
            ));

            http_response_code(200);

        $jwt = JWT::encode($token, $secret_key, 'HS256');
        $respMsg = array("message" => "Successful login.", "jwt" => $jwt, "email" => $item->email, "expireAt" => $expire_claim);
            $response['status'] = 1; 
            $response['message'] = $respMsg;
        }else{
            http_response_code(401);
            $response['message'] = "Login fail. Try again";
        }

    }else{
        http_response_code(401);
         $response['message'] = 'Please fill all the mandatory fields (email and password).'; 
    } 

 
// Return response 
echo json_encode($response, true);
 
?>