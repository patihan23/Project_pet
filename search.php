<?php
session_start();
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $search_query = $_POST["search_query"];
}

// ตรวจสอบคำค้นหาว่ามีรหัสประชาชนหรือชื่อเจ้าของหรือไม่
$sql = "SELECT pet.Type_pet, pet.Pet_name, pet.Gender, pet.color, pet.p_old,  pet_own.Po_name, pet_own.Hno, pet_own.Moo, pet_own.ID, history_v.HV_date, sterilization.S_date, pet.Breed, history_v.next_Hv_date 
        FROM pet
        INNER JOIN pet_own ON pet.ID_PO = pet_own.ID_PO
        LEFT JOIN history_v ON pet.ID_P = history_v.ID_P
        LEFT JOIN sterilization ON pet.ID_P = sterilization.ID_P
        WHERE (pet_own.Po_name LIKE ? OR pet.Pet_name LIKE ?)";

// เตรียมคำสั่ง SQL โดยใช้ prepared statements
$stmt = $conn->prepare($sql);

$search_param = "%$search_query%"; // เพิ่ม % ที่ตัวอักษรทั้งสองด้าน

// Bind parameters
$stmt->bind_param("ss", $search_param, $search_param);

// Execute
$stmt->execute();

// Get result
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<h3>ผลลัพธ์การค้นหาสำหรับ: $search_query</h3>";
    echo "<table>
        <tr>
            <th>ประเภทสัตว์เลี้ยง</th>
            <th>ชื่อสัตว์เลี้ยง</th>
            <th>เพศ</th>
            <th>พันธุ์</th>
            <th>สีหรือตำหนิ</th>
            <th>อายุ</th>
            <th>วันที่ทำการฉีดวัคซีน</th>
            <th>ฉีดครั้งถัดไป</th>
            <th>ชื่อเจ้าของสัตว์เลี้ยง</th>
        </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . ($row["Type_pet"] == 1 ? 'สุนัข' : ($row["Type_pet"] == 2 ? 'แมว' : 'ไม่ทราบ')) . "</td>";
        echo "<td>" . $row["Pet_name"] . "</td>";
        echo "<td>" . ($row["Gender"] == 1 ? 'เพศผู้' : ($row["Gender"] == 2 ? 'เพศเมีย' : 'ไม่ทราบ')) . "</td>";
        echo "<td>" . $row["Breed"] . "</td>";
        echo "<td>" . $row["color"] . "</td>";
        echo "<td>" . $row["p_old"] . "</td>";
        echo "<td>" . (!empty($row["HV_date"]) ? $row["HV_date"] : "ยังไม่ได้รับการฉีดวัคซีน") . "</td>";
        echo "<td>" . (!empty($row["next_Hv_date"]) ? $row["next_Hv_date"] : "ยังไม่ได้รับการฉีดวัคซีน") . "</td>";
        echo "<td>" . $row["Po_name"] . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "ไม่พบข้อมูลที่ตรงกับคำค้นหา: $search_query";
}

// ปิด prepared statement
$stmt->close();

// ปิดการเชื่อมต่อ
$conn->close();
