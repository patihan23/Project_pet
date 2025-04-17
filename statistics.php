<?php
session_start();
include('config.php');

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Pet</title>
    <link rel="icon" type="image/x-icon" href="assets/Orange White Creative Fox P Letter Startup Logo.png" />
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styles.css"> <!-- Ensure this file exists -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <?php include 'include/navbar.php'; ?>

    <section class="py-5">
    <div class="container px-5 mb-5">
        <div class="text-center mb-5">
        <div class="feature bg-primary bg-gradient-primary-to-secondary text-white rounded-3 mb-3"><i class="bi bi-bar-chart"></i></div>
            <h1 class="display-5 fw-bolder mb-0"><span class="text-gradient d-inline">สถิติประจำปี</span></h1>
        </div>
    

    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">ข้อมูลสถิติจำนวนสัตว์ในระบบประจำปี เลือกปี :</div>
                            <select id="yearSelector1" class="form-control">
                                <?php foreach ($years as $year) {
                                    $buddhistYear = $year + 543; // Convert AD to BE year
                                ?>
                                    <option value="<?= $year ?>">ปี : <?= $buddhistYear ?> </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="barChart1"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">ข้อมูลสถิติจำนวนสัตว์ที่ได้รับวัคซีนประจำปี เลือกปี :</div>
                            <select id="yearSelector2" class="form-control">
                                <?php foreach ($years as $year) {
                                    $buddhistYear = $year + 543; // Convert AD to BE year
                                ?>
                                    <option value="<?= $year ?>">ปี : <?= $buddhistYear ?> </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="barChart2"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </section>

    <?php include 'include/footer.php'; ?>

    <script>
        $(document).ready(function() {
            function loadChartData(year, chartId, url) {
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        year: year
                    },
                    dataType: 'json',
                    success: function(response) {
                        var labels = response.labels;
                        var data = response.data;
                        var colors = response.colors;

                        var ctx = document.getElementById(chartId).getContext('2d');
                        if (window[chartId] instanceof Chart) {
                            window[chartId].destroy();
                        }
                        window[chartId] = new Chart(ctx, {
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
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Error fetching data:', textStatus, errorThrown);
                    }
                });
            }

            // Load initial data for both charts
            var initialYear1 = $('#yearSelector1').val();
            loadChartData(initialYear1, 'barChart1', 'fetch_chart_data.php');

            var initialYear2 = $('#yearSelector2').val();
            loadChartData(initialYear2, 'barChart2', 'fetch_vaccine_chart_data.php');

            // Update chart 1 when year changes
            $('#yearSelector1').change(function() {
                var year = $(this).val();
                loadChartData(year, 'barChart1', 'fetch_chart_data.php');
            });

            // Update chart 2 when year changes
            $('#yearSelector2').change(function() {
                var year = $(this).val();
                loadChartData(year, 'barChart2', 'fetch_vaccine_chart_data.php');
            });
        });
    </script>
</body>

</html>

<?php
// Close the database connection
if (isset($conn) && $conn) {
    mysqli_close($conn);
}
?>
