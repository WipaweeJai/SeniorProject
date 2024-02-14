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
  <!-- Include jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body class="g-sidenav-show bg-gray-100">
<?php
    include "navbar.php";
?>
  <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg bg-transparent shadow-none position-absolute px-4 w-100 z-index-2">
      <div class="container-fluid py-1">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 ps-2 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="text-white opacity-5" href="javascript:;">หน้า</a></li>
            <li class="breadcrumb-item text-sm text-white" aria-current="page">Admin</li>
          </ol>
          <h6 class="text-white font-weight-bolder ms-2">Admin</h6>
        </nav>
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
    <div class="container-fluid" style="padding">
      <div class="page-header min-height-300 border-radius-xl mt-4" style="background-image: url('../assets/img/curved-images/curved0.jpg'); background-position-y: 50%;">
        <span class="mask bg-gradient-primary opacity-6"></span>
      </div>
    </div>

    <div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      <div class="card mb-4">
        <div class="card-header pb-0">
          <h6>จัดการกิจกรรม</h6>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
          <div class="table-responsive p-0">
            <table class="table align-items-center mb-0">
              <thead>
                <tr>
                  <th class="text-center text-secondary text-xxs font-weight-bolder opacity-7">ชื่อกิจกรรม</th>
                  <th class="text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">รหัสกิจกรรม</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">วันที่อัพเดทสถานะ</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"></th>
                </tr>
              </thead>
              <tbody>
                <!-- Query Data -->
                <?php
                require_once('../backend/dbcon.php');
                $sql = "SELECT * FROM tb_event";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                  // Query สถานะจากตาราง tb_event
                  $status_sql = "SELECT status FROM tb_event WHERE activity_id = " . $row['activity_id'];
                  $status_result = mysqli_query($conn, $status_sql);
                  $status_row = mysqli_fetch_assoc($status_result);
                  ?>
                  <tr>
                    <td>
                      <div class="d-flex px-2 py-1">
                        <div class="d-flex flex-column justify-content-center">
                          <!-- แสดงชื่อกิจกรรม -->
                          <h6 class="mb-0 text-sm"><?php echo $row['event_name']; ?></h6>
                        </div>
                      </div>
                    </td>
                    <!-- แสดงรหัสกิจกรรม -->
                    <td>
                      <p class="text-xs font-weight-bold mb-0"><?php echo $row['activity_id']; ?></p>
                    </td>
                    <!-- แสดงสถานะกิจกรรม -->
                    <td class="align-middle text-center text-sm">
                      <!-- แสดงสถานะจากฐานข้อมูล -->
                      <?php
                      $status = $status_row['status'];
                      if ($status == 'Approved') {
                          echo '<span class="badge badge-sm bg-gradient-success">Approve</span>';
                      } elseif ($status == 'Pending') {
                          echo '<span class="badge badge-sm bg-gradient-warning">Pending</span>';
                      } elseif ($status == 'Closed') {
                          echo '<span class="badge badge-sm bg-gradient-info">Closed</span>';
                      }
                      ?>
                      <!-- dropdown เพื่อเลือกแก้ไขสถานะ -->
                      <select class="form-select status-select" data-event-id="<?php echo $row['activity_id']; ?>">
                        <option value="Approved" <?php if ($status_row['status'] == 'Approved') echo "selected"; ?>>Approved</option>
                        <option value="Pending" <?php if ($status_row['status'] == 'Pending') echo "selected"; ?>>Pending</option>
                        <option value="Closed" <?php if ($status_row['status'] == 'Closed') echo "selected"; ?>>Closed</option>
                      </select>
                    </td>
                    <!-- แสดงวันที่และลิงก์ Edit -->
                    <td class="align-middle text-center">
                      <span class="text-secondary text-xs font-weight-bold">23/04/2018</span>
                    </td>
                    <td>
                      <ul class="nav nav-pills nav-fill p-1 bg-transparent" role="tablist" onclick="saveStatus()">
                      <a class="btn font-weight-light bg-gradient-dark mb-0 me-3" href="">
                        บันทึก
                      </a>
                      </ul>
                    </td>
                  </tr>
                <?php } ?>
                <script>
                  function saveStatus() {
                  var selects = document.querySelectorAll('.status-select');
                  selects.forEach(function(select) {
                    var activityId = select.getAttribute('data-event-id');
                    var newStatus = select.value;

                    // ส่งข้อมูลไปยังไฟล์ PHP เพื่ออัพเดทสถานะในฐานข้อมูล
                    $.ajax({
                    url: 'updateStatus.php',
                    method: 'POST',
                    data: {
                      activityId: activityId,
                      newStatus: newStatus
                    },
                    success: function(response) {
                      // ประมวลผลเมื่ออัพเดทสถานะสำเร็จ (ถ้าต้องการ)
                      console.log(response);
                    },
                    error: function(xhr, status, error) {
                      // ประมวลผลเมื่อเกิดข้อผิดพลาดในการอัพเดทสถานะ
                      console.error(xhr.responseText);
                    }
                    });
                  });
                  }
                </script>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>  
</div>

                
</main>
</body>

</html>