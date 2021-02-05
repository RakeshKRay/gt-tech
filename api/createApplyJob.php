<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include_once 'config/database.php';
    include_once 'model/ApplyJob.php';
    
    $database = new Database();
    $db = $database->getConnection();

    $item = new ContactUs($db);
    $data = json_decode(file_get_contents("php://input"));

    $item->fname = $data->fname;
    $item->dob = $data->dob;
    $item->experience = $data->experience;
    $item->location = $data->location;
    $item->email = $data->email;
    $item->phone = $data->phone;
    $item->designation = $data->designation;
    $item->applyDesc = $data->applyDesc;
    $item->cv = $data->cv;
    $item->created_date = date('Y-m-d H:i:s');
    
    if($item->createContactUs()){
       echo json_encode('Contact added successfully.');
    } else{
        echo json_encode('Contact could not be added.');
    }
?>