<?php
if (isset($_POST['btnAddHistory_v'])) {
    $HV_date = mysqli_real_escape_string($conn, $_POST['HV_date']);
    $next_Hv_date = mysqli_real_escape_string($conn, $_POST['next_Hv_date']);
    $ID_VC = mysqli_real_escape_string($conn, $_POST['ID_VC']);
    $ID_P = mysqli_real_escape_string($conn, $_POST['ID_P']);
    $ID_OFF = mysqli_real_escape_string($conn, $_POST['ID_OFF']);

    // Convert to date format
    $HV_date = date('Y-m-d', strtotime($HV_date));
    $next_Hv_date = date('Y-m-d', strtotime($next_Hv_date));
    
    // Extract years from dates
    $year = (new DateTime($HV_date))->format('Y');
    $next_year = (new DateTime($next_Hv_date))->format('Y');

    // Check if the next vaccination date is in the same year or earlier than HV_date
    if ($next_year <= $year || $next_Hv_date <= $HV_date) {
        echo '
        <script>
            $(document).ready(function() {
                Swal.fire({
                    title: "เกิดข้อผิดพลาด",
                    text: "วันฉีดวัคซีนครั้งถัดไปต้องอยู่หลังวันฉีดวัคซีนปัจจุบัน และไม่สามารถอยู่ในปีเดียวกัน",
                    icon: "error",
                    showConfirmButton: false,
                    timer: 2000
                }).then(() => {
                    window.location.href = "' . $_SERVER['REQUEST_URI'] . '";
                });
            });
        </script>
        ';
        exit;
    }

    // Check if the pet has already received vaccine in the same year
    $sql_check = "SELECT 1 FROM history_v WHERE ID_P = '$ID_P' AND YEAR(HV_date) = '$year'";
    $query_check = mysqli_query($conn, $sql_check);

    // Check if the next vaccination date is already set in the same year or next year
    $sql_check_next = "SELECT 1 FROM history_v 
                       WHERE ID_P = '$ID_P' 
                       AND (
                           (YEAR(next_Hv_date) = '$year' AND DATE(next_Hv_date) = '$next_Hv_date')
                           OR (YEAR(next_Hv_date) = '$next_year' AND DATE(next_Hv_date) = '$next_Hv_date')
                       )";
    $query_check_next = mysqli_query($conn, $sql_check_next);

    if (mysqli_num_rows($query_check) > 0) {
        echo '
        <script>
            $(document).ready(function() {
                Swal.fire({
                    title: "เกิดข้อผิดพลาด",
                    text: "สัตว์เลี้ยงตัวนี้ได้รับการฉีดวัคซีนในปี ' . ($year + 543) . ' แล้ว",
                    icon: "error",
                    showConfirmButton: false,
                    timer: 2000
                }).then(() => {
                    window.location.href = "' . $_SERVER['REQUEST_URI'] . '";
                });
            });
        </script>
        ';
    } elseif (mysqli_num_rows($query_check_next) > 0) {
        echo '
        <script>
            $(document).ready(function() {
                Swal.fire({
                    title: "เกิดข้อผิดพลาด",
                    text: "วันถัดไปนี้มีการกำหนดแล้วในปี ' . ($next_year + 543) . ' ",
                    icon: "error",
                    showConfirmButton: false,
                    timer: 2000
                }).then(() => {
                    window.location.href = "' . $_SERVER['REQUEST_URI'] . '";
                });
            });
        </script>
        ';
    } else {
        // Insert new history
        $sql_history_v = "INSERT INTO history_v
        (HV_date,
        next_Hv_date, 
        ID_VC,
        ID_P,
        ID_OFF
        ) 
        VALUES
        ('$HV_date',
        '$next_Hv_date', 
        '$ID_VC',
        '$ID_P',
        '$ID_OFF')";

        $query_history_v = mysqli_query($conn, $sql_history_v);
        if ($query_history_v) {
            echo  '
            <script>
                $(document).ready(function() {
                    Swal.fire({
                        title: "บันทึกข้อมูลสำเร็จ",
                        icon: "success",
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        window.location.href = "' . $_SERVER['REQUEST_URI'] . '";
                    });
                });
            </script>
            ';
        } else {
            echo '
            <script>
                $(document).ready(function() {
                    Swal.fire({
                        title: "เกิดข้อผิดพลาด",
                        text: "ไม่สามารถบันทึกข้อมูลได้",
                        icon: "error",
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        window.location.href = "' . $_SERVER['REQUEST_URI'] . '";
                    });
                });
            </script>
            ';
        }
    }
}
?>
