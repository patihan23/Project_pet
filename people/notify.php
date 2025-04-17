<?php
// เชื่อมต่อฐานข้อมูล
include('../config.php');

// ตรวจสอบ Session
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../login_official.php");
    exit;
}

// Query สำหรับดึงข้อมูล
$sql = "SELECT history_v.*, pet.Pet_name, pet.Type_pet, official.OFF_name, vaccine.V_name
        FROM history_v
        INNER JOIN pet ON history_v.ID_P = pet.ID_P
        INNER JOIN official ON history_v.ID_OFF = official.ID_OFF
        INNER JOIN vaccine ON history_v.ID_VC = vaccine.ID_VC";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("การดึงข้อมูลล้มเหลว: " . mysqli_error($conn));
}

// ตรวจสอบจำนวนแถวที่ได้
if (mysqli_num_rows($result) > 0) {
    // วนลูปแสดงผล
    while ($row = mysqli_fetch_assoc($result)) {
        echo "ID: " . $row["ID_HV"]. " - Pet Name: " . $row["Pet_name"]. " - HV Date: " . $row["HV_date"]. "<br>";
    }
} else {
    echo "ไม่พบข้อมูล";
}

// ปิดการเชื่อมต่อ
mysqli_close($conn);
?>


