<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/db_connect.php';
//include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';

//sec_session_start();

// We need to use sessions, so you should always start sessions using the below code.
session_start();

if (isset($mysqli)) {
    $WedstrijdNummer = filter_input(INPUT_POST, 'WedstrijdNummer', FILTER_SANITIZE_SPECIAL_CHARS);
    $wedstrijd = array(
        '1' => array("spelerT" => null, "spelerU" => null, "game1score" => null, "game2score" => null, "game3score" => null, "game4score" => null, "game5score" => null),
        '2' => array("spelerT" => null, "spelerU" => null, "game1score" => null, "game2score" => null, "game3score" => null, "game4score" => null, "game5score" => null),
        '3' => array("spelerT" => null, "spelerU" => null, "game1score" => null, "game2score" => null, "game3score" => null, "game4score" => null, "game5score" => null),
        '4' => array("spelerT" => "Dubbels", "spelerU" => "Dubbels", "game1score" => null, "game2score" => null, "game3score" => null, "game4score" => null, "game5score" => null),
        '5' => array("spelerT" => null, "spelerU" => null, "game1score" => null, "game2score" => null, "game3score" => null, "game4score" => null, "game5score" => null),
        '6' => array("spelerT" => null, "spelerU" => null, "game1score" => null, "game2score" => null, "game3score" => null, "game4score" => null, "game5score" => null),
        '7' => array("spelerT" => null, "spelerU" => null, "game1score" => null, "game2score" => null, "game3score" => null, "game4score" => null, "game5score" => null),
        '8' => array("spelerT" => null, "spelerU" => null, "game1score" => null, "game2score" => null, "game3score" => null, "game4score" => null, "game5score" => null),
        '9' => array("spelerT" => null, "spelerU" => null, "game1score" => null, "game2score" => null, "game3score" => null, "game4score" => null, "game5score" => null),
        '10' => array("spelerT" => null, "spelerU" => null, "game1score" => null, "game2score" => null, "game3score" => null, "game4score" => null, "game5score" => null)
    );


    $setquery = "SELECT ws.setnummer, concat((concat_ws(' ', p.Achternaam, p.Voorletters, p.Tussenvoegsels)), ' (' , p.Spelersnummer , ')') AS Speler,wss.thuisuit,wss.setwinnaar,wsgu.gamenummer,wsgu.scorethuis,wsgu.scoreuit
            FROM wedstrijdsets ws
            left join wedstrijdsetsspelers wss on wss.wedstrijdsetid = ws.wedstrijdsetid
            inner join wedstrijden w on w.Wedstrijdnummer = ws.wedstrijdnummer
            inner join wedstrijdsetgameuitslag wsgu on wsgu.wedstrijdsetid = ws.wedstrijdsetid
            left join personen p on p.id = wss.spelersid
            where w.Wedstrijdnummer = ?
            order by ws.setnummer,wsgu.gamenummer,wss.thuisuit";

    if ($stmt = $mysqli->prepare($setquery)) {
        $stmt->bind_param('i', $WedstrijdNummer);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $setnummer = (string)$row['setnummer'];
            $gamenummer = (string)$row['gamenummer'];
            if ($row['thuisuit'] == 'T') {
                if ($wedstrijd[$setnummer]['spelerT'] == null) {
                    $wedstrijd[$setnummer]['spelerT'] = $row['Speler'];
                }
            } elseif ($row['thuisuit'] == 'U') {
                if ($wedstrijd[$setnummer]['spelerU'] == null) {
                    $wedstrijd[$setnummer]['spelerU'] = $row['Speler'];
                }
            }
            $wedstrijd[$setnummer]['game' . $gamenummer . 'score'] = $row['scorethuis'] . '-' . $row['scoreuit'];
        }
        $result->close();
    }


    $ingevoerdquery = "select concat(concat_ws(' ', p.Achternaam, p.Voorletters, p.Tussenvoegsels) , ' (' , COALESCE(p.Spelersnummer, '') , ')') as IngevoerdDoor
            from wedstrijduitslag wu
            inner join personen p on p.id = wu.ingevoerddoor
            where wu.wedstrijdnummer = ? LIMIT 1 ;";

    if ($stmt = $mysqli->prepare($ingevoerdquery)) {
        $stmt->bind_param('i', $WedstrijdNummer);
        $stmt->execute();
        $stmt->bind_result($ingevoerddoor);
        $stmt->fetch();
        $stmt->close();
    }


    printf("<label>Wedstrijdnummer: %s</label><br>", $WedstrijdNummer);
    printf("<label>Ingevoerd door: %s</label>", $ingevoerddoor);
    printf("<table class='table table-striped'>");
    printf("<colgroup><col class='col-md-1'><col class='col-md-3'><col class='col-md-3'><col class='col-md-1'><col class='col-md-1'><col class='col-md-1'><col class='col-md-1'><col class='col-md-1'></colgroup>");
    printf("<thead><tr><th>Set</th><th>Thuis</th><th>Uit</th><th>Game1</th><th>Game2</th><th>Game3</th><th>Game4</th><th>Game5</th>");
    printf("</tr></thead>");
    printf("<tbody>");

    foreach ($wedstrijd as $key => $value) {
        if ($value["spelerT"] != null && $value["game1score"] != null) {
            printf("<tr>");
            printf("<td>");
            printf("%s", $key);
            printf("</td>");
            printf("<td  style='white-space:pre'>");
            if (!is_null($value['spelerT'])) {
                if (isset($value['spelerT'])) {
                    printf("%s", $value['spelerT']);
                }
            }
            printf("</td>");

            printf("<td style='white-space:pre'>");
            if (!is_null($value['spelerU'])) {
                if (isset($value['spelerU'])) {
                    printf("%s", $value['spelerU']);
                }
            }
            printf("</td>");

            printf("<td>");
            if (isset($value['game1score'])) {
                printf("%s", $value['game1score']);
            }
            printf("</td>");

            printf("<td>");
            if (isset($value['game2score'])) {
                printf("%s", $value['game2score']);
            }
            printf("</td>");

            printf("<td>");
            if (isset($value['game3score'])) {
                printf("%s", $value['game3score']);
            }
            printf("</td>");

            printf("<td>");
            if (isset($value['game4score'])) {
                printf("%s", $value['game4score']);
            }
            printf("</td>");

            printf("<td>");
            if (isset($value['game5score'])) {
                printf("%s", $value['game5score']);
            }
            printf("</td>");
            printf("</tr>");
        }
    }
    printf("</tbody></table>");
}

?>
