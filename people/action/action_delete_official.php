<?php
if(isset($_POST['btnDeleteofficial'])) {
    // ตรวจสอบว่ามีการส่งค่า ID_OFF มาหรือไม่
    if (isset($_POST["ID_OFF"]) && !empty($_POST["ID_OFF"])) {
        $ID_OFF = mysqli_real_escape_string($conn, $_POST["ID_OFF"]);

        // ตรวจสอบว่าข้อมูลที่ต้องการลบมีอยู่จริงในฐานข้อมูลหรือไม่
        $sqlcheck = "SELECT ID_OFF FROM official WHERE ID_OFF = ?";
        $stmt_check = mysqli_prepare($conn, $sqlcheck);
        mysqli_stmt_bind_param($stmt_check, 'i', $ID_OFF);
        mysqli_stmt_execute($stmt_check);
        mysqli_stmt_store_result($stmt_check);

        if (mysqli_stmt_num_rows($stmt_check) > 0) {
            // ลบข้อมูล
            $sqld_delete = "DELETE FROM official WHERE ID_OFF = ?";
            $stmt_delete = mysqli_prepare($conn, $sqld_delete);
            mysqli_stmt_bind_param($stmt_delete, 'i', $ID_OFF);
            $queryd_delete = mysqli_stmt_execute($stmt_delete);

            if ($queryd_delete) {
                echo '
                    <script>
                        window.onload = function() {
                            Swal.fire({
                                title: "ลบข้อมูลสำเร็จ", 
                                icon: "success",
                                button: "ตกลง",
                            }).then(() => {
                                location.href = "'.$_SERVER['REQUEST_URI'].'";
                            });
                        };
                    </script>
                ';
            } else {
                echo '
                    <script>
                        window.onload = function() {
                            Swal.fire({
                                title: "Error ลบข้อมูลไม่สำเร็จ", 
                                icon: "error",
                                button: "ตกลง",
                            }).then(() => {
                                location.href = "'.$_SERVER['REQUEST_URI'].'";
                            });
                        };
                    </script>
                ';	
            }

            // ปิด statement $stmt_delete หากมันถูกสร้างขึ้นมา
            if (isset($stmt_delete)) {
                mysqli_stmt_close($stmt_delete);
            }
        } else {
            echo '
                <script>
                    window.onload = function() {
                        Swal.fire({
                            title: "ไม่พบข้อมูลที่ต้องการลบ", 
                            icon: "warning",
                            button: "ตกลง",
                        }).then(() => {
                            location.href = "'.$_SERVER['REQUEST_URI'].'";
                        });
                    };
                </script>
            ';
        }

        // ปิด statement $stmt_check หลังจากใช้งานเสร็จสิ้น
        mysqli_stmt_close($stmt_check);
    } else {
        echo '
            <script>
                window.onload = function() {
                    Swal.fire({
                        title: "ไม่มีข้อมูลที่จะลบ", 
                        icon: "warning",
                        button: "ตกลง",
                    }).then(() => {
                        location.href = "'.$_SERVER['REQUEST_URI'].'";
                    });
                };
            </script>
        ';
    }
}
?>
