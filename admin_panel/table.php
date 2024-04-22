<?php
    session_start();
    require("backend.php");

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    //Load Composer's autoloader
    require '../vendor/autoload.php';

    function Send_notif($name, $email, $message){
        $mail = new PHPMailer(true);

        $mail->isSMTP();                                                                
        $mail->SMTPAuth   = true;   

        $mail->Host       = 'smtp.gmail.com'; 
        $mail->Username   = 'magnifiqueeventsandco@gmail.com';                    
        $mail->Password   = 'imtyvdctjwkvlisv'; 
        
        $mail->SMTPSecure = "tls";            
        $mail->Port       = 587;

        $mail->setFrom('magnifiqueeventsandco@gmail.com', $name);
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = "Magnifique Events & Co.";

        $email_template = $message;

        $mail->Body = $email_template;
        $mail->send();
        if($mail) {
            return true;
        }else {
            return false;
        }
    }
    
    $connect = new Connect_db();
    $query = new Queries($connect);

    if (isset($_SESSION['UID'])) {
        header("Location: ../index.php");
    }

    // sessions
    if (isset($_GET['deleteAcc'])) {
        $query->deleteAccount($_GET['deleteAcc']);
    }

    
    
    if (isset($_GET['UpdateReserveStatus'])) {
        $accepted = "approved";
        $statusid = $_GET['UpdateReserveStatus'];

        $row = $query->selectInfo($statusid);

        $name = $row['customername'];
        $email  = $row['email'];
        $eventdate = $row['eventdate'];
        $eventtime = $row['eventtime'];
        $venue = $row['facility'];

        $message = "Good day $name! your reservation on $eventdate , $eventtime at $venue has been approved. <br>";

        $result = $query->UpdateReservationStatus($accepted,$statusid);

        if ($result) {
            Send_notif("$name","$email","$message");
        }else {
            echo "<script>alert('Error Updating Reservation Status');</script>";
        }
    }

    if (isset($_GET['decline'])) {
        $accepted = "declined";
        $statusid = $_GET['decline'];
        
        $row = $query->selectInfo($statusid);

        $name = $row['customername'];
        $email  = $row['email'];
        $eventdate = $row['eventdate'];
        $eventtime = $row['eventtime'];
        $venue = $row['facility'];

        $message = "Good day $name! your reservation on $eventdate , $eventtime at $venue has been declined. <br> ";

        $result = $query->UpdateReservationStatus($accepted,$statusid);

        if ($result) {
            Send_notif("$name","$email","$message");
        }else {
            echo "<script>alert('Error Updating Reservation Status');</script>";
        }
    }
    
    // query

    // $limit = 5;

    // $page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

    // $start = ($page - 1) * $limit;

    // // $tablename = "products";
    // // $tabletoUse_inQuery = "PID";

    // if (isset($_GET['table']) && $_GET['table'] == 'Reservation') {
    //     $tablename = "Reservation";
    //     $tabletoUse_inQuery = "eventreserve";
    // } elseif (isset($_GET['table']) && $_GET['table'] == 'Users') {
    //     $tablename = "accounts";
    //     $tabletoUse_inQuery = "accounts";
    // }
        
    // if (isset($_GET['table']) || isset($_GET['page'])) {
    //     $result = $query->Print($start, $limit, $tablename);
    //     $rows = $result;
    // }
    
    // $totalRows = $query->getTotalRows($tabletoUse_inQuery);
    // $totalPages = ceil($totalRows / $limit);
    
    // $prev = $page > 1 ? $page - 1 : null;
    // $next = $page < $totalPages ? $page + 1 : null;

    // $count = 0;
    // $count = ($page - 1) * $limit + 1;

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="admin.css">
    <!-- <link rel="stylesheet" href="pop-ups.css"> -->

    <!-- Boxiocns CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>

    <!-- ajax -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Include SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

</head>
<body>

    <!-- Include SweetAlert2 library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- sidebar-header -->
  <?php include 'sidebar-header.php'; ?>

    <section class="section-panel">
        <div class="section-content">
        
            <div class="box-container">
                <main class="table">
                
                <?php 
                    if (isset($_GET['table']) && $_GET['table'] == 'Reservation') {
                        echo "<center><h3>Reservation</h3></center>";
                    } elseif (isset($_GET['table']) && $_GET['table'] == 'Users') {
                        echo "<center><h3>User Accounts</h3></center>";
                    }
                        
                ?>
        
                <div class="table-body">
                    <table>

                    <!-- 
                        TABLE HEAD 
                    -->
                        <?php if (isset($_GET['table']) && $_GET['table'] == 'Reservation') { ?>
                            <thead>
                                <tr>
                                    <th>no.</th>
                                    <th>Account Name</th>
                                    <th>Customer Name</th>
                                    <th>Phone Number</th>
                                    <th>Event Type</th>
                                    <th>Event Date</th>
                                    <th>Event Time</th>
                                    <th>Description</th>
                                    <th>Venue</th>
                                    <th>Package</th>
                                    <th>Price</th>
                                    <th>Payment Status</th>
                                    <th>Reservation Status</th>
                                </tr>
                            </thead>
                        <?php } elseif (isset($_GET['table']) && $_GET['table'] == 'Users') { ?>
                            <thead>
                                <tr>
                                    <th>no.</th>
                                    <th>User Name</th>
                                    <th>Email</th>
                                    <th>Date Created</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        <?php } ?>
                        
                        <!-- 
                            TABLE BODY
                        -->
                        <?php if (isset($_GET['table']) && $_GET['table'] == 'Reservation') { ?>

                            <tbody id="results">

                                <!-- ajax will fullfil your dreams charot yung kwan ahm result -->

                            </tbody>

                        <?php } elseif (isset($_GET['table']) && $_GET['table'] == 'Users') {?>
                            <tbody id="results">

                                <!-- ajax will fullfil your dreams charot yung kwan ahm result -->

                            </tbody>
                        <?php } ?>
                            
                    </table>
                    
                    
                    </div>
                </main>
            </div>
            
<!--             
            <div class="pagination">
                    <?php if ($prev !== null): ?>
                        <a href="?page=<?php echo $prev; ?>">Previous</a>
                    <?php endif; ?>
                    
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a <?php if ($i == $page) echo 'class="active"'; ?> href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    <?php endfor; ?>

                    <?php if ($next !== null): ?>
                        <a href="?page=<?php echo $next; ?>">Next</a>
                    <?php endif; ?>
                </div>
            </div>         -->
    </section>




    <!-- side bar and pop-ups script -->
    <script src="admin-pop.js"></script>

    


    <!-- ionicons -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>
</html>