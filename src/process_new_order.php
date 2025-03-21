<?php
    session_start();
    include "connecttodb.php";

    //conditional check to verify time delivered is after time placed
    if (isset($_POST['timeplaced']) && isset($_POST['timedelivered'])) {
        $timeplaced = strtotime($_POST['timeplaced']);
        $timedelivered = strtotime($_POST['timedelivered']);
        if ($timedelivered <= $timeplaced) {
            $_SESSION['error'] = "Time Delivered must be greater than Time Placed.";
            header("Location: addneworder.php");
            exit();
        }
    }

    $orderid = $_POST['orderid'];
    $deladdress = $_POST['deladdress'];
    $dateplaced = $_POST['dateplaced'];
    $timeplaced = $_POST['timeplaced'];
    $timedelivered = $_POST['timedelivered'];
    $pickuporder = $_POST['pickuporder'];
    $deliveryrating = $_POST['deliveryrating'];
    $driverid = $_POST['driverid'];
    $cusid = $_POST['cusid'];
    $dishes = $_POST['dishes'];

    // check to see if user entered a valid unique orderid
    $checkQuery = "SELECT * FROM cusorder WHERE orderid = '$orderid'";
    $checkResult = mysqli_query($connection, $checkQuery);
    if (mysqli_num_rows($checkResult) > 0) {
        $_SESSION['error'] = "Error: Order ID '$orderid' already exists. Please use a unique Order ID.";
        header("Location: addneworder.php");
        exit();
    }

    //replace optional fields with null if unspecified
    $deladdress = empty($deladdress) ? "NULL" : "'$deladdress'";
    $dateplaced = empty($dateplaced) ? "NULL" : "'$dateplaced'";
    $timeplaced = empty($timeplaced) ? "NULL" : "'$timeplaced'";
    $timedelivered = empty($timedelivered) ? "NULL" : "'$timedelivered'";
    $deliveryrating = empty($deliveryrating) ? "NULL" : intval($deliveryrating);
    $driverid = empty($driverid) ? "NULL" : "'$driverid'";

    //insert into database
    $query = "INSERT INTO cusorder (orderid, deladdress, dateplaced, timeplaced, timedelivered, pickuporder, deliveryrating, driverid, cusid) 
            VALUES ('$orderid', $deladdress, $dateplaced, $timeplaced, $timedelivered, '$pickuporder', $deliveryrating, $driverid, '$cusid')";
    $result = mysqli_query($connection, $query);

    if (!$result) {
        $_SESSION['error'] = "Error inserting new order: " . mysqli_error($connection);
        header("Location: addneworder.php");
        exit();
    }

    // insert each menuitem into overall order
    foreach ($dishes as $menuitemid => $quantity) {
        if ($quantity > 0) {
            $query = "INSERT INTO overallorder (orderid, menuitemid, quantity) 
                    VALUES ('$orderid', '$menuitemid', $quantity)";
            $result = mysqli_query($connection, $query);

            if (!$result) {
                $_SESSION['error'] = "Error inserting dish quantities: " . mysqli_error($connection);
                header("Location: addneworder.php");
                exit();
            }
        }
    }

    $_SESSION['success'] = "New order and dishes inserted successfully!";
    $_SESSION['orderid'] = $orderid;
    header("Location: displayorder.php");
    exit();
?>
