<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/db_connect.php';
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
    header('Location: ../index.php');
    exit;
}

//$format = 'd/m/Y';
//$date =  $_POST['geboortedatum'];
//
//$date = date_create_from_format($format, $date);
//echo date_format($date, 'Y-m-d');
//
//exit();

$data = array();

$persoonid = $_SESSION['id'];

$qryPersoon = 'SELECT p.Spelersnummer,p.Voorletters,p.Roepnaam,p.Tussenvoegsels,p.Achternaam,p.Geslacht,p.Straatnaam,p.Huisnummer,p.Achtervoegsels,p.Postcode,p.Woonplaats,p.Geboortedatum,p.Telefoon,p.Email,v.Naam,t.Teamnummer,p.Erelid,p.Donateur,tlt.type_omschrijving FROM personen p 
            LEFT JOIN team_indeling ti ON ti.spelersid = p.id 
            LEFT join lid_types tlt on tlt.id = ti.lidtype
            left join teams t on t.TeamID = ti.teamid
            left join verenigingen v on v.Verenigingsnummer = t.Verenigingsnummer
            WHERE p.id = ' . $persoonid . ' LIMIT 1';
if ($result = $mysqli->query($qryPersoon)) {
    while ($row = $result->fetch_assoc()) {
        $data['spelersnummer'] = $row['Spelersnummer'];
        $data['voorletters'] = $row['Voorletters'];
        $data['roepnaam'] = $row['Roepnaam'];
        $data['tussenvoegsels'] = $row['Tussenvoegsels'];
        $data['achternaam'] = $row['Achternaam'];
        $data['geslacht'] = $row['Geslacht'];
        $data['straatnaam'] = $row['Straatnaam'];
        $data['huisnummer'] = $row['Huisnummer'];
        $data['achtervoegsels'] = $row['Achtervoegsels'];
        $data['postcode'] = $row['Postcode'];
        $data['woonplaats'] = $row['Woonplaats'];
        if ($row['Geboortedatum'] !== null) {
            $gdatum = date_create_from_format('Y-m-d H:i:s', $row['Geboortedatum']);
            $data['geboortedatum'] = $gdatum->format('Y-m-d');
        } else {
            $data['geboortedatum'] = null;
        }

        $data['telefoon'] = $row['Telefoon'];
        $data['email'] = $row['Email'];
        $data['teamid'] = $row['Naam'] . " " . $row['Teamnummer'];
        $data['erelid'] = $row['Erelid'];
        $data['donateur'] = $row['Donateur'];
        $data['type_omschrijving'] = $row['type_omschrijving'];
    }
    /* free result set*/
    $result->close();
}

$query = "";
$comma = " ";

$mailmessage = "Gebruiker met spelersnummer " . $data['spelersnummer'] . " (" . $data['achternaam'] . " " . $data['voorletters'] . ") heeft de volgende gegevens gewijzigd:\n";
$mailto = "info@yendis.nl, secretaris@abtf.nl, penningmeester@abtf.nl";
$mailsubject = "Persoonsgegevens gewijzigd";

if (isset($_POST['roepnaam']) and $data['roepnaam'] != $_POST['roepnaam']) {
    if ($data['roepnaam'] !== null and $_POST['roepnaam'] == '') {
        $query .= $comma . 'roepnaam' . " = NULL";
    } else {
        $query .= $comma . 'roepnaam' . " = '" . mysqli_real_escape_string($mysqli, trim($_POST['roepnaam'])) . "'";
    }
    $comma = ", ";
    $mailmessage .= "Roepnaam: van " . $data['roepnaam'] . " naar: " . $_POST['roepnaam'] . "\r\n";
}
if (isset($_POST['voorletters']) and $data['voorletters'] != $_POST['voorletters']) {
    if ($data['voorletters'] !== null and $_POST['voorletters'] == '') {
        $query .= $comma . 'voorletters' . " = NULL";
    } else {
        $query .= $comma . 'voorletters' . " = '" . mysqli_real_escape_string($mysqli, trim($_POST['voorletters'])) . "'";
    }
    $comma = ", ";
    $mailmessage .= "Voorletters: van " . $data['voorletters'] . " naar: " . $_POST['voorletters'] . "\r\n";
}
if (isset($_POST['tussenvoegsels']) and ($data['tussenvoegsels'] != $_POST['tussenvoegsels'])) {
    if ($data['tussenvoegsels'] !== null and $_POST['tussenvoegsels'] == '') {
        $query .= $comma . 'tussenvoegsels' . " = NULL";
    } else {
        $query .= $comma . 'tussenvoegsels' . " = '" . mysqli_real_escape_string($mysqli, trim($_POST['tussenvoegsels'])) . "'";
    }
    $comma = ", ";
    $mailmessage .= "Tussenvoegsels: van " . $data['tussenvoegsels'] . " naar: " . $_POST['tussenvoegsels'] . "\r\n";
}
if (isset($_POST['achternaam']) and $data['achternaam'] != $_POST['achternaam']) {
    if ($data['achternaam'] !== null and $_POST['achternaam'] == '') {
        $query .= $comma . 'achternaam' . " = NULL";
    } else {
        $query .= $comma . 'achternaam' . " = '" . mysqli_real_escape_string($mysqli, trim($_POST['achternaam'])) . "'";
    }
    $comma = ", ";
    $mailmessage .= "Achternaam: van " . $data['achternaam'] . " naar: " . $_POST['achternaam'] . "\r\n";
}
if (isset($_POST['geslacht']) and $data['geslacht'] != $_POST['geslacht']) {
    if ($data['geslacht'] !== null and $_POST['geslacht'] == '') {
        $query .= $comma . 'geslacht' . " = NULL";
    } else {
        $query .= $comma . 'geslacht' . " = '" . mysqli_real_escape_string($mysqli, trim($_POST['geslacht'])) . "'";
    }
    $comma = ", ";
    $mailmessage .= "Geslacht: van " . $data['geslacht'] . " naar: " . $_POST['geslacht'] . "\r\n";
}
if (isset($_POST['gdat']) and $data['geboortedatum'] != $_POST['gdat']) {
    if ($data['geboortedatum'] !== null and $_POST['gdat'] == '') {
        $query .= $comma . 'geboortedatum' . " = NULL";
    } else {
        $format = 'd/m/Y';
        $date =  $_POST['gdat'];

        $date = date_create_from_format($format, $date);
        $geboortedatum = date_format($date, 'Y-m-d');

        $query .= $comma . 'geboortedatum' . " = '" . mysqli_real_escape_string($mysqli, trim($geboortedatum)) . "'";
    }

    $comma = ", ";
    $mailmessage .= "Geboortedatum: van " . $data['geboortedatum'] . " naar: " . $_POST['gdat'] . "\r\n";
}
if (isset($_POST['straatnaam']) and $data['straatnaam'] != $_POST['straatnaam']) {
    if ($data['straatnaam'] !== null and $_POST['straatnaam'] == '') {
        $query .= $comma . 'straatnaam' . " = NULL";
    } else {
        $query .= $comma . 'straatnaam' . " = '" . mysqli_real_escape_string($mysqli, trim($_POST['straatnaam'])) . "'";
    }
    $comma = ", ";
    $mailmessage .= "Straatnaam: van " . $data['straatnaam'] . " naar: " . $_POST['straatnaam'] . "\r\n";
}
if (isset($_POST['huisnummer']) and $data['huisnummer'] != $_POST['huisnummer']) {
    if ($data['huisnummer'] !== null and $_POST['huisnummer'] == '') {
        $query .= $comma . 'huisnummer' . " = NULL";
    } else {
        $query .= $comma . 'huisnummer' . " = '" . mysqli_real_escape_string($mysqli, trim($_POST['huisnummer'])) . "'";
    }
    $comma = ", ";
    $mailmessage .= "Huisnummer: van " . $data['huisnummer'] . " naar: " . $_POST['huisnummer'] . "\r\n";
}
if (isset($_POST['achtervoegsels']) and $data['achtervoegsels'] != $_POST['achtervoegsels']) {
    if ($data['achtervoegsels'] !== null and $_POST['achtervoegsels'] == '') {
        $query .= $comma . 'achtervoegsels' . " = NULL";
    } else {
        $query .= $comma . 'achtervoegsels' . " = '" . mysqli_real_escape_string($mysqli, trim($_POST['achtervoegsels'])) . "'";
    }
    $comma = ", ";
    $mailmessage .= "Achtervoegsels: van " . $data['achtervoegsels'] . " naar: " . $_POST['achtervoegsels'] . "\r\n";
}
if (isset($_POST['postcode']) and $data['postcode'] != $_POST['postcode']) {
    if ($data['postcode'] !== null and $_POST['postcode'] == '') {
        $query .= $comma . 'postcode' . " = NULL";
    } else {
        $query .= $comma . 'postcode' . " = '" . mysqli_real_escape_string($mysqli, trim($_POST['postcode'])) . "'";
    }
    $comma = ", ";
    $mailmessage .= "Postcode: van " . $data['postcode'] . " naar: " . $_POST['postcode'] . "\r\n";
}
if (isset($_POST['woonplaats']) and $data['woonplaats'] != $_POST['woonplaats']) {
    if ($data['woonplaats'] !== null and $_POST['woonplaats'] == '') {
        $query .= $comma . 'woonplaats' . " = NULL";
    } else {
        $query .= $comma . 'woonplaats' . " = '" . mysqli_real_escape_string($mysqli, trim($_POST['woonplaats'])) . "'";
    }
    $comma = ", ";
    $mailmessage .= "Woonplaats: van " . $data['woonplaats'] . " naar: " . $_POST['woonplaats'] . "\r\n";
}
if (isset($_POST['telefoonnummer']) and $data['telefoon'] != $_POST['telefoonnummer']) {
    if ($data['telefoon'] !== null and $_POST['telefoonnummer'] == '') {
        $query .= $comma . 'telefoon' . " = NULL";
    } else {
        $query .= $comma . 'telefoon' . " = '" . mysqli_real_escape_string($mysqli, trim($_POST['telefoonnummer'])) . "'";
    }
    $comma = ", ";
    $mailmessage .= "Telefoonnummer: van " . $data['telefoonnummer'] . " naar: " . $_POST['telefoonnummer'] . "\r\n";
}
if (isset($_POST['email']) and $data['email'] != $_POST['email']) {
    if ($data['email'] !== null and $_POST['email'] == '') {
        $query .= $comma . 'email' . " = NULL";
    } else {
        $query .= $comma . 'email' . " = '" . mysqli_real_escape_string($mysqli, trim($_POST['email'])) . "'";
    }
    $comma = ", ";
    $mailmessage .= "Email: van " . $data['email'] . " naar: " . $_POST['email'] . "\r\n";
}

if ($query != "") {
    $query = "UPDATE personen SET" . $query . " WHERE id = " . $persoonid;

    if ($mysqli->query($query)) {
//                mail($mailto, $mailsubject, $mailmessage, 'From: <info@yendis.nl>');
        header("Location: /portal/profiel.php?message=Update Succesvol&type=success");
        exit();
    } else {
        header("Location: /error.php?err=" . $mysqli->error . "&type=error");
        exit();
    }

} else {
    //echo "Geen wijziging";
    header("Location: /portal/profiel.php?message=Geen verandering ontvangen.&type=warning");
    exit();

}