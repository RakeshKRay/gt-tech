<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    
    include_once 'config/database.php';
    include_once 'model/ApplyJob.php';

    $database = new Database();
    $db = $database->getConnection();

    $items = new ApplyJob($db);

    $stmt = $items->getAll();
    $itemCount = $stmt->rowCount();


    //echo json_encode($itemCount);

    if($itemCount > 0){
        
        $applyJobArr = array();
        $applyJobArr["body"] = array();
        $applyJobArr["itemCount"] = $itemCount;

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $e = array(
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

            array_push($contactUsArr["body"], $e);
        }
        echo json_encode($contactUsArr);
    }

    else{
        http_response_code(404);
        echo json_encode(
            array("message" => "No record found.")
        );
    }
?>