<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/db_connect.php';
//include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';

//sec_session_start();

// We need to use sessions, so you should always start sessions using the below code.
session_start();
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <title><?php echo SITENAME ?></title>
    <link rel="shortcut icon" href="/images/ico/favicon.ico">
    <!--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css">
    <!--    <link rel="stylesheet" href="/css/bootstrap.min.css" >-->
    <link rel="stylesheet" href="/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/main.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.1/bootstrap-table.min.js"></script>
    <script type="application/javascript" src="/js/main.js"></script>
    <script type="text/javascript">
        function setCookie(cname, cvalue, exdays) {
            var d = new Date();
            d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
            var expires = "expires=" + d.toUTCString();
            document.cookie = cname + "=" + cvalue + "; " + expires;
        }

        function getCookie(cname) {
            var name = cname + "=";
            var ca = document.cookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }

        function checkCookie() {
            var user = getCookie("username");
            if (user != "") {
                alert("Welcome again " + user);
            } else {
                user = prompt("Please enter your name:", "");
                if (user != "" && user != null) {
                    setCookie("username", user, 365);
                }
            }
        }
    </script>
    <!--<style type="text/css">
        .loader {
            border: 16px solid #f3f3f3; /* Light grey */
            /*border-top: 16px solid #3498db; !* Blue *!*/
            border-top: 16px solid blue;
            border-right: 16px solid green;
            border-bottom: 16px solid red;
            border-radius: 50%;
            width: 120px;
            height: 120px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>-->
</head><!--/head-->

<body data-spy="scroll" data-target="#navbar" data-offset="0">

<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/includes/header.php";
//include_once $_SERVER['DOCUMENT_ROOT'] . "/includes/analyticstracking.php";
?>

<section id="teams">
    <div class="container">
        <div class="box">
            <div class="row">
                <div class="col-sm-12">
                    <div class="center">
                        <h2>Teams Score Overzicht</h2>
                    </div>
                    <div>
                        <div class="form-group">
                            <label for="selectklasse">Selecteer klasse:</label>
                            <select class="form-control" id="selectklasse">
                                <?php
                                if (isset($mysqli)) {
                                    $query = "select distinct klasse from teams order by klasse ASC";
                                    if ($result = $mysqli->query($query)) {
                                        while ($row = $result->fetch_assoc()) {
                                            printf("<option value='%s'>%s</option>", $row['klasse'], $row['klasse']);
                                        }
                                    }
                                    /* free result set */
                                    $result->close();
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col-lg-12" id="teamscoreoverzicht"></div>

                        <!--						<div class="col-lg-5"></div>-->
                        <div class="col-lg-12 loader" id="loader"></div>
                        <!--						<div class="col-lg-5"></div>-->


                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php";
?>


<script>
    var selectedklasse = getCookie("selectedklasse")

    if (selectedklasse != "") {
        var selectedklasse = getCookie("selectedklasse")
    } else {
        //var selectedklasse = '2';
        var selectedklasse = $("#selectklasse option:selected").val();
        setCookie("selectedklasse", selectedklasse, 1);
    }

    $("#selectklasse").val(selectedklasse);
    $("#loader").show();
    $("#teamscoreoverzicht").load("overzicht_teamscore-teamreturn.php", {klasse: selectedklasse}, function () {
        $("#loader").hide();
    });


    $("#selectklasse").change(function () {
        $("#teamscoreoverzicht").empty();
        $("#loader").show();
        var selectedklasse = $("#selectklasse option:selected").val();
        setCookie("selectedklasse", selectedklasse, 1);
        $("#teamscoreoverzicht").load("overzicht_teamscore-teamreturn.php", {klasse: selectedklasse}, function () {
            $("#loader").hide();
        });
    });
</script>

</body>
</html>
