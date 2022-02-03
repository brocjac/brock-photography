<?php
    include_once "includes/header-all.php";

    $id = $_SESSION['authUser']['UserId'] ?? '';

?>
    <?php
        $storeQuery = "SELECT * FROM `brockphotography_photos`";

        $result = mysqli_query($db, $storeQuery)
        or die('Error in query: ' . mysqli_error($db));
    ?>
    <?php
        if (isset($_POST['add'])){
            $imageId = $_POST['ImageId'];
            $imgSelectedQuery = "INSERT INTO `brockphotography_orderItem`(`ImageId`) VALUES ( ? )";

            $stmt = mysqli_prepare($db, $imgSelectedQuery);
            mysqli_stmt_bind_param($stmt, 'i', $imageId);
            $result = mysqli_stmt_execute($stmt) or die('Error inserting record.');

        }
    ?>
        <?php
        echo '<div class="rowGal" id="photos"><div class="columnGal">';
        ?>
        <?php
            $i = 0;
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

                if($i && $i % 2 === 0){
                    echo '</div><div class="columnGal">';
                }
            echo
                '<div class="image">
                    <a href="data:image/jpeg;base64, '.base64_encode($row['LargeImgSrc']).'" data-lightbox="mygallery"><img src="data:image/jpeg;base64, '.base64_encode($row['ImgSrc']).'" alt="Sky photo of clouds and light. " class="images"></a><br>';
                    echo '<a href="buy_photo.php?id=' . $row['ImageId'] . '" id="photo' . $row['ImageId'] . '" class="cartphoto">Learn More</a>
                </div>';
                $i++;
            }
        ?>
        <?php
        echo '</div></div>';
        ?>
<?php
include_once "includes/footer-all.php";
?>
</body>
</html>
