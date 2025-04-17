<?php
session_start();
include('../config.php');
if (!isset($_SESSION['username'])) {
  header("Location: ../login_official.php");
  exit;
}

// Fetch available years from the database
$years = [];
$result = mysqli_query($conn, "SELECT DISTINCT year_added as year FROM pet ORDER BY year_added DESC");
while ($row = mysqli_fetch_assoc($result)) {
  $years[] = $row['year'];
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>ข้อมูลสถิติ</title>
  <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
  <link rel="icon" href="assets/img/logo/logo.png" type="image/x-icon" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css?family=Kanit:100,200,300&amp;subset=thai" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
  <link rel="stylesheet" href="assets/css/plugins.min.css" />
  <link rel="stylesheet" href="assets/css/kaiadmin.min.css" />
  <link rel="stylesheet" href="assets/css/color.css" />
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.23/jspdf.plugin.autotable.min.js"></script>
  <script src="assets\js\THSarabunNew-normal.js"></script> <!-- เพิ่มไฟล์ฟอนต์นี้ -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

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
            <li class="nav-item active submenu">
              <a data-bs-toggle="collapse" href="#chart">
                <i class="far fa-chart-bar"></i>
                <p>ข้อมูลสถิติประจำปี</p>
                <span class="caret"></span>
              </a>
              <div class="collapse show" id="chart">
                <ul class="nav nav-collapse">
                  <li>
                    <a href="chart_pet.php">
                      <span class="sub-item">ข้อมูลสถิติจำนวนสัตว์ในระบบประจำปี</span>
                    </a>
                  </li>
                  <li class="active">
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
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <div class="card-title">ข้อมูลสถิติจำนวนสัตว์ที่ได้รับวัคซีนประจำปี เลือกปี :</div>
                  <select id="yearSelector" class="form-control">
                    <?php foreach ($years as $year) {
                      $buddhistYear = $year; // Convert Gregorian year to Buddhist year
                    ?>
                      <option value="<?= $year ?>">ปี : <?= $buddhistYear ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="card-body">
                  <div class="chart-container">
                    <canvas id="barChart" width="400" height="100"></canvas>
                  </div>
                  <button id="printPDF" class="btn btn-danger">ปริ้นเป็น PDF</button>
                  <button id="exportExcel" class="btn btn-success">ส่งออกเป็น Excel</button>

                  <div id="vaccine_chartContainer" class="mt-4">
                    <table id="vaccine_chart" class="table">
                      <!-- Table will be dynamically populated -->
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <style>
          @font-face {
            font-family: 'THSarabunNew';
            src: url('data:font/ttf;base64,...') format('truetype');
          }

          .table {
            font-family: 'THSarabunNew', sans-serif;
          }
        </style>

        <?php include 'include/footer.php'; ?>
      </div>
      <?php include('include/Custom_tp.php'); ?>
    </div>
    <!--   Core JS Files   -->
    <script src="assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="assets/js/core/popper.min.js"></script>
    <script src="assets/js/core/bootstrap.min.js"></script>

    <!-- jQuery Scrollbar -->
    <script src="assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

    <!-- jQuery Sparkline -->
    <script src="assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

    <!-- Chart Circle -->
    <script src="assets/js/plugin/chart-circle/circles.min.js"></script>

    <!-- Datatables -->
    <script src="assets/js/plugin/datatables/datatables.min.js"></script>

    <!-- Bootstrap Notify -->
    <script src="assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>

    <!-- jQuery Vector Maps -->
    <script src="assets/js/plugin/jsvectormap/jsvectormap.min.js"></script>
    <script src="assets/js/plugin/jsvectormap/world.js"></script>


    <!-- Kaiadmin JS -->
    <script src="assets/js/kaiadmin.min.js"></script>



    <!-- รวม JavaScript สำหรับควบคุม Modal -->
    <!-- <script src="editProfile.js"></script> -->

    <!-- Kaiadmin DEMO methods, don't include it in your project! -->
    <script src="assets/js/setting_color.js"></script>
    <!-- <script src="assets/js/demo.js"></script> -->
    <script>
      $("#lineChart").sparkline([102, 109, 120, 99, 110, 105, 115], {
        type: "line",
        height: "70",
        width: "100%",
        lineWidth: "2",
        lineColor: "#177dff",
        fillColor: "rgba(23, 125, 255, 0.14)",
      });

      $("#lineChart2").sparkline([99, 125, 122, 105, 110, 124, 115], {
        type: "line",
        height: "70",
        width: "100%",
        lineWidth: "2",
        lineColor: "#f3545d",
        fillColor: "rgba(243, 84, 93, .14)",
      });

      $("#lineChart3").sparkline([105, 103, 123, 100, 95, 105, 115], {
        type: "line",
        height: "70",
        width: "100%",
        lineWidth: "2",
        lineColor: "#ffa534",
        fillColor: "rgba(255, 165, 52, .14)",
      });
    </script>
<script>
$(document).ready(function() {
    function loadChartData(year) {
        $.ajax({
            url: 'fetch_vaccine_chart_data.php',
            type: 'POST',
            data: { year: year },
            dataType: 'json',
            success: function(response) {
                var labels = response.labels;
                var data = response.data;
                var colors = response.colors;

                var ctx = document.getElementById('barChart').getContext('2d');
                if (window.bar !== undefined) {
                    window.bar.destroy();
                }
                window.bar = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'จำนวนสัตว์เลี้ยง',
                            backgroundColor: colors,
                            borderColor: colors.map(color => color.replace('0.2', '1')),
                            borderWidth: 1,
                            data: data
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
        });
    }

    function loadTableData(year) {
        $.ajax({
            url: 'fetch_vaccine_table_data.php',
            type: 'POST',
            data: { year: year },
            success: function(response) {
                var parts = response.split('<!-- Table Separator -->');
                $('#vaccine_chartContainer').html(parts[0]);
                $('#vaccine_chart').html(parts[1]); // Assuming table is returned as HTML

                initializeDataTables(); // Ensure tables are re-initialized
            }
        });
    }

    function initializeDataTables() {
        if ($.fn.DataTable.isDataTable('#vaccine_chart')) {
            $('#vaccine_chart').DataTable().destroy();
        }

        $('#vaccine_chart').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            lengthChange: true,
            pageLength: 10,
            language: {
                search: "ค้นหา:",
                lengthMenu: "แสดง _MENU_ รายการต่อหน้า",
                info: "แสดงหน้า _PAGE_ จาก _PAGES_",
                infoEmpty: "ไม่มีข้อมูล",
                infoFiltered: "(ค้นหาจากทั้งหมด _MAX_ รายการ)",
                paginate: {
                    next: "ถัดไป",
                    previous: "ก่อนหน้า"
                }
            }
        });
    }

    function exportToExcel() {
        var wb = XLSX.utils.book_new();
        var selectedYear = $('#yearSelector').val();

        // Get all data from DataTable
        var table = $('#vaccine_chart').DataTable();
        var data = table.rows({ search: 'applied' }).data().toArray();

        // Extract headers
        var headers = [];
        $('#vaccine_chart thead tr').each(function() {
            $(this).find('th').each(function() {
                headers.push($(this).text());
            });
        });

        // Prepare data for Excel
        var wsData = [headers].concat(data.map(row => row.map(cell => cell.toString())));

        // Create worksheet from data
        var ws = XLSX.utils.aoa_to_sheet(wsData);
        XLSX.utils.book_append_sheet(wb, ws, 'Vaccine Data');

        // Save Excel file
        XLSX.writeFile(wb, `ข้อมูลสถิติจำนวนสัตว์ที่ได้รับวัคซีนประจำปี_${selectedYear}.xlsx`);
    }

    $('#yearSelector').change(function() {
        var year = $(this).val();
        loadChartData(year);
        loadTableData(year);
    });

    $('#printPDF').click(function() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF('landscape');
        var selectedYear = $('#yearSelector').val();

        var vaccineTable = $('#vaccine_chart').DataTable();

        // Ensure all data is visible
        vaccineTable.page.len(-1).draw();

        doc.addFileToVFS('THSarabunNew.ttf', THSarabunFont.regular);
        doc.addFont('THSarabunNew.ttf', 'THSarabunNew', 'normal');
        doc.setFont('THSarabunNew');
        doc.setFontSize(20);
        doc.text(15, 15, "ข้อมูลสถิติจำนวนสัตว์ที่ได้รับวัคซีนประจำปี ปี: " + selectedYear);

        setTimeout(function() {
            doc.autoTable({
                html: '#vaccine_chart',
                startY: 30,
                theme: 'striped',
                styles: {
                    font: 'THSarabunNew',
                    fontSize: 16
                },
                margin: {
                    horizontal: 10
                },
                columnStyles: {
                    0: { cellWidth: 'wrap' },
                    1: { cellWidth: 'wrap' },
                    2: { cellWidth: 'wrap' },
                    3: { cellWidth: 'wrap' },
                    4: { cellWidth: 'wrap' }
                },
                autoSize: true
            });

            var canvas = document.getElementById('barChart');
            var canvasImg = canvas.toDataURL("image/jpeg", 1.0);
            doc.addPage();
            doc.addImage(canvasImg, 'JPEG', 10, 30, 280, 150);

            doc.save(`ข้อมูลสถิติจำนวนสัตว์ที่ได้รับวัคซีนประจำปี_${selectedYear}.pdf`);

            // Restore default page length
            vaccineTable.page.len(10).draw();
        }, 1000);
    });

    $('#exportExcel').click(function() {
        exportToExcel();
    });

    var initialYear = $('#yearSelector').val();
    loadChartData(initialYear);
    loadTableData(initialYear);
});
</script>

</body>

</html>
<?php
// Close database connection
if (isset($conn) && $conn) {
  mysqli_close($conn);
}

?>