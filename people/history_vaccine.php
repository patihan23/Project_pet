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

// เก็บค่าปีที่ผู้ใช้เลือกจากฟอร์ม
$selectedYearVaccine = isset($_GET['year_vaccine']) ? $_GET['year_vaccine'] : '';
$selectedYearNext = isset($_GET['year_next']) ? $_GET['year_next'] : '';

function checkVaccineExpiration($selectedYearVaccine, $selectedYearNext)
{
  global $conn;
  $today = new DateTime();
  $expiredCount = 0;

  // ปรับ SQL ตามปีที่เลือก และดึงสถานะของสัตว์เลี้ยง
  $sql = "SELECT pet.Pet_name, history_v.next_Hv_date, history_v.ID_HV, pet.status
          FROM pet
          INNER JOIN history_v ON pet.ID_P = history_v.ID_P
          WHERE 1=1";

  if ($selectedYearVaccine) {
    $sql .= " AND YEAR(history_v.HV_date) = '$selectedYearVaccine'";
  }

  if ($selectedYearNext) {
    $sql .= " AND YEAR(history_v.next_Hv_date) = '$selectedYearNext'";
  }

  $result = mysqli_query($conn, $sql);

  while ($row = mysqli_fetch_assoc($result)) {
    $nextHvDate = new DateTime($row['next_Hv_date']);
    $petStatus = $row['status'];

    if ($nextHvDate < $today && $petStatus != 2) { // ตรวจสอบว่าสถานะของสัตว์เลี้ยงไม่ใช่ 2 (เสียชีวิต)
      $expiredCount++;
      $formattedDate = convertDateToThai($nextHvDate->format('Y-m-d'));
      $message = "ฉีดวัคซีนสัตว์เลี้ยง " . $row['Pet_name'] . " (ID: " . $row['ID_HV'] . ") เกินกำหนดฉีดวัคซีนแล้ว วันครบกำหนดคือ " . $formattedDate . ".";
      sendLineNotify($message);
    }
  }

  return $expiredCount;
}



$expiredCount = 0;

// ตรวจสอบการกดปุ่ม
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['check_expiration'])) {
  $expiredCount = checkVaccineExpiration($selectedYearVaccine, $selectedYearNext);
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>ประวัติการฉีดวัคซีน</title>
  <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
  <link rel="icon" href="assets/img/logo/logo.png" type="image/x-icon" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />

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
            <li class="nav-item active">
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
// Query to count all vaccinations
$sql = "SELECT COUNT(*) as history_vaccine_count FROM history_v";
$result = $conn->query($sql);

$history_vaccine_count = 0;
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $history_vaccine_count = $row["history_vaccine_count"];
  }
} else {
  echo "ไม่มีข้อมูล";
}

// Query to count cat vaccinations using JOIN
$sql = "SELECT COUNT(*) as cat_vaccine_count 
    FROM history_v 
    JOIN pet ON history_v.ID_P = pet.ID_P 
    WHERE pet.Type_pet = 2";
$result = $conn->query($sql);

$cat_vaccine_count = 0;
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $cat_vaccine_count = $row["cat_vaccine_count"];
  }
} else {
  echo "ไม่มีข้อมูล";
}

// Query to count dog vaccinations
$sql = "SELECT COUNT(*) as dog_vaccine_count 
    FROM history_v 
    JOIN pet ON history_v.ID_P = pet.ID_P 
    WHERE pet.Type_pet = 1";
$result = $conn->query($sql);

$dog_vaccine_count = 0;
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $dog_vaccine_count = $row["dog_vaccine_count"];
  }
} else {
  echo "ไม่มีข้อมูล";
}

// Query to count dog vaccinations excluding dead pets
$sql = "SELECT COUNT(*) as alive_dog_vaccine_count 
    FROM history_v 
    JOIN pet ON history_v.ID_P = pet.ID_P 
    WHERE pet.Type_pet = 1 
    AND pet.status != 2"; // ตรวจสอบสถานะของสัตว์เลี้ยง
$result = $conn->query($sql);

$alive_dog_vaccine_count = 0;
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $alive_dog_vaccine_count = $row["alive_dog_vaccine_count"];
  }
} else {
  echo "ไม่มีข้อมูล";
}

// Query to count dead pets that have vaccination history
$sql = "SELECT COUNT(DISTINCT pet.ID_P) as dead_pets_count 
        FROM pet 
        JOIN history_v ON pet.ID_P = history_v.ID_P 
        WHERE pet.status = 2"; // ตรวจสอบสถานะสัตว์เลี้ยงที่ตาย
$result = $conn->query($sql);

$dead_pets_count = 0;
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $dead_pets_count = $row["dead_pets_count"];
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
    $selectedYearVaccine = isset($_GET['year_vaccine']) ? $_GET['year_vaccine'] : '';
    $selectedYearNext = isset($_GET['year_next']) ? $_GET['year_next'] : '';

    // สร้างเงื่อนไขการกรอง
    $filterCondition = "1=1"; // เงื่อนไขที่เริ่มต้นเป็นจริงเสมอ

    if ($selectedYearVaccine) {
      $filterCondition .= " AND YEAR(HV_date) = '$selectedYearVaccine'";
    }

    if ($selectedYearNext) {
      $filterCondition .= " AND YEAR(next_Hv_date) = '$selectedYearNext'";
    }

    // คิวรีข้อมูลจำนวนวัคซีนทั้งหมด
    $historyVaccineQuery = "SELECT COUNT(*) AS count FROM history_v WHERE $filterCondition";
    $historyVaccineResult = mysqli_query($conn, $historyVaccineQuery);
    if (!$historyVaccineResult) {
        die("Error in query: " . mysqli_error($conn)); // แสดงข้อผิดพลาดของ SQL
    }
    $historyVaccineRow = mysqli_fetch_assoc($historyVaccineResult);
    $history_vaccine_count = $historyVaccineRow['count'];

    // คิวรีจำนวนแมวที่ได้รับวัคซีน
    $catVaccineQuery = "SELECT COUNT(*) AS count FROM history_v
                INNER JOIN pet ON history_v.ID_P = pet.ID_P
                WHERE pet.Type_pet = 2 AND $filterCondition";
    $catVaccineResult = mysqli_query($conn, $catVaccineQuery);
    if (!$catVaccineResult) {
        die("Error in query: " . mysqli_error($conn)); // แสดงข้อผิดพลาดของ SQL
    }
    $catVaccineRow = mysqli_fetch_assoc($catVaccineResult);
    $cat_vaccine_count = $catVaccineRow['count'];

    // คิวรีจำนวนสุนัขที่ได้รับวัคซีน
    $dogVaccineQuery = "SELECT COUNT(*) AS count FROM history_v
                INNER JOIN pet ON history_v.ID_P = pet.ID_P
                WHERE pet.Type_pet = 1 AND $filterCondition";
    $dogVaccineResult = mysqli_query($conn, $dogVaccineQuery);
    if (!$dogVaccineResult) {
        die("Error in query: " . mysqli_error($conn)); // แสดงข้อผิดพลาดของ SQL
    }
    $dogVaccineRow = mysqli_fetch_assoc($dogVaccineResult);
    $dog_vaccine_count = $dogVaccineRow['count'];

   // คิวรีจำนวนสัตว์เลี้ยงที่ตายทั้งหมด พร้อมกรองตามปี
$deadPetsQuery = "SELECT COUNT(*) AS count 
FROM pet 
WHERE status = 2 
AND EXISTS (
    SELECT 1 
    FROM history_v 
    WHERE pet.ID_P = history_v.ID_P 
    AND $filterCondition
)";

$deadPetsResult = mysqli_query($conn, $deadPetsQuery);
if (!$deadPetsResult) {
die("Error in query: " . mysqli_error($conn)); // แสดงข้อผิดพลาดของ SQL
}

$deadPetsRow = mysqli_fetch_assoc($deadPetsResult);
$dead_pets_count = $deadPetsRow['count'];
?>

        


        <div class="container">
          <div class="page-inner">

            <div class="row">
              <div class="row">
                <div class="col-sm-6 col-md-3 text-center">
                  <div class="card card-stats card-round">
                    <div class="card-body">
                      <div class="row align-items-center">
                        <div class="col-icon">
                          <div class="icon-big text-center icon-primary bubble-shadow-small">
                            <i class="fa-solid fa-laptop-medical"></i>
                          </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                          <div class="numbers">
                            <p class="card-category text-primary">จำนวนรายการวัคซีน</p>
                            <h4 class="card-title"><?php echo number_format($history_vaccine_count); ?></h4>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-sm-6 col-md-3 text-center">
                  <div class="card card-stats card-round">
                    <div class="card-body">
                      <div class="row align-items-center">
                        <div class="col-icon">
                          <div class="icon-big text-center icon-info bubble-shadow-small">
                            <i class="fa-solid fa-cat"></i>
                          </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                          <div class="numbers">
                            <p class="card-category text-info">จำนวนแมวที่ได้รับวัคซีน</p>
                            <h4 class="card-title"><?php echo number_format($cat_vaccine_count); ?></h4>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-sm-6 col-md-3 text-center">
                  <div class="card card-stats card-round">
                    <div class="card-body">
                      <div class="row align-items-center">
                        <div class="col-icon">
                          <div class="icon-big text-center icon-success bubble-shadow-small">
                            <i class="fa-solid fa-dog"></i>
                          </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                          <div class="numbers">
                            <p class="card-category text-success">จำนวนสุนัขที่ได้รับวัคซีน</p>
                            <h4 class="card-title"><?php echo number_format($dog_vaccine_count); ?></h4>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-sm-6 col-md-3 text-center">
                  <div class="card card-stats card-round">
                    <div class="card-body">
                      <div class="row align-items-center">
                        <div class="col-icon">
                          <div class="icon-big text-center icon-danger bubble-shadow-small">
                          <i class="fa-solid fa-book-skull"></i>
                          </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                          <div class="numbers">
                            <p class="card-category text-danger">จำนวนสัตว์เลี้ยงที่ตาย</p>
                            <h4 class="card-title"><?php echo number_format($dead_pets_count); ?></h4>
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
                    <div class="card-title">ประวัติการฉีดวัคซีน
                      <div class="text-center">
                        <button class="btn btn-success btn-round" data-toggle="modal" data-target="#add_history_v">
                          <span class="btn-label">
                            <i class="fa fa-plus"></i>
                          </span>
                          เพิ่มประวัติการฉีดวัคซีน
                        </button>
                      </div>
                    </div>
                    <form method="POST" action="">
                      <button type="submit" name="check_expiration" class="btn btn-primary" style="float: right;">
                        ตรวจสอบการหมดอายุวัคซีน
                      </button>
                    </form>
                    <form method="get" action="">
                      <div class="form-group">
                        <label for="year_vaccine">เลือกปีที่ฉีดวัคซีน:</label>
                        <select name="year_vaccine" id="year_vaccine" onchange="this.form.submit();">
                          <option value="">ทั้งหมด</option>
                          <?php
                          // ดึงปีที่แตกต่างจากประวัติการฉีดวัคซีน
                          $yearQuery = "SELECT DISTINCT YEAR(HV_date) AS year FROM history_v ORDER BY year DESC";
                          $yearResult = mysqli_query($conn, $yearQuery);
                          while ($yearRow = mysqli_fetch_assoc($yearResult)) {
                            $year = $yearRow['year'];
                            echo "<option value='$year'" . ($selectedYearVaccine == $year ? " selected" : "") . ">$year</option>";
                          }
                          ?>
                        </select>
                        <label for="year_next">เลือกปีที่ฉีดวัคซีนครั้งถัดไป:</label>
                        <select name="year_next" id="year_next" onchange="this.form.submit();">
                          <option value="">ทั้งหมด</option>
                          <?php
                          // ดึงปีที่แตกต่างจากวันที่ฉีดวัคซีนครั้งถัดไป
                          $yearQuery = "SELECT DISTINCT YEAR(next_Hv_date) AS year FROM history_v ORDER BY year DESC";
                          $yearResult = mysqli_query($conn, $yearQuery);
                          while ($yearRow = mysqli_fetch_assoc($yearResult)) {
                            $year = $yearRow['year'];
                            echo "<option value='$year'" . ($selectedYearNext == $year ? " selected" : "") . ">$year</option>";
                          }
                          ?>
                        </select>
                    </form>

                  </div>

                  <?php include 'model/form_add_history_v.php'; ?>

                  <div class="card-body">
  <div class="table-responsive">
    <table id="Hv_vaccineTable" class="table table-hover table-head-bg-black">
      <thead>
        <tr style="text-align: center;">
          <th>ลำดับ</th>
          <th>วันที่ฉีด</th>
          <th>ฉีดครั้งถัดไป</th>
          <th>ชื่อวัคซีน</th>
          <th>ชื่อเจ้าของสัตว์เลี้ยง</th>
          <th>ชื่อสัตว์เลี้ยง</th>
          <th>สัตวแพทย์รับผิดชอบ</th>
          <th>สถานะ</th>
          <th>จัดการ</th>
        </tr>
      </thead>
      <tbody>
  <?php
  $sql = "SELECT history_v.*, pet.Pet_name, pet.Type_pet, official.OFF_name, vaccine.V_name, pet.status, COALESCE(pet_own.Po_name, 'ไม่มีเจ้าของ') AS Po_name
  FROM history_v
  INNER JOIN pet ON history_v.ID_P = pet.ID_P
  LEFT JOIN pet_own ON pet.ID_PO = pet_own.ID_PO
  INNER JOIN official ON history_v.ID_OFF = official.ID_OFF
  INNER JOIN vaccine ON history_v.ID_VC = vaccine.ID_VC  
  WHERE $filterCondition
  ORDER BY history_v.ID_HV ASC";
  $result = mysqli_query($conn, $sql);
  $counter = 1;

  while ($row = mysqli_fetch_assoc($result)) : ?>
    <tr>
      <td><?php echo $counter; ?></td>
      <td><?php echo htmlspecialchars(convertDateToThai($row['HV_date'])); ?></td>
      <td><?php echo htmlspecialchars(convertDateToThai($row['next_Hv_date'])); ?></td>
      <td><?php echo htmlspecialchars($row['V_name']); ?></td>
      <td><?php echo htmlspecialchars($row['Po_name']); ?></td>
      <td><?php echo htmlspecialchars($row['Pet_name']); ?></td>
      <td><?php echo htmlspecialchars($row['OFF_name']); ?></td>
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
      <td>
        <button type="button" class="btn btn-warning btn-link btn-icon" data-toggle="modal" data-target="#edit_history_v<?php echo htmlspecialchars($row['ID_HV']); ?>">
          <span class="fa fa-edit"></span>
        </button>
        <button type="button" class="btn btn-danger btn-link btn-icon" data-toggle="modal" data-target="#delete_history_v<?php echo htmlspecialchars($row['ID_HV']); ?>">
          <span class="fa fa-trash"></span>
        </button>
      </td>
    </tr>
    <?php
    $counter++;
    include('model/form_edit_history_v.php');
    include('model/form_delete_history_v.php');
    ?>
  <?php endwhile; ?>
</tbody>


    </table>
    <?php include('action/action_insert_history_v.php') ?>
    <?php include('action/action_edit_history_v.php') ?>
    <?php include('action/action_delete_history_v.php') ?>
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
    <script>
      <?php if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['check_expiration'])) { ?>
        <?php if ($expiredCount > 0) { ?>
          Swal.fire({
            icon: 'success',
            title: 'พบสัตว์เลี้ยงที่เกินกำหนด',
            text: 'ระบบได้ทำการส่งการแจ้งเตือนเรียบร้อยแล้ว.'
          });
        <?php } else { ?>
          Swal.fire({
            icon: 'info',
            title: 'ไม่พบสัตว์เลี้ยงที่เกินกำหนด',
            text: 'ไม่พบสัตว์เลี้ยงที่เกินกำหนดในระบบ.'
          });
        <?php } ?>
      <?php } ?>
    </script>
</body>

</html>
<?php mysqli_close($conn); ?>