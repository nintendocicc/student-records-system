<?php
// ============================================
//  db_connect.php — Database Configuration
// ============================================
//
//  MAMP  (macOS default): DB_PASS = 'root', DB_PORT = 8889
//  XAMPP (macOS default): DB_PASS = '',     DB_PORT = 3306
// ============================================

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');      // MAMP: change to 'root'
define('DB_NAME', 'student_db');
define('DB_PORT', 3306);    // MAMP: change to 8889

function getConnection(): mysqli {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

    if ($conn->connect_error) {
        http_response_code(500);
        die(json_encode([
            'success' => false,
            'message' => 'DB connection failed: ' . $conn->connect_error
        ]));
    }

    $conn->set_charset('utf8mb4');
    return $conn;
}
?>
