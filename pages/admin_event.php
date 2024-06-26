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
          <h6 class="font-weight-bolder mb-0">จัดการกิจกรรม</h6>
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
    <div class="container-fluid">
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
                      $event_name = $row['event_name']; // Fetch event name from $row
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
      <div class="row">
        <div>
          <div class="card mb-4">
          <?php
            if(isset($_GET['id'])) {
                $activity_id = $_GET['id'];
                $sql = "SELECT * FROM tb_event WHERE activity_id = '$activity_id'";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);

                echo '<div class="card-header pb-0 p-3">';
                    echo '<p class="text-dark">ข้อมูลผู้ส่งข่าวกิจกรรม</p>';
                    echo '<p class="text-body text-sm font-weight-bolder ">ชื่อผู้ส่งข่าวกิจกรรม : <span class="font-weight-normal">' . $row['sender_name'] . '</span></p>';
                    echo '<p class="text-body text-sm font-weight-bolder ">อีเมล : <span class="font-weight-normal">' . $row['sender_email'] . '</p>';
                echo '</div>';
            }
            ?>
            <div class="divider"></div>
            <div class="card-header pb-0 p-3">
              <p class="text-dark">ข้อมูลเบื้องต้นของกิจกรรม</p>
            </div>
            <div class="card-body p-3">
            <form id="admin_event_form" method="post" enctype="multipart/form-data">
                    <?php
                        if(isset($_GET['id'])) {
                        $activity_id = $_GET['id'];
                        
                        $sql = "SELECT * FROM tb_event WHERE activity_id = '$activity_id'";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);
                        
                        echo '<p class="text-uppercase text-body text-sm font-weight-bolder ">ชื่อกิจกรรม : 
                            <input class="form-control custom-width" type="text" id="event_name" value="' . $row['event_name'] . '">
                            </p>';
                        echo '<p class="text-uppercase text-body text-sm font-weight-bolder ">รูปแบบกิจกรรม :
                            <input class="form-control custom-width" type="text" id="type" value="' . $row['type'] . '">';
                        echo '<p class="text-uppercase text-body text-sm font-weight-bolder">วันที่จัดกิจกรรม : ';
                          if(isset($row['event_date_to'])) {
                            echo '<div class="d-flex">';
                            echo '<input class="form-control custom-width mr-2" type="date" id="event_date_from" value="' . $row['event_date_from'] .'">';
                            echo '<input class="form-control custom-width" type="date" id="event_date_to" value="' . $row['event_date_to'] .'">';
                            echo '</div>';
                          } else {
                            // หรือหากไม่มีค่าใน event_date_to ให้แสดงเฉพาะ event_date_from
                            echo '<input class="form-control custom-width col-5" type="date" id="event_date_from" value="' . $row['event_date_from'] . '">';
                          }
                        echo '</p>';                            
                        echo '<p class="text-uppercase text-body text-sm font-weight-bolder ">วันที่รับสมัครวันสุดท้าย : 
                            <input class="form-control custom-width" type="date" id="event_reg_to" value="' . $row['event_reg_to'] . '">
                            </p>';
                        echo '<p class="text-uppercase text-body text-sm font-weight-bolder ">จำนวนที่รับ : 
                            <input class="form-control custom-width" type="text" id="event_number" value="' . $row['event_number'] . '">
                            </p>';
                        echo '<p class="text-uppercase text-body text-sm font-weight-bolder ">ค่าใช้จ่าย : 
                            <input class="form-control custom-width" type="text" id="event_fee" value="' . $row['event_fee'] . '">
                            </p>';
                        echo '<p class="text-uppercase text-body text-sm font-weight-bolder ">คุณสมบัติ (ระดับการศึกษา/ช่วงอายุ/อื่นๆ) : 
                            <input class="form-control custom-width" type="text" id="requirements" value="' . $row['requirements'] . '">
                            </p>';
                        echo '<p class="text-uppercase text-body text-sm font-weight-bolder ">สถานที่จัดกิจกรรม : 
                            <input class="form-control custom-width" type="text" id="event_location" value="' . $row['event_location'] . '">
                            </p>';
                        echo '<div class="divider"></div>';
                        echo '<div style="text-align: center;">';
                        echo '<img src="' . $row['event_poster'] . '" style="width: 40%; border-radius: 5px; box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.75); margin: auto;">';
                        echo '</div>';
                        echo '<textarea class="form-control mt-3" id="event_detail_full" rows="3">' . $row['event_detail_full'] . '</textarea>';
                        echo '<div class="divider"></div>';
                        echo '<p class="text-uppercase text-body text-sm font-weight-bolder mt-3">สถานะกิจกรรม</p>
                            <select id="status" class="form-select status-select" style="width: 50%" data-event-id="' . $row['activity_id'] . '">
                                <option value="Approved"'; if ($row['status'] == 'Approved') echo "selected"; echo '>Approved</option>
                                <option value="Pending"'; if ($row['status'] == 'Pending') echo "selected"; echo '>Pending</option>
                                <option value="Closed"'; if ($row['status'] == 'Closed') echo "selected"; echo '>Closed</option>
                            </select>';
                        }
                    ?>
                    <!-- ปุ่มส่งข้อมูลกิจกรรม -->
                    <div class="col-12 text-center mt-3">
                        <button class="btn bg-gradient-dark mb-0 text-lg" type="submit" id="btn_edit_event"><i class="fas fa-plus"></i>&nbsp;&nbsp;บันทึก</button>
                        <button class="btn bg-gradient-danger mb-0 text-lg" type="submit" id="btn_delete_event"><i class="far fa-trash-alt"></i>&nbsp;&nbsp;ลบ</button>
                    </div>
                </form>
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

  <!--แก้ไขกิจกรรม-->
  <script>
    document.getElementById("btn_edit_event").addEventListener("click", function() {
    event.preventDefault();
    var formData = new FormData(document.getElementById("admin_event_form"));
    var event_name = document.getElementById("event_name").value;
    var status = document.getElementById("status").value;
    var type = document.getElementById("type").value;
    var event_date_to = document.getElementById("event_date_to").value;
    var event_date_from = document.getElementById("event_date_from").value;
    var event_reg_to = document.getElementById("event_reg_to").value;
    var event_number = document.getElementById("event_number").value;
    var event_fee = document.getElementById("event_fee").value;
    var requirements = document.getElementById("requirements").value;
    var event_location = document.getElementById("event_location").value;
    var event_detail_full = document.getElementById("event_detail_full").value;
    

    // เพิ่มค่าเข้าไปใน formData
    var activity_id = <?php echo json_encode($_GET['id']); ?>;
    
    formData.append("activity_id", activity_id);
    formData.append("event_name", event_name);
    formData.append("status", status);
    formData.append("type", type);
    formData.append("event_date_to", event_date_to);
    formData.append("event_date_from", event_date_from);
    formData.append("event_reg_to", event_reg_to);
    formData.append("event_number", event_number);
    formData.append("event_fee", event_fee);
    formData.append("requirements", requirements);
    formData.append("event_location", event_location);
    formData.append("event_detail_full", event_detail_full);
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
            window.location.href = "adminevent.php";
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
    document.getElementById("btn_delete_event").addEventListener("click", function(event){
        event.preventDefault(); // ป้องกันการโหลดหน้าเว็บหลังจากการกดปุ่ม

        // ยืนยันว่าผู้ใช้ต้องการลบกิจกรรม
        var confirmation = confirm("ต้องการลบกิจกรรมนี้หรือไม่");
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
                    alert("ลบกิจกรรมเสร็จสิ้น");
                    window.location.href = "admin.php";
                }
            };
            xhr.send("activity_id=" + activityId + "&status=Closed");
        }
    });
  </script>

</body>

</html>