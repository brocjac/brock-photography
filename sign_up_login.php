<?php
include_once "includes/header-all.php";
?>
<div class="container login-container">
    <div class="row">
        <div class="col-md-6 login-form-1">
            <h3>Sign Up</h3>
            <?php
            $accountCreated = false;
            $isValid = true;

            if(isset($_POST['signup'])){
                $userId = $_POST['UserId'] ?? '';
                $firstName = $_POST['FirstName'] ?? '';
                $lastName = $_POST['LastName'] ?? '';
                $email = $_POST['Email'];
                $password = $_POST['Password'];

                $firstName = htmlspecialchars($firstName);
                $lastName = htmlspecialchars($lastName);
                $email = htmlspecialchars($email);
                $password = htmlspecialchars($password);

                if (empty($firstName && $lastName)){
                    $isValid = true;
                } else {
                    echo "<div class='alert alert-success'>Must have first and last name.</div>";
                }

                $number = preg_match('@[0-9]@', $password);
                $uppercase = preg_match('@[A-Z]@', $password);
                $lowercase = preg_match('@[a-z]@', $password);
                $specialChars = preg_match('@[^\w]@', $password);

                if (strlen($password) < 8 || !$number || !$uppercase || !$lowercase || !$specialChars) {
                    $isValid = false;
                    echo "<div class='alert alert-danger'>Password must be at least 8 characters in length<br> must contain at least one number<br> one upper case letter<br> one lower case letter<br> one special character.</div>";
                } else {
                    echo "<div class='alert alert-success'>Your password is strong.</div>";
                }

                // validate email/password
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    echo ("<div class='alert alert-success'>$email is a valid email address</div>");
                } else {
                    $isValid = false;
                    echo ("<div class='alert alert-danger'>$email is not a valid email address</div>");
                }

                $password = password_hash($password, PASSWORD_DEFAULT);
                if ($isValid === true) {
                    $query = "INSERT INTO `brockphotography_users`(`UserId`, `FirstName`, `LastName`, `Email`, `Password`, `Role`) VALUES (NULL, ? , ? , ? , ? ,'user')";

                    $stmt = mysqli_prepare($db, $query);
                    mysqli_stmt_bind_param($stmt, "ssss", $firstName, $lastName, $email, $password);
                    mysqli_stmt_execute($stmt) or die('Error inserting record.');


                    if (mysqli_stmt_insert_id($stmt)) {
                        $accountCreated = true;
                        echo '<div class="alert alert-success"><b>Account Created!</b><br>Please Login</div>';
                    } else {
                        echo '<div class="alert alert-danger"><b>Error creating account</b><br></div>';
                    }
                }
            }

            ?>
            <?php if(!$accountCreated): ?>
                <form method="post">
                    <div class="form-group">
                        <input class="form-control" name="FirstName" type="text" placeholder="First Name">
                    </div>
                    <div class="form-group">
                        <input class="form-control" name="LastName" type="text" placeholder="Last Name">
                    </div>
                    <div class="form-group">
                        <input type="text" name="Email" class="form-control" placeholder="Your Email *" value="">
                    </div>
                    <div class="form-group">
                        <input type="password" name="Password" class="form-control" placeholder="Your Password *" value="">
                    </div>
                    <div class="form-group">
                        <input type="submit" name="signup" class="btnSubmit" value="Sign Up">
                    </div>
                </form>
            <?php endif; ?>
        </div>
            <div class="col-md-6 login-form-2">
                <h3>Login</h3>
                <?php
                    if (isset($_POST['login'])) {
                        $email = $_POST['email'];
                        $password = $_POST['password'];

                        $query = "SELECT UserId, Email, Password, Role FROM `brockphotography_users` WHERE email = ?";

                        $stmt = mysqli_prepare($db, $query);
                        mysqli_stmt_bind_param($stmt, "s", $email);
                        mysqli_stmt_execute($stmt);

                        mysqli_stmt_bind_result($stmt, $userId, $email, $hashedPassword, $role);

                        mysqli_stmt_fetch($stmt);

                        if (password_verify($password, $hashedPassword)) {
                            $newHash = password_hash($password, PASSWORD_DEFAULT);

                            session_regenerate_id(true);

                            $_SESSION['authUser']['UserId'] = $userId;
                            $_SESSION['authUser']['email'] = $email;
                            $_SESSION['authUser']['role'] = $role;

                            header('Location: index.php');
                            die();

                        } else {
                            echo '<div class="alert alert-danger"><b>Invalid username or password</b><br>Please try again</div>';
                        }
                    }
                    if(isset($_GET['logout'])){
                        unset($_SESSION['authUser']);

                        session_destroy();

                        header("Location: sign_up_login.php");
                    }
                    ?>
                <?php if(isset($_SESSION['authUser'])): ?>
                <form method="get">
                    <input type="submit" name="logout" class="btnSubmit" value="Log Out">
                </form>
                <?php else: ?>
                <form method="post">
                    <div class="form-group">
                        <input type="text" name="email" class="form-control" placeholder="Your Email *" value="">
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="Your Password *" value="">
                    </div>
                    <div class="form-group">
                        <input type="submit" name="login" class="form-control" value="Login">
                    </div>
                </form>
                <?php endif; ?>
            </div>
    </div>
</div>
<?php
include_once "includes/footer-all.php";
?>
<script src="http://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="jquery.hashchange.min.js"></script>
<script src="jquery.easytabs.min.js"></script>
<script src="js/lightbox.js"></script>
<script src="script.js"></script>
</body>
</html>