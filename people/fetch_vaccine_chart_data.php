<?php
session_start();
include('../config.php');

// ตรวจสอบการเข้าสู่ระบบ
if (!isset($_SESSION['username'])) {
    header("Location: ../login_official.php");
    exit;
}

// รับปีที่เลือกจากการร้องขอ
$year = $_POST['year'];

// ตรวจสอบว่าปีที่เลือกมีค่า
if (!$year) {
    echo json_encode(['labels' => [], 'data' => [], 'colors' => []]);
    exit;
}

// คำสั่ง SQL สำหรับสรุปข้อมูลวัคซีน
$sql = "SELECT 
            CASE 
                WHEN p.Type_pet = 1 THEN 'สุนัข'
                WHEN p.Type_pet = 2 THEN 'แมว'
            END AS type,
            CASE 
                WHEN p.Gender = 1 THEN 'เพศผู้'
                WHEN p.Gender = 2 THEN 'เพศเมีย'
            END AS gender,
            CASE 
                WHEN hv.HV_date IS NOT NULL THEN 'ได้รับวัคซีน'
                ELSE 'ไม่ได้รับวัคซีน'
            END AS vaccination_status,
            COUNT(*) AS total
        FROM pet p
        LEFT JOIN history_v hv ON p.ID_P = hv.ID_P AND YEAR(hv.HV_date) = ?
        WHERE p.Type_pet IN (1, 2)
        GROUP BY p.Type_pet, p.Gender, vaccination_status";

$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $year);
$stmt->execute();
$result = $stmt->get_result();

// เตรียมข้อมูลสำหรับการแสดงผล
$labels = [];
$data = [];
$colors = [];
$colorMap = [
    'สุนัข-เพศผู้-ได้รับวัคซีน' => '#FF9999',
    'สุนัข-เพศเมีย-ได้รับวัคซีน' => '#FF6666',
    'แมว-เพศผู้-ได้รับวัคซีน' => '#99CC99',
    'แมว-เพศเมีย-ได้รับวัคซีน' => '#66CC66',
    'สุนัข-เพศผู้-ไม่ได้รับวัคซีน' => '#FFCC99',
    'สุนัข-เพศเมีย-ไม่ได้รับวัคซีน' => '#FF9966',
    'แมว-เพศผู้-ไม่ได้รับวัคซีน' => '#99CCFF',
    'แมว-เพศเมีย-ไม่ได้รับวัคซีน' => '#66CCFF',
];

while ($row = $result->fetch_assoc()) {
    $key = $row['type'] . '-' . $row['gender'] . '-' . $row['vaccination_status'];
    $labels[] = $key; // แสดง label เป็นประเภทสัตว์ - เพศ - สถานะวัคซีน
    $data[] = $row['total'];
    $colors[] = $colorMap[$key];
}

// ส่งข้อมูลกลับเป็น JSON
echo json_encode([
    'labels' => $labels,
    'data' => $data,
    'colors' => $colors
]);

$stmt->close();
$conn->close();
?>
