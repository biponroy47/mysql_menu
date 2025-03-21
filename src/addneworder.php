<?php
session_start();
include "connecttodb.php";

$customerQuery = "SELECT cusid FROM customer";
$customerResult = mysqli_query($connection, $customerQuery);

if (!$customerResult) {
    die("Error fetching customer IDs: " . mysqli_error($connection));
}

$driverQuery = "SELECT driverid FROM driver";
$driverResult = mysqli_query($connection, $driverQuery);
if (!$driverResult) {
    die("Error fetching driver IDs: " . mysqli_error($connection));
}

$dishQuery = "SELECT menuitemid, dishname FROM menuitem";
$dishResult = mysqli_query($connection, $dishQuery);
if (!$dishResult) {
    die("Error fetching dish names: " . mysqli_error($connection));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Insert New Order</title>
    <link rel="stylesheet" type="text/css" href="../css/addneworder.css">
</head>
<body>
    <h1>Insert New Order</h1>
    <?php
    if (isset($_SESSION['error'])) {
        echo '<div class="message error">' . $_SESSION['error'] . '</div>';
        unset($_SESSION['error']);
    }
    ?>
    <!-- redirect to process new order page to insert new data -->
    <form action="process_new_order.php" method="POST">
        <div class="container">
            <div class="form-container">
                <h2>Order Details</h2>
                <label for="orderid">Order ID:</label>
                <input type="text" id="orderid" name="orderid" maxlength="4" required>
                <br>
                <label for="deladdress">Delivery Address:</label>
                <input type="text" id="deladdress" name="deladdress" maxlength="20">
                <br>
                <label for="dateplaced">Date Placed:</label>
                <input type="date" id="dateplaced" name="dateplaced" required>
                <br>
                <label for="timeplaced">Time Placed:</label>
                <input type="time" id="timeplaced" name="timeplaced" required>
                <br>
                <label for="timedelivered">Time Delivered:</label>
                <input type="time" id="timedelivered" name="timedelivered">
                <br>
                <label for="pickuporder">Pickup Order (Y/N):</label>
                <select id="pickuporder" name="pickuporder" required>
                    <option value="">-- Select Pickup Option --</option>
                    <option value="Y">Yes</option>
                    <option value="N">No</option>
                </select>
                <br>
                <label for="deliveryrating">Delivery Rating (1-5):</label>
                <input type="number" id="deliveryrating" name="deliveryrating" min="1" max="5">
                <br>
                <label for="driverid">Driver ID:</label>
                <select id="driverid" name="driverid">
                    <option value="">-- Select Driver --</option>
                    <?php
                    while ($row = mysqli_fetch_assoc($driverResult)) {
                        echo '<option value="' . $row['driverid'] . '">' . $row['driverid'] . '</option>';
                    }
                    ?>
                </select>
                <br>
                <label for="cusid">Customer ID:</label>
                <select id="cusid" name="cusid" required>
                    <option value="">-- Select Customer --</option>
                    <?php
                    mysqli_data_seek($customerResult, 0);
                    while ($row = mysqli_fetch_assoc($customerResult)) {
                        echo '<option value="' . $row['cusid'] . '">' . $row['cusid'] . '</option>';
                    }
                    ?>
                </select>
                <br>
            </div>
            <div class="form-container">
                <h2>Select Dishes</h2>
                <?php
                mysqli_data_seek($dishResult, 0);
                while ($row = mysqli_fetch_assoc($dishResult)) {
                    echo '<label for="dish_' . $row['menuitemid'] . '">' . $row['dishname'] . ':</label>';
                    echo '<input type="number" id="dish_' . $row['menuitemid'] . '" name="dishes[' . $row['menuitemid'] . ']" min="0" value="0">';
                    echo '<br>';
                }
                ?>
            </div>
        </div>
        <button type="submit">Submit Order</button>
    </form>
    <p><a href="../mainmenu.php">Back to Main Menu</a></p>
</body>
</html>

<?php
mysqli_free_result($customerResult);
mysqli_free_result($driverResult);
mysqli_free_result($dishResult);
?>