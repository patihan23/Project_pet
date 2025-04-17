<?php
// ตรวจสอบว่าปุ่มลบถูกคลิกหรือไม่
if (isset($_POST['btnDeletePet_own'])) {
    // ป้องกันการโจมตี SQL Injection
    $ID_PO = mysqli_real_escape_string($conn, $_POST["ID_PO"]);

    // ตรวจสอบว่ามีข้อมูลในตาราง pet_own หรือไม่
    $sqlcheck = "SELECT ID_PO FROM pet_own WHERE ID_PO = '$ID_PO'";
    $querycheck = mysqli_query($conn, $sqlcheck);

    if (mysqli_num_rows($querycheck) > 0) {
        // ตรวจสอบว่ามีการอ้างอิงข้อมูลในตารางอื่นหรือไม่
        $sqlDependencyCheck = "SELECT COUNT(*) AS dependencyCount 
                               FROM pet WHERE ID_PO = '$ID_PO'"; // เปลี่ยน pets เป็นชื่อของตารางที่อ้างอิงถึง pet_own
        $queryDependencyCheck = mysqli_query($conn, $sqlDependencyCheck);

        if ($queryDependencyCheck) {
            $dependencyRow = mysqli_fetch_assoc($queryDependencyCheck);

            if ($dependencyRow['dependencyCount'] > 0) {
                // ข้อมูลมีการอ้างอิงอยู่ ไม่สามารถลบได้
                echo '
                    <script>
                        $(document).ready(function() {
                            Swal.fire({
                                title: "ไม่สามารถลบข้อมูล",
                                text: "มีข้อมูลที่เกี่ยวข้องอยู่ในระบบ กรุณาตรวจสอบและลบข้อมูลที่เกี่ยวข้องก่อน",
                                icon: "warning",
                                showConfirmButton: true,
                                timer: 15000
                            }).then(() => {
                                window.location.href = "' . $_SERVER['REQUEST_URI'] . '";
                            });
                        });
                    </script>
                ';
            } else {
                // ไม่มีการอ้างอิง สามารถลบข้อมูลได้
                $sqld_delete = "DELETE FROM pet_own WHERE ID_PO = '$ID_PO'";
                $queryd_delete = mysqli_query($conn, $sqld_delete);

                if ($queryd_delete) {
                    // ลบสำเร็จ
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
                    // ลบไม่สำเร็จ
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
        } else {
            // ข้อผิดพลาดในการตรวจสอบข้อมูล
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
        }
    } else {
        // ข้อมูลไม่พบในตาราง pet_own
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
}
?>
