<style>
    .result-container {
        overflow-x: auto;
        width: 100%;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    table th,
    table td {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: left;
        white-space: nowrap;
    }

    table th {
        background-color: #f2f2f2;
    }

    table tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    table tr:hover {
        background-color: #e0e0e0;
    }

    .card-body.result-container {
        max-width: 100%;
    }
</style>

<?php
session_start();
include('config.php');
?>
<?php include 'include/navbar.php'; ?>
<!-- Page content-->
<section class="py-5">
    <div class="container px-5">
        <!-- Contact form-->
        <div class="bg-light rounded-4 py-5 px-4 px-md-5">
            <div class="text-center mb-5">
                <div class="feature bg-primary bg-gradient-primary-to-secondary text-white rounded-3 mb-3"><i class="bi bi-search"></i></div>
                <h1 class="fw-bolder">ตรวจสอบการฉีดวัคซีนสัตว์เลี้ยง</h1>
                <p class="lead fw-normal text-muted mb-0"></p>
            </div>
            <div class="row gx-5 justify-content-center">
                <div class="col-lg-12 col-xl-10">
                    <!-- Search form-->
                    <div id="m1" class="container mt-5">
                        <div class="card col-12">
                            <div class="card-header">
                                <h4>ค้นหาข้อมูล</h4>
                            </div>
                            <div class="card-body">
                                <form id="search-form" method="post" action="search.php">
                                    <div class="mb-3">
                                        <label for="search_query" class="form-label">ค้นหา</label>
                                        <input type="text" class="form-control" id="search_query" name="search_query" placeholder="ชื่อเจ้าของสัตว์เลี้ยง หรือ ชื่อสัตว์เลี้ยง">
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <button type="submit" class="btn btn-primary">ค้นหา</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Result container-->
                    <div class="container mt-4">
                        <div class="card">
                            <div class="card-body result-container">
                                <!-- ผลการค้นหาจะแสดงที่นี่ -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const searchForm = document.getElementById("search-form");
        const resultContainer = document.querySelector(".result-container");

        searchForm.addEventListener("submit", function(event) {
            event.preventDefault();

            const searchQuery = document.getElementById("search_query").value;

            const xhr = new XMLHttpRequest();
            xhr.open("POST", "search.php");

            xhr.onload = function() {
                if (xhr.status === 200) {
                    resultContainer.innerHTML = xhr.responseText;
                } else {
                    resultContainer.innerHTML = '<div class="alert alert-danger">เกิดข้อผิดพลาดในการค้นหา</div>';
                }
            };

            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("search_query=" + encodeURIComponent(searchQuery));
        });
    });
</script>
<!-- Footer-->
<?php include 'include/footer.php'; ?>
</body>

</html>
