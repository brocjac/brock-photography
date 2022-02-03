<?php
    include_once "includes/header-all.php";

    $id = $_GET['UserId'] ?? '1';

    $id = intval($id);

    $query = "SELECT * FROM `brockphotography_users` 
    LEFT JOIN `brockphotography_address` USING(AddressId) 
    LEFT JOIN `brockphotography_zip` USING(Zip) WHERE UserId = $id";

    $result = mysqli_query($db, $query) or die('Error loading users info.');

    $info = mysqli_fetch_array($result, MYSQLI_ASSOC);

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
    if (isset($_SESSION['authUser']) && $_SESSION['authUser']){
        if($_SESSION['authUser']['role'] == 'admin'){
            ?>
                <div class="containerPages">
                    <div class="grid">
                        <div id="userInformation">
                            <h2>User Information</h2>
                            <p><?= $info['FirstName'] ?></p>
                            <p><?= $info['LastName'] ?></p>
                            <p><?= $info['Email'] ?></p>
                        </div>
                        <div id="addressInformation">
                            <h2>User Address</h2>
                            <p><?= $info['Address'] ?></p>
                            <p><?= $info['Address2'] ?></p>
                            <p><?= $info['City'] ?></p>
                            <p><?= $info['State'] ?></p>
                            <p><?= $info['Zip'] ?></p>
                        </div>
                    </div>
                    <table class="table table-dark table-hover">
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
                        </tbody>
                    </table>
                </div>
            <?php
        }
    }
    ?>
<?php
    include_once "includes/footer-all.php";
?>