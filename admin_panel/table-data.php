
<?php
    require_once("backend.php");
    $connect = new Connect_db();
    $mysqli = $connect->getConn(); 

    if (isset( $_GET['tablename'] )) {
        $tablename = $_GET['tablename'];
    }
    
    if (isset($_GET['searchEvent'])) {
        
        $searchEvent = $_GET['searchEvent'];

        $query = "SELECT *
                    FROM booking as b
                    INNER JOIN eventreserve as e ON b.RID = e.RID
                    INNER JOIN venue as v ON b.venueID = v.venueID
                    INNER JOIN package as p ON b.packageID = p.packageID
                    INNER JOIN accounts as a ON e.accountID = a.accountID
                    INNER JOIN payment as pay ON e.paymentID = pay.paymentID
                    WHERE a.accountname LIKE '%$searchEvent%'";
        $stmt = $mysqli->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
    } else {
        $query = "SELECT *
                    FROM booking as b
                    INNER JOIN eventreserve as e ON b.RID = e.RID
                    INNER JOIN venue as v ON b.venueID = v.venueID
                    INNER JOIN package as p ON b.packageID = p.packageID
                    INNER JOIN accounts as a ON e.accountID = a.accountID
                    INNER JOIN payment as pay ON e.paymentID = pay.paymentID";
        $result = $mysqli->query($query);
    }

    if ($result) {
        if ($result->num_rows > 0) {
            $count = 0;
            while ($row = $result->fetch_assoc()) {
                ?>
                <?php if ($tablename == 'Event') {?>
                    <tr>
                        <td><?php echo ++$count ?></td>
                        <td><?php echo $row['accountID'] ?></td>
                        <td><?php echo $row['accountname'] ?></td>
                        <td><?php echo $row['phonenum'] ?></td>
                        <td><?php echo $row['eventtype'] ?></td>
                        <td><?php echo $row['eventdate'] ?></td>
                        <td><?php echo $row['eventtime'] ?></td>
                        <td><?php echo $row['description'] ?></td>
                        <td><?php echo $row['facility'] ?></td>
                        <td><?php echo $row['packagename'] ?></td>
                        <td><?php echo $row['price'] ?></td>
                    </tr>
                <?php } elseif ($tablename == 'Reservation') {?>

                    <tr>
                        <td><?php echo ++$count ?></td>
                        <td><?php echo $row['accountID'] ?></td>
                        <td><?php echo $row['accountname'] ?></td>
                        <td><?php echo $row['phonenum'] ?></td>
                        <td><?php echo $row['eventtype'] ?></td>
                        <td><?php echo $row['eventdate'] ?></td>
                        <td><?php echo $row['eventtime'] ?></td>
                        <td><?php echo $row['description'] ?></td>
                        <td><?php echo $row['facility'] ?></td>
                        <td><?php echo $row['packagename'] ?></td>
                        <td><?php echo $row['amount'] ?></td>
                        <td><?php echo $row['paymentstatus'] ?></td>
                        <td>
                            <a href="table.php?table=Reservation&UpdateReserveStatus=<?php echo $row['bookingID'] ?>">accept</a>
                            <a href="table.php?deleteid=<?php echo $row['accountID'] ?>" onclick="return confirm('Are you sure you want to delete this product?')">decline</a>
                        </td>
                    </tr>

                <?php } elseif ($tablename == 'Users') {
                    if ($row['role'] === 0) {
                        continue;
                    }
                ?>
                    <tr>
                        <td><?php echo ++$count ?></td>
                        <td><?php echo $row['accountname'] ?></td>
                        <td><?php echo $row['email'] ?></td>
                        <td><?php echo $row['datecreated'] ?></td>
                        <td>
                            <a href="table.php?table=Users&deleteAcc=<?php echo $row['accountID'] ?>" onclick="return confirm('Are you sure you want to delete this product?')"><ion-icon name="trash"></ion-icon></a>
                        </td>
                    </tr>

                <?php } ?>

                <?php
            }
        } else {
            echo "<h3>No Search Found...</h3>";
        }
    } else {
        // Handle database error
        echo "Error: " . $mysqli->error;
    }
?>







                        
