<?php
include "connecttodb.php";

$menuitemid = $_POST['menuitemid'];
$field = $_POST['field'];
$value = $_POST['value'];

// either changes price or calorie count using same function
if ($field === 'price' || $field === 'caloriecount') {
  $query = "UPDATE menuitem SET $field = '$value' WHERE menuitemid = '$menuitemid'";
  $result = mysqli_query($connection, $query);

  if ($result && mysqli_affected_rows($connection) > 0) {
    echo "SUCCESS";
  } else {
    echo "ERROR";
  }
} else {
  echo "ERROR";
}

mysqli_close($connection);
?>