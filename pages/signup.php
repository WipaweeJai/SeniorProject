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
</head>

<body class="">
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg position-absolute top-0 z-index-3 w-100 shadow-none my-3 navbar-transparent mt-4">
    <div class="container">
      <a class="navbar-brand font-weight-bolder ms-lg-0 ms-3 text-white" href="../pages/index.php">
        ระบบบริหารและจัดการใบประกาศเข้าร่วมกิจกรรม
      </a>
      <div class="collapse navbar-collapse" id="navigation">
        <ul class="navbar-nav mx-auto ms-xl-auto me-xl-7">
        </ul>
        <ul class="navbar-nav d-lg-block d-none">
          <li class="nav-item">
            <a href="index.php" class="btn btn-sm btn-round mb-0 me-1 bg-gradient-light">กลับสู่หน้าหลัก</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- End Navbar -->
  <main class="main-content  mt-0">
    <section class="min-vh-100 mb-8" >
      <div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg" style="background-image: url('../assets/img/15.jpg');" >
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-5 text-center mx-auto">
              <h1 class="text-white mb-2 mt-5">ลงทะเบียนสมาชิก</h1>
              <p class="text-lead text-white"></p>
            </div>
          </div>
        </div>
      </div>
      <div class="container">
        <div class="row mt-lg-n10 mt-md-n11 mt-n10 ">
          <div class="col-xl-4 col-lg-5 col-md-7 mx-auto ">
            <div class="card z-index-0">
              
              <div class="row px-xl-5 px-sm-4 px-3">
              </div>
              <div class="card-body">

              <form role="form" class="font-weight-bolder">
                  <h6>คุณมีสถานะอะไร?</h6>
                  <div class="mb-3">
                      <button type="button" class="btn btn-outline-info text-sm status-btn" data-status="student">นิสิต</button>
                      <button type="button" class="btn btn-outline-info text-sm status-btn" data-status="external">บุคคลภายนอก</button>
                      <input type="hidden" id="status" name="status" required>
                  </div>
              </form>
                 <!-- status : student  -->
                <form role="form" class="font-weight-bolder student-form" action="signupAction.php" method="post" style="display: none;">
                    <input type="hidden" id="status" name="status" value="student" required>
                    <h6>ชื่อ-นามสกุล (ไม่ต้องมีคำนำหน้า)</h6>
                      <div class="mb-3">
                          <input type="text" id="name" name="name" class="form-control" placeholder="ชื่อภาษาไทย" required pattern="[ก-๙ะ-์\s]+" title="กรุณากรอกภาษาไทยเท่านั้น">
                      </div>
                    <h6>รหัสนิสิต</h6>
                      <div class="mb-3">
                          <input type="text" id="user_id" name="user_id" class="form-control" placeholder="รหัสนิสิต 10 หลัก" pattern="[0-9]{10}" maxlength="10" title="กรุณากรอกตัวเลข 10 หลัก" required>
                      </div>
                    <h6>อีเมล</h6>
                      <div class="mb-3">
                        <input type="email" id="email" name="email" class="form-control" placeholder="อีเมล" required>
                      </div>
                    <h6>รหัสผ่าน</h6>
                      <div class="mb-3">
                          <input type="password" id="password" name="password" class="form-control" placeholder="รหัสผ่าน" required minlength="8">
                      </div>

                    <div class="text-center">
                      <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">ลงทะเบียน</button>
                    </div>
                </form>
                <!-- status : external -->
                <form role="form" class="font-weight-bolder external-form" action="signupAction.php" method="post" style="display: none;">
                    <input type="hidden" id="status" name="status" value="external" required>
                    <input type="hidden" id="user_id" name="user_id" required>
                    <h6>ชื่อ-นามสกุล (ไม่ต้องมีคำนำหน้า)</h6>
                      <div class="mb-3">
                          <input type="text" id="name" name="name" class="form-control" placeholder="ชื่อภาษาไทย" required pattern="[ก-๙ะ-์\s]+" title="กรุณากรอกภาษาไทยเท่านั้น">
                      </div>
                    <h6>อีเมล</h6>
                      <div class="mb-3">
                        <input type="email" id="email" name="email" class="form-control" placeholder="อีเมล" required>
                      </div>
                    <h6>รหัสผ่าน</h6>
                      <div class="mb-3">
                          <input type="password" id="password" name="password" class="form-control" placeholder="รหัสผ่าน" required minlength="8">
                      </div>

                    <div class="text-center">
                      <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">ลงทะเบียน</button>
                    </div>
                </form>

              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
</main>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusButtons = document.querySelectorAll('.status-btn');
    const studentForm = document.querySelector('.student-form');
    const externalForm = document.querySelector('.external-form');
    const statusInput = document.getElementById('status');

    statusButtons.forEach(button => {
        button.addEventListener('click', function() {
            const status = this.getAttribute('data-status');
            statusInput.value = status;
            if (status === 'student') {
                studentForm.style.display = 'block';
                externalForm.style.display = 'none';
            } else if (status === 'external') {
                studentForm.style.display = 'none';
                externalForm.style.display = 'block';
            }
            statusButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
        });
    });
});
</script>