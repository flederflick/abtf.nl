<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/db_connect.php';
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
    <!--[if lt IE 9]>
    <script src="/js/html5shiv.js"></script>
    <script src="/js/respond.min.js"></script>
    <![endif]-->
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
    </script>
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
                        <h2>Teamoverzicht</h2>
                    </div>
                    <div>
                        <div class="form-group">
                            <label for="selTeam">Selecteer team::</label>
                            <select class="form-control" id="selTeam">
                                <?php
                                if (isset($mysqli)) {
                                    $query = "select t.TeamID,v.Naam,t.Teamnummer from teams t inner join verenigingen v on t.Verenigingsnummer = v.Verenigingsnummer where Teamnummer > 0 order by Naam,Teamnummer";
                                    if ($result = $mysqli->query($query)) {
                                        while ($row = $result->fetch_assoc()) {
                                            printf("<option value='%s'>%s %s</option>", $row['TeamID'], $row['Naam'], $row['Teamnummer']);
                                        }
                                    }
                                    /* free result set */
                                    $result->close();
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col-lg-12" id="teamschema">
                        </div>
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
    var selectedteam = getCookie("selectedteam");

    if (selectedteam != "") {
        var selectedteam = getCookie("selectedteam")
    } else {
        var selectedteam = $("#selTeam option:selected").val();
        setCookie("selectedteam", selectedteam, 1);
    }

    $("#selTeam").val(selectedteam);
    $("#teamschema").load("overzicht_teams-return.php", {team: selectedteam});

    $("#selTeam").change(function () {
        var selectedteam = $("#selTeam option:selected").val();
        setCookie("selectedteam", selectedteam, 1);
        $("#teamschema").load("overzicht_teams-return.php", {team: selectedteam});
    });
</script>

</body>
</html>
