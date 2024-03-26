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
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400&display=swap" rel="stylesheet">
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

  <!-- Include the specific styles for the calendar-17 -->
  <!-- <link rel="stylesheet" href="calendar/calendar-17/fonts/icomoon/style.css"> -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="calendar/calendar-04/css/style.css">
</head>

<body class="g-sidenav-show  bg-gray-100">
  <?php
    include "layout/navbar.php";
    require_once('../backend/dbcon.php');
  ?>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Topbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">หน้า</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">หน้าหลัก</li>
          </ol>
          <h6 class="font-weight-bolder mb-0">หน้าหลัก</h6>
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
    <!-- End Topbar -->

      <div class="row mt-4">
          <!-- Slider กิจกรรม -->
          <div class="carousel-container">
            <div id="carouselCaptions" class="carousel slide col-lg-12 mb-lg-0 mb-4" data-bs-ride="carousel">
              <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
              </div>
              <div class="carousel-inner">
              <?php
                $sql = "SELECT event_banner 
                        FROM tb_event 
                        WHERE event_reg_to <= CURDATE() 
                        AND event_reg_to >= DATE_SUB(CURDATE(), INTERVAL 10 DAY)";
                $result = mysqli_query($conn, $sql);

                $active = false; // ตั้งค่าให้ active เป็น false ที่นี่

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $banner_path = $row["event_banner"];
                ?>
                      <div class="carousel-item <?php echo ($active ? 'active' : ''); ?>">
                        <img src="<?php echo $banner_path; ?>" class="d-block w-100 custom-rounded" alt="Event Banner">
                      </div>
                <?php
                        $active = true; // กำหนดให้ active เป็น true เมื่อเจอแบนเนอร์แรก
                    }
                } else {
                    echo "ไม่พบข้อมูลแบนเนอร์ตามเงื่อนไขที่กำหนด";
                }
              ?>


                  <!-- <div class="carousel-item active">
                    <img  src="../assets/img/upload_event/banner/1034.png" class="d-block w-100 custom-rounded" alt="Image 1">
                  </div>
                  <div class="carousel-item">
                    <img src="../assets/img/upload_event/banner/1032.png" class="d-block w-100 custom-rounded" alt="Image 2">
                  </div>
                  <div class="carousel-item">
                    <img  src="../assets/img/upload_event/banner/1033.png" class="d-block w-100 custom-rounded" alt="Image 3">
                  </div> -->
              </div>

              <button class="carousel-control-prev" type="button" data-bs-target="#carouselCaptions" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
              </button>

              <button class="carousel-control-next" type="button" data-bs-target="#carouselCaptions" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
              </button>
          </div>
        </div>

        <!-- ประชาสัมพันธ์ -->
        <div class="col-lg-5">
          <div class="card h-100 p-3">
            <div class="overflow-hidden position-relative border-radius-lg bg-cover h-100" style="background-image: url('../assets/img/3.jpg');">
              <div class="card-body position-relative z-index-1 d-flex flex-column h-100 p-3">
                <h5 class="text-dark font-weight-bolder mb-4 pt-2">ข่าวประชาสัมพันธ์</h5>
                <p class="text-dark mb-5">ประกาศปรับปรุงระบบ VPN เพื่อเพิ่มความมั่นคงปลอดภัย (ดาวน์โหลดใบประกาศชุดใหม่)</p>
                <a class="text-dark text-sm font-weight-bold mb-0 icon-move-right mt-auto" href="https://www.src.ku.ac.th/services/File_news/2567/Jan/KU0111_161059.jpg" target="_blank">
                  รายละเอียด
                  <i class="fas fa-arrow-right text-sm ms-1" aria-hidden="true" ></i>
                </a>
              </div>
            </div>
          </div>
        </div>

      <!-- Calendar -->
      <?php
        require_once('../backend/dbcon.php');
        $sql = "SELECT event_date_from and event_date_to FROM tb_event";
        $result = mysqli_query($conn, $sql);
      ?>
        <div class="col-lg-4 mb-lg-0 mb-4">
          <div class="row">
              <div class="calendar-container">
                <div class="calendar"> 
                  <div class="year-header"> 
                    <span class="left-button fa fa-chevron-left" id="prev"> </span> 
                    <span class="year" id="label"></span> 
                    <span class="right-button fa fa-chevron-right" id="next"> </span>
                  </div> 
                  <table class="months-table w-100"> 
                    <tbody>
                      <tr class="months-row">
                        <td class="month">Jan</td> 
                        <td class="month">Feb</td> 
                        <td class="month">Mar</td> 
                        <td class="month">Apr</td> 
                        <td class="month">May</td> 
                        <td class="month">Jun</td> 
                        <td class="month">Jul</td>
                        <td class="month">Aug</td> 
                        <td class="month">Sep</td> 
                        <td class="month">Oct</td>          
                        <td class="month">Nov</td>
                        <td class="month">Dec</td>
                      </tr>
                    </tbody>
                  </table> 
                  
                  <table class="days-table w-100"> 
                    <td class="day">Sun</td> 
                    <td class="day">Mon</td> 
                    <td class="day">Tue</td> 
                    <td class="day">Wed</td> 
                    <td class="day">Thu</td> 
                    <td class="day">Fri</td> 
                    <td class="day">Sat</td>
                  </table> 
                  <div class="frame"> 
                    <table class="dates-table w-100"> 
                      <tbody class="tbody">             
                      </tbody> 
                    </table>
                  </div> 
                  <!-- <button class="button" id="add-button">Add Event</button> -->
                </div>
              </div> 
          </div>

          <!-- Include specific scripts for the calendar-17 -->
          <script src="calendar/calendar-04/js/jquery.min.js"></script>
          <script src="calendar/calendar-04/js/popper.js"></script>
          <script src="calendar/calendar-04/js/bootstrap.min.js"></script>
          <script src="calendar/calendar-04/js/main.js"></script>
          <script src="http://localhost/project/pages/getEventCalendar.php"></script>
        </div>
      <!-- end calendar -->

        <!-- start ข้อมูลกิจกรรมจาก calendar -->
        <div class="col-lg-7">
          <div class="card z-index-2">
            <div class="card pb-13">
              <ul class="list-group card-body">
                <!-- วนข้อมูลกิจกรรมลงหน้าเว็บ -->
                <?php
                    require_once('../backend/dbcon.php');

                    $sql = "SELECT * FROM tb_event where status = 'Approved'";
                    $result = mysqli_query($conn, $sql);

                    // ตรวจสอบว่ามีข้อมูลในฐานข้อมูลหรือไม่
                    if (mysqli_num_rows($result) > 0) {
                        // วนลูปเพื่อดึงข้อมูลและแสดงในแท็ก <li>
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<li class="list-group-item border-0 d-flex p-4 mb-2 glass">';
                            echo '<div class="d-flex flex-column">';
                            echo '<h6 class="mb-3 text-sm">' . $row['event_name'] . '</h6>';
                            echo '<span class="mb-2 text-xs">' . $row['event_location'] . '</span>';
                            echo '<span class="text-dark mb-2 text-xs font-weight-bold"><i class="far fa-regular fa-clock me-2"></i>' . $row['event_date_from'] . ' <span class="text-dark ms-sm-2 font-weight-bold">' . $row['event_date_to'] . '</span></span>';
                            echo '</div>';
                            echo '<div class="ms-auto text-end">';
                            echo '<a class="btn btn-link text-dark px-3 mb-3" ><i class="fas fa-solid fa-chevron-right text-dark me-2"></i></a>';
                            echo '</div>';
                            echo '</li>';
                        }
                    } else {
                        echo "ไม่พบข้อมูล";
                    }
                    ?>
              </ul>
            </div>
          </div>
        </div>
  </main>



  <!--   Core JS Files   -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/chartjs.min.js"></script>

  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/soft-ui-dashboard.min.js?v=1.0.7"></script>
</body>

</html>