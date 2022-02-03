<?php
include_once "includes/header-all.php";
?>
<?php
    $idUser = $_SESSION['authUser']['UserId'] ?? '';
    $idUser = intval($idUser);
    $id = $_GET['id'];

    $userQuery = "SELECT * FROM `brockphotography_users` WHERE UserId = $idUser";
    $resultUser = mysqli_query($db, $userQuery)
    or die('Error in query: ');
    $address = mysqli_fetch_array($resultUser, MYSQLI_ASSOC);

    if (isset($_POST['addToCart'])){

        $orderPrintSizeId = $_POST["OrderPrintSizeId"];

        // insert record
        $query = "INSERT INTO `brockphotography_orderItem` (`UserId`, `ImageId`, `OrderPrintSizeId`) VALUES ( ? , ?, ? )";
        $stmt = mysqli_prepare($db, $query) or die('Error in query');
        mysqli_stmt_bind_param($stmt, "iii", $idUser, $id, $orderPrintSizeId);
        $result = mysqli_stmt_execute($stmt) or die('Error executing query.');

        if ($address['AddressId']) {
            if($newId = mysqli_insert_id($db)){
                // redirect back to the city page
                header('Location: user_invoice.php?id=' . $idUser);
            } else {
                echo "SOMETHING WENT WRONG!";
            }
        } else {
            header('Location: add_address.php?UserId=' . $idUser);
        }
    }

    $storeQuery = "SELECT * FROM `brockphotography_photos` WHERE ImageId = $id";
    $result = mysqli_query($db, $storeQuery)
    or die('Error in query: ');

    $sizeQuery = "SELECT * FROM `brockphotography_photoSizes`";
    $resultSize = mysqli_query($db, $sizeQuery)
    or die('Error in query: ');

?>
    <form method="post">
        <div class="containerPages containerPurchase">
            <?php
                if(isset($_SESSION['authUser']) and $_SESSION['authUser']) {
                    if (isset($_SESSION['authUser'])) {
                        ?>
                            <div class="frameSize">
                                <label>Print Size:<br>
                                    <select name="OrderPrintSizeId">
                                        <?php while ($row = mysqli_fetch_array($resultSize, MYSQLI_ASSOC)){ ?>
                                            <option value="<?=$row['OrderPrintSizeId']?>" <?= $row['OrderPrintSizeId'] ?>><?= $row['PhotoSizes'] ?></option>
                                        <?php } ?>
                                    </select>
                                </label>
                            </div>
                        <?php
                        }
                    }
                ?>
            <?php
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                echo '<div class="imageBuyContainer">
                        <a href="data:image/jpeg;base64, ' . base64_encode($row['LargeImgSrc']) . '" data-lightbox="mygallery"><img src="data:image/jpeg;base64, ' . base64_encode($row['ImgSrc']) . '" alt="Sky photo of clouds and light. " class="imageBuy"></a>
                        <h3 class="imageTitle">' . $row['Alt'] . '</h3>
                    </div>';
                if(isset($_SESSION['authUser']) and $_SESSION['authUser']) {
                    if (isset($_SESSION['authUser'])) {
                        echo '<input class="addToCart" type="submit" name="addToCart" value="Add To Cart">';
                    }
                } else {
                    ?>
                        <a href="sign_up_login.php">log in</a>
                    <?php
                }
            }
            ?>
        </div>
    </form>
<?php
include_once "includes/footer-all.php"
?>