<?php

require_once "includes/header-all.php";

$id = $_SESSION['authUser']['UserId'] ?? '';
$id = intval($id);

$queryTotal = "SELECT *,
TRUNCATE(SUM(brockphotography_photos.PhotoValuePrice + brockphotography_photoSizes.PrintPrice), 2) AS TotalPrice 
FROM `brockphotography_users` 
    LEFT JOIN `brockphotography_orderItem` USING(UserId) 
    LEFT JOIN `brockphotography_photos` USING(ImageId) 
    LEFT JOIN `brockphotography_photoSizes` USING(OrderPrintSizeId)
    WHERE UserId = $id
    GROUP BY brockphotography_orderItem.OrderItemId";

$query = "SELECT * FROM `brockphotography_users` LEFT JOIN `brockphotography_address` USING(AddressId) LEFT JOIN `brockphotography_zip` USING(Zip) WHERE UserId = '$id'";

$queryInvoice = "SELECT *,
TRUNCATE(SUM(brockphotography_photos.PhotoValuePrice + brockphotography_photoSizes.PrintPrice), 2) AS TotalInvoicePrice 
FROM `brockphotography_users` 
    LEFT JOIN `brockphotography_orderItem` USING(UserId) 
    LEFT JOIN `brockphotography_photos` USING(ImageId) 
    LEFT JOIN `brockphotography_photoSizes` USING(OrderPrintSizeId)
    WHERE UserId = $id
    GROUP BY `brockphotography_users`.`UserId`";

$result = mysqli_query($db, $query)
or die('Error in query' . mysqli_error($db));

$products = mysqli_fetch_array($result, MYSQLI_ASSOC);

$resultTotal = mysqli_query($db, $queryTotal)
or die('Error in query' . mysqli_error($db));

$productsTotal = mysqli_fetch_array($resultTotal, MYSQLI_ASSOC);

$resultInvoice = mysqli_query($db, $queryInvoice)
or die('Error in query' . mysqli_error($db));

$productsInvoice = mysqli_fetch_array($resultInvoice, MYSQLI_ASSOC)
?>
    <div class="containerPages">
        <h1 class="pageTitle"><?= $products['FirstName'] ?> <?= $products['LastName'] ?></h1>
        <div class="informationOrder">
            <div>
                <p>First Name: </p>
                <p><?= $products['FirstName'] ?></p>
            </div>
            <div>
                <p>Last Name: </p>
                <p><?= $products['LastName'] ?></p>
            </div>
            <div>
                <p>Address: </p>
                <p><?= $products['Address'] ?></p>
            </div>
            <div>
                <p>City: </p>
                <p><?= $products['City'] ?></p>
            </div>
            <div>
                <p>State: </p>
                <p><?= $products['State'] ?></p>
            </div>
            <div>
                <p>Zip: </p>
                <p><?= $products['Zip'] ?></p>
            </div>
        </div>
        <table class="table table-dark table-hover tableOrder">
            <thead>
            <tr>
                <th>Model</th>
                <th>Order Date</th>
                <th>Order Number</th>
            </tr>
            </thead>
            <?php
            mysqli_data_seek($resultTotal, 0);
            while ($row = mysqli_fetch_array($resultTotal, MYSQLI_ASSOC)){
                ?>
                <tr>
                    <td><a class="links" href="order_product_details.php?id=<?= $row['ProductID'] ?>"><?= $row['Alt'] ?></a></td>
                    <td><?= $row['PhotoSizes'] ?></td>
                    <td>$<?= $row['TotalPrice'] ?></td>
                </tr>
                <?php
            }
            ?>
            <tr>
                <td></td>
                <th>Total: </th>
                <td>$<?= $productsInvoice['TotalInvoicePrice'] ?></td>
        </table>
    </div>
<?php
include_once "includes/footer-all.php";
?>