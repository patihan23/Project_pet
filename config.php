<?php
// การเชื่อมต่อกับ MySQL
$servername = "";
$username = "";
$password = ""; // ใส่รหัสผ่าน MySQL ที่คุณตั้งไว้

// ชื่อฐานข้อมูล
$dbname = "project_pet";

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("เชื่อมต่อล้มเหลว: " . $conn->connect_error);
}