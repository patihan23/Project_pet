<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <!-- Include SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
</head>

<body>

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Include SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
        $(document).ready(function () {
            <?php
            session_start();
            include('config.php');
            $errors = array();

            if (isset($_POST['login_user'])) {
                $username = mysqli_real_escape_string($conn, $_POST['username']);
                $password = mysqli_real_escape_string($conn, $_POST['password']);

                if (count($errors) == 0) {
                    $query = "SELECT * FROM official WHERE User = '$username' AND Pass = '$password'";
                    $result = mysqli_query($conn, $query);

                    if (mysqli_num_rows($result) == 1) {
                        $row = mysqli_fetch_assoc($result);
                        $_SESSION['username'] = $username;
                        $_SESSION['user_role'] = $row['user_role'];
                        $_SESSION['ID_OFF'] = $row['ID_OFF']; // เก็บค่า ID_OFF ลงใน session

                        echo "Swal.fire({
                            icon: 'success',
                            title: 'Login Successful',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.location.href = 'people/index';
                        });";
                    } else {
                        echo "Swal.fire({
                            icon: 'error',
                            title: 'Login Failed',
                            text: 'Invalid username or password',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.history.back();
                        });";
                    }
                }
            }
            ?>
        });
    </script>
</body>

</html>
