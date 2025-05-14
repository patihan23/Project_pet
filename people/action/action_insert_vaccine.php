<?php
if (isset($_POST['btnAddVaccine'])) {
    // For debugging if needed
    // echo "<pre>";
    // print_r($_POST);
    // echo "</pre>";
    // exit;
    
    $V_name = mysqli_real_escape_string($conn, $_POST['V_name']);
    $V_info = mysqli_real_escape_string($conn, $_POST['V_info']);
    $V_storage = mysqli_real_escape_string($conn, $_POST['V_storage']);
    $Expiration_date = mysqli_real_escape_string($conn, $_POST['Expiration_date']);
    $Dosage = mysqli_real_escape_string($conn, $_POST['Dosage']);

    // Make sure we have all required fields
    if (empty($V_name) || empty($V_info) || empty($V_storage) || empty($Expiration_date) || empty($Dosage)) {
        echo '
        <script>
            $(document).ready(function() {
                Swal.fire({
                    title: "เกิดข้อผิดพลาด",
                    text: "กรุณากรอกข้อมูลให้ครบถ้วน",
                    icon: "error",
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location.href = "' . $_SERVER['REQUEST_URI'] . '";
                });
            });
        </script>
        ';
        return;
    }

    $sql_vaccine = "INSERT INTO vaccine
    (V_name,
    V_info, 
    V_storage,
    Expiration_date,
    Dosage
    ) 
    VALUES
    ('$V_name',
    '$V_info', 
    '$V_storage',
    '$Expiration_date',
    '$Dosage')";

    $query_vaccine = mysqli_query($conn, $sql_vaccine);
    if ($query_vaccine) {
        echo '
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
                    text: "ไม่สามารถบันทึกข้อมูลได้: ' . mysqli_error($conn) . '",
                    icon: "error",
                    showConfirmButton: false,
                    timer: 2500
                }).then(() => {
                    window.location.href = "' . $_SERVER['REQUEST_URI'] . '";
                });
            });
        </script>
        ';
    }
}
?>