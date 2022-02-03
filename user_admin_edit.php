<?php
    include_once "includes/header-all.php";

    $id = $_GET['UserId'] ?? '1';

    $id = intval($id);

    $query = "SELECT * FROM `brockphotography_users` LEFT JOIN `brockphotography_address` USING(AddressId) LEFT JOIN `brockphotography_zip` USING(Zip) WHERE UserId = $id";

    $result = mysqli_query($db, $query) or die('Error loading users info.');

    $info = mysqli_fetch_array($result, MYSQLI_ASSOC);
    ?>
<?php
if(isset($_POST['submit'])){
    if($_SESSION['csrf_token'] !== $_POST['csrf_token']){
        die('Invalid Token');
    }

    $userId = $_POST['UserId'] ?? '';
    $addressId = $_POST['AddressId'] ?? '';
    $firstName = $_POST['FirstName'] ?? '';
    $lastName = $_POST['LastName'] ?? '';
    $email = $_POST['Email'] ?? '';
    $role = $_POST['Role'] ?? '';
    $address = $_POST['Address'] ?? '';
    $address2 = $_POST['Address2'] ?? '';
    $city = $_POST['City'] ?? '';
    $state = $_POST['State'] ?? '';
    $zip = $_POST['Zip'] ?? '';

    $firstName = htmlspecialchars($firstName);
    $lastName = htmlspecialchars($lastName);
    $email = htmlspecialchars($email);
    $address = htmlspecialchars($address);
    $address2 = htmlspecialchars($address2);
    $city = htmlspecialchars($city);
    $state = htmlspecialchars($state);
    $zip = htmlspecialchars($zip);

    $query = "UPDATE `brockphotography_users` SET `FirstName`= ?,`LastName`= ?,`Email`= ?, `Role`= ? WHERE UserId = ?";

    $stmt = mysqli_prepare($db, $query) or die('Error in query.');
    mysqli_stmt_bind_param($stmt, 'ssssi', $firstName, $lastName, $email, $role, $userId);
    $result = mysqli_stmt_execute($stmt) or die("Error adding place.");
    if ($info['AddressId']) {
        $queryAddress = "UPDATE `brockphotography_address` SET `Zip`= ? ,`Address`= ? ,`Address2`= ?  WHERE `AddressId`= ? ";

        $stmt = mysqli_prepare($db, $queryAddress) or die('Error in query.');
        mysqli_stmt_bind_param($stmt, 'issi', $zip, $address, $address2, $info['AddressId']);
        $result = mysqli_stmt_execute($stmt) or die("Error adding place.");

        $queryZip = "UPDATE `brockphotography_zip` SET `City`= ? ,`State`= ?  WHERE `Zip`= ? ";

        $stmt = mysqli_prepare($db, $queryZip) or die('Error in query.');
        mysqli_stmt_bind_param($stmt, 'ssi', $city, $state, $zip);
        $result = mysqli_stmt_execute($stmt) or die("Error adding place.");
    }
    // redirect back to the city page
    header('Location: users.php?UserId=' . $info['UserId']);
}
?>
<?php
        if (isset($_SESSION['authUser']) and $_SESSION['authUser']){
        if($_SESSION['authUser']['role'] == 'admin'){
            ?>
                <form method="post">
                    <div id="container">
                        <div class="form-group">
                            <label for="firstName">First Name:</label>
                            <input class="form-control" id="firstName" name="FirstName" type="text" value="<?= $info['FirstName'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="lastName">Last Name:</label>
                            <input class="form-control" id="lastName" name="LastName" type="text" value="<?= $info['LastName'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="text" id="email" name="Email" class="form-control" value="<?= $info['Email'] ?>">
                        </div>
                        <div class="form-group">
                            <label class="mt-2 mb-4">Role:</label>
                            <select name="Role">
                                <option value="user" <?= $info['Role'] == 'user' ? 'selected': '' ?>>user</option>
                                <option value="admin" <?= $info['Role'] == 'admin' ? 'selected': '' ?>>admin</option>
                            </select>
                        </div>
                        <?php
                            if ($info['AddressId']){
                                ?>
                                    <div class="form-group">
                                        <label for="address">Address:</label>
                                        <input type="text" id="address" name="Address" class="form-control" value="<?= $info['Address'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="address2">Address2:</label>
                                        <input type="text" id="address2" name="Address2" class="form-control" value="<?= $info['Address2'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="city">City:</label>
                                        <input type="text" id="city" name="City" class="form-control" value="<?= $info['City'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="state">State:</label>
                                        <input type="text" id="state" name="State" class="form-control" value="<?= $info['State'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="zip">Zip:</label>
                                        <input type="text" id="zip" name="Zip" class="form-control" value="<?= $info['Zip'] ?>">
                                    </div>
                                <?php } else {
                                echo "";
                            } ?>
                        <div class="form-group">
                            <input type="hidden" name="UserId" value="<?= $info['UserId'] ?>">
                            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                            <input type="submit" name="submit" class="btnSubmit" value="Update">
                        </div>
                    </div>
                </form>
            <?php
            }
        }
    ?>
<?php
    include_once "includes/footer-all.php";
?>