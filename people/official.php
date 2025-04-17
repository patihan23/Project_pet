<?php
session_start();
include('../config.php');
if (!isset($_SESSION['username']) || $_SESSION['user_role'] !== 'admin') {
  header("Location: ../login_official.php");
  exit;
}

$perPage = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page > 1) ? ($page * $perPage) - $perPage : 0;
$loggedInUserID = $_SESSION['ID_OFF'];
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>ข้อมูลเจ้าหน้าที่</title>
  <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
  <link rel="icon" href="assets/img/logo/logo.png" type="image/x-icon" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">



  <!-- Fonts and icons -->
  <link href="https://fonts.googleapis.com/css?family=Kanit:100,200,300&amp;subset=thai" rel="stylesheet">

  <!-- CSS Files -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
  <link rel="stylesheet" href="assets/css/plugins.min.css" />
  <link rel="stylesheet" href="assets/css/kaiadmin.min.css" />

  <link rel="stylesheet" href="assets/css/color.css" />
</head>


<body>
  <div class="wrapper">
    <!-- Sidebar -->
    <div class="sidebar" data-background-color="dark">
      <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
          <a href="index.php" class="logo">
            <img src="assets/img/logo/logo_pet.png" alt="navbar brand" class="navbar-brand" height="20" />
          </a>
          <div class="nav-toggle">
            <button class="btn btn-toggle toggle-sidebar">
              <i class="gg-menu-right"></i>
            </button>
            <button class="btn btn-toggle sidenav-toggler">
              <i class="gg-menu-left"></i>
            </button>
          </div>
          <button class="topbar-toggler more">
            <i class="gg-more-vertical-alt"></i>
          </button>
        </div>
        <!-- End Logo Header -->
      </div>
      <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
          <ul class="nav nav-secondary">
            <li class="nav-item">
              <a href="index.php">
                <i class="fas fa-home"></i>
                <p>หน้าแรก</p>
              </a>
            </li>
            <li class="nav-item">
              <a data-bs-toggle="collapse" href="#chart">
                <i class="far fa-chart-bar"></i>
                <p>ข้อมูลสถิติประจำปี</p>
                <span class="caret"></span>
              </a>
              <div class="collapse" id="chart">
                <ul class="nav nav-collapse">
                  <li>
                    <a href="chart_pet.php">
                      <span class="sub-item">ข้อมูลสถิติจำนวนสัตว์ในระบบประจำปี</span>
                    </a>
                  </li>
                  <li>
                    <a href="chart_history_v.php">
                      <span class="sub-item">ข้อมูลสถิติจำนวนสัตว์ที่ได้รับวัคซีนประจำปี</span>
                    </a>
                  </li>
                </ul>
              </div>
            </li>
            <li class="nav-item">
              <a data-bs-toggle="collapse" href="#chart_day">
                <i class="fas fa-calendar-alt"></i>
                <p>ข้อมูลประจำวัน</p>
                <span class="caret"></span>
              </a>
              <div class="collapse " id="chart_day">
                <ul class="nav nav-collapse">
                  <li class="">
                    <a href="chart_day_received.php">
                      <span class="sub-item">ข้อมูลสัตว์ที่ได้รับวัคซีน</span>
                    </a>
                  </li>
                  <li class="">
                    <a href="chart_day_not_received.php">
                      <span class="sub-item">ข้อมูลสัตว์ที่ไม่ได้รับวัคซีน</span>
                    </a>
                  </li>
                </ul>
              </div>
            </li>
            <li class="nav-item">
              <a data-bs-toggle="collapse" href="#maps">
                <i class="fas fa-map-marker-alt"></i>
                <p>Maps</p>
                <span class="caret"></span>
              </a>
              <div class="collapse" id="maps">
                <ul class="nav nav-collapse">
                  <li>
                    <a href="googlemaps.php">
                      <span class="sub-item">ตำแหน่งจุดฉีด Google Maps</span>
                    </a>
                  </li>
                  <li>
                    <a href="OpenStreetMap.php">
                      <span class="sub-item">ตำแหน่งจุดฉีด OpenStreetMap</span>
                    </a>
                  </li>
                </ul>
              </div>
            </li>
            <li class="nav-section">
              <span class="sidebar-mini-icon">
                <i class="fa fa-ellipsis-h"></i>
              </span>
              <h4 class="text-section">Pet Menu</h4>
            </li>
            <li class="nav-item">
              <a href="pet_own.php">
                <i class="fas fa-user-alt "></i>
                <p>ข้อมูลเจ้าของสัตว์เลี้ยง</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="pet.php">
                <i class="fas fa-paw"></i>
                <p>ข้อมูลสัตว์เลี้ยง</p>
              </a>
            </li>
            <li class="nav-section">
              <span class="sidebar-mini-icon">
                <i class="fa fa-ellipsis-h"></i>
              </span>
              <h4 class="text-section">Vaccine Menu</h4>
            </li>
            <li class="nav-item">
              <a href="vaccine.php">
                <i class="fa-solid fa-syringe"></i>
                <p>ข้อมูลวัคซีน</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="history_vaccine.php">
                <i class="fa-solid fa-book-medical"></i>
                <p>ประวัติการฉีดวัคซีน</p>
              </a>
            </li>
            <?php

            // ตรวจสอบว่ามี session 'username' และ 'user_role' หรือไม่
            if (isset($_SESSION['username']) && isset($_SESSION['user_role'])) {
              $user_role = $_SESSION['user_role'];

              // ตรวจสอบว่า user_role เป็น admin หรือไม่
              if ($user_role === 'admin') {
            ?>
                <li class="nav-section">
                  <span class="sidebar-mini-icon">
                    <i class="fa fa-ellipsis-h"></i>
                  </span>
                  <h4 class="text-section">Admin Menu</h4>
                </li>
                <li class="nav-item active">
                  <a href="official.php">
                    <i class="fa-solid fa-user-tie"></i>
                    <p>ข้อมูลเจ้าหน้าที่</p>
                  </a>
                </li>
            <?php }
            } ?>
          </ul>
        </div>
      </div>
    </div>
    <!-- End Sidebar -->
    <style>
      .pagination {
        display: flex;
        justify-content: center;
        margin: 20px 0;
      }

      .page-link {
        background-color: #F8F8FF;
        /* สีพื้นหลังปุ่ม */
        color: #000000;
        /* สีตัวหนังสือ */
        padding: 10px 15px;
        margin: 5px;
        border: 1px solid #007BFF;
        /* สีเส้นขอบปุ่ม */
        border-radius: 5px;
        text-decoration: none;
      }

      .page-link:hover {
        background-color: #BEBEBE;
        /* สีพื้นหลังเมื่อนำเมาส์มาชี้ */
      }
    </style>
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Include SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php
    $sql = "SELECT COUNT(*) as official_count FROM official WHERE ID_OFF  ";
    $result = $conn->query($sql);

    $official_count = 0;
    if ($result->num_rows > 0) {
      // Output the count of male dogs
      while ($row = $result->fetch_assoc()) {
        $official_count = $row["official_count"];
      }
    } else {
      echo "ไม่มีข้อมูล";
    }

    $sql = "SELECT COUNT(*) as official_user_count FROM official WHERE user_role = 'user'  ";
    $result = $conn->query($sql);

    $official_user_count = 0;
    if ($result->num_rows > 0) {
      // Output the count of male dogs
      while ($row = $result->fetch_assoc()) {
        $official_user_count = $row["official_user_count"];
      }
    } else {
      echo "ไม่มีข้อมูล";
    }

    $sql = "SELECT COUNT(*) as official_admin_count FROM official WHERE user_role = 'admin' ";
    $result = $conn->query($sql);

    $official_admin_count = 0;
    if ($result->num_rows > 0) {
      // Output the count of male dogs
      while ($row = $result->fetch_assoc()) {
        $official_admin_count = $row["official_admin_count"];
      }
    } else {
      echo "ไม่มีข้อมูล";
    }


    ?>


    <div class="main-panel">
      <div class="main-header">
        <div class="main-header-logo">
          <!-- Logo Header -->
          <div class="logo-header" data-background-color="dark">
            <a href="index.html" class="logo">
              <img src="assets/img/logo/logo.png" alt="navbar brand" class="navbar-brand" height="20" />
            </a>
            <div class="nav-toggle">
              <button class="btn btn-toggle toggle-sidebar">
                <i class="gg-menu-right"></i>
              </button>
              <button class="btn btn-toggle sidenav-toggler">
                <i class="gg-menu-left"></i>
              </button>
            </div>
            <button class="topbar-toggler more">
              <i class="gg-more-vertical-alt"></i>
            </button>
          </div>
          <!-- End Logo Header -->
        </div>
        <!-- Navbar Header -->
        <?php include 'include/navbar.php'; ?>
        <!-- End Navbar -->

        <div class="container">
          <div class="page-inner">

            <div class="row">
              <div class="row">
                <div class="col-sm-6 col-md-3">
                  <div class="card card-stats card-round">
                    <div class="card-body">
                      <div class="row align-items-center">
                        <div class="col-icon">
                          <div class="icon-big text-center icon-primary bubble-shadow-small">
                            <i class="fa-solid fa-users-rectangle"></i>
                          </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                          <div class="numbers">
                            <p class="card-category text-primary">จำนวนบุคคลากร
                            </p>
                            <h4 class="card-title"><?php echo number_format($official_count); ?></h4>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-sm-6 col-md-3">
                  <div class="card card-stats card-round">
                    <div class="card-body">
                      <div class="row align-items-center">
                        <div class="col-icon">
                          <div class="icon-big text-center icon-info bubble-shadow-small">
                            <i class="fa-solid fa-user-nurse"></i>
                          </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                          <div class="numbers">
                            <p class="card-category text-info">จำนวนเจ้าหน้าที่</p>
                            <h4 class="card-title"><?php echo number_format($official_user_count); ?></h4>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6 col-md-3">
                  <div class="card card-stats card-round">
                    <div class="card-body">
                      <div class="row align-items-center">
                        <div class="col-icon">
                          <div class="icon-big text-center icon-success bubble-shadow-small">
                            <i class="fa-solid fa-user-shield"></i>
                          </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                          <div class="numbers">
                            <p class="card-category text-success">จำนวนผู้ดูแลระบบ</p>
                            <h4 class="card-title"><?php echo number_format($official_admin_count); ?></h4>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
            </div>
            <div class="row">
              <div class="container mt-12" style="width:100%;">

                <div class="card col-12">
                  <div class="card-header">
                    <div class="card-title">จัดการข้อมูลบุคลากร
                      <div class="text-center">
                        <button class="btn btn-success btn-round" data-toggle="modal" data-target="#add_official">
                          <span class="btn-label">
                            <i class="fa fa-plus"></i>
                          </span>
                          เพิ่มเจ้าหน้าที่
                        </button>
                      </div>
                    </div>

                  </div>


                  <?php include('model/form_add_official.php') ?>


                  <div class="card-body">
                    <div class="table-responsive">
                      <table id="Hv_vaccineTable" class="table table-hover table-head-bg-black">
                        <thead>
                          <tr style="text-align: center;">
                            <th>ลำดับ</th>
                            <th>ชื่อผู้ใช้</th>
                            <th>รหัสผ่าน</th>
                            <th>ชื่อ-นามสกุล</th>
                            <th>เบอร์โทร</th>
                            <th>อีเมล์</th>
                            <th>ตำแหน่ง</th>
                            <th>หน้าที่</th>
                            <th>รูปภาพ</th>
                            <th>จัดการ</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          // Fetch data for DataTables
                          $sql = "SELECT * FROM official 
                      ORDER BY official.ID_OFF ASC";
                          $result = mysqli_query($conn, $sql);

                          $counter = 1; // เริ่มนับลำดับจาก 1

                          while ($row = mysqli_fetch_assoc($result)) : ?>
                            <tr>
                            <td><?php echo $counter; ?></td> <!-- แสดงลำดับที่ -->
                              <td><?php echo $row['User']; ?></td>
                              <td><?php echo $row['Pass']; ?></td>
                              <td><?php echo $row['Off_name']; ?></td>
                              <td><?php echo $row['num']; ?></td>
                              <td><?php echo $row['email']; ?></td>
                              <td><?php echo $row['pst']; ?></td>
                              <td>
                                <?php
                                if ($row['user_role'] == 'user') {
                                  echo 'เจ้าหน้าที่';
                                } elseif ($row['user_role'] == 'admin') {
                                  echo 'แอดมิน';
                                }
                                ?>
                              </td>
                              <td>
                                <img src="<?php echo $row['profile_image']; ?>" alt="Profile Image">
                              </td>
                              <td><button type="button" class="btn btn-warning btn-link btn-icon" data-toggle="modal" data-target="#editOfficial<?php echo $row['ID_OFF'] ?>"><span class="fa fa-edit"></span></button>
                              <button type="button" class="btn btn-danger btn-link btn-icon" data-toggle="modal" data-target="#delete_official<?php echo $row['ID_OFF']; ?>"><span class="fa fa-trash"></span></button></td>
                            </tr>
                            <?php $counter++; // เพิ่มลำดับที่ทีละ 1 ในแต่ละรอบของ loop
                            include('model/form_edit_official.php') ?>
                            <?php include('model/form_delete_official.php') ?>
                          <?php endwhile; ?>
                        </tbody>
                      </table>
                      <?php include('action/action_insert_official.php') ?>
                      <?php include('action/action_edit_official.php') ?>
                      <?php include('action/action_delete_official.php') ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Add CSS -->
        <style>
          .table img {
            max-width: 50px;
            /* ลดขนาดรูปภาพ */
            height: auto;
          }

          .table-container {
            margin: 0 auto;
            width: 100%;
            /* ลดขนาดความกว้างของตาราง */
          }
        </style>


        <style>
          .table tbody td {
            text-align: center;
            white-space: nowrap;
          }
        </style>
        <script>
          $(document).ready(function() {
            $('#Hv_vaccineTable').DataTable({
              "paging": true,
              "searching": true,
              "ordering": true,
              "info": true,
              "lengthChange": true,
              "pageLength": 10,
              "language": {
                "search": "ค้นหา:",
                "lengthMenu": "แสดง _MENU_ รายการต่อหน้า",
                "info": "แสดงหน้า _PAGE_ จาก _PAGES_",
                "infoEmpty": "ไม่มีข้อมูล",
                "infoFiltered": "(ค้นหาจากทั้งหมด _MAX_ รายการ)",
                "paginate": {
                  "next": "ถัดไป",
                  "previous": "ก่อนหน้า"
                }
              }
            });
          });
        </script>


        <?php include 'include/footer.php'; ?>
      </div>

      <!-- Custom template | don't include it in your project! -->
      <?php include('include/Custom_tp.php'); ?>
      <!-- End Custom template -->
    </div>
    <?php include('include/script.php'); ?>
</body>

</html>

<?php mysqli_close($conn); ?>