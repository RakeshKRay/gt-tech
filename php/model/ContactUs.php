<?php
    class ContactUs{

        // Connection
        private $conn;

        // Table
        private $db_table = "contact_us";

        // Columns
        public $id;
        public $name;
        public $email;
        public $phone;
        public $message;
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
                        name = :name, 
                        email = :email, 
                        phone = :phone, 
                        message = :message, 
                        created_date = :created_date";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            // sanitize
            $this->name=htmlspecialchars(strip_tags($this->name));
            $this->email=htmlspecialchars(strip_tags($this->email));
            $this->phone=htmlspecialchars(strip_tags($this->phone));
            $this->message=htmlspecialchars(strip_tags($this->message));
            $this->created_date=htmlspecialchars(strip_tags($this->created_date));
        
            // bind data
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":age", $this->phone);
            $stmt->bindParam(":designation", $this->message);
            $stmt->bindParam(":created", $this->created_date);
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        // READ single
        public function getSingleContactUs(){
            $sqlQuery = "SELECT
                        id, 
                        name, 
                        email, 
                        phone, 
                        message, 
                        created_date
                      FROM
                        ". $this->db_table ."
                    WHERE 
                       id = ?
                    LIMIT 0,1";

            $stmt = $this->conn->prepare($sqlQuery);

            $stmt->bindParam(1, $this->id);

            $stmt->execute();

            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $this->name = $dataRow['name'];
            $this->email = $dataRow['email'];
            $this->phone = $dataRow['phone'];
            $this->message = $dataRow['message'];
            $this->created_date = $dataRow['created_date'];
        }        

        // // UPDATE
        // public function updateEmployee(){
        //     $sqlQuery = "UPDATE
        //                 ". $this->db_table ."
        //             SET
        //                 name = :name, 
        //                 email = :email, 
        //                 phone = :phone, 
        //                 message = :message, 
        //                 created_date = :created_date
        //             WHERE 
        //                 id = :id";
        
        //     $stmt = $this->conn->prepare($sqlQuery);
        
        //     $this->name=htmlspecialchars(strip_tags($this->name));
        //     $this->email=htmlspecialchars(strip_tags($this->email));
        //     $this->phone=htmlspecialchars(strip_tags($this->phone));
        //     $this->message=htmlspecialchars(strip_tags($this->message));
        //     $this->created_date=htmlspecialchars(strip_tags($this->created_date));
        //     $this->id=htmlspecialchars(strip_tags($this->id));
        
        //     // bind data
        //     $stmt->bindParam(":name", $this->name);
        //     $stmt->bindParam(":email", $this->email);
        //     $stmt->bindParam(":phone", $this->phone);
        //     $stmt->bindParam(":message", $this->message);
        //     $stmt->bindParam(":created_date", $this->created_date);
        //     $stmt->bindParam(":id", $this->id);
        
        //     if($stmt->execute()){
        //        return true;
        //     }
        //     return false;
        // }

        // DELETE
        function deleteEmployee(){
            $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ?";
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->id=htmlspecialchars(strip_tags($this->id));
        
            $stmt->bindParam(1, $this->id);
        
            if($stmt->execute()){
                return true;
            }
            return false;
        }

    }
?>