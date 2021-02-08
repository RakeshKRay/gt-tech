<?php
include_once 'config/database.php';
include_once 'model/ApplyJob.php';

$uploadDir = './uploads/'; 
$response = array( 
    'status' => 0, 
    'message' => 'Form submission failed, please try again.' 
); 
$database = new Database();
$db = $database->getConnection();
$item = new ApplyJob($db);
// If form is submitted 
if(isset($_POST['fname']) || isset($_POST['dob']) || isset($_POST['experience']) || isset($_POST['location']) || isset($_POST['phone']) || isset($_POST['email']) || isset($_POST['designation']) || isset($_POST['applyDesc']) || isset($_POST['file'])){ 
    // Get the submitted form data 
    $item->fname = $_POST['fname']; 
    $item->dob = $_POST['dob'];
    $item->experience = $_POST['experience'];
    $item->location = $_POST['location'];
    $item->phone = $_POST['phone'];
    $item->email = $_POST['email'];
    $item->designation = $_POST['designation'];
    $item->applyDesc = $_POST['applyDesc'];
    $item->created_date = date('Y-m-d H:i:s');
    // Check whether submitted data is not empty 
    if(!empty($item->fname) && !empty($item->email)){ 
        // Validate email 
        if(filter_var($item->email, FILTER_VALIDATE_EMAIL) === false){ 
            $response['message'] = 'Please enter a valid email.'; 
        }else{ 
            $uploadStatus = 1; 
             
            // Upload file 
            $uploadedFile = ''; 
            if(!empty($_FILES["file"]["name"])){ 
                 
                // File path config 
                $fileName = basename($_FILES["file"]["name"]); 
                $targetFilePath = $uploadDir . $fileName; 
                $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION); 
                 
                // Allow certain file formats 
                $allowTypes = array('pdf', 'doc', 'docx'); 
                if(in_array($fileType, $allowTypes)){ 
                    // Upload file to the server 
                    if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){ 
                        $uploadedFile = $fileName; 
                    }else{ 
                        $uploadStatus = 0; 
                        $response['message'] = 'Sorry, there was an error uploading your file.'; 
                    } 
                }else{ 
                    $uploadStatus = 0; 
                    $response['message'] = 'Sorry, only PDF, DOC files are allowed to upload.'; 
                } 
            } 
             
            if($uploadStatus == 1){  
                $item->cv = $uploadedFile; 
                // Insert form data in the database 
                if($item->createApplyJob()){
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
    // header("Access-Control-Allow-Origin: *");
    // header("Content-Type: application/json; charset=UTF-8");
    // header("Access-Control-Allow-Methods: POST");
    // header("Access-Control-Max-Age: 3600");
    // header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    // include_once 'config/database.php';
    // include_once 'model/ApplyJob.php';
    
    // $database = new Database();
    // $db = $database->getConnection();

    // $item = new ApplyJob($db);
    // $data = json_decode(file_get_contents("php://input"));

    // $item->fname = $data->fname;
    // $item->dob = $data->dob;
    // $item->experience = $data->experience;
    // $item->location = $data->location;
    // $item->email = $data->email;
    // $item->phone = $data->phone;
    // $item->designation = $data->designation;
    // $item->applyDesc = $data->applyDesc;
    // $item->cv = $data->cv;
    // $item->created_date = date('Y-m-d H:i:s');
    
    // if($item->createApplyJob()){
    //    echo json_encode('Request added successfully.');
    // } else{
    //     echo json_encode('Request could not be added.');
    // }
?>