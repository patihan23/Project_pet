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

    // Query สำหรับข้อมูลที่ได้รับวัคซีน
    $sql_received = "SELECT 
                        history_v.HV_date,
                        history_v.next_Hv_date,
                        vaccine.V_name,
                        pet.Pet_name,
                        pet_own.Po_name,
                        official.OFF_name
                    FROM history_v
                    INNER JOIN pet ON history_v.ID_P = pet.ID_P
                    INNER JOIN pet_own ON pet_own.ID_PO = pet.ID_PO
                    INNER JOIN official ON history_v.ID_OFF = official.ID_OFF
                    INNER JOIN vaccine ON history_v.ID_VC = vaccine.ID_VC
                    WHERE DATE(history_v.HV_date) = ?
                    ORDER BY history_v.HV_date ASC";

    // Query สำหรับข้อมูลที่ไม่ได้รับวัคซีนในปีที่กำหนด
    $sql_not_received = "SELECT 
                            pet.Pet_name,
                            pet_own.Po_name,
                            pet.year_added
                        FROM pet
                        INNER JOIN pet_own ON pet_own.ID_PO = pet.ID_PO
                        WHERE NOT EXISTS (
                            SELECT 1 
                            FROM history_v 
                            WHERE history_v.ID_P = pet.ID_P
                            AND YEAR(history_v.HV_date) = ?
                        )
                        ORDER BY pet.Pet_name ASC";

    // Prepare and execute the received query
    $stmt_received = $conn->prepare($sql_received);
    $stmt_received->bind_param('s', $day);  // Bind parameter for the received query
    $stmt_received->execute();
    $result_received = $stmt_received->get_result();

    // Prepare and execute the not received query
    $stmt_not_received = $conn->prepare($sql_not_received);
    $stmt_not_received->bind_param('i', $year);  // Bind the year for the not received query
    $stmt_not_received->execute();
    $result_not_received = $stmt_not_received->get_result();

    // Generate HTML for received table
    echo '<table id="receivedTable" class="table table-striped table-bordered">
            <thead>
                <tr style="text-align: center;">
                    <th>ลำดับ</th>
                    <th>วันที่ฉีด</th>
                    <th>ฉีดครั้งถัดไป</th>
                    <th>ชื่อวัคซีน</th>
                    <th>ชื่อเจ้าของสัตว์เลี้ยง</th>
                    <th>ชื่อสัตว์เลี้ยง</th>
                    <th>สัตวแพทย์รับผิดชอบ</th>
                </tr>
            </thead>
            <tbody>';
    
    // Initialize a counter for row numbers
    $counter = 1;

    while ($row = $result_received->fetch_assoc()) {
        echo '<tr style="text-align: center;">
                <td>' . htmlspecialchars($counter++) . '</td> <!-- Add counter here -->
                <td>' . htmlspecialchars(convertDateToThai($row['HV_date'])) . '</td>
                <td>' . htmlspecialchars(convertDateToThai($row['next_Hv_date'])) . '</td>
                <td>' . htmlspecialchars($row['V_name']) . '</td>
                <td>' . htmlspecialchars($row['Po_name']) . '</td>
                <td>' . htmlspecialchars($row['Pet_name']) . '</td>
                <td>' . htmlspecialchars($row['OFF_name']) . '</td>
            </tr>';
    }
    echo '  </tbody>
          </table>';

    // Generate HTML for not received table
    echo '<!-- Table Separator -->
          <table id="notReceivedTable" class="table table-striped table-bordered">
            <thead>
                <tr style="text-align: center;">
                    <th>ชื่อสัตว์</th>
                    <th>ชื่อเจ้าของสัตว์เลี้ยง</th>
                </tr>
            </thead>
            <tbody>';
    while ($row = $result_not_received->fetch_assoc()) {
        echo '<tr style="text-align: center;">
                <td>' . htmlspecialchars($row['Pet_name']) . '</td>
                <td>' . htmlspecialchars($row['Po_name']) . '</td>
            </tr>';
    }
    echo '  </tbody>
          </table>';
}
?>
