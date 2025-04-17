<?php
if (isset($_POST['btnEditSterilization'])) {
    // echo "<pre>";
    // print_r($_POST);
    // echo "</pre>";
    // exit;
    $ID_S = mysqli_real_escape_string($conn, $_POST['ID_S']);
    $S_date = mysqli_real_escape_string($conn, $_POST['S_date']);
	$ID_P = mysqli_real_escape_string($conn, $_POST['ID_P']);
	$ID_OFF = mysqli_real_escape_string($conn, $_POST['ID_OFF']);

    $sql_update_sterilization = "UPDATE sterilization SET 
    S_date = '$S_date',
	ID_P = '$ID_P',
	ID_OFF = '$ID_OFF'
    WHERE ID_S = '$ID_S' ";

    $query_update_sterilization = mysqli_query($conn, $sql_update_sterilization);
    if ($query_update_sterilization) {
        echo '
				<script>
					swal({
						title: "แก้ไขข้อมูลสำเร็จ", 
						icon: "success",
						button: "ตกลง",
						}).then( () => {
							location.href = "' . $_SERVER['REQUEST_URI'] . '"
										
						});	
				</script>
			';
    } else {
        echo '
				<script>
					swal({
						title: "แก้ไขข้อมูลไม่สำเร็จ", 
						icon: "error",
						button: "ตกลง",
						}).then( () => {
							location.href = "' . $_SERVER['REQUEST_URI'] . '"
										
						});	
				</script>
			';
    }


}


?>