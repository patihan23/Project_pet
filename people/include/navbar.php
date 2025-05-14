<nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
    <div class="container-fluid">
        <nav class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex">
            <div>
                <div>
                    <h4>ระบบจัดเก็บข้อมูลการฉีดวัคซีนสำหรับสัตว์</h4>
                </div>
            </div>
        </nav>

        <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
            <?php
            include('./config.php');

            if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
                $username = $_SESSION['username']; // เก็บชื่อผู้ใช้จาก session

                // ดึงข้อมูล Off_name และ URL ของรูปภาพจากฐานข้อมูล
                $query = "SELECT ID_OFF, Off_name, profile_image, Pass, num, email, User, user_role, pst FROM official WHERE User = '$username'";
                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) == 1) {
                    $row = mysqli_fetch_assoc($result);
                    $offName = $row['Off_name']; // เก็บ Off_name จากฐานข้อมูล 
                    $profileImage = $row['profile_image']; // เก็บ URL ของรูปภาพ
                    $loggedInUserID = $row['ID_OFF'];
                    $User = $row['User'];
                    $Pass = $row['Pass'];
                    $num = $row['num'];
                    $email = $row['email'];

            ?>
                    <li class="nav-item topbar-user dropdown hidden-caret">
                        <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                            <div class="avatar avatar-online">
                                <img src="<?php echo $profileImage; ?>" alt="..." class="avatar-img rounded-circle" />
                            </div>
                            <span class="profile-username">
                                <span class="op-7">ยินดีต้อนรับ,</span>
                                <span class="fw-bold"><?php echo $offName; ?></span>
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-user animated fadeIn">
                            <div class="dropdown-user-scroll scrollbar-outer">
                                <li>
                                    <div class="user-box">
                                        <div class="avatar-lg ">
                                            <img src="<?php echo $profileImage; ?>" alt="image profile" class="avatar-img" />
                                        </div>
                                        <div class="u-text">
                                            <h4><?php echo $offName; ?></h4>
                                            <h6 class="Info Text">ตำแหน่ง <?php
                                                                            if ($row['user_role'] == 'user') {
                                                                                echo 'เจ้าหน้าที่';
                                                                            } elseif ($row['user_role'] == 'admin') {
                                                                                echo 'แอดมิน';
                                                                            }
                                                                            ?></h6>
                                            <button type="button" class="btn btn-warning btn-xs" data-bs-toggle="modal" style="color: white;" data-bs-target="#editProfile<?php echo $loggedInUserID; ?>">
                                                แก้ไขข้อมูล
                                            </button>

                                            <div class="dropdown-divider"></div>
                                            <a href="logout.php" class="btn btn-danger btn-xs">ออกจากระบบ</a>
                                        </div>
                                    </div>
                                </li>
                            </div>
                        </ul>
                    </li>
            <?php
                } else {
                    // กรณีไม่พบข้อมูลหรือพบผู้ใช้หลายราย
                    echo "User not found or multiple users found.";
                }
            } else {
                // กรณีไม่มี session 'username' หรือ session เป็นค่าว่างเปล่า
                echo "กรุณาเข้าสู่ระบบเพื่อใช้งาน";
            }
            ?>
        </ul>
    </div>
</nav>
</div>

<?php include('model/form_edit_profile.php') ?>
<?php include('action/action_edit_profile.php') ?>