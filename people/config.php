<?php
// Load environment variables
require_once __DIR__ . '/../DotEnv.php';

try {
    $dotenv = new DotEnv(__DIR__ . '/../.env');
    $dotenv->load();
} catch (Exception $e) {
    die('Environment file error: ' . $e->getMessage());
}

// Include helper functions and configuration
require_once __DIR__ . '/../helpers.php';
require_once __DIR__ . '/../secure_session.php';
require_once __DIR__ . '/../app_config.php';
require_once __DIR__ . '/../line_notify.php';

// Validate environment
AppConfig::validateEnvironment();

// Start secure session
startSecureSession();

// การเชื่อมต่อกับ MySQL โดยใช้ environment variables
$servername = DotEnv::get('DB_HOST', 'localhost');
$username = DotEnv::get('DB_USERNAME');
$password = DotEnv::get('DB_PASSWORD');
$dbname = DotEnv::get('DB_NAME');

// ตรวจสอบว่ามีข้อมูลที่จำเป็นครบถ้วน
if (!$username || !$password || !$dbname) {
    logError("ขาดข้อมูลการเชื่อมต่อฐานข้อมูลใน environment variables");
    die("ข้อผิดพลาด: ขาดข้อมูลการเชื่อมต่อฐานข้อมูลใน environment variables");
}

// สร้างการเชื่อมต่อ
try {
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // ตรวจสอบการเชื่อมต่อ
    if ($conn->connect_error) {
        throw new Exception("เชื่อมต่อล้มเหลว: " . $conn->connect_error);
    }
    
    // กำหนด charset เป็น utf8mb4 เพื่อรองรับภาษาไทยและ emoji
    $conn->set_charset("utf8mb4");
    
} catch (Exception $e) {
    logError("Database connection failed", ['error' => $e->getMessage()]);
    die("เชื่อมต่อฐานข้อมูลล้มเหลว");
}

// Include database utilities after connection is established
require_once __DIR__ . '/../database_utils.php';

// ตั้งค่า timezone
$timezone = DotEnv::get('APP_TIMEZONE', 'Asia/Bangkok');
date_default_timezone_set($timezone);

// ตั้งค่า session security
if (DotEnv::get('SESSION_SECURE', 'false') === 'true') {
    ini_set('session.cookie_secure', 1);
}
if (DotEnv::get('SESSION_HTTPONLY', 'true') === 'true') {
    ini_set('session.cookie_httponly', 1);
}

// Set error reporting based on environment
if (isDebugMode()) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}
?>
