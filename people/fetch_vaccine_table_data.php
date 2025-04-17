<?php
session_start();
include('../config.php');

if (!isset($_SESSION['username'])) {
    header("Location: ../login_official.php");
    exit;
}

// รับปีที่เลือกจากการร้องขอ
$year = $_POST['year'];

// ตรวจสอบว่าปีที่เลือกมีค่า
if (!$year) {
    echo "ไม่มีข้อมูล";
    exit;
}

// ค้นหาข้อมูลการฉีดวัคซีนตามปีที่เลือก
$sql = "SELECT 
            history_v.ID_HV,
            history_v.HV_date,
            history_v.next_Hv_date,
            vaccine.V_name,
            pet.Pet_name,
            official.OFF_name
        FROM history_v
        INNER JOIN pet ON history_v.ID_P = pet.ID_P
        INNER JOIN official ON history_v.ID_OFF = official.ID_OFF
        INNER JOIN vaccine ON history_v.ID_VC = vaccine.ID_VC
        WHERE YEAR(history_v.HV_date) = ?
        ORDER BY history_v.ID_HV ASC";

$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $year);
$stmt->execute();
$result = $stmt->get_result();

echo '<table id="vaccine_chart" class="table">
        <thead>
            <tr style="text-align: center;">
                <th>วันที่ฉีด</th>
                <th>ฉีดครั้งถัดไป</th>
                <th>ชื่อวัคซีน</th>
                <th>ชื่อสัตว์เลี้ยง</th>
                <th>สัตวแพทย์รับผิดชอบ</th>
            </tr>
        </thead>
        <tbody>';

while ($row = $result->fetch_assoc()) {
    // แปลงวันที่เป็นรูปแบบปี พ.ศ.
    $hv_date_thai = convertDateToThai($row['HV_date']);
    $next_hv_date_thai = convertDateToThai($row['next_Hv_date']);
    
    echo '<tr style="text-align: center;">
            <td>' . htmlspecialchars($hv_date_thai) . '</td>
            <td>' . htmlspecialchars($next_hv_date_thai) . '</td>
            <td>' . htmlspecialchars($row['V_name']) . '</td>
            <td>' . htmlspecialchars($row['Pet_name']) . '</td>
            <td>' . htmlspecialchars($row['OFF_name']) . '</td>
          </tr>';
}

echo '  </tbody>
      </table>';

$stmt->close();
$conn->close();

function convertDateToThai($date)
{
    $months = array(
        '01' => 'ม.ค.',
        '02' => 'ก.พ.',
        '03' => 'มี.ค.',
        '04' => 'เม.ย.',
        '05' => 'พ.ค.',
        '06' => 'มิ.ย.',
        '07' => 'ก.ค.',
        '08' => 'ส.ค.',
        '09' => 'ก.ย.',
        '10' => 'ต.ค.',
        '11' => 'พ.ย.',
        '12' => 'ธ.ค.'
    );

    $dateTime = new DateTime($date);
    $day = $dateTime->format('j');
    $month = $dateTime->format('m');
    $year = $dateTime->format('Y') + 543; // Adjust for Thai year
    return $day . ' ' . $months[$month] . ' ' . $year;
}
?>

