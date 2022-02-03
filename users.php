<?php
include_once "includes/header-all.php";
?>
<?php
    $sort = $_GET['sort'] ?? 'FirstName';
    $dir = $_GET['dir'] ?? 'ASC';

    $sort = in_array($sort, ['FirstName', 'LastName', 'Email', 'Role']) ? $sort : 'FirstName';
    $dir = in_array($dir, ['ASC', 'DESC']) ? $dir : 'ASC';

    $query = "SELECT UserId, FirstName, LastName, Email, Role FROM `brockphotography_users` ORDER BY $sort $dir";

    $result = mysqli_query($db, $query) or die('Error in query:');
?>
<?php
    if (isset($_SESSION['authUser']) and $_SESSION['authUser']){
        if($_SESSION['authUser']['role'] == 'admin'){
            ?>
                <table class="table table-dark">
                    <thead>
                        <?php
                            $firstNameDir = ($sort == 'FirstName' && $dir == 'ASC') ? 'DESC' : 'ASC';
                            $firstNameArr = '';
                            if ($sort == 'FirstName'){
                                $firstNameArr = $dir == 'ASC' ? '&darr;' : '&uarr;';
                            }
                            $lastNameDir = ($sort == 'LastName' && $dir == 'ASC') ? 'DESC' : 'ASC';
                            $lastNameArr = '';
                            if ($sort == 'LastName'){
                                $lastNameArr = $dir == 'ASC' ? '&darr;' : '&uarr;';
                            }
                            $emailDir = ($sort == 'Email' && $dir == 'ASC') ? 'DESC' : 'ASC';
                            $emailArr = '';
                            if ($sort == 'Email'){
                                $emailArr = $dir == 'ASC' ? '&darr;' : '&uarr;';
                            }
                            $roleDir = ($sort == 'Role' && $dir == 'ASC') ? 'DESC' : 'ASC';
                            $roleArr = '';
                            if ($sort == 'Role'){
                                $roleArr = $dir == 'ASC' ? '&darr;' : '&uarr;';
                            }
                        ?>
                        <th><a href="?sort=FirstName&dir=<?= $firstNameDir ?>">First Name</a> <?= $firstNameArr ?></th>
                        <th><a href="?sort=LastName&dir=<?= $lastNameDir ?>">Last Name</a> <?= $lastNameArr ?></th>
                        <th><a href="?sort=Email&dir=<?= $emailDir ?>">Email</a> <?= $emailArr ?></th>
                        <th><a href="?sort=Role&dir=<?= $roleDir ?>">Role</a> <?= $roleArr ?></th>
                        <th></th>
                        <th></th>
                    </thead>
                    <tbody>
                        <?php
                            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                                echo "<tr>
                                    <td><a href='user_admin_details.php?UserId={$row['UserId']}'>{$row['FirstName']}</a></td>
                                    <td>{$row['LastName']}</td>
                                    <td>{$row['Email']}</td>
                                    <td>{$row['Role']}</td>
                                    <td><a href='user_admin_edit.php?UserId={$row['UserId']}'>Edit</a></td>
                                    <td><a href='user_admin_delete.php?UserId={$row['UserId']}'>Delete</a></td>
                                </tr>";
                            }
                        ?>
                    </tbody>
                </table>
            <?php
        }
    } else {
        echo "access denied";
    }
?>
<?php
    include_once "includes/footer-all.php"
?>
