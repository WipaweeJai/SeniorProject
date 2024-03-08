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

<body class="g-sidenav-show bg-gray-100">
<?php
  include "navbar.php";
  require_once('../backend/dbcon.php');
?>
  <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">หน้า</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">กิจกรรม</li>
          </ol>
          <h6 class="font-weight-bolder mb-0">รายละเอียดกิจกรรม</h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
          <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            <div class="input-group">
              <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
              <input type="text" class="form-control" placeholder="ค้นหา">
            </div>
          </div>
          <ul class="navbar-nav  justify-content-end">
            <li class="nav-item d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body font-weight-bold px-0">
                <i class="fa fa-user me-sm-1"></i>
                <span class="d-sm-inline d-none">เข้าสู่ระบบ</span>
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
    <div class="container-fluid">
      <?php
        if(isset($_GET['id'])) {
          $activity_id = $_GET['id'];
          $sql = "SELECT * FROM tb_event WHERE activity_id = '$activity_id'";
          $result = mysqli_query($conn, $sql);
          if($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            // ดึงค่า event_banner จาก $row
            $event_banner = $row['event_banner'];
            // สร้าง HTML tag โดยใช้ค่าของ $event_banner
            echo '<div class="page-header min-height-500 border-radius-xl mt-4" style="background-image: url(\'' . $event_banner . '\'); background-position-y: 50%;"></div>';
          }
        }
        ?>
        <div class="card card-body blur shadow-blur mx-4 mt-n6 overflow-hidden">
          <div class="row gx-4">
            <div class="col-auto my-auto">
              <div class="h-100">
                <?php
                  if(isset($_GET['id'])) {
                    $activity_id = $_GET['id'];
                    $sql = "SELECT * FROM tb_event WHERE activity_id = '$activity_id'";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                  echo '<h5 class="mb-1">' . $row['event_name'] . '</h5>';
                  }
                ?>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
              <div class="nav-wrapper position-relative end-0">
                <ul class="nav nav-pills nav-fill p-1 bg-transparent" role="tablist">
                  <li class="nav-item"  style="padding-right: 10px;">
                    <a class="nav-link mb-0 px-0 py-2 active" href="form_cert_zip.php?id=<?php echo $activity_id; ?>" role="tab">
                        <i class="far fa-regular fa-paper-plane"></i>
                        <span class="ms-1">อัพโหลดใบประกาศ</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link mb-0 px-0 py-2 active "  href="https://www.camphub.in.th/basic-python-programming-for-health-data-science/" target ="_blank" role="tab">
                      <i class="far fa-regular fa-paper-plane"></i>
                      <span class="ms-1">ลงทะเบียน</span>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>

    <div class="container-fluid py-4">
      <div class="row">
        <div>
          <div class="card mb-4">
            <div class="card-header pb-0 p-3">
              <p class="text-dark">ข้อมูลเบื้องต้นของกิจกรรม</p>
            </div>
            <div class="card-body p-3">
              <?php
                if(isset($_GET['id'])) {
                  $activity_id = $_GET['id'];
                  
                  $sql = "SELECT * FROM tb_event WHERE activity_id = '$activity_id'";
                  $result = mysqli_query($conn, $sql);
                  $row = mysqli_fetch_assoc($result);
                  
                  echo '<p class="text-uppercase text-body text-sm font-weight-bolder ">รูปแบบกิจกรรม :
                    <span class="text-dark ms-sm-2 font-weight-bold">' . $row['type'] . '</span></p>';
                  echo '<p class="text-uppercase text-body text-sm font-weight-bolder ">วันที่จัดกิจกรรม : 
                    <span class="text-dark ms-sm-2 font-weight-bold">' . $row['event_date_from'] . '</span></p>';
                  echo '<p class="text-uppercase text-body text-sm font-weight-bolder ">วันที่รับสมัครวันสุดท้าย : 
                    <span class="text-dark ms-sm-2 font-weight-bold">' . $row['event_reg_to'] . '</span></p>';
                  echo '<p class="text-uppercase text-body text-sm font-weight-bolder ">จำนวนที่รับ : 
                    <span class="text-dark ms-sm-2 font-weight-bold">' . $row['event_number'] . '</span></p>';
                  echo '<p class="text-uppercase text-body text-sm font-weight-bolder ">ค่าใช้จ่าย : 
                    <span class="text-dark ms-sm-2 font-weight-bold">' . $row['event_fee'] . '</span></p>';
                  echo '<p class="text-uppercase text-body text-sm font-weight-bolder ">คุณสมบัติ (ระดับการศึกษา/ช่วงอายุ/อื่นๆ) : 
                    <span class="text-dark ms-sm-2 font-weight-bold">' . $row['requirements'] . '</span></p>';
                  echo '<p class="text-uppercase text-body text-sm font-weight-bolder ">สถานที่จัดกิจกรรม : 
                    <span class="text-dark ms-sm-2 font-weight-bold">' . $row['event_location'] . '</span></p>';
                  echo '<div class="divider"></div>';
                  echo '<img src="' . $row['event_poster'] . '" width="40%" >';
                  echo '<p class="mb-5">' . $row['event_detail_full'] . '</span></p>';
                }
              ?>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
  
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