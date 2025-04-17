<?php
if (isset($_POST['btnEditHistory_v'])) {
    $ID_HV = mysqli_real_escape_string($conn, $_POST['ID_HV']);
    $HV_date = mysqli_real_escape_string($conn, $_POST['HV_date']);
    $next_Hv_date = mysqli_real_escape_string($conn, $_POST['next_Hv_date']);
    $ID_VC = mysqli_real_escape_string($conn, $_POST['ID_VC']);
    $ID_P = mysqli_real_escape_string($conn, $_POST['ID_P']);
    $ID_OFF = mysqli_real_escape_string($conn, $_POST['ID_OFF']);

    // Get the current HV_date for comparison
    $sql_get_current_date = "SELECT HV_date FROM history_v WHERE ID_HV = '$ID_HV'";
    $result_current_date = mysqli_query($conn, $sql_get_current_date);
    $row_current_date = mysqli_fetch_assoc($result_current_date);
    $current_HV_date = $row_current_date['HV_date'];

    // Only check for duplicate if the HV_date has been changed
    if ($HV_date != $current_HV_date) {
        $year = date('Y', strtotime($HV_date));

        // Check for duplicate vaccination records in the same year for the same pet and vaccine
        $sql_check_duplicate = "SELECT COUNT(*) as count 
                                FROM history_v 
                                WHERE ID_P = '$ID_P' 
                                AND ID_VC = '$ID_VC' 
                                AND YEAR(HV_date) = '$year' 
                                AND ID_HV != '$ID_HV'";
        
        $result_check = mysqli_query($conn, $sql_check_duplicate);
        $row_check = mysqli_fetch_assoc($result_check);

        // Check if next_Hv_date is duplicated in the same year
        $sql_check_next_date = "SELECT COUNT(*) as count 
                                FROM history_v 
                                WHERE ID_P = '$ID_P' 
                                AND YEAR(next_Hv_date) = '$year' 
                                AND ID_HV != '$ID_HV'";

        $result_check_next = mysqli_query($conn, $sql_check_next_date);
        $row_check_next = mysqli_fetch_assoc($result_check_next);

        if ($row_check['count'] > 0) {
            // There is a duplicate vaccination record in the same year
            echo '
                <script>
                    $(document).ready(function() {
                        Swal.fire({
                            title: "เกิดข้อผิดพลาด",
                            text: "มีการฉีดวัคซีนนี้แล้วในปีนี้",
                            icon: "error",
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.location.href = "' . $_SERVER['REQUEST_URI'] . '";
                        });
                    });
                </script>
            ';
            exit;
        } elseif ($row_check_next['count'] > 0) {
            // There is a duplicate next vaccination date in the same year
            echo '
                <script>
                    $(document).ready(function() {
                        Swal.fire({
                            title: "เกิดข้อผิดพลาด",
                            text: "วันถัดไปนี้มีการกำหนดแล้วในปีนี้",
                            icon: "error",
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.location.href = "' . $_SERVER['REQUEST_URI'] . '";
                        });
                    });
                </script>
            ';
            exit;
        }
    }

    // Proceed with the update
    $sql_update_history_v = "UPDATE history_v SET 
                            HV_date = '$HV_date',
                            next_Hv_date = '$next_Hv_date',
                            ID_VC = '$ID_VC',
                            ID_P = '$ID_P',
                            ID_OFF = '$ID_OFF'
                            WHERE ID_HV = '$ID_HV'";

    $query_update_history_v = mysqli_query($conn, $sql_update_history_v);
    if ($query_update_history_v) {
        echo '
            <script>
                $(document).ready(function() {
                    Swal.fire({
                        title: "แก้ไขข้อมูลสำเร็จ",
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
?>
