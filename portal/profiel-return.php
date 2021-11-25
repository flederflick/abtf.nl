<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/db_connect.php';
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
    header('Location: ../index.php');
    exit;
}

$data = array();
$persoonid = $_SESSION['id'];

$qryPersoon = 'SELECT p.Spelersnummer,p.Voorletters,p.Roepnaam,p.Tussenvoegsels,p.Achternaam,p.Geslacht,p.Straatnaam,p.Huisnummer,p.Achtervoegsels,p.Postcode,p.Woonplaats,p.Geboortedatum,p.Telefoon,p.Email,v.Naam,t.Teamnummer,p.Erelid,p.Donateur,tlt.type_omschrijving FROM personen p 
            LEFT JOIN team_indeling ti ON ti.spelersid = p.id 
            LEFT join lid_types tlt on tlt.id = ti.lidtype
            left join teams t on t.TeamID = ti.teamid
            left join verenigingen v on v.Verenigingsnummer = t.Verenigingsnummer
            WHERE p.id = ' . $persoonid;
if ($result = $mysqli->query($qryPersoon)) {
    while ($row = $result->fetch_assoc()) {
        $data[] = array(
            'spelersnummer' => $row['Spelersnummer'],
            'voorletters' => $row['Voorletters'],
            'roepnaam' => $row['Roepnaam'],
            'tussenvoegsels' => $row['Tussenvoegsels'],
            'achternaam' => $row['Achternaam'],
            'geslacht' => $row['Geslacht'],
            'straatnaam' => $row['Straatnaam'],
            'huisnummer' => $row['Huisnummer'],
            'achtervoegsels' => $row['Achtervoegsels'],
            'postcode' => $row['Postcode'],
            'woonplaats' => $row['Woonplaats'],
            'geboortedatum' => $row['Geboortedatum'],
            'telefoon' => $row['Telefoon'],
            'email' => $row['Email'],
            'teamid' => $row['Naam'] . " " . $row['Teamnummer'],
            'erelid' => $row['Erelid'],
            'donateur' => $row['Donateur'],
            'type_omschrijving' => $row['type_omschrijving']
        );
    }
    /* free result set*/
    $result->close();
}


header('Content-type: application/json');
echo json_encode($data);
