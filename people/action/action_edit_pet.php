<?php
if (isset($_POST['btnEditPet'])) {
  // echo "<pre>";
  // print_r($_POST);
  // echo "</pre>";
  // exit;
  $ID_P = mysqli_real_escape_string($conn, $_POST['ID_P']);
  $Type_pet = mysqli_real_escape_string($conn, $_POST['Type_pet']);
  $Pet_name = mysqli_real_escape_string($conn, $_POST['Pet_name']);
  $Gender = mysqli_real_escape_string($conn, $_POST['Gender']);
  $Breed = mysqli_real_escape_string($conn, $_POST['Breed']);
  $color = mysqli_real_escape_string($conn, $_POST['color']);
  $p_old = mysqli_real_escape_string($conn, $_POST['p_old']);
  $status = mysqli_real_escape_string($conn, $_POST['status']);
  $weight = mysqli_real_escape_string($conn, $_POST['weight']);
  $ID_PO = mysqli_real_escape_string($conn, $_POST['ID_PO']);

  $sql_update_pet = "UPDATE pet SET 
    Type_pet = '$Type_pet',
    Pet_name = '$Pet_name',
    Gender = '$Gender',
    Breed = '$Breed',
    color = '$color',
    status = '$status',
    p_old = '$p_old',
    weight = '$weight',   
    ID_PO = '$ID_PO'
    WHERE ID_P = '$ID_P' ";

  $query_update_pet = mysqli_query($conn, $sql_update_pet);
  if ($query_update_pet) {
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
