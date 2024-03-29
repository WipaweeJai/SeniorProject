<?php 
  session_start();
  $name = $_SESSION['name'];
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
  <!-- Nepcha Analytics (nepcha.com) -->
  <!-- Nepcha is a easy-to-use web analytics. No cookies and fully compliant with GDPR, CCPA and PECR. -->
  <script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script>
</head>

<body class="g-sidenav-show  bg-gray-100">
<?php
  include "layout/navbar.php";
  require_once('../backend/dbcon.php');
?>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">หน้า</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">อัปโหลดไฟล์ใบประกาศ</li>
          </ol>
          <h6 class="font-weight-bolder mb-0">อัปโหลดไฟล์ใบประกาศ</h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <ul class="ms-md-auto pe-md-3 d-flex align-items-center navbar-nav  justify-content-end">
            <li class="nav-item d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body font-weight-bold px-0">
                <?php
                  if(isset($name)) {
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
      <?php
        if(isset($_GET['id'])) {
          $activity_id = $_GET['id'];
          $sql = "SELECT * FROM tb_event WHERE activity_id = '$activity_id'";
          $result = mysqli_query($conn, $sql);
          if($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $event_banner = $row['event_banner'];
            echo '<div class="page-header min-height-300 border-radius-xl mt-4" style="background-image: url(\'' . $event_banner . '\'); background-position-y: 50%;">';
          }
        }
      ?>
      </div>

      <div class="row">
        <form action="extract_zip.php" method="post" enctype="multipart/form-data">
            <div class="container-fluid py-4">
                <div class="row">
                    <div class="card mb-4">
                      <?php
                        require_once('../backend/dbcon.php');
                        if(isset($_GET['id'])) {
                            $activity_id = $_GET['id'];
                            $sql = "SELECT event_name FROM tb_event WHERE activity_id = '$activity_id'";
                            $result = mysqli_query($conn, $sql);
                            if(mysqli_num_rows($result) > 0) {
                                $row = mysqli_fetch_assoc($result);
                                $event_name = $row['event_name'];
                            }
                        }
                      ?>
                        <div class="card-body p-3">
                            <p class="text-dark text-lg font-weight-normal">
                                ชื่อกิจกรรม
                                <span class="text-dark ms-sm-2 font-weight-bold">
                                    <input class="form-control custom-width" type="text" id="event_name" placeholder="กรุณาพิมพ์ชื่อกิจกรรม" maxlength="60" name="event_name" value="<?php echo $event_name; ?>" readonly>
                                </span>
                            </p>
                            <div class="divider"></div>
                            <a class="btn bg-gradient-success mb-3 text-sm font-weight-normal" href="../assets/img/manual/manual.pdf" target="_blank">
                                คู่มือรายละเอียดการอัปโหลดไฟล์
                            </a>

                            <p class="text-dark text-lg font-weight-normal ">
                              อัปโหลดไฟล์รายชื่อผู้ผ่านกิจกรรม *
                              <a class="btn bg-gradient-info btn-sm mt-3 font-weight-normal" onclick="openModal('myModal1')">ข้อกำหนด</a>
                              <div id="myModal1" class="modal1">
                                <div class="modal1-content-wrapper">
                                  <img class="modal1-content" id="img01" src="../assets/img/activity6.png" alt="">
                                  <span class="close" onclick="closeModal('myModal1')">&times;</span>
                                </div>
                              </div>
                              <div class="mb-3">
                                  <p class="text-sm font-weight-light ">ไฟล์ Excel ขนาดไม่เกิน 5 MB</p>
                                  <input class="form-control custom-width" type="file" id="excel_file" name="excel_file" require>
                              </div>
                            </p>

                            <p class="text-dark text-lg font-weight-normal ">
                              อัปโหลดไฟล์ใบประกาศเข้าร่วมกิจกรรม *
                              <a class="btn bg-gradient-info btn-sm mt-3 font-weight-normal" onclick="openModal('myModal2')">ข้อกำหนด</a>
                              <div id="myModal2" class="modal1">
                                <div class="modal1-content-wrapper">
                                  <img class="modal1-content" id="img02" src="../assets/img/activity7.png" alt="">
                                  <span class="close" onclick="closeModal('myModal2')">&times;</span>
                                </div>
                              </div>
                              <div class="mb-3">
                                <p class="text-sm font-weight-light ">ไฟล์ zip ขนาดไม่เกิน 5 MB</p>
                                <input class="form-control custom-width" type="file" id="zip_file" name="zip_file" require>
                              </div>
                            </p>

                        </div>
                    </div>
                </div>
                <!-- ปุ่มอัปโหลดไฟล์ -->
                <div class="col-6 text-end">
                <button class="btn bg-gradient-dark mb-0 text-lg" id="btn_add_event" name="upload_btn">
                  <i class="fas fa-plus"></i>&nbsp;&nbsp;อัปโหลดไฟล์
                </button>
                </div>
            </div>
        </form>
    
       
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

<script>

document.getElementById("btn_add_event").addEventListener("click", function(event) {
var excelFile = document.getElementById("excel_file").value;
var zipFile = document.getElementById("zip_file").value;

if(excelFile === "" || zipFile === "") {
    event.preventDefault();
    alert("กรุณากรอกข้อมูลไฟล์รายชื่อผู้ผ่านกิจกรรมและไฟล์ใบประกาศกิจกรรม");
}
});

function openModal(modalId) {
  var modal = document.getElementById(modalId);
  modal.style.display = "block";
}

function closeModal(modalId) {
  var modal = document.getElementById(modalId);
  modal.style.display = "none";
}


</script>

</body>
</html>
