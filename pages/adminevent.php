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
  <!-- Include jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
            <li class="breadcrumb-item text-sm text-dark" aria-current="page">จัดการกิจกรรม</li>
          </ol>
          <h6 class="font-weight-bolder ms-2">จัดการกิจกรรม</h6>
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
    <div class="container-fluid" style="padding">
      <div class="page-header min-height-300 border-radius-xl mt-4" style="background-image: url('../assets/img/13.jpg'); background-position-y: 50%;">
      </div>
    </div>

<!-- จัดการกิจกรรม -->
<div class="container-fluid py-4" >
  <div class="row">
    <div class="col-12 ">
      <div class="card">
        <div class="card-header pb-0 ">
          <h5 class="font-weight-bolder text-info text-gradient">จัดการกิจกรรม</h5>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
          <div class="table-responsive p-0">
            <table class="table align-items-center mb-0">
              <thead>
                <tr>
                  <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">ชื่อกิจกรรม</th>
                  <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">รหัสกิจกรรม</th>
                  <th class="text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7">Status</th>
                  <th class="text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7">วันที่แก้ไข</th>
                  <th class="text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7"></th>
                  <th class="text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7"></th>
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
                      <p class="text-center text-xs font-weight-bold mb-0"><?php echo $row['activity_id']; ?></p>
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
                            echo '<span class="badge badge-sm bg-gradient-secondary">Closed</span>';
                        }
                      ?>
                    </td>
                    <!-- แสดงวันที่และลิงก์ Edit -->
                    <td class="align-middle text-center">
                      <?php
                        $date_sql = "SELECT update_date FROM tb_event WHERE activity_id = " . $row['activity_id'];
                        $date_result = mysqli_query($conn, $date_sql);
                        $date_row = mysqli_fetch_assoc($date_result);
                        $thai_year = date("Y", strtotime($date_row['update_date'])) + 543;
                        $thai_date = date("d-m-", strtotime($date_row['update_date'])) . $thai_year;
                        $time = date("H:i:s", strtotime($date_row['update_date']));
                        
                        echo '<span class="text-secondary text-xs font-weight-bold">' . $thai_date . ' ' . $time . '</span>';
                      ?>
                    </td>

                    <td>
                      <?php
                        echo '<ul class="nav nav-pills nav-fill p-1 bg-transparent" role="tablist">';
                        echo '<a class="btn font-weight-light bg-gradient-dark mb-0 me-2" href="admin_event.php?id=' .$row['activity_id']. '">';
                        echo '<i class="fas fa-pencil-alt"></i> แก้ไข';
                        echo '</a>';
                        echo '</ul>';
                      ?>
                    </td>
                    <td>
                      <?php
                        echo '<i class="far fa-trash-alt" style="color: #d50707;" onclick="deleteRow(' . $row['activity_id'] . ')"></i>';
                      ?>
                    </td>
                  </tr>
                <?php } ?>

                <!-- ลบกิจกรรมถาวร -->
                <script>
                  function deleteRow(activityId) {
                    if (confirm('ต้องการลบกิจกรรมถาวรใช่หรือไม่?')) {
                      $.ajax({
                        url: 'deleteRow.php', // เปลี่ยนเส้นทางไปยังไฟล์ PHP ที่ทำการลบข้อมูล
                        method: 'POST',
                        data: { activityId: activityId },
                        success: function(response) {
                          console.log(response);
                          // สามารถเพิ่มการรีเฟรชตารางหรือส่วนที่ต้องการให้ลบข้อมูลออกจาก DOM ได้ที่นี่
                        },
                        error: function(xhr, status, error) {
                          console.error(xhr.responseText);
                        }
                      });
                    }
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