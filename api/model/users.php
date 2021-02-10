<?php
class Users{
    // Connection
    private $conn;

    // Table
    private $db_table = "users";

    // Columns
    public $id;
    public $fname;
    public $lname;
    public $email;
    public $password;
    public $created_date;
    public $role;

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
     public function create(){
        $sqlQuery = "INSERT INTO ". $this->db_table ." SET fname = :fname, lname = :lname, email = :email, password = :password, created_date = :created_date, role = :role";
    
        $stmt = $this->conn->prepare($sqlQuery);
    
        // sanitize
        $this->fname = htmlspecialchars(strip_tags($this->fname));
        $this->lname = htmlspecialchars(strip_tags($this->lname));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->created_date = htmlspecialchars(strip_tags($this->created_date));
        $this->role = htmlspecialchars(strip_tags($this->role));
    
        // bind data
        $stmt->bindParam(":fname", $this->fname);
        $stmt->bindParam(":lname", $this->lname);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":created_date", $this->created_date);
        $stmt->bindParam(":role", $this->role);
    
        if($stmt->execute()){
           return true;
        }
        return false;
    }

    // READ single
    public function getSingle(){
        $sqlQuery = "SELECT * FROM ". $this->db_table ." WHERE id = ? LIMIT 0,1";

        $stmt = $this->conn->prepare($sqlQuery);

        $stmt->bindParam(1, $this->id);
        
        $stmt->execute();
        $num = $stmt->rowCount();
        if($num>0){
            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $dataRow['id'];
            $this->fname = $dataRow['fname'];
            $this->lname = $dataRow['lname'];
            $this->password = $dataRow['password'];
            $this->email = $dataRow['email'];
            $this->created_date = $dataRow['created_date'];
            $this->role = $dataRow['role'];
        }
    }   
    
    // READ single
    public function checkLogin(){
        $sqlQuery = "SELECT * FROM ". $this->db_table ." WHERE email = ? and password = ? LIMIT 0,1";

        $stmt = $this->conn->prepare($sqlQuery);

        $stmt->bindParam(1, $this->email);
        $stmt->bindParam(1, $this->password);
        $stmt->execute();
        $num = $stmt->rowCount();
        if($num>0){
            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $dataRow['id'];
            $this->fname = $dataRow['fname'];
            $this->email = $dataRow['lname'];
            $this->created_date = $dataRow['created_date'];
            $this->role = $dataRow['role'];
            return true;
        }else{
            return false;
        }
    }
}
?>