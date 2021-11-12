<?php

//foreach ($_POST as $key => $value) {
//    error_log('POST VARIABLE: '. $key . ' WITH VALUE: ' .  $value);
//}

// Check for empty fields
if (empty($_POST['name']) ||
    empty($_POST['email']) ||
    empty($_POST['message']) ||
    !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    echo "No arguments Provided!";
    return false;
}


$name = trim(stripslashes($_POST['name']));
$email = trim(stripslashes($_POST['email']));
$subject = 'Contactformulier ABTF.nl'; //trim(stripslashes($_POST['subject']));
$message = trim(stripslashes($_POST['message']));


header('Content-type: application/json');

$status = array(
    'type' => 'success',
    'message' => 'Bericht verzonden!'
);


if (empty($name) && empty($email) && empty($message)) {
    $status['type'] = 'error';
    $status['message'] = 'Error.';
    http_response_code(404);
    die;
}


$email_from = $email;
$email_to = 'info@abtf.nl';

$body = 'Name: ' . $name . "\n\n" . 'Email: ' . $email . "\n\n" . 'Subject: ' . $subject . "\n\n" . 'Message: ' . $message;

$success = mail($email_to, $subject, $body, 'From: <' . $email_from . '>');

if (!$success) {
    $status['type'] = 'error';
    $status['message'] = 'Error. Bericht niet verzonden. Gebruik contact gegevens.';
}

echo json_encode($status);
die;