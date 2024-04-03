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
  require_once('../backend/dbcon.php');
?>
  <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">หน้า</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">จัดการกิจกรรม</li>
          </ol>
          <h6 class="font-weight-bolder mb-0">จัดการรายชื่อและใบประกาศเข้าร่วมกิจกรรม</h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
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
    <div class="container-fluid " >
      <?php
        if(isset($_GET['id'])) {
        $activity_id = $_GET['id'];
        $sql = "SELECT * FROM tb_event WHERE activity_id = '$activity_id'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);  
        }
      ?>
      <!-- รูปภาพแบนเบอร์ของกิจกรรมยังไม่แก้ เพราะติดปัญหาการอัปโหลดภาพลงอยู่ -->
        <div class="page-header min-height-500 border-radius-xl mt-4" style="background-image: url('<?php echo $row['event_banner']; ?>'); background-position-y: 50%;">
        </div>
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
                      $event_name = $row['event_name'];
                  }
                ?>
                <div class="h-100">
                    <h5 class='mb-1'>รหัสกิจกรรม : <?php echo $activity_id; ?></h5>
                    <h5 class='mb-1'><?php echo $event_name; ?></h5>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    <div class="container-fluid py-4">
      <div class="row" >
        <div>
          <div class="card mb-4">
            <div class="card-header pb-0 p-3">
              <p class="text-dark">ข้อมูลเบื้องต้นของกิจกรรม</p>
            </div>
            <div class="card-body p-3">
                <form id="admin_certtemp_form" method="post" enctype="multipart/form-data">
                    <?php
                        if(isset($_GET['id'])) {
                        $activity_id = $_GET['id'];
                        
                        $sql = "SELECT * FROM tb_certificate_template WHERE activity_id = '$activity_id'";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);
                        
                        echo '<p class="text-uppercase text-body text-sm font-weight-bolder ">ชื่อกิจกรรม : 
                            <input class="form-control custom-width" type="text" id="event_name" value="' . $row['event_name'] . '" readonly>
                            </p>';
                        echo '<p class="text-uppercase text-body text-sm font-weight-bolder ">สถานะกิจกรรม</p>
                            <input class="form-control custom-width" type="text" id="status" value="' . $row['status'] . '" readonly> </p>';
                         }
                    ?>
                    <!-- ปุ่มส่งข้อมูลกิจกรรม -->
                    <div class="col-12 text-center mt-3">
                        <button class="btn bg-gradient-success mb-0 text-lg" type="submit" id="btn_create_cert"><i class="fas fa-plus"></i>&nbsp;&nbsp;สร้างคิวอาร์โค้ด</button>
                        <!-- <button class="btn bg-gradient-dark mb-0 text-lg" type="submit" id="btn_edit_certtemp"><i class="fas fa-plus"></i>&nbsp;&nbsp;บันทึก</button> -->
                        <!-- <button class="btn bg-gradient-danger mb-0 text-lg" type="submit" id="btn_delete_certtemp"><i class="far fa-trash-alt"></i>&nbsp;&nbsp;ลบ</button> -->
                    </div>
                </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
<!-- ปุ่มเจนใบประกาศที่มีคิวอาร์โค้ด + เจนเลขเรฟ -->
  <script>
    document.getElementById("btn_create_cert").addEventListener("click", function(event){
    event.preventDefault();
    var formData = new FormData(document.getElementById("admin_certtemp_form"));
    var event_name = document.getElementById("event_name").value;
    var status = document.getElementById("status").value;
    // เพิ่มค่าเข้าไปใน formData
    var activity_id = <?php echo json_encode($_GET['id']); ?>;
    formData.append("activity_id", activity_id);
    formData.append("event_name", event_name);
    formData.append("status", status);
    console.log(formData);

    // ตรวจสอบ key ที่ถูกส่งมา
    formData.forEach(function(value, key) {
        console.log(key, value);
    });
    // ส่งข้อมูลโดยใช้ AJAX
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "generateQR.php", true);
    xhr.onload = function() {
    console.log("Response:", xhr.responseText);
        if (xhr.status === 200) {
            // อัปเดตเรียบร้อย
            alert("สร้างคิวอาร์โค้ดเรียบร้อยแล้ว");
            window.location.href = 'admin.php';
        } else {
            // เกิดข้อผิดพลาดในการอัปเดต
            alert("เกิดข้อผิดพลาดในการสร้างข้อมูล");
        }
    };
    xhr.send(formData);
    });
  </script>


  <!--แก้ไขใบประกาศและรายชื่อ-->
  <script>
    document.getElementById("btn_edit_certtemp").addEventListener("click", function() {
    event.preventDefault();
    var formData = new FormData(document.getElementById("admin_certtemp_form"));
    var event_name = document.getElementById("event_name").value;
    var status = document.getElementById("status").value;
    var type = document.getElementById("type").value;
    // เพิ่มค่าเข้าไปใน formData
    var activity_id = <?php echo json_encode($_GET['id']); ?>;
    formData.append("activity_id", activity_id);
    formData.append("event_name", event_name);
    formData.append("status", status);
    console.log(formData);

    // ตรวจสอบ key ที่ถูกส่งมา
    formData.forEach(function(value, key) {
        console.log(key, value);
    });
    // ส่งข้อมูลโดยใช้ AJAX
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "update_event.php", true);
    xhr.onload = function() {
        console.log("Response:", xhr.responseText);  // เพิ่มบรรทัดนี้
        if (xhr.status === 200) {
            // อัปเดตเรียบร้อย
            alert("อัปเดตข้อมูลเรียบร้อยแล้ว");
        } else {
            // เกิดข้อผิดพลาดในการอัปเดต
            alert("เกิดข้อผิดพลาดในการอัปเดตข้อมูล");
        }
    };
    xhr.send(formData);
  });
  </script>

  <!--ลบกิจกรรม-->
  <script>
    document.getElementById("btn_delete_certtemp").addEventListener("click", function(event){
        event.preventDefault(); // ป้องกันการโหลดหน้าเว็บหลังจากการกดปุ่ม
        // ยืนยันว่าผู้ใช้ต้องการลบกิจกรรม
        var confirmation = confirm("คุณแน่ใจหรือไม่ว่าต้องการลบกิจกรรมนี้?");
        if(confirmation) {
            // ดึง ID ของกิจกรรม
            var activityId = <?php echo $activity_id; ?>;
            // ส่งคำขอ HTTP POST ไปยังไฟล์ PHP เพื่อลบข้อมูล
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "delete_event.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // หลังจากลบข้อมูลเสร็จสิ้น ทำสิ่งที่คุณต้องการ เช่น รีโหลดหน้าเว็บหรือแสดงข้อความว่าลบสำเร็จ
                    alert("ลบกิจกรรมเรียบร้อยแล้ว");
                    window.location.href = "admin.php";
                }
            };
            xhr.send("activity_id=" + activityId + "&status=Closed");
        }
    });
  </script>

</body>
</html>

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
