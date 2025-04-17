<?php
session_start();
include('../config.php');

if (!isset($_SESSION['username'])) {
    header("Location: ../login_official.php");
    exit;
}

// Fetch available days from the database
$days = [];
$result = mysqli_query($conn, "SELECT DISTINCT DATE(HV_date) as day FROM history_v ORDER BY DATE(HV_date) DESC");
while ($row = mysqli_fetch_assoc($result)) {
    $days[] = $row['day'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>ข้อมูลประจำวัน</title>
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
    <script src="assets/js/THSarabunNew-normal.js"></script>
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
                                    <li class="">
                                        <a href="chart_history_v.php">
                                            <span class="sub-item">ข้อมูลสถิติจำนวนสัตว์ที่ได้รับวัคซีนประจำปี</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item active submenu">
                            <a data-bs-toggle="collapse" href="#chartday">
                                <i class="far fa-chart-bar"></i>
                                <p>ข้อมูลประจำวัน</p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse show" id="chartday">
                                <ul class="nav nav-collapse">
                                    <li class="active">
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
                                    <div class="card-title">ข้อมูลสถิติจำนวนสัตว์ที่ได้รับวัคซีนประจำวัน เลือกวัน :</div>
                                    <select id="daySelector" class="form-control">
                                        <?php foreach ($days as $day) {
                                            $buddhistDay = $day; // Convert Gregorian date to Buddhist date if needed
                                        ?>
                                            <option value="<?= $day ?>">วันที่ : <?= $buddhistDay ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="card-body">
                                    <button id="printPDF" class="btn btn-pdf btn-danger">ปริ้นเป็น PDF</button>
                                    <button id="exportExcel" class="btn btn-success">ส่งออกเป็น Excel</button>
                                    <div id="petTableContainer" class="mt-4">
                                        <!-- Tables will be dynamically populated -->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h4>สัตว์เลี้ยงที่ได้การฉีดวัคซีน</h4>
                                                <div id="receivedTableContainer">
                                                    <!-- Table will be dynamically populated -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php include 'include/footer.php'; ?>
            </div>
        </div>

        <!-- Include JavaScript files -->
        <script src="assets/js/core/jquery-3.7.1.min.js"></script>
        <script src="assets/js/core/popper.min.js"></script>
        <script src="assets/js/core/bootstrap.min.js"></script>
        <script src="assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
        <script src="assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>
        <script src="assets/js/plugin/chart-circle/circles.min.js"></script>
        <script src="assets/js/plugin/datatables/datatables.min.js"></script>
        <script src="assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>
        <script src="assets/js/plugin/jsvectormap/jsvectormap.min.js"></script>
        <script src="assets/js/plugin/jsvectormap/world.js"></script>
        <script src="assets/js/kaiadmin.min.js"></script>

        <script>
            $(document).ready(function() {
                function loadTableData(day) {
                    $.ajax({
                        url: 'fetch_table_day.php',
                        type: 'POST',
                        data: {
                            day: day
                        },
                        success: function(response) {
                            // Assume response contains HTML for both tables separated by a marker
                            var parts = response.split('<!-- Table Separator -->');
                            $('#receivedTableContainer').html(parts[0]);
                            $('#notReceivedTableContainer').html(parts[1]);

                            // Reinitialize DataTables after loading new data
                            initializeDataTables();
                        }
                    });
                }

                function initializeDataTables() {
                    if ($.fn.DataTable.isDataTable('#receivedTable')) {
                        $('#receivedTable').DataTable().destroy();
                    }

                    if ($.fn.DataTable.isDataTable('#notReceivedTable')) {
                        $('#notReceivedTable').DataTable().destroy();
                    }

                    $('#receivedTable').DataTable({
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

                    $('#notReceivedTable').DataTable({
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

                    var selectedDay = $('#daySelector').val();

                    // Export received table
                    var receivedTable = $('#receivedTable').DataTable().rows().nodes().to$();
                    var receivedData = [];
                    $('#receivedTable thead tr').each(function() {
                        var headers = [];
                        $(this).find('th').each(function() {
                            headers.push($(this).text());
                        });
                        receivedData.push(headers);
                    });

                    receivedTable.each(function() {
                        var row = [];
                        $(this).find('td').each(function() {
                            row.push($(this).text());
                        });
                        receivedData.push(row);
                    });

                    var ws1 = XLSX.utils.aoa_to_sheet(receivedData);
                    XLSX.utils.book_append_sheet(wb, ws1, 'Received Vaccinations');


                    // Save the Excel file
                    var formattedDate = new Date(selectedDay).toISOString().slice(0, 10); // Convert date to YYYY-MM-DD format
                    XLSX.writeFile(wb, `ข้อมูลสถิติจำนวนสัตว์ที่ได้รับวัคซีนประจำวัน_${formattedDate}.xlsx`);
                }

                $('#daySelector').change(function() {
                    var day = $(this).val();
                    loadTableData(day);
                });
                $('#printPDF').click(function() {
                    const {
                        jsPDF
                    } = window.jspdf;
                    const doc = new jsPDF('landscape');

                    var selectedDay = $('#daySelector').val();

                    var receivedTable = $('#receivedTable').DataTable();
                    var notReceivedTable = $('#notReceivedTable').DataTable();

                    receivedTable.page.len(-1).draw();
                    notReceivedTable.page.len(-1).draw();

                    doc.addFileToVFS('THSarabunNew.ttf', THSarabunFont.regular);
                    doc.addFont('THSarabunNew.ttf', 'THSarabunNew', 'normal');
                    doc.setFont('THSarabunNew');
                    doc.setFontSize(20);
                    doc.text(15, 15, "ข้อมูลสถิติจำนวนสัตว์ที่ได้รับวัคซีนประจำวัน วันที่: " + selectedDay);

                    setTimeout(function() {
                        doc.autoTable({
                            html: '#receivedTable',
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
                                0: {
                                    cellWidth: 'wrap'
                                },
                                1: {
                                    cellWidth: 'wrap'
                                },
                                2: {
                                    cellWidth: 'wrap'
                                },
                                3: {
                                    cellWidth: 'wrap'
                                },
                                4: {
                                    cellWidth: 'wrap'
                                }
                            },
                            autoSize: true
                        });

                        doc.addPage();
                        doc.autoTable({
                            html: '#notReceivedTable',
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
                                0: {
                                    cellWidth: 'wrap'
                                }
                            },
                            autoSize: true
                        });

                        var formattedDate = new Date(selectedDay).toISOString().slice(0, 10); // Convert date to YYYY-MM-DD format
                        doc.save(`ข้อมูลสถิติจำนวนสัตว์ที่ได้รับวัคซีนประจำวัน_${formattedDate}.pdf`);

                        receivedTable.page.len(10).draw();
                        notReceivedTable.page.len(10).draw();
                    }, 1000);
                });


                $('#exportExcel').click(function() {
                    exportToExcel();
                });

                var initialDay = $('#daySelector').val();
                loadTableData(initialDay);
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