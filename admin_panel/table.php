<?php
    session_start();
    require("backend.php");
    
    $connect = new Connect_db();
    $query = new Queries($connect);
    
    
    if (isset($_GET['deleteid'])) {
        $productId = $_GET['deleteid'];
            
        if ($query->deleteProduct($productId)) {
            header("Location: table.php?table=Products&deleted=Successfully_deleted_the_selected_item!");
        }
    }

    // query

    $limit = 5;

    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

    $start = ($page - 1) * $limit;

    // $tablename = "products";
    // $tabletoUse_inQuery = "PID";

    if (isset($_GET['table']) && $_GET['table'] == 'Reservation') {
        $tablename = "Reservation";
        $tabletoUse_inQuery = "eventreserve";
    } elseif (isset($_GET['table']) && $_GET['table'] == 'Event') {
        $tablename = "Event";
        $tabletoUse_inQuery = "eventreserve";
    } elseif (isset($_GET['table']) && $_GET['table'] == 'Users') {
        $tablename = "accounts";
        $tabletoUse_inQuery = "accounts";
    }
        
    if (isset($_GET['table']) || isset($_GET['page'])) {
        $result = $query->Print($start, $limit, $tablename);
        $rows = $result;
    }
    
    $totalRows = $query->getTotalRows($tabletoUse_inQuery);
    $totalPages = ceil($totalRows / $limit);
    
    $prev = $page > 1 ? $page - 1 : null;
    $next = $page < $totalPages ? $page + 1 : null;

    $count = 0;
    $count = ($page - 1) * $limit + 1;

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
</head>
<body>

  <!-- sidebar-header -->
  <?php include 'sidebar-header.php'; ?>


    <section class="section-panel">
        <div class="section-content">
        
            <div class="box-container">
                <main class="table">
                
                <?php 
                    if (isset($_GET['table']) && $_GET['table'] == 'Reservation') {
                        echo "<div class='title-btn'>
                                <h3>Reservation</h3>
                                <div class='add-btn'>
                                    <a href='pop-ups.php?pop=addProduct'>
                                        <ion-icon name='bag-add-outline'></ion-icon>
                                    </a>
                                </div>
                               </div>
                            ";
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
                                    <th>Event Date</th>
                                    <th>Theme</th>
                                    <th>Description</th>
                                    <th>Venue</th>
                                    <th>Package</th>
                                    <th>Price</th>
                                    <th>Payment Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        <?php } elseif (isset($_GET['table']) && $_GET['table'] == 'Users') {?>
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

                            <?php while ($row = mysqli_fetch_assoc($rows)){  ?>
                                <tr>
                                    <td><?php echo $count++ ?></td>
                                    <td><?php echo $row['accountID'] ?></td>
                                    <td><?php echo $row['customerName'] ?></td>
                                    <td><?php echo $row['phonenum'] ?></td>
                                    <td><?php echo $row['date'] ?></td>
                                    <td><?php echo $row['theme'] ?></td>
                                    <td><?php echo $row['description'] ?></td>
                                    <td><?php echo $row['facility'] ?></td>
                                    <td><?php echo $row['packageName'] ?></td>
                                    <td><?php echo $row['price'] ?></td>
                                    <td><?php echo $row['paymentstatus'] ?></td>
                                    <td>
                                        <a href="pop-ups.php?pop=updateProduct&updateId=<?php echo $row['accountID'] ?>"><ion-icon name="create-outline"></ion-icon></a>
                                        <a href="table.php?deleteid=<?php echo $row['accountID'] ?>" onclick="return confirm('Are you sure you want to delete this product?')"><ion-icon name="trash"></ion-icon></a>
                                    </td>
                                </tr>
                            <?php } ?>

                            </tbody>
                        <?php } elseif (isset($_GET['table']) && $_GET['table'] == 'Users') {?>
                            <tbody id="results">
                                <?php while ($row = mysqli_fetch_assoc($rows)){
                                    if ($row['role'] === 0) {
                                        continue;
                                    }
                                ?>
                                    <tr>
                                        <td><?php echo $count++ ?></td>
                                        <td><?php echo $row['name'] ?></td>
                                        <td><?php echo $row['email'] ?></td>
                                        <td><?php echo $row['datecreated'] ?></td>
                                        <td>
                                            <a href="users-table.php?deleteid=<?php echo $row['accountID'] ?>" onclick="return confirm('Are you sure you want to delete this product?')"><ion-icon name="trash"></ion-icon></a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        <?php } ?>
                            
                    </table>
                    
                    
                    </div>
                </main>
            </div>
            
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
        </div>        
    </section>




  <!-- side bar and pop-ups script -->
    <script src="admin-pop.js"></script>

    


    <!-- ionicons -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>
</html>