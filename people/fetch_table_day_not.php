<?php
session_start();
include('../config.php');

if (!isset($_SESSION['username'])) {
    header("Location: ../login_official.php");
    exit;
}

// ฟังก์ชันแปลงวันที่เป็นปี พ.ศ.
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

$day = $_POST['day'] ?? '';

if ($day) {
    // Extract year from the date input
    $year = (new DateTime($day))->format('Y');

    // Query สำหรับข้อมูลที่ไม่ได้รับวัคซีนในปีที่กำหนด
    $sql_not_received = "SELECT 
                            pet.Pet_name,
                            pet_own.Po_name,
                            pet.year_added,
                            COALESCE(MAX(history_v.HV_date), 'ยังไม่ได้รับการฉีดวัคซีน') AS last_vaccine_date
                        FROM pet
                        INNER JOIN pet_own ON pet_own.ID_PO = pet.ID_PO
                        LEFT JOIN history_v ON history_v.ID_P = pet.ID_P
                            AND YEAR(history_v.HV_date) < ?
                        WHERE NOT EXISTS (
                            SELECT 1
                            FROM history_v
                            WHERE history_v.ID_P = pet.ID_P
                            AND YEAR(history_v.HV_date) = ?
                        )
                        GROUP BY pet.ID_P
                        ORDER BY pet.Pet_name ASC";

    // Prepare and execute the not received query
    $stmt_not_received = $conn->prepare($sql_not_received);
    $stmt_not_received->bind_param('ii', $year, $year);  // Bind both parameters for the not received query
    $stmt_not_received->execute();
    $result_not_received = $stmt_not_received->get_result();

    // Generate HTML for not received table
    echo '<table id="notReceivedTable" class="table table-striped table-bordered">
            <thead>
                <tr style="text-align: center;">
                    <th>ลำดับ</th>
                    <th>ชื่อสัตว์</th>
                    <th>ชื่อเจ้าของสัตว์เลี้ยง</th>
                    <th>วันที่ได้รับวัคซีนครั้งล่าสุด</th>
                </tr>
            </thead>
            <tbody>';
    
    // Initialize a counter for row numbers
    $counter = 1;

    while ($row = $result_not_received->fetch_assoc()) {
        echo '<tr style="text-align: center;">
                <td>' . htmlspecialchars($counter++) . '</td>
                <td>' . htmlspecialchars($row['Pet_name']) . '</td>
                <td>' . htmlspecialchars($row['Po_name']) . '</td>
                <td>' . htmlspecialchars($row['last_vaccine_date'] == 'ยังไม่ได้รับการฉีดวัคซีน' ? 'ยังไม่ได้รับการฉีดวัคซีน' : convertDateToThai($row['last_vaccine_date'])) . '</td>
            </tr>';
    }
    echo '  </tbody>
          </table>';
}
?>