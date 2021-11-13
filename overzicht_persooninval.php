<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/db_connect.php';
// We need to use sessions, so you should always start sessions using the below code.
session_start();
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <title><?php echo SITENAME  ?></title>
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

    </script>
</head><!--/head-->

<body data-spy="scroll" data-target="#navbar" data-offset="0">

<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . "/includes/header.php";
//	include_once $_SERVER['DOCUMENT_ROOT'] . "/includes/analyticstracking.php";
?>
    <section id="inval">
        <div class="container">
            <div class="box">
                <div class="row">
                    <div class="gap"></div>
                    <div class="col-sm-12">
                        <div class="center">
                            <h2>Inval Overzicht</h2>
                        </div>
                        <div>
                            <div class="col-lg-12" id="invalschema">

                            <?php

                            printf ("<table class='table table-striped'>");
                            printf ("<colgroup><col class='col-md-2'><col class='col-md-4'><col class='col-md-3'><col class='col-md-3'></colgroup>");
                            printf ("<thead><tr><th>wedstrijd-set</th><th>Speler</th><th>Eigen Team</th><th>Ingevallen in:</th>");
                            printf ("</tr></thead>");
                            printf ("<tbody>");

                            if(!$mysqli->connect_errno) {
                                $query = "SELECT concat_ws(' ',p.Achternaam,p.Voorletters,p.Roepnaam,'(',p.Spelersnummer,')') as Speler ,ws.wedstrijdnummer,ws.setnummer,wss.spelersid,wss.thuisuit,wss.inval,p.id,p.Spelersnummer,ti.TeamID,w.ThuisTeam,w.UitTeam,concat_ws(' ',vt.Naam,tt.Teamnummer) as TeamThuis,concat_ws(' ',vu.Naam,tu.Teamnummer) as TeamUit,concat_ws(' ',vp.Naam,tp.Teamnummer) as TeamSpeler FROM wedstrijdsets ws
                                            inner join wedstrijden w on w.Wedstrijdnummer = ws.wedstrijdnummer
                                            inner join wedstrijdsetsspelers wss on wss.wedstrijdsetid = ws.wedstrijdsetid
                                            inner join teams tt on tt.TeamID = w.ThuisTeam
                                            inner join verenigingen vt on vt.Verenigingsnummer = tt.Verenigingsnummer
                                            inner join teams tu on tu.TeamID = w.UitTeam
                                            inner join verenigingen vu on vu.Verenigingsnummer = tu.Verenigingsnummer
                                            inner join personen p on p.id = wss.spelersid
                                            inner join team_indeling ti on ti.spelersid = p.id
                                            inner join teams tp on tp.TeamID = ti.TeamID
                                            inner join verenigingen vp on vp.Verenigingsnummer = tp.Verenigingsnummer
                                            
                                            where wss.inval = 1
                                            order by ws.Wedstrijdnummer,p.spelersnummer,ws.setnummer
                                            ";


                                if ($result = $mysqli->query($query)) {
                                    while ($row = $result->fetch_assoc()) {
                                        printf("<tr>");
                                        printf("<td>");
                                        printf("%s-%s", $row['wedstrijdnummer'], $row['setnummer']);
                                        printf("</td>");
                                        printf("<td>");
                                        printf("%s", $row['Speler']);
                                        printf("</td>");
                                        printf("<td>");
                                        printf("%s", $row['TeamSpeler']);
                                        printf("</td>");
                                        if ($row['thuisuit'] == 'U') {
                                            printf("<td>");
                                            printf("%s", $row['TeamUit']);
                                            printf("</td>");
                                        }
                                        if ($row['thuisuit'] == 'T') {
                                            printf("<td>");
                                            printf("%s", $row['TeamThuis']);
                                            printf("</td>");
                                            printf("</tr>");
                                        }
                                    }
                                    $result->close();
                                }

                            }

                            printf("</tbody></table>");

                            ?>


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
</body>
</html>
