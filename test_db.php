<?php
// Dezactivăm ascunderea erorilor ca să vedem exact ce se întâmplă
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!file_exists(__DIR__ . '/config.php')) {
    die("✗ Eroare critică: Fișierul config.php nu există în acest folder!");
}

require_once __DIR__ . '/config.php';

echo "<h3>Diagnostic Conexiune Bază de Date</h3>";
echo "DB_HOST curent în aplicație: " . (defined('DB_HOST') ? DB_HOST : 'Nedefinit') . "<br>";
echo "DB_NAME curent în aplicație: " . (defined('DB_NAME') ? DB_NAME : 'Nedefinit') . "<br>";

try {
    // Încercăm o conexiune brută direct din script pentru a testa credențialele din .env
    $host = defined('DB_HOST') ? DB_HOST : 'localhost';
    $dbname = defined('DB_NAME') ? DB_NAME : 'r133813iton_ai_video';
    $user = defined('DB_USER') ? DB_USER : 'r133813iton_dacos';
    $pass = defined('DB_PASS') ? DB_PASS : 'Azor&?2026?!';
    
    $test_pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $test_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<span style='color:green; font-weight:bold;'>✓ Succes! Conexiunea directă PDO funcționează perfect cu aceste date.</span><br>";
    
    // Testăm și obiectul global $pdo al aplicației tale
    if (isset($pdo)) {
        $stmt = $pdo->query('SELECT 1');
        echo "<span style='color:green; font-weight:bold;'>✓ Succes! Obiectul global \$pdo din config.php este inițializat corect.</span>";
    } else {
        echo "<span style='color:red; font-weight:bold;'>✗ Problemă: Obiectul \$pdo nu este definit în config.php (posibil ca fișierul .env să nu fie citit corect de librăria aplicației).</span>";
    }

} catch (Exception $e) {
    echo "<span style='color:red; font-weight:bold;'>✗ Eroare MySQL:</span> " . $e->getMessage();
}
?>