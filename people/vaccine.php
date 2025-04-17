<?php
session_start();
include('../config.php');
if (!isset($_SESSION['username'])) {
  header("Location: ../login_official.php");
  exit;
}

function sendLineNotify($message)
{
  $token = "0V6X2lx2DUEMyFrHjmttdHIybPcHJrWAjjHkIkUBKaL"; // ใส่ Token ของ LINE Notify ของคุณที่นี่
  $apiUrl = "https://notify-api.line.me/api/notify";

  $data = array('message' => $message);
  $headers = array(
    'Authorization: Bearer ' . $token,
    'Content-Type: application/x-www-form-urlencoded'
  );

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $apiUrl);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

  $response = curl_exec($ch);
  curl_close($ch);

  // Optional: log response for debugging
  // error_log($response);
}

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

function checkVaccineExpiration()
{
  global $conn;
  $today = new DateTime();
  $expiredCount = 0;

  $sql = "SELECT * FROM vaccine";
  $result = mysqli_query($conn, $sql);

  while ($row = mysqli_fetch_assoc($result)) {
    $expirationDate = new DateTime($row['Expiration_date']);
    if ($expirationDate < $today) {
      $expiredCount++;
      $formattedDate = convertDateToThai($expirationDate->format('Y-m-d'));
      $message = "วัคซีน " . $row['V_name'] . " (ID: " . $row['ID_VC'] . ") ได้หมดอายุแล้วตั้งแต่วันที่ " . $formattedDate . ".";
      sendLineNotify($message);
    }
  }

  return $expiredCount;
}

$expiredCount = 0;

// ตรวจสอบการกดปุ่ม
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['check_expiration'])) {
  $expiredCount = checkVaccineExpiration();
}



?>




<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>ข้อมูลวัคซีน </title>
  <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
  <link rel="icon" href="assets/img/logo/logo.png" type="image/x-icon" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
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
            <li class="nav-item active">
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
    <!-- Include SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php
    $sql = "SELECT COUNT(*) as vaccine_count FROM vaccine WHERE ID_VC";
    $result = $conn->query($sql);

    $vaccine_count = 0;
    if ($result->num_rows > 0) {
      // Output the count of male dogs
      while ($row = $result->fetch_assoc()) {
        $vaccine_count = $row["vaccine_count"];
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
                <div class="col-sm-6 col-md-3 text-center">
                  <div class="card card-stats card-round">
                      <!-- <div class="card-body">
                        <div class="row align-items-center">
                          <div class="col-icon">
                            <div class="icon-big text-center icon-primary bubble-shadow-small">
                              <i class="fa-solid fa-shield-virus"></i>
                            </div>
                          </div>
                          <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                              <p class="card-category text-primary">จำนวนชนิดวัคซีน
                              </p>
                              <h4 class="card-title"><?php echo number_format($vaccine_count); ?></h4>
                            </div>
                          </div>
                        </div>
                      </div> -->
                  </div>
                </div>

              </div>
            </div>
            <div class="row">
              <div class="container mt-12" style="width:100%;">
                <div class="card col-12">
                  <div class="card-header">
                    <div class="card-title">จัดการข้อมูลวัคซีน
                      <div class="text-center">
                        <button class="btn btn-success btn-round" data-toggle="modal" data-target="#add_vaccine">
                          <span class="btn-label">
                            <i class="fa fa-plus"></i>
                          </span>
                          เพิ่มข้อมูลวัคซีน
                        </button>
                      </div>
                    </div>
                    <form method="POST" action="">
                      <button type="submit" name="check_expiration" class="btn btn-primary">ตรวจสอบการหมดอายุวัคซีน</button>
                    </form>
                  </div>


                  <?php include 'model/form_add_vaccine.php'; ?>


                  <div class="card-body">
                    <div class="table-responsive">
                      <table id="vaccineTable" class="table table-hover table-head-bg-black">
                        <thead>
                          <tr style="text-align: center;">
                            <th>ลำดับ</th>
                            <th>ชื่อวัคซีน</th>
                            <th>รายละเอียดวัคซีน</th>
                            <th>การจัดเก็บวัคซีน</th>
                            <th>วันที่หมดอายุ</th>
                            <th>จำนวน [โดส]</th>
                            <th>จัดการ</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          // Fetch data for DataTables
                          $sql = "SELECT * 
                                    FROM vaccine ORDER BY vaccine.ID_VC ASC";
                          $result = mysqli_query($conn, $sql);
                          $counter = 1;

                          while ($row = mysqli_fetch_assoc($result)) : ?>
                            <tr>
                            <td><?php echo $counter; ?></td>
                              <td>
                                <?php echo $row['V_name']; ?>
                              </td>
                              <td>
                                <?php echo $row['V_info']; ?>
                              </td>
                              <td>
                                <?php echo $row['V_storage']; ?>
                              </td>
                              <td><?php echo convertDateToThai($row['Expiration_date']); ?></td>
                              <td>
                                <?php echo $row['Dosage']; ?>
                              </td>
                              <td><button type="button" class="btn btn-warning btn-link btn-icon" data-toggle="modal" data-target="#edit_vaccine<?php echo $row['ID_VC'] ?>"><span class="fa fa-edit"></span>
                                  <button type="button" class="btn btn-danger btn-link btn-icon" data-toggle="modal" data-target="#delete_vaccine<?php echo $row['ID_VC']; ?>"><span class="fa fa-trash"></span></td>
                            </tr>
                            <?php $counter++; include('model/form_edit_vaccine.php') ?>
                            <?php include('model/form_delete_vaccine.php') ?>
                          <?php endwhile; ?>
                        </tbody>
                      </table>
                      <?php include('action/action_insert_vaccine.php') ?>
                      <?php include('action/action_edit_vaccine.php') ?>
                      <?php include('action/action_delete_vaccine.php') ?>
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
            $('#vaccineTable').DataTable({
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
    <script>
      <?php if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['check_expiration'])) { ?>
        <?php if ($expiredCount > 0) { ?>
          Swal.fire({
            icon: 'success',
            title: 'พบวัคซีนที่หมดอายุ',
            text: 'ระบบได้ทำการส่งการแจ้งเตือนเรียบร้อยแล้ว.'
          });
        <?php } else { ?>
          Swal.fire({
            icon: 'info',
            title: 'ไม่พบวัคซีนที่หมดอายุ',
            text: 'ไม่พบวัคซีนที่หมดอายุในระบบ.'
          });
        <?php } ?>
      <?php } ?>
    </script>
</body>

</html>
<?php mysqli_close($conn); ?>