<?php
session_name('jbrockwell_brockphotography');
session_start();
include_once "includes/database.php";

if(!isset($_SESSION['csrf_token'])){
    $_SESSION['csrf_token'] = uniqid();
}

if(isset($_GET['logout'])){
    unset($_SESSION['authUser']);

    session_destroy();

    header("Location: sign_up_login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Brock Photography</title>
    <link href="css/design.css" rel="stylesheet" type="text/css">
    <link href="css/user_admin_style.css" rel="stylesheet" type="text/css">
    <link href="css/store.css" rel="stylesheet" type="text/css">
    <link href="css/lightbox.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap-modified.css" rel="stylesheet">
</head>
<body>
<body>
    <nav class="navAll">
        <h3><a class="links" href="index.php">Brock Photography</a></h3>
        <div id="navbar">
            <ul>
                <li> <a href="galleries.php">Galleries</a></li>
                <li> <a href="contact.php">Contact</a></li>
                <?php if(isset($_SESSION['authUser']) and $_SESSION['authUser']): ?>
                    <?php if ($_SESSION['authUser']['role'] == 'admin'): ?>
                        <li><a href="users.php">Edit Users</a></li>
                        <li><a href="user_page.php">User Information</a></li>
                    <?php elseif ($_SESSION['authUser']['role'] == 'user'):?>
                        <li><a href="user_page.php">User Information</a></li>
                    <?php endif; ?>
                <?php else: ?>
                    <li> <a href="sign_up_login.php">Sign Up</a></li>
                <?php endif; ?>
                <?php if(isset($_SESSION['authUser'])): ?>
                    <form method="get">
                        <div class="logoutFloat"><input type="submit" name="logout" class="btnSubmit" value="Log Out"></div>
                    </form>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
