<?php
// การเชื่อมต่อกับ MySQL
$servername = "sql107.infinityfree.com";
$username = "if0_38604586";
$password = "6b1AkWzukDP"; // ใส่รหัสผ่านจริงที่คุณได้รับจาก InfinityFree

// ชื่อฐานข้อมูล
$dbname = "if0_38604586_project_pet"; // เปลี่ยน XXX เป็นชื่อฐานข้อมูลจริงที่คุณสร้างไว้

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("เชื่อมต่อล้มเหลว: " . $conn->connect_error);
} else {
    // กำหนด charset เป็น utf8mb4 เพื่อรองรับภาษาไทยและ emoji
    $conn->set_charset("utf8mb4");
}
?>
