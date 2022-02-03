<?php
    include_once "includes/header-all.php"
?>
<?php
    $id = $_SESSION['authUser']['UserId'] ?? '';
    $id = intval($id);
    $query = "SELECT * FROM `brockphotography_users` LEFT JOIN `brockphotography_address` USING(AddressId) LEFT JOIN `brockphotography_zip` USING(Zip) WHERE UserId = '$id'";
    $result = mysqli_query($db, $query) or die('Error loading user information.');
    $userInfo = mysqli_fetch_array($result, MYSQLI_ASSOC);
?>
<?php
    if(isset($_POST['submit'])){
        $addressId = $_POST['AddressId'] ?? '';
        $address = $_POST['Address'];
        $address2 = $_POST['Address2'];
        $city = $_POST['City'];
        $state = $_POST['State'] ?? '';
        $zip = $_POST['Zip'];

        // sanitize inputs
        $address = strip_tags($address);
        $address2 = strip_tags($address2);
        $city = strip_tags($city);
        $zip = strip_tags($zip);

        if(empty($address && $city && $state && $zip)) {
            $query = "INSERT INTO `brockphotography_address`(`AddressId`, `Zip`, `Address`, `Address2`) VALUES (NULL, ? , ? , ? )";
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, 'iss', $zip, $address, $address2);
            $result = mysqli_stmt_execute($stmt) or die();
            $addressId = mysqli_stmt_insert_id($stmt);

            $query = "UPDATE `brockphotography_users` SET `AddressId`= ? WHERE UserId = ? LIMIT 1";
            $stmt = mysqli_prepare($db, $query) or die('Error in query.');
            mysqli_stmt_bind_param($stmt, 'ii', $addressId, $id);
            $result = mysqli_stmt_execute($stmt) or die();

            $query = "INSERT INTO `brockphotography_zip`(`Zip`, `City`, `State`) VALUES (? , ? , ? )";
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, 'iss', $zip, $city, $state);
            $result = mysqli_stmt_execute($stmt) or die();
        } else {

        }
    }
?>
<form method="post">
    <div class="addAddress">
        <h3>Shipping Address</h3>
        <label for="address">Address: </label><br><input type="text" name="Address" id="address" style="width: 25em;"><br>
        <label for="address">Address2: </label><br><input type="text" name="Address2" id="address" style="width: 25em;"><br>
        <label for="city">City: </label><input type="text" name="City" id="city" style="width: 100px;">
        <label for="state">State:
            <select name="State">
                <option value="AL">AL</option>
                <option value="AK">AK</option>
                <option value="AR">AR</option>
                <option value="AZ">AZ</option>
                <option value="CA">CA</option>
                <option value="CO">CO</option>
                <option value="CT">CT</option>
                <option value="DC">DC</option>
                <option value="DE">DE</option>
                <option value="FL">FL</option>
                <option value="GA">GA</option>
                <option value="HI">HI</option>
                <option value="IA">IA</option>
                <option value="ID">ID</option>
                <option value="IL">IL</option>
                <option value="IN">IN</option>
                <option value="KS">KS</option>
                <option value="KY">KY</option>
                <option value="LA">LA</option>
                <option value="MA">MA</option>
                <option value="MD">MD</option>
                <option value="ME">ME</option>
                <option value="MI">MI</option>
                <option value="MN">MN</option>
                <option value="MO">MO</option>
                <option value="MS">MS</option>
                <option value="MT">MT</option>
                <option value="NC">NC</option>
                <option value="NE">NE</option>
                <option value="NH">NH</option>
                <option value="NJ">NJ</option>
                <option value="NM">NM</option>
                <option value="NV">NV</option>
                <option value="NY">NY</option>
                <option value="ND">ND</option>
                <option value="OH">OH</option>
                <option value="OK">OK</option>
                <option value="OR">OR</option>
                <option value="PA">PA</option>
                <option value="RI">RI</option>
                <option value="SC">SC</option>
                <option value="SD">SD</option>
                <option value="TN">TN</option>
                <option value="TX">TX</option>
                <option value="UT">UT</option>
                <option value="VT">VT</option>
                <option value="VA">VA</option>
                <option value="WA">WA</option>
                <option value="WI">WI</option>
                <option value="WV">WV</option>
                <option value="WY">WY</option>
            </select>
        </label>
        <label for="zip">Zip: </label><input type="text" name="Zip" id="zip" style="width: 40px;"><br>
        <input type="hidden" name="AddressId" value="<?= $userInfo['AddressId'] ?>">
        <input type="submit" name="submit" value="add place">
    </div>
</form>
<?php
    include_once "includes/footer-all.php"
?>
