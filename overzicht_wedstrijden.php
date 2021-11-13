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
</head><!--/head-->

<body data-spy="scroll" data-target="#navbar" data-offset="0">

<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/includes/header.php";
//include_once $_SERVER['DOCUMENT_ROOT'] . "/includes/analyticstracking.php";
?>

<section id="wedstrijden">
    <div class="container">
        <div class="box">
            <div class="row">
                <div class="col-sm-12">
                    <div class="center">
                        <h2>Wedstrijdoverzicht</h2>
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

                        <div class="col-lg-12" id="wedstrijdklasseschema">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php"; ?>

<script>
    var selectedklasse = getCookie("selectedklasse");

    if (selectedklasse != "") {
        var selectedklasse = getCookie("selectedklasse")
    } else {
        var selectedklasse = '1';
        setCookie("selectedklasse", selectedklasse, 1);
    }

    $("#selectklasse").val(selectedklasse);

    $("#wedstrijdklasseschema").load("overzicht_wedstrijden-klassereturn.php", {klasse: selectedklasse});
    //$("#geselecteerdeklasse").val("Geselecteerde Klasse: " + selectedklasse );


    $("#selectklasse").change(function () {
        var selectedklasse = $("#selectklasse option:selected").val();
        setCookie("selectedklasse", selectedklasse, 1);
        $("#wedstrijdklasseschema").load("overzicht_wedstrijden-klassereturn.php", {klasse: selectedklasse});
    });

</script>
</body>
</html>
