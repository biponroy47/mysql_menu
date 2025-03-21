<?php
session_start();

//get order id from previous screen, either from inserting a new order or viewing order from all orders screen
if (isset($_GET['orderid'])) {
    $orderid = $_GET['orderid'];
} elseif (isset($_SESSION['orderid'])) {
    $orderid = $_SESSION['orderid'];
    unset($_SESSION['orderid']);
} else {
    header("Location: addneworder.php");
    exit();
}

include 'connecttodb.php';

// get all menu items associated with order, price and quantities
$query = "
    SELECT 
        m.dishname, 
        m.price, 
        o.quantity, 
        (o.quantity * m.price) AS total_price 
    FROM 
        overallorder o 
    JOIN 
        menuitem m 
    ON 
        o.menuitemid = m.menuitemid 
    WHERE 
        o.orderid = '$orderid'
";

$result = mysqli_query($connection, $query);

if (!$result) {
    die("Error executing query: " . mysqli_error($connection));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order Confirmation</title>
    <link rel="stylesheet" type="text/css" href="../css/displayorder.css">
</head>
<body>
    <h1>Order Details</h1>
    <h2>Order ID: <?php echo $orderid; ?></h2>
    <table>
        <thead>
            <tr>
                <th>Dish Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total Price</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['dishname'] . "</td>";
                    echo "<td>" . $row['price'] . "</td>";
                    echo "<td>" . $row['quantity'] . "</td>";
                    echo "<td>" . $row['total_price'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No items found for this order.</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <?php
    $subtotal = 0;
    //calculate subtotal using quantities and prices
    if (mysqli_num_rows($result) > 0) {
        mysqli_data_seek($result, 0);
        while ($row = mysqli_fetch_assoc($result)) {
            $subtotal += $row['total_price'];
        }
    }
    echo "<h1>Subtotal: $" . number_format($subtotal, 2) . "</h1>";
    ?>

    <p><a href="showorders.php">View All Orders</a></p>
    <p><a href="../mainmenu.php">Back to Main Menu</a></p>

    <?php
    mysqli_free_result($result);
    mysqli_close($connection);
    ?>
</body>
</html>