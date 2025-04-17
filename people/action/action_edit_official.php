<?php
// Check if the form is submitted
if (isset($_POST['btnEditofficial'])) {
    include('config.php'); // Include database connection

    // Sanitize and retrieve form data
    $ID_OFF = mysqli_real_escape_string($conn, $_POST['ID_OFF']);
    $User = mysqli_real_escape_string($conn, $_POST['User']);
    $Pass = mysqli_real_escape_string($conn, $_POST['Pass']);
    $Off_name = mysqli_real_escape_string($conn, $_POST['Off_name']);
    $num = mysqli_real_escape_string($conn, $_POST['num']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pst = mysqli_real_escape_string($conn, $_POST['pst']);
    $user_role = mysqli_real_escape_string($conn, $_POST['user_role']);
    $profileImageURL = null;

    // Check if profile image is uploaded
    if (!empty($_FILES['profile_image']['name'])) {
        $file = $_FILES['profile_image'];
        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];
        $fileType = $file['type'];

        // File handling
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif');

        if (in_array($fileExt, $allowedExtensions) && $fileError === 0) {
            $fileNameNew = uniqid('', true) . '.' . $fileExt;
            $fileDestination = '../profile/' . $fileNameNew;

            if (move_uploaded_file($fileTmpName, $fileDestination)) {
                $profileImageURL = $fileDestination;
            } else {
                echo '
                    <script>
                        Swal.fire({
                            title: "เกิดข้อผิดพลาดในการอัปโหลดไฟล์",
                            icon: "error",
                            showConfirmButton: true
                        });
                    </script>
                ';
                exit;
            }
        } else {
            echo '
                <script>
                    Swal.fire({
                        title: "ชนิดของไฟล์ที่อัปโหลดไม่ได้รับอนุญาต",
                        icon: "error",
                        showConfirmButton: true
                    });
                </script>
            ';
            exit;
        }
    }

    // Update database
    $sql_update_official = "UPDATE official SET 
        User = '$User',
        Pass = '$Pass',
        Off_name = '$Off_name',
        num = '$num',
        email = '$email',
        pst = '$pst',
        user_role = '$user_role'";

    if ($profileImageURL) {
        $sql_update_official .= ", profile_image = '$profileImageURL'";
    }

    $sql_update_official .= " WHERE ID_OFF = '$ID_OFF'";
    $query_update_official = mysqli_query($conn, $sql_update_official);

    if ($query_update_official) {
        // Update session only if editing own profile
        if ($_SESSION['ID_OFF'] == $ID_OFF) {
            $_SESSION['username'] = $User;
            $_SESSION['offName'] = $Off_name;
            $_SESSION['profileImage'] = $profileImageURL;
            // Update other session variables as needed
        }

        // Redirect or show success message
        echo '
            <script>
                Swal.fire({
                    title: "แก้ไขข้อมูลสำเร็จ",
                    icon: "success",
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location.href = "' . $_SERVER['REQUEST_URI'] . '";
                });
            </script>
        ';
    } else {
        // Show error message
        echo '
            <script>
                Swal.fire({
                    title: "เกิดข้อผิดพลาด",
                    text: "ไม่สามารถบันทึกข้อมูลได้",
                    icon: "error",
                    showConfirmButton: true
                });
            </script>
        ';
    }
}
?>