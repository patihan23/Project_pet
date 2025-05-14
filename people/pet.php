<?php
session_start();
include('../config.php');
if (!isset($_SESSION['username'])) {
  header("Location: ../login_official.php");
  exit;
}

$perPage = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page > 1) ? ($page * $perPage) - $perPage : 0;
$loggedInUserID = $_SESSION['ID_OFF'];


function convertDateToThai($date)
{
  $months = array(
    '01' => 'ม.ค.',
    '02' => 'ก.พ.',
    '03' => 'มี.ค.',
    '04' => 'เม.ย.',
    '05' => 'พ.ค.',
    '06' => 'มิ.ย.',
    '07' => 'ก.ค.',
    '08' => 'ส.ค.',
    '09' => 'ก.ย.',
    '10' => 'ต.ค.',
    '11' => 'พ.ย.',
    '12' => 'ธ.ค.'
  );

  $dateTime = new DateTime($date);
  $day = $dateTime->format('j');
  $month = $dateTime->format('m');
  $year = $dateTime->format('Y') + 543; // Adjust for Thai year
  return $day . ' ' . $months[$month] . ' ' . $year;
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>ข้อมูลสัตว์เลี้ยง</title>
  <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
  <link rel="icon" href="assets/img/logo/logo.png" type="image/x-icon" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css?family=Kanit:100,200,300&amp;subset=thai" rel="stylesheet">
  <!-- jQuery UI CSS -->
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
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
            <li class="nav-item active">
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
                <li class="nav-item">
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
    <!-- Include jQuery UI -->
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <!-- Include SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php
    $sql = "SELECT COUNT(*) as male_dogs_count FROM pet WHERE Type_pet = 1 AND Gender = 1";
    $result = $conn->query($sql);

    $male_dogs_count = 0;
    if ($result->num_rows > 0) {
      // Output the count of male dogs
      while ($row = $result->fetch_assoc()) {
        $male_dogs_count = $row["male_dogs_count"];
      }
    } else {
      echo "ไม่มีข้อมูล";
    }

    $sql = "SELECT COUNT(*) as female_dogs_count FROM pet WHERE Type_pet = 1 AND Gender = 2";
    $result = $conn->query($sql);

    $female_dogs_count = 0;
    if ($result->num_rows > 0) {
      // Output the count of male dogs
      while ($row = $result->fetch_assoc()) {
        $female_dogs_count = $row["female_dogs_count"];
      }
    } else {
      echo "ไม่มีข้อมูล";
    }

    $sql = "SELECT COUNT(*) as male_cat_count FROM pet WHERE Type_pet = 2 AND Gender = 1";
    $result = $conn->query($sql);

    $male_cat_count = 0;
    if ($result->num_rows > 0) {
      // Output the count of male dogs
      while ($row = $result->fetch_assoc()) {
        $male_cat_count = $row["male_cat_count"];
      }
    } else {
      echo "ไม่มีข้อมูล";
    }

    $sql = "SELECT COUNT(*) as female_cat_count FROM pet WHERE Type_pet = 2 AND Gender = 2";
    $result = $conn->query($sql);

    $female_cat_count = 0;
    if ($result->num_rows > 0) {
      // Output the count of male dogs
      while ($row = $result->fetch_assoc()) {
        $female_cat_count = $row["female_cat_count"];
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

        <?php
        $selectedYear = isset($_GET['year']) ? $_GET['year'] : '';

        // Adjust the SQL queries based on the selected year
        $countMaleDogsQuery = "SELECT COUNT(*) AS male_dogs_count FROM pet WHERE Type_pet = 1 AND Gender = 1";
        $countFemaleDogsQuery = "SELECT COUNT(*) AS female_dogs_count FROM pet WHERE Type_pet = 1 AND Gender = 2";
        $countMaleCatsQuery = "SELECT COUNT(*) AS male_cat_count FROM pet WHERE Type_pet = 2 AND Gender = 1";
        $countFemaleCatsQuery = "SELECT COUNT(*) AS female_cat_count FROM pet WHERE Type_pet = 2 AND Gender = 2";

        if ($selectedYear) {
          $countMaleDogsQuery .= " AND YEAR(year_added) = '$selectedYear'";
          $countFemaleDogsQuery .= " AND YEAR(year_added) = '$selectedYear'";
          $countMaleCatsQuery .= " AND YEAR(year_added) = '$selectedYear'";
          $countFemaleCatsQuery .= " AND YEAR(year_added) = '$selectedYear'";
        }

        $countMaleDogsResult = mysqli_query($conn, $countMaleDogsQuery);
        $countFemaleDogsResult = mysqli_query($conn, $countFemaleDogsQuery);
        $countMaleCatsResult = mysqli_query($conn, $countMaleCatsQuery);
        $countFemaleCatsResult = mysqli_query($conn, $countFemaleCatsQuery);

        $countMaleDogsRow = mysqli_fetch_assoc($countMaleDogsResult);
        $countFemaleDogsRow = mysqli_fetch_assoc($countFemaleDogsResult);
        $countMaleCatsRow = mysqli_fetch_assoc($countMaleCatsResult);
        $countFemaleCatsRow = mysqli_fetch_assoc($countFemaleCatsResult);

        $male_dogs_count = $countMaleDogsRow['male_dogs_count'];
        $female_dogs_count = $countFemaleDogsRow['female_dogs_count'];
        $male_cat_count = $countMaleCatsRow['male_cat_count'];
        $female_cat_count = $countFemaleCatsRow['female_cat_count'];
        ?>

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
                            <i class="fa-solid fa-dog"></i>
                          </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                          <div class="numbers">
                            <p class="card-category text-primary">จำนวนสุนัขเพศผู้</p>
                            <h4 class="card-title"><?php echo number_format($male_dogs_count); ?></h4>
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
                            <i class="fa-solid fa-shield-dog"></i>
                          </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                          <div class="numbers">
                            <p class="card-category text-info">จำนวนสุนัขเพศเมีย</p>
                            <h4 class="card-title"><?php echo number_format($female_dogs_count); ?></h4>
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
                            <i class="fa-solid fa-cat"></i>
                          </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                          <div class="numbers">
                            <p class="card-category text-success">จำนวนแมวเพศผู้</p>
                            <h4 class="card-title"><?php echo number_format($male_cat_count); ?></h4>
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
                          <div class="icon-big text-center icon-secondary bubble-shadow-small">
                            <i class="fa-solid fa-shield-cat"></i>
                          </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                          <div class="numbers">
                            <p class="card-category text-secondary">จำนวนแมวเพศเมีย</p>
                            <h4 class="card-title"><?php echo number_format($female_cat_count); ?></h4>
                          </div>
                          </h4>
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
                    <div class="card-title">จัดการข้อมูลสัตว์เลี้ยง
                      <div class="text-center">
                        <button class="btn btn-success btn-round" data-toggle="modal" data-target="#add_pet">
                          <span class="btn-label">
                            <i class="fas fa-plus"></i>
                          </span>
                          เพิ่มข้อมูลสัตว์เลี้ยง
                        </button>
                      </div>
                    </div>
                    <form method="get" action="" id="yearForm">
                      <label for="year">เลือกปี:</label>
                      <select name="year" id="year" onchange="document.getElementById('yearForm').submit();">
                        <option value="">ทั้งหมด</option>
                        <?php
                        // Fetch available years from the database
                        $yearQuery = "SELECT DISTINCT YEAR(year_added) AS year_added FROM pet ORDER BY year_added DESC";
                        $yearResult = mysqli_query($conn, $yearQuery);
                        while ($yearRow = mysqli_fetch_assoc($yearResult)) {
                          $year = $yearRow['year_added'];
                          echo "<option value='$year'" . ($selectedYear == $year ? " selected" : "") . ">$year</option>";
                        }
                        ?>
                      </select>
                    </form>
                  </div>


                  <?php include 'model/form_add_pet.php'; ?>

                  <div class="card-body">
                    <div class="table-responsive">
                      <table id="petTable" class="table table-hover table-head-bg-black">
                        <thead>
                          <tr style="text-align: center;">
                            <th>ลำดับ</th>
                            <th>ชื่อสัตว์เลี้ยง</th>
                            <th>ประเภทสัตว์เลี้ยง</th>
                            <th>เพศ</th>
                            <th>สายพันธุ์</th>
                            <th>อายุ</th>
                            <th>สี/ตำหนิ</th>
                            <th>น้ำหนัก</th>
                            <th>สถานะ</th>
                            <th>ชื่อเจ้าของสัตว์เลี้ยง</th>
                            <th>จัดการ</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          // Fetch data for DataTables
                          $sql = "SELECT pet.*, pet_own.Po_name, pet_own.Hno, pet_own.Moo, pet_own.ID
                          FROM pet 
                          INNER JOIN pet_own ON pet.ID_PO = pet_own.ID_PO";
                          if ($selectedYear) {
                            $sql .= " WHERE YEAR(pet.year_added) = '$selectedYear'";
                          }
                          $sql .= " ORDER BY pet.ID_P ASC";
                          $result = mysqli_query($conn, $sql);
                          $counter = 1; // เริ่มนับลำดับจาก 1

                          while ($row = mysqli_fetch_assoc($result)) : ?>
                            <tr>
                              <td><?php echo $counter; ?></td> <!-- แสดงลำดับที่ -->
                              <td><?php echo $row['Pet_name']; ?></td>
                              <td><?php
                                  if ($row['Type_pet'] == 1) {
                                    echo 'สุนัข';
                                  } elseif ($row['Type_pet'] == 2) {
                                    echo 'แมว';
                                  } else {
                                    echo 'ไม่ทราบ';
                                  }
                                  ?></td>
                              <td><?php
                                  if ($row['Gender'] == 1) {
                                    echo 'เพศผู้';
                                  } elseif ($row['Gender'] == 2) {
                                    echo 'เพศเมีย';
                                  } else {
                                    echo 'ไม่ทราบ';
                                  }
                                  ?></td>
                              <td><?php echo $row['Breed']; ?></td>
                              <td><?php echo convertDateToThai($row['p_old']); ?></td>
                              <td><?php echo $row['color']; ?></td>
                              <td><?php echo $row['weight']; ?> kg</td>
                              <td style="background-color: 
  <?php
                            if ($row['status'] == 1) {
                              echo '#d4edda';  // สีเขียวอ่อน (สำหรับยังมีชีวิต)
                            } elseif ($row['status'] == 2) {
                              echo '#f8d7da';  // สีแดงอ่อน (สำหรับเสียชีวิต)
                            } else {
                              echo '#fefefe';  // สีขาว (สำหรับไม่ทราบ)
                            }
  ?>;">
                                <?php
                                if ($row['status'] == 1) {
                                  echo 'ยังมีชีวิต';
                                } elseif ($row['status'] == 2) {
                                  echo 'เสียชีวิต';
                                } else {
                                  echo 'ไม่ทราบ';
                                }
                                ?>
                              </td>

                              <td><?php echo $row['Po_name']; ?></td>
                              <td><button type="button" class="btn btn-warning btn-link btn-icon" data-toggle="modal" data-target="#edit_pet<?php echo $row['ID_P'] ?>"><span class="fa fa-edit"></span></button>
                                <button type="button" class="btn btn-danger btn-link btn-icon" data-toggle="modal" data-target="#delete_pet<?php echo $row['ID_P']; ?>"><span class="fa fa-trash"></span></button>
                              </td>
                            </tr>
                            <?php
                            $counter++; // เพิ่มลำดับที่ทีละ 1 ในแต่ละรอบของ loop
                            include('model/form_edit_pet.php');
                            include('model/form_delete_pet.php');
                            ?>
                          <?php endwhile; ?>
                        </tbody>
                      </table>
                      <?php include('action/action_insert_pet.php') ?>
                      <?php include('action/action_edit_pet.php') ?>
                      <?php include('action/action_delete_pet.php') ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>


        <!-- Add CSS -->
        <style>
          .table tbody td {
            text-align: center;
            white-space: nowrap;
          }
        </style>
        <script>
          $(document).ready(function() {
            $('#petTable').DataTable({
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
    
    <!-- SweetAlert notification script -->
    <?php if(isset($_SESSION['swal_success'])): ?>
    <script>
        Swal.fire({
            title: 'สำเร็จ!',
            text: '<?php echo $_SESSION['swal_message']; ?>',
            icon: 'success',
            timer: 1500,
            showConfirmButton: false
        });
    </script>
    <?php 
        unset($_SESSION['swal_success']);
        unset($_SESSION['swal_message']);
    endif; ?>
    
    <?php if(isset($_SESSION['swal_error'])): ?>
    <script>
        Swal.fire({
            title: 'เกิดข้อผิดพลาด!',
            text: '<?php echo $_SESSION['swal_message']; ?>',
            icon: 'error',
            showConfirmButton: true
        });
    </script>
    <?php 
        unset($_SESSION['swal_error']);
        unset($_SESSION['swal_message']);
    endif; ?>
</body>

</html>
<?php mysqli_close($conn); ?>