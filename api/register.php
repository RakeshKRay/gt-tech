<?php
include_once 'config/database.php';
include_once 'model/users.php';

$response = array( 
    'status' => 0, 
    'message' => 'Form submission failed, please try again.' 
); 
$database = new Database();
$db = $database->getConnection();
$item = new Users($db);
// If form is submitted 
if(isset($_POST['fname']) || isset($_POST['lname']) || isset($_POST['email']) || isset($_POST['password']) ){ 
    // Get the submitted form data 
    $item->fname = $_POST['fname']; 
    $item->dob = $_POST['lname'];
    $item->experience = $_POST['email'];
    $item->location = $_POST['password'];
    $item->created_date = date('Y-m-d H:i:s');
    // Check whether submitted data is not empty 
    if(!empty($item->fname) && !empty($item->email) && !empty($item->lname) && !empty($item->password) ){ 
        // Validate email 
        if(filter_var($item->email, FILTER_VALIDATE_EMAIL) === false){ 
            $response['message'] = 'Please enter a valid email.'; 
        }else{ 
            $uploadStatus = 1; 
             
            if($uploadStatus == 1){  
                // Insert form data in the database 
                if($item->create()){
                    $response['status'] = 1; 
                    $response['message'] = 'Form data submitted successfully!';
                     } 
            } 
        } 
    }else{ 
         $response['message'] = 'Please fill all the mandatory fields (name and email).'; 
    } 
} 
 
// Return response 
echo json_encode($response);
 
?>