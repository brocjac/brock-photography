<?php
    include_once "includes/header-all.php";

    $id = $_GET['UserId'] ?? '1';

    $id = intval($id);

    $query = "SELECT * FROM `brockphotography_orderItem` WHERE "
?>
<form method="get">
    <input type="submit" name="orderNow" value="Proceed to Checkout">
</form>
<?php
    include_once "includes/footer-all.php";
?>
