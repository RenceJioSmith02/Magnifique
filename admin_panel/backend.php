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

        public  function getTotalRows($tabletoUse_inQuery ){
            $stmt = $this->connection->prepare("SELECT COUNT(*) AS total FROM $tabletoUse_inQuery ");
            $stmt->execute();
            $row = $stmt->get_result()->fetch_assoc();
            
            return $row["total"];
        }

        public function selectALLreservation($accountID) {
            $query="SELECT e.RID, e.accountID, e.customername, p.packagename, e.eventdate, e.eventtime, v.facility, b.bookingdate, b.reservationstatus
            FROM booking as b
            INNER JOIN eventreserve as e ON b.RID = e.RID
            INNER JOIN package as p ON b.packageID = p.packageID
            INNER JOIN venue as v ON b.venueID = v.venueID
            WHERE e.accountID = ?";
            $stmt =  $this->connection->prepare($query);
            $stmt->bind_param('i',$accountID);
            $stmt->execute();
            $results = $stmt->get_result();

            return $results;
        }
        public function selectONEreservation($RID) {
            $query="SELECT e.RID, e.accountID, e.customername, p.packagename, e.eventdate, e.eventtime, v.facility, b.bookingdate, b.reservationstatus
            FROM booking as b
            INNER JOIN eventreserve as e ON b.RID = e.RID
            INNER JOIN package as p ON b.packageID = p.packageID
            INNER JOIN venue as v ON b.venueID = v.venueID
            WHERE e.RID = ?";
            $stmt =  $this->connection->prepare($query);
            $stmt->bind_param('i',$RID);
            $stmt->execute();
            $results = $stmt->get_result();

            return $results;
        }
        
        
        public function checkDate($venue,$eventdate){
            $stmt = $this->connection->prepare("SELECT b.venueID, e.eventdate 
                                                    FROM `booking` as b
                                                    INNER JOIN eventreserve as e 
                                                    ON b.RID = e.RID
                                                    WHERE b.venueID = ? AND e.eventdate = ?");
            $stmt->bind_param('is', $venue, $eventdate);
            $stmt->execute();
            $results = $stmt->get_result()->fetch_assoc();
        
            return $results !== null;
        }
        
        public function checkUserExist($accountID) {
            $stmt = $this->connection->prepare("SELECT DISTINCT COUNT(*) AS total FROM accounts WHERE accountID=?");
            $stmt->bind_param("i", $accountID); 
            $stmt->execute();
            $row = $stmt->get_result()->fetch_assoc();
            
            return $row["total"];
        }
        public function deleteAccount($accountID) {
            $stmt_delete = $this->connection->prepare("DELETE FROM accounts WHERE accountID = ?");
            $stmt_delete->bind_param("i", $accountID);
            $stmt_delete->execute();
        }
        public function UpdateReservationStatus($status,$bookingID) {
            $stmt_delete = $this->connection->prepare("UPDATE `booking` SET `reservationstatus`= ? WHERE bookingID = ?");
            $stmt_delete->bind_param("si", $status, $bookingID);
            $result =  $stmt_delete->execute();

            return  $result;
        }
        
        public function selectInfo($bookingID) {
            $stmt_select = $this->connection->prepare("SELECT a.email, e.customername, e.eventdate, e.eventtime, v.facility FROM `booking` AS b
                                                            INNER JOIN eventreserve AS e ON b.RID = e.RID 
                                                            INNER JOIN venue AS v ON b.venueID = v.venueID 
                                                            INNER JOIN accounts AS a ON e.accountID = a.accountID 
                                                            WHERE b.bookingID = ?");
                                                        
            $stmt_select->bind_param("i", $bookingID);
            $stmt_select->execute();
            $row = $stmt_select->get_result()-> fetch_assoc();

            return $row;
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
        
            $stmt =  $this->connection->prepare("INSERT INTO `accounts` (`accountname`, `email`, `password`, `datecreated`, `role`) VALUES(?,?,?,?,?)");
        
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
        

    class Reservation {
        private $connection;
        private $name;
        private $phonenum;
        private $package;
        private $eventdate;
        private $eventtime;
        private $venue;
        private $numofguest;
        private $description;
        private $cardname;
        private $cardtype;
        private $cardnumber;
        private $paymenttype;
        private $amount;
        private $dateofpayment;
        private $eventtype;

        public function __construct(Connect_db $connect, $name, $phonenum, $package, $eventdate, $eventtime, $venue, $numofguest, $description, $cardname, $cardtype, $cardnumber, $paymenttype, $amount, $dateofpayment, $eventtype) {
            $this->connection = $connect->getConn();
            $this->name = $name;
            $this->phonenum = $phonenum;
            $this->package = $package;
            $this->eventdate = $eventdate;
            $this->eventtime = $eventtime;
            $this->venue = $venue;
            $this->numofguest = $numofguest;
            $this->description = $description;
            $this->cardname = $cardname;
            $this->cardtype = $cardtype;
            $this->cardnumber = $cardnumber;
            $this->paymenttype = $paymenttype;
            $this->amount = $amount;
            $this->dateofpayment = $dateofpayment;
            $this->eventtype = $eventtype;

        }

        public function insertReserve($accountID) {

            
            $stmt =  $this->connection->prepare("INSERT INTO `payment`( `nameoncard`,`cardtype`, `cardnumber`, `amount`, `payment_date`, `paymentstatus`)  VALUES(?,?,?,?,?,?)");
        
            $stmt->bind_param("ssiiss", $this->cardname, $this->cardtype, $this->cardnumber, $this->amount, $this->dateofpayment, $this->paymenttype );
            $success = $stmt->execute();

            if ($success) {
                $foreignkey = mysqli_insert_id($this->connection) ;  // get the last id inserted in database
                $stmt =  $this->connection->prepare("INSERT INTO `eventreserve`(`customername`, `phonenum`, `eventtype`, `eventdate`, `eventtime`, `numofguest`, `description`, `paymentID`, `accountID`) VALUES(?,?,?,?,?,?,?,?,?)");
        
                $stmt->bind_param("sisssssii", $this->name, $this->phonenum, $this->eventtype, $this->eventdate, $this->eventtime, $this->numofguest, $this->description, $foreignkey, $accountID);
                $success1 = $stmt->execute();

                if ($success1) {
                    $foreignkey1 = mysqli_insert_id($this->connection) ;  // get the last id inserted in database
                    $date =  date("Y-m-d");
                    $status = 'Pending';
                    $stmt =  $this->connection->prepare("INSERT INTO `booking`(`RID`, `bookingdate`, `venueID`, `packageID`, `reservationstatus`) VALUES(?,?,?,?,?)");
            
                    $stmt->bind_param("isiis",$foreignkey1, $date, $this->venue, $this->package, $status);
                    $success2 = $stmt->execute();

                    if ($success2) {
                        return $success2;
                    }
                }
            }
            return false;
        }
    }


?>




