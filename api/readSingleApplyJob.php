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

    $item = new ApplyJob($db);

    $item->id = isset($_GET['id']) ? $_GET['id'] : die();
  
    $item->getSingleApplyJob();

    if($item->fname != null){
        // create array
        $applyJob_arr = array(
            "id" => $id,
                "fname" => $fname,
                "dob" => $dob,
                "experience" => $experience,
                "location" => $location,
                "email" => $email,
                "phone" => $phone,
                "designation" => $designation,
                "applyDesc" => $applyDesc,
                "cv" => $cv,
                "created_date" => $created_date
        );
      
        http_response_code(200);
        echo json_encode($applyJob_arr);
    }
      
    else{
        http_response_code(404);
        echo json_encode("Contact message not found.");
    }
?>