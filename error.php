<?php

$error = filter_input(INPUT_GET, 'err', $filter = FILTER_SANITIZE_STRING);

if (!$error) {
    $error = 'Oops! An unknown error happened.';
}


session_start();
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <title>ABTF</title>
    <link rel="shortcut icon" href="/images/ico/favicon.ico">
    <!--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css">
    <!--    <link rel="stylesheet" href="/css/bootstrap.min.css" >-->
    <link rel="stylesheet" href="/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/main.css">
    <!--[if lt IE 9]>
    <script src="/js/html5shiv.js"></script>
    <script src="/js/respond.min.js"></script>
    <![endif]-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.1/bootstrap-table.min.js"></script>
    <script type="application/javascript" src="/js/main.js"></script>
</head><!--/head-->

<body data-spy="scroll" data-target="#navbar" data-offset="0">

<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/includes/header.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/includes/analyticstracking.php";
?>


<section id="bestuur">
    <div class="container">
        <div class="box">
            <div class="center">
                <h2>Er was een probleem</h2>
                <p class="error"><?php echo $error; ?></p>
            </div>
        </div>
    </div>
</section>


<?php include_once "includes/footer.php"; ?>


</body>
</html>
