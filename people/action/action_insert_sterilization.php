<?php
if (isset($_POST['btnAddSterilization'])) {
    // echo "<pre>";
    // print_r($_POST);
    // echo "</pre>";
    // exit;
    $S_date = mysqli_real_escape_string($conn, $_POST['S_date']);
    $ID_P = mysqli_real_escape_string($conn, $_POST['ID_P']);
    $ID_OFF = mysqli_real_escape_string($conn, $_POST['ID_OFF']);

    $sql_sterilization = "INSERT INTO sterilization
    (S_date, 
    ID_P,
    ID_OFF
    ) 
    VALUES
    ('$S_date', 
    '$ID_P',
    '$ID_OFF')";

    $query_sterilzation = mysqli_query($conn, $sql_sterilization);
    if ($query_sterilzation) {
        echo '
				<script>
					swal({
						title: "บันทึกข้อมูลสำเร็จ", 
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
						title: "Error ข้อมูลซ้ำกัน!!", 
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