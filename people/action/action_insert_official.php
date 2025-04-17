<?php
if (isset($_POST['btnAddofficial'])) {
    include('config.php'); // เชื่อมต่อฐานข้อมูล

    // ตรวจสอบและเก็บข้อมูลที่รับมาจากฟอร์ม
    $User = mysqli_real_escape_string($conn, $_POST['User']);
    $Pass = mysqli_real_escape_string($conn, $_POST['Pass']);
    $Off_name = mysqli_real_escape_string($conn, $_POST['Off_name']);
    $num = mysqli_real_escape_string($conn, $_POST['num']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pst = mysqli_real_escape_string($conn, $_POST['pst']);
    $user_role = mysqli_real_escape_string($conn, $_POST['user_role']);

    // ตรวจสอบว่ามีชื่อผู้ใช้ซ้ำหรือไม่
    $checkUserQuery = "SELECT User FROM official WHERE User='$User'";
    $checkUserResult = mysqli_query($conn, $checkUserQuery);

    if (mysqli_num_rows($checkUserResult) > 0) {
        echo '
            <script>
                $(document).ready(function() {
                    Swal.fire({
                        title: "ชื่อผู้ใช้ซ้ำ",
                        text: "กรุณาเลือกชื่อผู้ใช้ที่แตกต่าง",
                        icon: "error",
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        location.href = "' . $_SERVER['REQUEST_URI'] . '";
                    });
                });
            </script>
        ';
    } else {
        // ตรวจสอบการอัปโหลดไฟล์รูปภาพ
        if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === 0) {
            $file = $_FILES['profile_image'];
            $fileName = $file['name'];
            $fileTmpName = $file['tmp_name'];
            $fileSize = $file['size'];
            $fileError = $file['error'];
            $fileType = $file['type'];

            // ตรวจสอบว่าไฟล์ที่อัปโหลดเป็นไฟล์รูปภาพหรือไม่
            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif');

            if (in_array($fileExt, $allowedExtensions)) {
                if ($fileError === 0) {
                    // สร้างชื่อไฟล์ใหม่เพื่อป้องกันชื่อซ้ำ
                    $fileNameNew = uniqid('', true) . '.' . $fileExt;
                    $fileDestination = '../profile/' . $fileNameNew; // กำหนดตำแหน่งที่จะเก็บไฟล์
                    
                    if (move_uploaded_file($fileTmpName, $fileDestination)) {
                        $profileImageURL = '../profile/' . $fileNameNew; // เก็บ path ของไฟล์รวมกับชื่อไฟล์
                    

                        // เพิ่มข้อมูลลงในฐานข้อมูล
                        $sql_official = "INSERT INTO official (User, Pass, Off_name, num, email, pst, user_role, profile_image)
                                         VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                        $stmt = mysqli_prepare($conn, $sql_official);
                        mysqli_stmt_bind_param($stmt, 'ssssssss', $User, $Pass, $Off_name, $num, $email, $pst, $user_role, $profileImageURL);
                        $query_official = mysqli_stmt_execute($stmt);

                        if ($query_official) {
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
                    } else {
                        echo '
                            <script>
                                $(document).ready(function() {
                                    Swal.fire({
                                        title: "เกิดข้อผิดพลาดในการอัปโหลดไฟล์",
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
                } else {
                    echo '
                        <script>
                            $(document).ready(function() {
                                Swal.fire({
                                    title: "เกิดข้อผิดพลาดในการอัปโหลดไฟล์",
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
            } else {
                echo '
                    <script>
                    $(document).ready(function() {
                        Swal.fire({
                            title: "ชนิดของไฟล์ที่อัปโหลดไม่ได้รับอนุญาต",
                            icon: "error",
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            location.href = "' . $_SERVER['REQUEST_URI'] . '";
                        });
                    });
                    </script>
                ';
            }
        } else {
            echo '
                <script>
                $(document).ready(function() {
                    Swal.fire({
                        title: "กรุณาเลือกไฟล์รูปภาพ",
                        icon: "warning",
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        location.href = "' . $_SERVER['REQUEST_URI'] . '";
                    });
                });
                </script>
            ';
        }
    }
}
?>
