<?php
include('process.php');

require_once "PHPMailer.php";
require_once "Exception.php";
require_once "SMTP.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

$mail = new PHPMailer(true);
//$mail->SMTPDebug = 3;      
$mail->SMTPDebug = 2;
$mail->isSMTP();
$mail->Host = 'smtp-relay.sendinblue.com';
$mail->SMTPAuth = true;
$mail->Username = 'tinggas.imccccs@gmail.com';
$mail->Password = 'sAcgIk9EKTCMmNpt';
$mail->SMTPSecure = 'tsl';
$mail->Port = 587;
$mail->From = 'IMCC_Shit@school.com';
$mail->FromName = 'IMCC Shit';
$mail->addAddress('giovanetinggas@gmail.com', 'Giovane');
$mail->isHTML(true);
$mail->Subject = 'Green Heart';
$mail->Body = 'Green Hearted Shit';
$mail->AltBody = 'Body in plain text for non-HTML mail clients';
try {
    $mail->send();
    echo "Message has been sent successfully";
} catch (Exception $e) {
    echo "Mailer Error: " . $mail->ErrorInfo;
}
