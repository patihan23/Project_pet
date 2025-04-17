<?php		
if (isset($_POST['btnDeletePet'])) {
	// echo "<pre>";
	// print_r($_POST);
	// echo "<pre>";
	// exit();
	$ID_P = mysqli_real_escape_string($conn, $_POST["ID_P"]);
	$sqlcheck = "SELECT ID_P AS ID_P FROM pet WHERE ID_P = '$ID_P'";
	$querycheck = mysqli_query($conn, $sqlcheck);
	$rowcheck = mysqli_fetch_array($querycheck);
	$pet_ID2 = $rowcheck['ID_P'];
	// echo 'pet_ID2 => '.$ID_P;
	if ($pet_ID2 == $ID_P) {
		$sqld_delete = "DELETE FROM pet WHERE ID_P = '$ID_P'";
		$queryd_delete = mysqli_query($conn, $sqld_delete);
		if ($queryd_delete) {
			echo '
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
			echo '
  <script>
      $(document).ready(function() {
          Swal.fire({
              title: "เกิดข้อผิดพลาด",
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
