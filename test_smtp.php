<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/config.php';

// Încercăm să încărcăm PHPMailer din folderul includes al aplicației tale
// Notă: Ajustează căile de mai jos dacă fișierele PHPMailer se află în alt subfolder (ex: vendor/)
$phpmailer_path = __DIR__ . '/includes/PHPMailer/PHPMailer.php';
$smtp_path = __DIR__ . '/includes/PHPMailer/SMTP.php';
$exception_path = __DIR__ . '/includes/PHPMailer/Exception.php';

if (!file_exists($phpmailer_path)) {
    // Încercare alternativă în caz că structura diferă
    die("✗ Nu am găsit PHPMailer în /includes/PHPMailer/. Te rog să verifici în File Manager unde se află folderul PHPMailer.");
}

require_once $exception_path;
require_once $phpmailer_path;
require_once $smtp_path;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

try {
    // Activăm debug-ul detaliat (Serverul ne va spune pas cu pas ce nu îi convine)
    $mail->SMTPDebug = 2; 
    $mail->Debugoutput = 'html';

    $mail->isSMTP();
    $mail->Host       = SMTP_HOST;
    $mail->SMTPAuth   = true;
    $mail->Username   = SMTP_USER;
    $mail->Password   = SMTP_PASS;
    $mail->SMTPSecure = 'ssl'; // Portul 465 cere de obicei 'ssl' direct
    $mail->Port       = SMTP_PORT;

    $mail->setFrom(SMTP_FROM, SMTP_FROM_NAME);
    
    // SCHIMBĂ AICI: Pune adresa ta de mail personală pentru test
    $mail->addAddress('adresa_ta_personala@gmail.com'); 

    $mail->isHTML(true);
    $mail->Subject = 'Test SMTP Movify - Romarg';
    $mail->Body    = 'Dacă vezi acest mesaj, conexiunea SMTP prin server-0402.whmpanels.com funcționează!';

    echo "<h3>Se inițializează trimiterea prin SMTP...</h3>";
    $mail->send();
    echo "<h4 style='color:green;'>✓ Succes! Emailul a fost trimis prin SMTP fără probleme.</h4>";

} catch (Exception $e) {
    echo "<h4 style='color:red;'>✗ Eroare PHPMailer: " . $mail->ErrorInfo . "</h4>";
}
?>