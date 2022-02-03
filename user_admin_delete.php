<?php
    include_once "includes/header-all.php";

    $id = $_GET['UserId'] ?? '1';

    $id = intval($id);

    $query = "SELECT * FROM `brockphotography_users` WHERE UserId = '$id'";

    $result = mysqli_query($db, $query) or die('Error loading users.');

    $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
?>
<?php
    if (isset($_POST['delete'])){
        $userId = $_POST['UserId'];

        $userId = intval($userId);

        //validation/sanitization
        if($_SESSION['csrf_token'] !== $_POST['csrf_token']){
            //something wrong or session expierd, dont update
            die('invalid token');
        }
        //TODO: convert to prepared statements maybe

        $query = "DELETE FROM `brockphotography_users` WHERE UserId = $userId LIMIT 1";

        $result = mysqli_query($db, $query);

        if(mysqli_affected_rows($db)){
            header('Location: users.php?UserId=' . $user['UserId']);
        } else {
            echo "something went wrong";
        }
    } elseif (isset($_POST['cancel'])) {
        header('Location: users.php?UserId=' . $user['UserId']);
        die();
    }
    if (isset($_SESSION['authUser']) and $_SESSION['authUser']){
        if($_SESSION['authUser']['role'] == 'admin'){
            ?>
                <form method="post">
                    <p>
                        Are you sure you want to delete <?= $user['FirstName'] ?> <?= $user['LastName'] ?>?
                    </p>
                    <p>
                        <!-- use hidden fields to pass information with the form that the user doesn't enter -->
                        <input type="hidden" name="UserId" value="<?= $user['UserId'] ?>">
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                        <input type="submit" name="cancel" value="No" class="btn btn-secondary">
                        <input type="submit" name="delete" value="Yes" class="btn btn-danger">
                    </p>
                </form>
            <?php
        }
    }
?>
<?php
    include_once "includes/footer-all.php";
?>
