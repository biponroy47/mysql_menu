<?php
include 'connecttodb.php';

//query to retreive all orders from cusorder
$query = "
    SELECT 
        co.orderid, 
        c.firstname AS customer_firstname, 
        c.lastname AS customer_lastname, 
        co.dateplaced, 
        co.timeplaced, 
        co.timedelivered, 
        co.deliveryrating, 
        d.firstname AS driver_firstname, 
        d.lastname AS driver_lastname
    FROM 
        cusorder co
    JOIN 
        customer c ON co.cusid = c.cusid
    LEFT JOIN 
        driver d ON co.driverid = d.driverid
";

$result = mysqli_query($connection, $query);
if (!$result) {
    die("Error executing query: " . mysqli_error($connection));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Orders</title>
    <link rel="stylesheet" type="text/css" href="../css/showorders.css">
</head>
<body>
    <h1>All Orders</h1>
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer First Name</th>
                <th>Customer Last Name</th>
                <th>Date Placed</th>
                <th>Time Placed</th>
                <th>Time Delivered</th>
                <th>Delivery Rating</th>
                <th>Driver First Name</th>
                <th>Driver Last Name</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['orderid'] . "</td>";
                    echo "<td>" . $row['customer_firstname'] . "</td>";
                    echo "<td>" . $row['customer_lastname'] . "</td>";
                    echo "<td>" . $row['dateplaced'] . "</td>";
                    echo "<td>" . $row['timeplaced'] . "</td>";
                    echo "<td>" . $row['timedelivered'] . "</td>";
                    echo "<td>" . $row['deliveryrating'] . "</td>";
                    echo "<td>" . $row['driver_firstname'] . "</td>";
                    echo "<td>" . $row['driver_lastname'] . "</td>";
                    echo "<td>
                            <form action='displayorder.php' method='GET' style='display:inline;'>
                                <input type='hidden' name='orderid' value='" . $row['orderid'] . "'>
                                <button type='submit'>View Order</button>
                            </form>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='10'>No orders found.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <p><a href="../mainmenu.php">Back to Main Menu</a></p>

    <?php
    mysqli_free_result($result);
    mysqli_close($connection);
    ?>
</body>
</html>