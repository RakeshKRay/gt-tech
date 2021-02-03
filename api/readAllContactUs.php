<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    
    include_once 'config/database.php';
    include_once 'model/ContactUs.php';

    $database = new Database();
    $db = $database->getConnection();

    $items = new ContactUs($db);

    $stmt = $items->getAll();
    $itemCount = $stmt->rowCount();


    echo json_encode($itemCount);

    if($itemCount > 0){
        
        $contactUsArr = array();
        $contactUsArr["body"] = array();
        $contactUsArr["itemCount"] = $itemCount;

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $e = array(
                "id" => $id,
                "name" => $name,
                "email" => $email,
                "phone" => $phone,
                "message" => $message,
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