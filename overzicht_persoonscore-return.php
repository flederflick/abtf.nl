<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/db_connect.php';
//include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';

//sec_session_start();

// We need to use sessions, so you should always start sessions using the below code.
session_start();

if (isset($mysqli)) {
    $persoonsklasse = filter_input(INPUT_POST, 'persoonsklasse', FILTER_SANITIZE_SPECIAL_CHARS);

    $persoonsscores = array();
    #$personeninklasseQuery = "select p.ID,p.Achternaam,p.Tussenvoegsels,p.Roepnaam,p.Voorletters,v.Naam,t.Teamnummer from personen p inner join teams t on t.TeamID = p.TeamID inner join verenigingen v on t.Verenigingsnummer = v.Verenigingsnummer where t.Klasse = " . $persoonsklasse . " and p.Spelersnummer IS NOT NULL";
    $personeninklasseQuery = "select p.ID,p.Achternaam,p.Tussenvoegsels,p.Roepnaam,p.Voorletters,v.Naam,t.Teamnummer from personen p 
                inner join team_indeling ti on ti.spelersid = p.id
                inner join teams t on t.TeamID = ti.TeamID 
                inner join verenigingen v on t.Verenigingsnummer = v.Verenigingsnummer 
                where t.Klasse = " . $persoonsklasse . " and p.Spelersnummer IS NOT NULL";

    if ($result = $mysqli->query($personeninklasseQuery)) {
        while ($row = $result->fetch_assoc()) {
            $persoonsid = (int)$row['ID'];
            $totaal = 0;
            $setsplayed = 0;
            $setswon = 0;

            if (is_null($row['Tussenvoegsels'])) {
                $tussenvoegsels = "";
            } else {
                $tussenvoegsels = $row['Tussenvoegsels'];
            }

            $spelersnaam = $row['Achternaam'] . ", " . $row['Voorletters'] . " $tussenvoegsels";
            $teamnaam = $row['Naam'] . " " . $row['Teamnummer'];

            $matchesAndSetsPlayedQuery = "SELECT * FROM wedstrijdsetsspelers wss inner join wedstrijdsets ws on ws.wedstrijdsetid = wss.wedstrijdsetid where spelersid = " . $persoonsid . " and inval != 1 and setnummer != 4";

//            $invalquery = "SELECT * FROM wedstrijdsetsspelers wss inner join wedstrijdsets ws on ws.wedstrijdsetid = wss.wedstrijdsetid where spelersid = " . $persoonsid . " and inval = 1 and setnummer != 4";

            if ($MatchesPlayedResult = $mysqli->query($matchesAndSetsPlayedQuery)) {
                $setsplayed = $MatchesPlayedResult->num_rows;
                while ($matchrow = $MatchesPlayedResult->fetch_assoc()) {
                    if ($matchrow['thuisuit'] == $matchrow['setwinnaar']) {
                        $setswon++;
                    }
                }
                $MatchesPlayedResult->close();
            }

            if ($setsplayed == 0) {
                $percentage = 0;
            } else {
                $percentage = round(($setswon / $setsplayed) * 100);
            }

            $persoonscore = array("spelersnaam" => $spelersnaam, "teamnaam" => $teamnaam, "setsgespeeld" => $setsplayed, "setsgewonnen" => $setswon, "winpercentage" => $percentage);
            array_push($persoonsscores, $persoonscore);
        }
    }
    $result->close();

    usort($persoonsscores, function ($a, $b) {
        if ($a['winpercentage'] == $b['winpercentage']) {
            return $b['setsgespeeld'] > $a['setsgespeeld'] ? 1 : -1;
        } else {
            return $b['winpercentage'] > $a['winpercentage'] ? 1 : -1;
        }
    });


    printf("<table class='table table-striped'>");
    printf("<colgroup><col class='col-md-3'><col class='col-md-3'><col class='col-md-2'><col class='col-md-2'><col class='col-md-2'></colgroup>");
    printf("<thead><tr><th>Speler</th><th>Team</th><th>Sets gespeeld</th><th>Sets gewonnen</th><th>Win percentage</th>");
    printf("</tr></thead>");
    printf("<tbody>");

    foreach ($persoonsscores as $value) {
        printf("<tr>");
        printf("<td>");
        printf("%s", $value['spelersnaam']);
        printf("</td>");
        printf("<td>");
        printf("%s", $value['teamnaam']);
        printf("</td>");
        printf("<td>");
        printf("%s", $value['setsgespeeld']);
        printf("</td>");
        printf("<td>");
        printf("%s", $value['setsgewonnen']);
        printf("</td>");
        printf("<td>");
        printf("%s%%", $value['winpercentage']);
        printf("</td>");
        printf("</tr>");
    }
    printf("</tbody></table>");

}
