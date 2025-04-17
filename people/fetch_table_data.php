<?php
include('../config.php');

if (isset($_POST['year'])) {
    $year = mysqli_real_escape_string($conn, $_POST['year']);

    $query = "
        SELECT 
            Pet_name AS pet_name,
            CASE 
                WHEN Type_pet = 1 THEN 'สุนัข'
                WHEN Type_pet = 2 THEN 'แมว'
                ELSE 'ไม่ทราบ'
            END AS type_pet,
            CASE 
                WHEN Gender = 1 THEN 'เพศผู้'
                WHEN Gender = 2 THEN 'เพศเมีย'
                ELSE 'ไม่ทราบ'
            END AS gender,
            Breed AS breed,
            p_old AS birth_date, -- แสดงวันที่เกิดตามที่เก็บในตาราง
            color AS color,
            weight AS weight,
            (YEAR(year_added) ) AS year_added
        FROM pet 
        WHERE YEAR(year_added) = '$year'
        ORDER BY Pet_name
    ";

    $result = mysqli_query($conn, $query);

    // ฟังก์ชันแปลงวันที่เป็นปี พ.ศ.
    function convertDateToThai($date) {
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

    if (mysqli_num_rows($result) > 0) {
        echo '<table id="petTable" class="table table-bordered">';
        echo '<thead><tr style="text-align: center;">
            <th>ชื่อสัตว์เลี้ยง</th>
            <th>ประเภทสัตว์เลี้ยง</th>
            <th>เพศ</th>
            <th>สายพันธุ์</th>
            <th>วันเกิด</th>
            <th>สี</th>
            <th>น้ำหนัก</th>
        </tr></thead>';
        echo '<tbody>';
        while ($row = mysqli_fetch_assoc($result)) {
            $birth_date_thai = convertDateToThai($row['birth_date']);
            
            echo '<tr style="text-align: center;">';
            echo '<td>' . htmlspecialchars($row['pet_name'], ENT_QUOTES, 'UTF-8') . '</td>';
            echo '<td>' . htmlspecialchars($row['type_pet'], ENT_QUOTES, 'UTF-8') . '</td>';
            echo '<td>' . htmlspecialchars($row['gender'], ENT_QUOTES, 'UTF-8') . '</td>';
            echo '<td>' . htmlspecialchars($row['breed'], ENT_QUOTES, 'UTF-8') . '</td>';
            echo '<td>' . htmlspecialchars($birth_date_thai, ENT_QUOTES, 'UTF-8') . '</td>'; // แสดงวันเกิดที่แปลงแล้ว
            echo '<td>' . htmlspecialchars($row['color'], ENT_QUOTES, 'UTF-8') . '</td>';
            echo '<td>' . htmlspecialchars($row['weight'], ENT_QUOTES, 'UTF-8') . ' kg</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    } else {
        echo '<p>ไม่พบข้อมูลสำหรับปีที่เลือก</p>';
    }
}

mysqli_close($conn);
?>
