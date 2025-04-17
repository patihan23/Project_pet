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
                  <li class="nav-item active">
                      <a href="index.php">
                          <i class="fas fa-home"></i>
                          <p>หน้าแรก</p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="chart.php">
                      <i class="far fa-chart-bar"></i>
                          <p>สถิติ</p>
                      </a>
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