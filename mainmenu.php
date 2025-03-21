<!DOCTYPE html>
<html>
    <head>
        <title>Main Menu</title>
        <link rel="stylesheet" type="text/css" href="css/mainmenu.css">
        <!-- import script for rendering menu items in same page -->
        <script src="scripts/mainmenu.js"></script>
    </head>
    <body>
        <?php include "src/connecttodb.php"; ?>
        <h1>Main Menu</h1>
        <div class="button-container">
            <!-- main buttons for menu functionality -->
            <button id="insertButton" onclick="window.location.href='src/addneworder.php'">Insert New Order</button>
            <button id="showOrdersButton" onclick="window.location.href='src/showorders.php'">Show All Orders</button>
            <button id="newDriversButton" onclick="window.location.href='src/newdrivers.php'">Show New Drivers</button>
        </div>
        <!-- buttons to sort by name or price and order  -->
        <div class="button-container">
            <button id="sortButton" onclick="toggleSort()">Sort by Price</button>
            <button id="orderButton" onclick="toggleOrder()">Sort Order: ASC</button>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Menu ID</th>
                    <th>Dish Name</th>
                    <th>Price</th>
                    <th>Calories</th>
                    <th>Vegetarian</th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="menuTableBody">
                <!-- call showmenuitems to populate all menu items -->
                <?php include "src/showmenuitems.php"; ?>
            </tbody>
        </table>
    </body>
</html>
