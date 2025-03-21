<?php
include 'connecttodb.php';

//retreive all drivers with no deliveries including orders with NULL driverids
$query = "
    SELECT
        d.driverid, 
        d.firstname, 
        d.lastname
    FROM 
        driver d
    LEFT JOIN 
        cusorder co 
    ON 
        d.driverid = co.driverid
    WHERE 
        co.driverid IS NULL;
";

$result = mysqli_query($connection, $query);

if (!$result) {
    die("Error executing query: " . mysqli_error($connection));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>New Drivers</title>
    <link rel="stylesheet" type="text/css" href="../css/newdrivers.css">
</head>
<body>
    <h1>Drivers With No Deliveries</h1>
    <table>
        <thead>
            <tr>
                <th>Driver ID</th>
                <th>Driver First Name</th>
                <th>Driver Last Name</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['driverid'] . "</td>";
                    echo "<td>" . $row['firstname'] . "</td>";
                    echo "<td>" . $row['lastname'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No drivers found.</td></tr>";
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