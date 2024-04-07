<?php
session_start();
@$name = $_SESSION['name'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>
    ระบบบริหารและจัดการใบประกาศเข้าร่วมกิจกรรม
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="../assets/css/soft-ui-dashboard.css?v=1.0.7" rel="stylesheet" />
  <script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script>
</head>

<body class="g-sidenav-show  bg-gray-100">
  <?php
  include "layout/navbar.php";
  ?>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur"
      navbar-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">หน้า</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">กิจกรรม</li>
          </ol>
          <h6 class="font-weight-bolder mb-0">กิจกรรม</h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
              <div class="ms-md-auto pe-md-3 d-flex align-items-center">

                <!-- <div class="input-group">
                <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                <input type="text" class="form-control" placeholder="ค้นหา">
                </div> -->

                <div class="input-group">
                  <!-- <span class="input-group-text -btextody">เลือกสถานะของกิจกรรม</i></span> -->
                  <select class="form-select" aria-label="เลือกสถานะ">
                    <option selected value="เลือกสถานะ">เลือกสถานะ</option>
                    <option value="เปิดรับสมัคร">เปิดรับสมัคร</option>
                    <option value="ปิดรับสมัคร">ปิดรับสมัคร</option>
                    <option value="ใกล้ปิดรับสมัคร">ใกล้ปิดรับสมัคร</option>
                  </select>
                </div>
              </div>
              <ul class="navbar-nav justify-content-end">
                <li class="nav-item d-flex align-items-center">
                  <a class="btn font-weight-light bg-gradient-dark mb-0 me-3" href="add_event.php">
                    เพิ่มกิจกรรมบนหน้าเว็บ
                  </a>
                </li>
                <li class="nav-item d-flex align-items-center">
                  <a href="javascript:;" class="nav-link text-body font-weight-bold px-0">
                    <?php
                    if (isset($name)) {
                      echo "<a href='profile.php' class='fa fa-user me-sm-1 px-2'></a>";
                      echo "<a href='profile.php' class='d-sm-inline d-none font-weight-normal'>" . ucfirst($name) . "</a>";
                    } else {
                      echo "<a href='login.php' class='fa fa-user me-sm-1 px-2'></a>";
                      echo "<a href='login.php' class='d-sm-inline d-none font-weight-bolder'>เข้าสู่ระบบ</a>";
                    }
                    ?>
                  </a>
                </li>

                <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                  <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                    <div class="sidenav-toggler-inner">
                      <i class="sidenav-toggler-line"></i>
                      <i class="sidenav-toggler-line"></i>
                      <i class="sidenav-toggler-line"></i>
                    </div>
                  </a>
                </li>
              </ul>
            </div>
          </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
      <div class="col-lg-10 mb-lg-0 mb-4 ">
        <?php
        require_once ('../backend/dbcon.php');
        $status = '';
        $sql = "SELECT * FROM tb_event";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="card mb-4 event-card">';
            echo '<div class="card-body p-3">';
            echo '<div class="row">';
            echo '<div class="col-lg-6 text-center mt-5 mt-lg-0">';
            echo '<div class="border-radius-img h-100">';
            echo '<img src="../assets/img/shapes/waves-white.svg" class="position-absolute h-100 w-50 top-0 d-lg-block d-none" alt="waves">';
            echo '<div class="position-relative d-flex align-items-center justify-content-center ">';
            echo '<img src="' . $row['event_banner'] . '" width="auto" >';
            $event_reg_to = strtotime($row['event_reg_to']);
            $current_date = time();
            // หาความต่างระหว่างวันที่ปัจจุบันกับวันที่ event_reg_to (ในหน่วยวัน)
            $diff_days = ($event_reg_to - $current_date) / (60 * 60 * 24);
            if (($row['status'] === 'Approved' && $diff_days <= 7) || $row['status'] === 'Approved') {
                if ($diff_days <= 7) {
                    $status = 'ใกล้ปิดรับสมัคร';
                    echo '<div class="text-box" style="background-color: #ea0606;">';
                    echo '<div >'. $status . '</div>';
                } else {
                    $status = 'เปิดรับสมัคร';
                    echo '<div class="text-box" style="background-color: #4CAF50;">';
                    echo '<div >'. $status . '</div>';
                }
            } elseif ($row['status'] === 'Closed') {
                $status = 'ปิดรับสมัคร';
                echo '<div class="text-box" style="background-color: #8392A8;">';
                echo '<div >'. $status . '</div>';
            } 
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '<div class="col-lg-5">';
            echo '<div class="d-flex flex-column h-100">';
            echo '<a class="font-weight-bold text-info text-gradient lead" href="event_detail.php?id=' . $row['activity_id'] . '">' . $row['event_name'] . '</a>';
            echo '<p class="mb-5">' . $row['event_detail_short'] . '</p>';
            echo '<a class="text-body text-sm font-weight-bold mb-0 icon-move-right mt-auto" href="event_detail.php?id=' . $row['activity_id'] . '">';
            echo 'รายละเอียด';
            echo '<i class="fas fa-arrow-right text-sm ms-1" aria-hidden="true"></i>';
            echo '</a>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';            
          }
        } else {
          echo "ไม่พบข้อมูล";
        }

        ?>

      </div>
    </div>
    </div>
    </div>
    </div>
  </main>

  <!--   Core JS Files   -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/soft-ui-dashboard.min.js?v=1.0.7"></script>
</body>

</html>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    const selectElement = document.querySelector('.form-select');
    selectElement.addEventListener('change', (event) => {
      const selectedStatus = event.target.value;
      const eventCards = document.querySelectorAll('.event-card');
      eventCards.forEach((card) => {
        const cardStatus = card.querySelector('.text-box div').innerText.trim();
        if (selectedStatus === 'เลือกสถานะ' || cardStatus === selectedStatus) {
          card.style.display = 'block';
        } else {
          card.style.display = 'none';
        }
      });
    });
  });
</script>
