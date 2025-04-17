<?php
if (isset($_POST['btnEditPet_own'])) {
    // echo "<pre>";
    // print_r($_POST);
    // echo "</pre>";
    // exit;
    $ID_PO = mysqli_real_escape_string($conn, $_POST['ID_PO']);
    $date_add = mysqli_real_escape_string($conn, $_POST['date_add']);
    $Po_name = mysqli_real_escape_string($conn, $_POST['Po_name']);
    $Hno = mysqli_real_escape_string($conn, $_POST['Hno']);
    $Moo = mysqli_real_escape_string($conn, $_POST['Moo']);
    $tb = mysqli_real_escape_string($conn, $_POST['tb']);
    $ID = mysqli_real_escape_string($conn, $_POST['ID']);

    $sql_update_pet_own = "UPDATE pet_own SET 
    date_add = '$date_add',
    Po_name = '$Po_name',
    Hno = '$Hno',
    Moo = '$Moo',
    tb = '$tb',
    ID = '$ID'
    WHERE ID_PO = '$ID_PO' ";

    $query_update_pet_own = mysqli_query($conn, $sql_update_pet_own);
    if ($query_update_pet_own) {
        echo'
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