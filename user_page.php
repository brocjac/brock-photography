<?php 
    include_once "includes/header-all.php"
?>
<?php
    $id = $_SESSION['authUser']['UserId'] ?? '';
    $id = intval($id);
    $query = "SELECT * FROM `brockphotography_users` LEFT JOIN `brockphotography_address` USING(AddressId) LEFT JOIN `brockphotography_zip` USING(Zip) WHERE UserId = '$id'";
    $result = mysqli_query($db, $query) or die('Error loading user information.');
    $userInfo = mysqli_fetch_array($result, MYSQLI_ASSOC);

$queryTotal = "SELECT *,
TRUNCATE(SUM(brockphotography_photos.PhotoValuePrice + brockphotography_photoSizes.PrintPrice), 2) AS TotalPrice 
FROM `brockphotography_users` 
    LEFT JOIN `brockphotography_orderItem` USING(UserId) 
    LEFT JOIN `brockphotography_photos` USING(ImageId) 
    LEFT JOIN `brockphotography_photoSizes` USING(OrderPrintSizeId)
    WHERE UserId = $id
    GROUP BY brockphotography_orderItem.OrderItemId";

$resultTotal = mysqli_query($db, $queryTotal) or die('Error loading users info.');

$infoTotal = mysqli_fetch_array($resultTotal, MYSQLI_ASSOC);
?>
<?php
    if (isset($_SESSION['authUser']) and $_SESSION['authUser']){
        if($_SESSION['authUser']['UserId'] == $id){
            ?>
        <div class="containerPages">
            <div class="grid">
                <div class="userInformation">
                    <h2>Personal Information</h2>
                    <p><?= $userInfo['FirstName'] ?></p>
                    <p><?= $userInfo['LastName'] ?></p>
                    <p><?= $userInfo['Email'] ?></p>
                </div>
                <div class="addressInfo">
                    <?php
                        if($userInfo['AddressId']){
                            ?>
                                <h2>User Address</h2>
                                <p><?= $userInfo['Address'] ?></p>
                                <p><?= $userInfo['Address2'] ?></p>
                                <p><?= $userInfo['City'] ?></p>
                                <p><?= $userInfo['State'] ?></p>
                                <p><?= $userInfo['Zip'] ?></p>
                            <?php
                        } else {
                            echo "<p><a href='add_address.php'>Add address</a></p>";
                        }
                    ?>
                </div>
            </div>
            <table class="table table-dark">
                <thead>
                <th>Title</th>
                <th>Print Size</th>
                <th>Total Price</th>
                </thead>
                <tbody>
                <?php
                mysqli_data_seek($resultTotal, 0);
                while ($row = mysqli_fetch_array($resultTotal, MYSQLI_ASSOC)){
                    echo "<tr>
                                <td><a href='user_admin_details.php?UserId={$row['UserId']}'>{$row['Alt']}</a></td>
                                <td>{$row['PhotoSizes']}</td>
                                <td>{$row['TotalPrice']}</td>
                            </tr>";
                }
                ?>
                <td><a href="user_invoice.php?UserId=<?= $userInfo['UserId'] ?>">Invoice Page</a></td>
                <td></td>
                <td></td>
                </tbody>
            </table>
        </div>
            <?php
        }
    }
?>
<?php
    include_once "includes/footer-all.php"
?>
