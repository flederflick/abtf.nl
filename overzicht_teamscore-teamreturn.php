<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/db_connect.php';
//include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';

//sec_session_start();

// We need to use sessions, so you should always start sessions using the below code.
session_start();


if (isset($mysqli)) {
    $klasse = filter_input(INPUT_POST, 'klasse', FILTER_SANITIZE_SPECIAL_CHARS);

    $teamscores = array();
    $query = "select t.teamid from teams t inner join verenigingen v on v.Verenigingsnummer = t.Verenigingsnummer where klasse = " . $klasse . " and v.Verenigingsnummer != 98";
    if ($result = $mysqli->query($query)) {
        while ($row = $result->fetch_row()) {
            $teamid = (int)$row[0];
            $teamNaam = "";

            $totaal = 0;
            $strafuit = 0;
            $strafthuis = 0;

            $aantalwedstrijden = 0;
            $aantalgespeeldewedstrijden = 0;

            $naamquery = "select v.Naam,t.Teamnummer from teams t inner join verenigingen v on v.Verenigingsnummer = t.Verenigingsnummer where t.TeamID = " . $teamid;
            if ($naamresult = $mysqli->query($naamquery)) {
                $rownaam = $naamresult->fetch_row();
                $teamNaam = $rownaam[0] . " " . $rownaam[1];
                $naamresult->close();
            }


            $thuisScoreQuery = "select sum(uw.scoreThuis) as thuisscore from wedstrijduitslag uw inner join wedstrijden w on w.Wedstrijdnummer = uw.wedstrijdnummer inner join teams t on t.TeamID = w.ThuisTeam where t.teamid = " . $teamid;
            if ($thuisscoreresult = $mysqli->query($thuisScoreQuery)) {
                $rowthuisscore = $thuisscoreresult->fetch_row();
                if (!is_null($rowthuisscore[0])) {
                    $totaal += $rowthuisscore[0];
                }
                $thuisscoreresult->close();
            }


            $uitScoreQuery = "select sum(uw.scoreUit) as uitscore from wedstrijduitslag uw inner join wedstrijden w on w.Wedstrijdnummer = uw.wedstrijdnummer inner join teams t on t.TeamID = w.UitTeam where t.teamid = " . $teamid;
            if ($uitscoreresult = $mysqli->query($uitScoreQuery)) {
                $rowuitscore = $uitscoreresult->fetch_row();
                if (!is_null($rowuitscore[0])) {
                    $totaal += $rowuitscore[0];
                }
                $uitscoreresult->close();
            }


            $uitStrafQuery = "select sum(s.Strafpunten) from wedstrijden w inner join strafpunten s on s.Wedstrijdnummer = w.Wedstrijdnummer where w.UitTeam = " . $teamid;
            if ($uitstrafresult = $mysqli->query($uitStrafQuery)) {
                $rowstrafuit = $uitstrafresult->fetch_row();
                if (!is_null($rowstrafuit[0])) {
                    $strafuit += $rowstrafuit[0];
                }
                $uitstrafresult->close();
            }


            $aantalWedstrijdenQuery = "select count(*) from wedstrijden w left join wedstrijduitslag uw on uw.wedstrijdnummer = w.Wedstrijdnummer where w.ThuisTeam = " . $teamid . " or w.UitTeam = " . $teamid;
            if ($aantalWedstrijdenresult = $mysqli->query($aantalWedstrijdenQuery)) {
                $rowaantalWedstrijden = $aantalWedstrijdenresult->fetch_row();
                if (!is_null($rowaantalWedstrijden[0])) {
                    $aantalwedstrijden += $rowaantalWedstrijden[0];
                }
                $aantalWedstrijdenresult->close();
            }

            $aantalGespeeldeWedstrijdenQuery = "select count(*) from wedstrijden w left join wedstrijduitslag uw on uw.wedstrijdnummer = w.Wedstrijdnummer where (w.ThuisTeam = " . $teamid . " or w.UitTeam = " . $teamid . ") and uw.wedstrijdnummer IS NOT NULL";
            if ($aantalGespeeldeWedstrijdenresult = $mysqli->query($aantalGespeeldeWedstrijdenQuery)) {
                $rowaantalgespeeldewedstrijden = $aantalGespeeldeWedstrijdenresult->fetch_row();
                if (!is_null($rowaantalgespeeldewedstrijden[0])) {
                    $aantalgespeeldewedstrijden += $rowaantalgespeeldewedstrijden[0];
                }
                $aantalGespeeldeWedstrijdenresult->close();
            }

            $totaalstraf = $strafthuis + $strafuit;
            $score = $totaal - $totaalstraf;

            $nogtespelenwedstrijden = $aantalgespeeldewedstrijden;

            $teamscore = array($teamNaam, $totaal, $totaalstraf, $score, $nogtespelenwedstrijden);
            array_push($teamscores, $teamscore);
        }
    }

    $result->close();

    usort($teamscores, function ($a, $b) {
        return $b[3] - $a[3];
    });


    printf("<table class='table table-striped'>");
    printf("<colgroup><col class='col-md-4'><col class='col-md-4'><col class='col-md-2'><col class='col-md-2'></colgroup>");
    printf("<thead><tr><th>Team</th><th>Gespeelde wedstrijden</th><th>Punten</th><th>Totaal</th>");
    printf("</tr></thead>");
    printf("<tbody>");

    foreach ($teamscores as $value) {
        printf("<tr>");
        printf("<td>");
        printf("%s", $value[0]);
        printf("</td>");
        printf("<td>");
        printf("%s", $value[4]);
        printf("</td>");
        printf("<td>");
        printf("%s", $value[1]);
        printf("</td>");
        printf("<td>");
        printf("%s", $value[3]);
        printf("</td>");
        printf("</tr>");
    }
    printf("</tbody></table>");
}

