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
          <h6 class="font-weight-bolder ms-2">จัดการผู้ใช้งาน</h6>
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
          <h5 class="font-weight-bolder text-info text-gradient">จัดการผู้ใช้งาน</h5>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
          <div class="table-responsive p-0">
            <table class="table align-items-center mb-0">
              <thead>
                <tr>
                  <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">ชื่อผู้ใช้งาน</th>
                  <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">รหัสผู้ใช้งาน</th>
                  <th class="text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7">สถานะ</th>
                </tr>
              </thead>
              <tbody>
                <!-- Query Data -->
                <?php
                  require_once('../backend/dbcon.php');
                  $sql = "SELECT * FROM tb_user";
                  $result = mysqli_query($conn, $sql);
                  while ($row = mysqli_fetch_assoc($result)) {
                ?>
                  <tr>
                    <td>
                      <div class="d-flex px-2 py-1">
                        <div class="d-flex flex-column justify-content-center">
                          <!-- แสดงชื่อผู้ใช้งาน -->
                          <h6 class="mb-0 text-sm"><?php echo $row['name']; ?></h6>
                        </div>
                      </div>
                    </td>
                    <!-- แสดงรหัสผู้ใช้งาน -->
                    <td>
                      <p class="text-center text-xs font-weight-bold mb-0"><?php echo $row['user_id']; ?></p>
                    </td>
                    <!-- แสดงสถานะผู้ใช้งาน -->
                    <td class="align-middle text-center text-sm">
                      <?php
                        $status = $row['status'];
                        if ($status == 'student') {
                            echo '<span class="badge badge-sm bg-gradient-success">Student</span>';
                        } elseif ($status == 'external') {
                            echo '<span class="badge badge-sm bg-gradient-warning">External</span>';
                        } elseif ($status == 'admin') {
                            echo '<span class="badge badge-sm bg-gradient-secondary">Admin</span>';
                        }
                      ?>
                    </td>
                    <td>
                      <?php
                        echo '<ul class="nav nav-pills nav-fill p-1 bg-transparent" role="tablist">';
                        echo '<a class="btn font-weight-light bg-gradient-dark mb-0 me-2" href="admin_user.php?id=' .$row['user_id']. '">';
                        echo '<i class="fas fa-pencil-alt"></i> แก้ไข';
                        echo '</a>';
                        echo '</ul>';
                      ?>
                    </td>
                  </tr>
                <?php } ?>

                <!-- ลบกิจกรรมถาวร
                <script>
                  function deleteRow(activityId) {
                    if (confirm('คุณต้องการลบกิจกรรมถาวรใช่หรือไม่?')) {
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
                </script> -->

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