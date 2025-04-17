<?php
if (isset($_POST['btnAddVaccine'])) {
    // echo "<pre>";
    // print_r($_POST);
    // echo "</pre>";
    // exit;
    $V_name = mysqli_real_escape_string($conn, $_POST['V_name']);
    $V_info = mysqli_real_escape_string($conn, $_POST['V_info']);
    $V_storage = mysqli_real_escape_string($conn, $_POST['V_storage']);
    $Expiration_date = mysqli_real_escape_string($conn, $_POST['Expiration_date']);
    $Dosage = mysqli_real_escape_string($conn, $_POST['Dosage']);

    $sql_vaccine = "INSERT INTO Vaccine
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