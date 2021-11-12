<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.html');
    exit;
}
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/db_connect.php';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Profile Page</title>
    <link href="../css/style.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
</head>
<body class="loggedin">
<nav class="navtop">
    <div>
        <h1>Website Title</h1>
        <a href="profile.php"><i class="fas fa-user-circle"></i>Profile</a>
        <a href="../login/logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
    </div>
</nav>
<div class="content">
    <h2>Profile Page</h2>
    <div>
        <p>Your account details are below:</p>
        <table>
            <tr>
                <td>Spelersnummer:</td>
                <td><?=$_SESSION['spelersnummer']?></td>
            </tr>
            <tr>
                <td>Roepnaam:</td>
                <td><?=$_SESSION['roepnaam']?></td>
            </tr>
            <tr>
                <td>Achternaam:</td>
                <td><?=$_SESSION['achternaam']?></td>
            </tr>
            <tr>
                <td>Email:</td>
                <td><?=$_SESSION['email']?></td>
            </tr>
        </table>
    </div>
</div>
</body>
</html>
