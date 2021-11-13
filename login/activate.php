<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/db_connect.php';

// First we check if the email and code exists...
if (isset($_GET['email'], $_GET['code'])) {
    if ($stmt = $mysqli->prepare('SELECT * FROM personen WHERE email = ? AND activation_code = ?')) {
        $stmt->bind_param('ss', $_GET['email'], $_GET['code']);
        $stmt->execute();
        // Store the result so we can check if the account exists in the database.
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            // Account exists with the requested email and code.
            if ($stmt = $mysqli->prepare('UPDATE personen SET activation_code = ? WHERE email = ? AND activation_code = ?')) {
                // Set the new activation code to 'activated', this is how we can check if the user has activated their account.
                $newcode = 'activated';
                $stmt->bind_param('sss', $newcode, $_GET['email'], $_GET['code']);
                $stmt->execute();
                echo 'Your account is now activated! You can now <a href="index.php">login</a>!';
            }
        } else {
            echo 'The account is already activated or doesn\'t exist!';
        }
    }
}
?>