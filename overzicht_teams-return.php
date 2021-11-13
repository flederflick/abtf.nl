<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/db_connect.php';
//include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';

//sec_session_start();

// We need to use sessions, so you should always start sessions using the below code.
session_start();

if (isset($mysqli)) {
    $teamid = filter_input(INPUT_POST, 'team', FILTER_SANITIZE_SPECIAL_CHARS);

    $query = "select p.Spelersnummer,p.Voorletters,p.Roepnaam,p.Tussenvoegsels,p.Achternaam,v.naam,t.Teamnummer,tlt.type_omschrijving from personen p 
        inner join team_indeling ti on ti.spelersid = p.id
        inner join lid_types tlt on tlt.id = ti.lidtype
        inner join teams t on t.TeamID = ti.teamid
        inner join verenigingen v on v.Verenigingsnummer = t.Verenigingsnummer
        where ti.TeamID = " . $teamid . " order by ti.lidtype desc,p.Spelersnummer asc";


    printf("<table class='table table-striped'>");
    printf("<colgroup><col class='col-md-1'><col class='col-md-1'><col class='col-md-2'><col class='col-md-2'><col class='col-md-2'><col class='col-md-2'></colgroup>");
    printf("<thead><tr><th>Spelers#</th><th>Voorletters</th><th>Roepnaam</th><th>Achternaam</th><th>Team</th><th>Type</th>");
    printf("</tr></thead>");
    printf("<tbody>");
    if ($result = $mysqli->query($query)) {
        while ($row = $result->fetch_assoc()) {
            printf("<tr>");
            printf("<td>");
            printf("%s", $row['Spelersnummer']);
            printf("</td>");
            printf("<td>");
            printf("%s", $row['Voorletters']);
            printf("</td>");
            printf("<td>");
            printf("%s", $row['Roepnaam']);
            printf("</td>");
            printf("<td>");
            printf("%s %s", $row['Achternaam'], $row['Tussenvoegsels']);
            printf("</td>");
            printf("<td>");
            printf("%s %s", $row['naam'], $row['Teamnummer']);
            printf("</td>");
            printf("<td>");
            printf("%s", $row['type_omschrijving']);
            printf("</td>");
            printf("</tr>");
        }
        printf("</tbody></table>");
        /* free result set */
        $result->close();
    }

}

