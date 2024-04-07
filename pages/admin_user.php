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
            <li class="breadcrumb-item text-sm text-dark" aria-current="page">จัดการบัญชีผู้ใช้งาน</li>
          </ol>
          <h6 class="text-dark font-weight-bolder ms-2">จัดการบัญชีผู้ใช้งาน</h6>
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
      <div class="page-header min-height-300 border-radius-xl mt-4 " style="background-image: url('../assets/img/7.jpg'); background-position-y: 50%;"></div>
      <div class="card card-body glass mx-4 mt-n6 overflow-hidden">
        <div class="row gx-4">
          <div class="col-auto my-auto">
          <?php
            echo '<div class="h-100">';
            if(isset($_GET['id'])) {
                $user_id = $_GET['id'];
                $sql = "SELECT * FROM tb_user WHERE user_id = '$user_id'";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                    echo '<div class="h-100">';
                    echo '<h5 class="mb-1">' .$row['name']. '</h5>';
                    if ($row['status'] == 'student') {
                        echo "<p class='mb-0 font-weight-bold text-sm'>นิสิต</p>";
                    } elseif ($row['status'] == 'external') {
                        echo "<p class='mb-0 font-weight-bold text-sm'>บุคคลภายนอก</p>";
                    } elseif ($row['status'] == 'admin') {
                        echo "<p class='mb-0 font-weight-bold text-sm'>Admin</p>";
                    }
                    echo '</div>';
            } 
            echo '</div>';
          ?>
          </div>
          <div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
              <!-- <div class="nav-wrapper position-relative end-0">
                <ul class="nav nav-pills nav-fill p-1 bg-transparent justify-content-end" role="tablist">
                    <button id="deleteBtn" class="btn mb-0 bg-outline-dark " href="#" >
                      <i class="far fa-trash-alt"></i>
                      <span class="ms-1">ลบบัญชีผู้ใช้งาน</span>
                  </button>
                </ul>
              </div> -->
            </div>
        </div>
      </div>
    </div>
    <div class="container-fluid py-4">
      <form id="admin_certtemp_form" method="post" enctype="multipart/form-data">
        <div class="row">
          <div class="col-12">
            <div class="card h-100">
              <div class="card-header pb-0 p-3">
                <h6 class="mb-0">ข้อมูลส่วนตัว</h6>
              </div>
              <div class="card-body p-3">
                <ul class="list-group">
                  <?php
                    if(isset($_GET['id'])) {
                    $user_id = $_GET['id'];
                    $sql = "SELECT * FROM tb_user WHERE user_id = '$user_id'";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    
                    echo '<li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">รหัสบัญชีผู้ใช้ :</strong> &nbsp;' . $row['user_id'] . '</li>';
                    echo '<li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">ชื่อ-นามสกุล :</strong> &nbsp;' . $row['name'] . '</li>';
                    echo '<li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Email :</strong> &nbsp;' . $row['email'] . '</li>';
                    echo '<li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Password :</strong> &nbsp;' . $row['password'] . '</li>';
                    }
                  ?>

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
                  $activity_id = $_GET['id'];
                  // ค้นหา user_id โดยใช้ชื่อผู้ใช้จาก session
                  $sql_user_id = "SELECT user_id FROM tb_user WHERE user_id = '$user_id'";
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
                        $user_id1 = substr($user_id, 1);
                        $image_url = "http://localhost/project/assets/img/zip/{$activity_id}/modified/{$user_id1}.png";
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
                        <a href="<?php echo $image_url; ?>" download>
                          <button type="button" class="btn btn-outline-info btn-sm mb-0">ดาวน์โหลดใบประกาศ</button>
                        </a>
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
        <!-- ปุ่มส่งข้อมูลกิจกรรม -->
        <div class="col-12 text-center mt-3">
          <button class="btn bg-gradient-dark mb-0 text-lg" type="submit" id="btn_edit_user"><i class="fas fa-plus"></i>&nbsp;&nbsp;บันทึก</button>
          <button class="btn bg-gradient-danger mb-0 text-lg" type="submit" id="btn_delete_user"><i class="far fa-trash-alt"></i>&nbsp;&nbsp;ลบ</button>
        </div>
      </form>
    </div>
  </div>
</body>

</html>

<!-- เมื่อกดปุ่มลบบัญชีผู้ใช้งาน -->
<script>
 document.getElementById("btn_delete_user").addEventListener("click", function(event) {
    event.preventDefault(); // ป้องกันการโหลดหน้าเว็บหลังจากการกดปุ่ม

    var confirmation = confirm("ต้องการลบบัญชีผู้ใช้ถาวรหรือไม่");
    if (confirmation) {
      var user_id = '<?php echo $_GET['id']; ?>'; // ดึงค่า user_id จาก URL parameters โดยใช้ PHP เพื่อแปลงเป็นสตริงของ JavaScript

      var xhr = new XMLHttpRequest();
      xhr.open("POST", "deleteAccount.php", true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
          alert("ลบบัญชีผู้ใช้เสร็จสิ้น");
          // window.location.href = "admin_user.php"; // โดยปกติก็ควรเป็น "admin_user.php" หรือหน้าที่ต้องการให้เปิดหลังจากการลบ
        }
      };
      xhr.send("user_id=" + user_id);
    }
  });

</script>