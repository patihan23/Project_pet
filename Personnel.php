<?php include 'config.php'; ?>
<?php include 'include/navbar.php'; ?>

<?php 
$sql = "SELECT Off_name, num, pst, email, profile_image FROM official";
$result = $conn->query($sql);
?>

<!-- ส่วนโครงการ -->
<section class="py-5">
    <div class="container px-5 mb-5">
        <div class="text-center mb-5">
        <div class="feature bg-primary bg-gradient-primary-to-secondary text-white rounded-3 mb-3"><i class="bi bi-person-circle"></i></div>
            <h1 class="display-5 fw-bolder mb-0"><span class="text-gradient d-inline">บุคคลากร</span></h1>
        </div>
        <div class="row gx-5 justify-content-center">
            <div class="col-lg-11 col-xl-9 col-xxl-8">
                <?php
                if ($result->num_rows > 0) {
                    // แสดงข้อมูลแต่ละแถว
                    while($row = $result->fetch_assoc()) {
                        $profile_image_path = $row["profile_image"];
                        
                        // ตรวจสอบและปรับเปลี่ยนเส้นทางรูปภาพ
                        if (file_exists($profile_image_path)) {
                            $display_image_path = $profile_image_path;
                        } else {
                            // กำหนดเส้นทางรูปภาพใหม่หากรูปภาพอยู่ในโฟลเดอร์อื่น
                            $display_image_path = './profile/' . basename($profile_image_path);
                        }

                        echo '
                        <div class="card overflow-hidden shadow rounded-4 border-0 mb-5">
                            <div class="card-body p-0">
                                <div class="d-flex align-items-center">
                                    <img class="img-fluid" src="' . $display_image_path . '" alt="..." style="max-width: 180px; margin-right: 15px;" />
                                    <div class="p-5">
                                        <h2 class="fw-bolder">' . $row["Off_name"] . '</h2>
                                        <p>
                                            <i class="bi bi-phone"> ' . $row["num"] . '</i> <br>
                                            <i class="bi bi-envelope"> ' . $row["email"] . '</i><hr>
                                            ตำแหน่ง ' . $row["pst"] . '
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>';
                    }
                } else {
                    echo "ไม่พบข้อมูล";
                }
                ?>
            </div>
        </div>
    </div>
</section>
<!-- Call to action section-->
</main>
<!-- Footer-->
<?php include 'include/footer.php' ?>
</body>
</html>
