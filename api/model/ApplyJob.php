<?php
class ApplyJob{
    // Connection
    private $conn;

    // Table
    private $db_table = "apply_job";

    // Columns
    public $id;
    public $fname;
    public $dob;
    public $experience;
    public $location;
    public $email;
    public $phone;
    public $designation;
    public $applyDesc;
    public $cv;
    public $created_date;

    // Db connection
    public function __construct($db){
        $this->conn = $db;
    }

    // GET ALL
    public function getAll(){
        $sqlQuery = "SELECT * FROM " . $this->db_table . "";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }

    // CREATE
    public function createContactUs(){
        $sqlQuery = "INSERT INTO
                    ". $this->db_table ."
                SET
                    fname = :fname,
                    dob = :dob, 
                    experience= :experience,
                    location = :location,
                    email = :email, 
                    phone = :phone, 
                    designation = :designation,
                    message = :message, 
                    created_date = :created_date";
    
        $stmt = $this->conn->prepare($sqlQuery);
    
        // sanitize
        $this->fname=htmlspecialchars(strip_tags($this->fname));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->phone=htmlspecialchars(strip_tags($this->phone));
        $this->message=htmlspecialchars(strip_tags($this->message));
        $this->created_date=htmlspecialchars(strip_tags($this->created_date));
    
        // bind data
        $stmt->bindParam(":fname", $this->fname);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":phone", $this->phone);
        $stmt->bindParam(":message", $this->message);
        $stmt->bindParam(":created_date", $this->created_date);
    
        if($stmt->execute()){
           return true;
        }
        return false;
    }

    // READ single
    public function getSingleContactUs(){
        $sqlQuery = "SELECT * FROM ". $this->db_table ." WHERE id = ? LIMIT 0,1";

        $stmt = $this->conn->prepare($sqlQuery);

        $stmt->bindParam(1, $this->id);

        $stmt->execute();

        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $this->id = $dataRow['id'];
        $this->fname = $dataRow['fname'];

        $this->email = $dataRow['email'];
        $this->phone = $dataRow['phone'];
        $this->message = $dataRow['message'];
        $this->created_date = $dataRow['created_date'];
    }
}
?>