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

<body class="g-sidenav-show bg-gray-100">
<?php
    include "layout/navbar.php";
?>
<div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg bg-transparent shadow-none position-absolute px-4 w-100 z-index-2">
      <div class="container-fluid py-1">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 ps-2 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="text-dark opacity-5">หน้า</a></li>
            <li class="breadcrumb-item text-sm text-dark" aria-current="page">โปรไฟล์</li>
          </ol>
          <h6 class="text-dark font-weight-bolder ms-2">โปรไฟล์</h6>
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
    <div class="container-fluid">
      <div class="page-header min-height-300 border-radius-xl mt-4 " style="background-image: url('../assets/img/7.jpg'); background-position-y: 50%;">
      </div>
      <div class="card card-body glass mx-4 mt-n6 overflow-hidden">
        <div class="row gx-4">
          <div class="col-auto my-auto">
            <div class="h-100">
              <?php
                require_once('../backend/dbcon.php');
                $name = $_SESSION['name'];
                $status = "";
                $user_id = "";
                $sql = "SELECT * FROM tb_user WHERE name ='$name'";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    $name = $row['name'];
                    $email = $row['email'];
                    $status = $row['status'];
                    $tel = $row['tel'];
                    $user_id = $row['user_id'];
                }
                ?>
                
                <div class="h-100">
                    <h5 class='mb-1'><?php echo $name ?></h5>
                    <?php
                    if ($status == 'student') {
                        echo "<p class='mb-0 font-weight-bold text-sm'>นิสิต</p>";
                    } elseif ($status == 'external') {
                        echo "<p class='mb-0 font-weight-bold text-sm'>บุคคลภายนอก</p>";
                    } elseif ($status == 'admin') {
                        echo "<p class='mb-0 font-weight-bold text-sm'>Admin</p>";
                    }                    
                    ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card h-100">
            <div class="card-header pb-0 p-3">
              <h6 class="mb-0">ข้อมูลส่วนตัว</h6>
            </div>
            <div class="card-body p-3">
              <ul class="list-group">
                <?php
                    if ($status == 'student') {
                      echo '<li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">บัญชีนนทรี :</strong> &nbsp; ' . $user_id . '</li>';
                    }
                ?>
                <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">ชื่อ-นามสกุล :</strong> &nbsp; <?php echo $name ?></li>
                <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Email :</strong> &nbsp; <?php echo $email; ?></li>
                <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">เบอร์โทรศัพท์ :</strong> &nbsp; <?php echo $tel; ?></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-12 mt-4">
          <div class="card mb-4">
            <div class="card-header pb-0 p-3">
              <h6 class="mb-1">รายการใบประกาศ</h6>
            </div>
            <div class="card-body p-3">
              <div class="row">
              <?php
                $name = $_SESSION['name'];
                // ค้นหา user_id โดยใช้ชื่อผู้ใช้จาก session
                $sql_user_id = "SELECT user_id FROM tb_user WHERE name = '$name'";
                $result_user_id = mysqli_query($conn, $sql_user_id);

                // ตรวจสอบว่ามีผลลัพธ์จากคำสั่ง SQL
                if (mysqli_num_rows($result_user_id) > 0) {
                  // ดึงข้อมูล user_id จากผลลัพธ์
                  $row_user_id = mysqli_fetch_assoc($result_user_id);
                  $user_id = $row_user_id['user_id'];

                  // คำสั่ง SQL เพื่อดึงข้อมูลกิจกรรมที่เกี่ยวข้องกับผู้ใช้นี้
                  $sql_event = "SELECT tb_certificate.*, tb_event.*
                                FROM tb_certificate
                                INNER JOIN tb_event ON tb_certificate.activity_id = tb_event.activity_id
                                WHERE tb_certificate.user_id = '$user_id'";
                  $result_event = mysqli_query($conn, $sql_event);

                  // ตรวจสอบว่ามีข้อมูลกิจกรรมหรือไม่
                  if (mysqli_num_rows($result_event) > 0) {
                    // วนลูปเพื่อแสดงข้อมูลทุกกิจกรรม
                    while ($row = mysqli_fetch_assoc($result_event)) {
                      $activity_id = $row['activity_id'];
                      $cert_Ref = $row['cert_Ref'];
                      $event_name = $row['event_name'];
                      $event_banner = $row['event_banner'];
                      $image_url = "http://localhost/project/assets/img/zip/{$activity_id}/modified/{$cert_Ref}.png";
              ?>

              <div class="col-xl-3 col-md-6 mb-xl-0 mb-4">
                <div class="card card-blog card-plain">
                  <div class="position-relative">
                    <a class="d-block shadow-xl border-radius-xl">
                      <img src="<?php echo $event_banner; ?>" alt="img-blur-shadow" class="img-fluid shadow border-radius-xl">
                    </a>
                  </div>

                  <div class="card-body px-1 pb-0">
                    <h6><?php echo $event_name; ?></h6>
                    <div class="d-flex align-items-center justify-content-between">
                      <button type="button" class="btn btn-outline-info btn-sm mb-0" onclick="window.open('<?php echo $image_url; ?>', '_blank')">
                        รายละเอียด
                      </button>
                    </div>
                  </div>
                </div>
              </div>

              <?php
                    }
                  } else {
                    // ไม่พบข้อมูลกิจกรรม
                    echo "ไม่พบข้อมูลกิจกรรม";
                  }
                } else {
                  // ไม่พบผู้ใช้ในฐานข้อมูล
                  echo "ไม่พบผู้ใช้ในระบบ";
                }
              ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>