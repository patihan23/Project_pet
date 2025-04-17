<?php
session_start();
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout Page</title>
    <!-- Include SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
</head>

<body>

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Include SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
        $(document).ready(function() {
            Swal.fire({
                icon: 'success',
                title: 'แก้ไขข้อมูลสำเร็จกรุณาเข้าสู่ระบบใหม่',
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                window.location.href = '.../login_official.php'; // เปลี่ยนเส้นทางของหน้าหลัก
            });
        });
    </script>

</body>

</html>