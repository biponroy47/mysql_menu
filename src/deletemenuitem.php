<?php
include "connecttodb.php";

$menuitemid = $_POST['menuitemid'];

//delete menu item if it isn't associated with any current orders
$query = "DELETE FROM menuitem WHERE menuitemid = '$menuitemid'";
$result = mysqli_query($connection, $query);

if ($result && mysqli_affected_rows($connection) > 0) {
    echo "SUCCESS";
} else {
    $error = mysqli_error($connection);
    if (strpos($error, "foreign key constraint fails") !== false) {
        echo "FOREIGN_KEY_ERROR";
    } else {
        echo "ERROR";
    }
}

mysqli_close($connection);
?>