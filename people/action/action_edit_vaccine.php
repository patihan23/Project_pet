<?php
if (isset($_POST['btnEditVaccine'])) {
    // echo "<pre>";
    // print_r($_POST);
    // echo "</pre>";
    // exit;
    $ID_VC = mysqli_real_escape_string($conn, $_POST['ID_VC']);
    $V_name = mysqli_real_escape_string($conn, $_POST['V_name']);
    $V_info = mysqli_real_escape_string($conn, $_POST['V_info']);
    $V_storage = mysqli_real_escape_string($conn, $_POST['V_storage']);
    $Expiration_date = mysqli_real_escape_string($conn, $_POST['Expiration_date']);
    $Dosage = mysqli_real_escape_string($conn, $_POST['Dosage']);

    $sql_update_vaccine = "UPDATE vaccine SET 
    V_name = '$V_name',
    V_info = '$V_info',
    V_storage = '$V_storage',
    Expiration_date = '$Expiration_date',
    Dosage = '$Dosage'
    WHERE ID_VC = '$ID_VC' ";

    $query_update_vaccine = mysqli_query($conn, $sql_update_vaccine);
    if ($query_update_vaccine) {
        echo  '
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