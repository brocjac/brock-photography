<?php
include_once "includes/header-all.php";
include_once "includes/store.php"
?>
<?php
include_once "includes/functions.php";
    if (formVal('send')){
        $email = formVal('email');
        $subject = formVal('subject');
        $message = formVal('message');

        $email = htmlspecialchars($email);
        $subject = htmlspecialchars($subject);
        $message = htmlspecialchars($message);

        $headers = "From: Brock Photography<jbrockwell.bitlampsites.com>";
        $headers .= "Reply-To: $email\n";
        if(mail('brocjac24@outlook.com', $subject, $message, $headers)){
            echo '<p>Thank you for your message, we will get back with you soon.</p>';
        } else {
            echo '<p>Error</p>';
        }
    }
?>
<form method="post">
    <main id="contact">
        <p>
            <label for="email">Email</label><br>
            <input id="email" name="email" type="email">
        </p>
        <p>
            <label for="subject">Subject</label><br>
            <input id="subject" name="subject" type="text">
        </p>
        <p>
            <label for="message">Message</label><br>
            <textarea id="message" name="message" type="email"></textarea>
        </p>
        <p>
            <input type="submit" name="send" value="Send Message">
        </p>
    </main>
</form>
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