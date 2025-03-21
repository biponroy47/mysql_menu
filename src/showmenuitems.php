<?php
    include "connecttodb.php";

    //retreives all menu items depending on sorting order and attribute
    $sortBy = $_GET['sort'] ?? 'dishname';
    $sortOrder = $_GET['order'] ?? 'ASC';

    if ($sortBy !== 'dishname' && $sortBy !== 'price') {
        $sortBy = 'dishname';
    }
    if ($sortOrder !== 'ASC' && $sortOrder !== 'DESC') {
        $sortOrder = 'ASC';
    }

    $query = "SELECT * FROM menuitem ORDER BY $sortBy $sortOrder";
    $result = mysqli_query($connection, $query);

    if (!$result) {
        die("Database query failed.");
    }

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row["menuitemid"] . "</td>";
        echo "<td>" . $row["dishname"] . "</td>";
        echo "<td>" . $row["price"] . "</td>";
        echo "<td>" . $row["caloriecount"] . "</td>";
        echo "<td>" . $row["veggie"] . "</td>";
        echo "<td><button class='deleteButton' onclick='deleteMenuItem(\"" . $row["menuitemid"] . "\")'>Delete</button></td>";
        echo "<td><button class='editPriceButton' onclick='editPrice(\"" . $row["menuitemid"] . "\")'>Edit Price</button></td>";
        echo "<td><button class='editCalButton' onclick='editCalories(\"" . $row["menuitemid"] . "\")'>Edit Calories</button></td>";
        echo "</tr>";
    }

    mysqli_free_result($result);
?>
