<?php
    class Connect_db {
        private $servername = "localhost";
        private $username ="root";
        private $password = "";
        private $database = "bookingsystem";
        private $conn;

        function  __construct() {

            $conn = new mysqli($this->servername, $this->username, $this->password, $this->database);
            

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $this->conn=$conn;
        }

        public function getConn(){  
            return $this->conn;
        }
        
        function closeConn(){
            $this->conn->close();
        }    
                
    }

    class Queries {
        private $connection;

        public function __construct(Connect_db $connect) {
            $this->connection = $connect->getConn();
        }

        public function Print($start,$limit,$tablename,$primarykey) {
            switch ($tablename) {
                case 'Reservation':
                    $sql = "SELECT p.PID, p.Pname, c.category, p.Pprice, p.Pdescription, p.Pimage 
                    FROM products AS p 
                    JOIN category AS c ON p.CID = c.CID 
                    ORDER BY p.PID ASC LIMIT ?, ?";

                    break;
                case 'Event':
                    $sql = "SELECT o.orderID, p.PID, a.name, p.Pname, c.quantity , p.Pprice 
                    FROM orders AS o
                        JOIN accounts AS a ON o.accountID = a.accountID
                            JOIN cart as c ON c.accountID = a.accountID
                            JOIN products AS p ON  c.PID = p.PID
                                ORDER BY o.productID ASC LIMIT  ?, ?";
                    break;
                case 'sales':
                    $sql = "SELECT * FROM sales
                    ORDER BY salesID ASC LIMIT  ?, ?";
                    break;
                case 'accounts':
                    $sql = "SELECT * FROM accounts ORDER BY " . $primarykey . " ASC LIMIT  ?, ?";
                    break;
                default:
                    # code...
                    break;
            }
            

            $stmt  = $this->connection->prepare($sql);

            $stmt->bind_param("ii", $start, $limit);
            $stmt->execute();
            $result = $stmt->get_result();
            
            return $result;
        }

        public  function getTotalRows(){
            $stmt = $this->connection->prepare("SELECT COUNT(*) AS total FROM products");
            $stmt->execute();
            $row = $stmt->get_result()->fetch_assoc();
            
            return $row["total"];
        }

        public function deleteProduct($productId)
        {
            $stmt_select = $this->connection->prepare("SELECT Pimage FROM products WHERE PID = ?");
            $stmt_select->bind_param("i", $productId);
            $stmt_select->execute();
            $result_select = $stmt_select->get_result();
            $row = $result_select->fetch_assoc();
            $imagePath = $row['Pimage'];
        
            // Delete the image path from the database
            $stmt_delete = $this->connection->prepare("DELETE FROM products WHERE PID = ?");
            $stmt_delete->bind_param("i", $productId);
            $result = $stmt_delete->execute();
        
            // Delete the image file from the folder
            if ($imagePath && file_exists($imagePath)) {
                unlink($imagePath);
            }
            
            return $result;
        }

        public function selectAll($tablename,$id) {
            $query="SELECT * FROM ".$tablename." WHERE productID=?";
            $stmt =  $this->connection->prepare($query);
            $stmt->bind_param('i',$id);
            $stmt->execute();
            $results = $stmt->get_result();

            return $results;
        }

        public function printUpdateproducts($id){
            $stmt = $this->connection->prepare("SELECT * FROM products JOIN specs ON products.PID= specs.specsID WHERE products.PID = ?");
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $results = $stmt->get_result();
        
            return $results;
        }

        public function getProductImageById($id) {
            $stmt_select = $this->connection->prepare("SELECT Pimage FROM products WHERE PID = ?");
            $stmt_select->bind_param("i", $id);
            $stmt_select->execute();
            $result_select = $stmt_select->get_result();
            $row = $result_select->fetch_assoc();
        
            return $row['Pimage'];
        }
        
        



    }

    class Accounts {
        protected $connection;
        private $name;
        protected $email;
        protected $password;

        public function __construct(Connect_db $connect, $name, $email, $password) {
            $this->connection = $connect->getConn();
            $this->name = $name;
            $this->email = $email;
            $this->password = $password;
        } 

        public function checkIfUserExists() {
            $stmt = $this->connection->prepare("SELECT * FROM accounts WHERE email = ?");
            $stmt->bind_param("s", $this->email);
            $stmt->execute();
        
            $result = $stmt->get_result();
        
            return $result->num_rows > 0;
        }

        public function createAccount() {
            $passwordhashed = password_hash($this->password, PASSWORD_BCRYPT);
            $role = 1;
            $datetime = date('Y-m-d H:i:s');
        
            $stmt =  $this->connection->prepare("INSERT INTO `accounts` (`name`, `email`, `password`, `datecreated`, `role`) VALUES(?,?,?,?,?)");
        
            $stmt->bind_param("sssss", $this->name, $this->email, $passwordhashed, $datetime, $role);
            $success = $stmt->execute();
        
            return $success;
        }

    }

    class AccountLogin extends Accounts {
        public function __construct(Connect_db $connect, $email, $password) {
            parent::__construct($connect, '', $email, $password);
        }
    
        public function loginAccount(){
            $stmt = $this->connection->prepare("SELECT * FROM `accounts` WHERE `email` = ?");
                $stmt->bind_param( "s", $this->email );
                $stmt->execute();
                $user = $stmt->get_result()->fetch_assoc();

                if ($user && password_verify($this->password, $user['password'])) {
                    return $user;
                }
            return null;
        }
    }
    

    class Products {
        protected $connection;
        private $productName;
        private $productType;
        private $productPrice;
        private $aboutProduct;
        private $productPictures;
        protected $bodymaterial;
        protected $bodyfinish;
        protected $fretboardmaterial;
        protected $numoffrets;
        protected $strings;
        
    
        public function __construct(Connect_db $connect, $productName, $productType, $productPrice, $aboutProduct, $productPictures, $bodymaterial, $bodyfinish, $fretboardmaterial, $numoffrets, $strings) {

            $this->connection = $connect->getConn();
            $this->productName = $productName;
            $this->productType = $productType;
            $this->productPrice = $productPrice;
            $this->aboutProduct = $aboutProduct;
            $this->productPictures = $productPictures;
            $this->bodymaterial = $bodymaterial;
            $this->bodyfinish = $bodyfinish;
            $this->fretboardmaterial = $fretboardmaterial;
            $this->numoffrets = $numoffrets;
            $this->strings = $strings;
        }

        public function InsertProducts() {
            $stmt = $this->connection->prepare("INSERT INTO `products` (`Pname`, `CID`, `Pprice`, `Pdescription`, `Pimage`) VALUES(?,?,?,?,?)");
            $stmt->bind_param("sidss" , $this->productName, $this->productType, $this->productPrice, $this->aboutProduct, $this->productPictures);
            $result = $stmt->execute();

            if ($result) {
                $foreignkey = mysqli_insert_id( $this->connection ); 

                $stmt = $this->connection->prepare("INSERT INTO `specs`(`bodymaterial`,`bodyfinish`,`fretboardmaterial`,`numoffrets`,`strings`,`productID`) VALUES (?,?,?,?,?,?)");

                $stmt->bind_param("sssisi",$this->bodymaterial, $this->bodyfinish, $this->fretboardmaterial, $this->numoffrets, $this->strings, $foreignkey);
                $success = $stmt->execute();
                if($success){
                    return $success;
                }else{
                    return  false;
                }
            }
        }

        public function Update($id){

            $stmt = $this->connection->prepare("UPDATE `products` SET `Pname`= ?, `CID`= ?, `Pprice`= ?, `Pdescription`= ?, `Pimage`=? WHERE `PID`= ?");
            $stmt->bind_param("sidssi", $this->productName, $this->productType, $this->productPrice, $this->aboutProduct, $this->productPictures, $id);
            $result = $stmt->execute();
        
            if ($result) {
                $stmt = $this->connection->prepare("UPDATE `specs` SET `bodymaterial`=?, `bodyfinish`=?, `fretboardmaterial`=?, `numoffrets`=?, `strings`=? WHERE `specsID`= ?");
                $stmt->bind_param("sssisi", $this->bodymaterial, $this->bodyfinish, $this->fretboardmaterial, $this->numoffrets, $this->strings, $id);
                $success = $stmt->execute();

                if ($success) {
                    return $success;
                }
            } else {
                return $stmt->error;
            }
        }

    }
        


?>




