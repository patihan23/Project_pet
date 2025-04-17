<?php
// Check if the delete button was clicked
if (isset($_POST['btnDeleteHistory_v'])) {
    // Sanitize input
    $ID_HV = mysqli_real_escape_string($conn, $_POST["ID_HV"]);

    // Check if the record exists
    $sqlcheck = "SELECT ID_HV FROM history_v WHERE ID_HV = '$ID_HV'";
    $querycheck = mysqli_query($conn, $sqlcheck);

    if ($querycheck) {
        if (mysqli_num_rows($querycheck) > 0) {
            // Record exists, proceed with deletion
            $sqld_delete = "DELETE FROM history_v WHERE ID_HV = '$ID_HV'";
            $queryd_delete = mysqli_query($conn, $sqld_delete);

            if ($queryd_delete) {
                // Success
                echo'
                            <script>
                                $(document).ready(function() {
                                    Swal.fire({
                                        title: "ลบข้อมูลสำเร็จ",
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
                // Failure
                echo '
  <script>
      $(document).ready(function() {
          Swal.fire({
              title: "Error ลบข้อมูลไม่สำเร็จ",
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
        } else {
            // Record does not exist
            echo '
  <script>
      $(document).ready(function() {
          Swal.fire({
              title: "ไม่พบข้อมูลที่ต้องการลบ",
              icon: "warning",
              showConfirmButton: false,
              timer: 1500
          }).then(() => {
              window.location.href = "' . $_SERVER['REQUEST_URI'] . '";
          });
      });
  </script>
';
        }
    } else {
        // Query failed
        echo '
  <script>
      $(document).ready(function() {
          Swal.fire({
              title: "เกิดข้อผิดพลาดในการตรวจสอบข้อมูล",
              icon: "error",
              showConfirmButton: false,
              timer: 1500
          }).then(() => {
              window.location.href = "' . $_SERVER['REQUEST_URI'] . '";
          });
      });
  </script>
';
        // Log or display detailed error information
        error_log("SQL Error: " . mysqli_error($conn));
    }
}
?>
