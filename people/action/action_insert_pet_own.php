<?php
if (isset($_POST['btnAddPet_own'])) {
  // echo "<pre>";
  // print_r($_POST);
  // echo "</pre>";
  // exit;
  $Po_name = mysqli_real_escape_string($conn, $_POST['Po_name']);
  $Hno = mysqli_real_escape_string($conn, $_POST['Hno']);
  $Moo = mysqli_real_escape_string($conn, $_POST['Moo']);
  $tb = mysqli_real_escape_string($conn, $_POST['tb']);
  $ID = mysqli_real_escape_string($conn, $_POST['ID']);

  $sql_pet_own = "INSERT INTO pet_own
    (date_add,
    Po_name, 
    Hno,
    Moo,
    tb,
    ID
    ) 
    VALUES
    (NOW(),
    '$Po_name', 
    '$Hno',
    '$Moo',
    '$tb',
    '$ID')";

  $query_pet_own = mysqli_query($conn, $sql_pet_own);
  if ($query_pet_own) {
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
