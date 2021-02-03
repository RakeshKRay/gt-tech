<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include_once 'config/database.php';
    include_once 'model/ContactUs.php';

    $database = new Database();
    $db = $database->getConnection();

    $item = new ContactUs($db);

    $item->id = isset($_GET['id']) ? $_GET['id'] : die();
  
    $item->getSingleContactUs();

    if($item->name != null){
        // create array
        $emp_arr = array(
            "id" =>  $item->id,
            "name" => $item->name,
            "email" => $item->email,
            "phone" => $item->phone,
            "message" => $item->message,
            "created_date" => $item->created_date
        );
      
        http_response_code(200);
        echo json_encode($emp_arr);
    }
      
    else{
        http_response_code(404);
        echo json_encode("Contact message not found.");
    }
?>