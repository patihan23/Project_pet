<?php
// Check if the delete button was clicked
if (isset($_POST['btnDeleteSterilization'])) {
    // Sanitize input
    $ID_S = mysqli_real_escape_string($conn, $_POST["ID_S"]);

    // Check if the record exists
    $sqlcheck = "SELECT ID_S FROM sterilization WHERE ID_S = '$ID_S'";
    $querycheck = mysqli_query($conn, $sqlcheck);

    if (mysqli_num_rows($querycheck) > 0) {
        // Check if the record has dependencies
        $sqlDependencyCheck = "SELECT COUNT(*) AS dependencyCount 
                               FROM other_table WHERE ID_S = '$ID_S'"; // Replace other_table with the actual table name
        $queryDependencyCheck = mysqli_query($conn, $sqlDependencyCheck);
        $dependencyRow = mysqli_fetch_assoc($queryDependencyCheck);

        if ($dependencyRow['dependencyCount'] > 0) {
            // Record has dependencies, notify the user
            echo '
                <script>
                    swal({
                        title: "ไม่สามารถลบข้อมูล", 
                        text: "มีข้อมูลที่เกี่ยวข้องอยู่ในระบบ กรุณาตรวจสอบและลบข้อมูลที่เกี่ยวข้องก่อน", 
                        icon: "warning",
                        button: "ตกลง",
                    }).then(() => {
                        location.href = "' . $_SERVER['REQUEST_URI'] . '";
                    });
                </script>
            ';
        } else {
            // No dependencies, proceed with deletion
            $sqld_delete = "DELETE FROM sterilization WHERE ID_S = '$ID_S'";
            $queryd_delete = mysqli_query($conn, $sqld_delete);

            if ($queryd_delete) {
                // Success
                echo '
                    <script>
                        swal({
                            title: "ลบข้อมูลสำเร็จ", 
                            icon: "success",
                            button: "ตกลง",
                        }).then(() => {
                            location.href = "' . $_SERVER['REQUEST_URI'] . '";
                        });
                    </script>
                ';
            } else {
                // Failure
                echo '
                    <script>
                        swal({
                            title: "Error ลบข้อมูลไม่สำเร็จ", 
                            icon: "error",
                            button: "ตกลง",
                        }).then(() => {
                            location.href = "' . $_SERVER['REQUEST_URI'] . '";
                        });
                    </script>
                ';
            }
        }
    } else {
        // Record does not exist
        echo '
            <script>
                swal({
                    title: "ไม่พบข้อมูลที่ต้องการลบ", 
                    icon: "warning",
                    button: "ตกลง",
                }).then(() => {
                    location.href = "' . $_SERVER['REQUEST_URI'] . '";
                });
            </script>
        ';
    }
}
?>
