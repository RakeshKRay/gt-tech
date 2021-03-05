<?php
 header("Access-Control-Allow-Origin: *");
 header("Content-Type: application/json; charset=UTF-8");
 header("Access-Control-Allow-Methods: POST");
 header("Access-Control-Max-Age: 3600");
 header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once 'config/database.php';
include_once 'model/users.php';

$response = array( 
    'status' => 0, 
    'message' => 'Form submission failed, please try again.' 
); 
$database = new Database();
$db = $database->getConnection();
$item = new Users($db);
$data = json_decode(file_get_contents("php://input"));

    // Get the submitted form data 
    $item->fname = $data->fname; 
    $item->lname = $data->lname;
    $item->email = $data->email;
    $item->password = $data->password;
    $item->role = $data->role;
    $item->created_date = date('Y-m-d H:i:s');
    
    // Check whether submitted data is not empty 
    if(!empty($item->fname) && !empty($item->email) && !empty($item->lname) && !empty($item->password) && !empty($item->role) ){ 
        // Validate email 
        if(filter_var($item->email, FILTER_VALIDATE_EMAIL) === false){ 
            $response['message'] = 'Please enter a valid email.'; 
        }else{ 
            // Insert form data in the database 
            if($item->create()){
                $response['status'] = 1; 
                $response['message'] = 'User created successfully!';
            }else{
                $response['message'] = 'There is some error. Contact administrator';
            }
        } 
    }else{ 
         $response['message'] = 'Please fill all the mandatory fields (name and email).'; 
    } 

 
// Return response 
echo json_encode($response);
 
?>