
<?php
require_once("backend.php");
$connect = new Connect_db();
$mysqli = $connect->getConn(); // Assuming getConnection() returns the MySQLi object

if (isset($_POST['searchEvent'])) {
    $searchEvent = $_POST['searchEvent'];
    $query = "SELECT a.accountID, a.name as customerName, e.phonenum, e.date, e.theme, e.description, e.type, v.facility, p.name as packageName, p.price
                FROM booking as b
                INNER JOIN eventreserve as e ON b.eventID = e.eventID
                INNER JOIN accounts as a ON e.accountID = a.accountID
                INNER JOIN venue as v ON e.venueID = v.venueID
                INNER JOIN package as p ON e.packageID = p.packageID
                INNER JOIN payment as pay ON e.paymentID = pay.paymentID
                WHERE a.name LIKE '%$searchEvent%'";
    $stmt = $mysqli->prepare($query);
    // $stmt->bind_param("s", $searchEvent);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $query = "SELECT a.accountID, a.name as customerName, e.phonenum, e.date, e.theme, e.description, e.type, v.facility, p.name as packageName, p.price
                FROM booking as b
                INNER JOIN eventreserve as e ON b.eventID = e.eventID
                INNER JOIN accounts as a ON e.accountID = a.accountID
                INNER JOIN venue as v ON e.venueID = v.venueID
                INNER JOIN package as p ON e.packageID = p.packageID
                INNER JOIN payment as pay ON e.paymentID = pay.paymentID";
    $result = $mysqli->query($query);
}

if ($result) {
    if ($result->num_rows > 0) {
        $count = 0;
        while ($row = $result->fetch_assoc()) {
            ?>
                <tr>
                    <td><?php echo ++$count ?></td>
                    <td><?php echo $row['accountID'] ?></td>
                    <td><?php echo $row['customerName'] ?></td>
                    <td><?php echo $row['phonenum'] ?></td>
                    <td><?php echo $row['date'] ?></td>
                    <td><?php echo $row['theme'] ?></td>
                    <td><?php echo $row['description'] ?></td>
                    <td><?php echo $row['facility'] ?></td>
                    <td><?php echo $row['packageName'] ?></td>
                    <td><?php echo $row['price'] ?></td>
                </tr>
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








