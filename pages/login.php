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
  <div class="container position-sticky z-index-sticky top-0">
    <div class="row">
      <div class="col-12">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg blur blur-rounded top-0 z-index-3 shadow position-absolute my-3 py-2 start-0 end-0 mx-4">
          <div class="container-fluid pe-0">
            <a class="navbar-brand font-weight-bolder ms-lg-0 ms-3 " href="../pages/index.php">
              ระบบบริหารและจัดการใบประกาศเข้าร่วมกิจกรรม
            </a>
            <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon mt-2">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </span>
            </button>
            <div class="collapse navbar-collapse" id="navigation">
              <ul class="navbar-nav mx-auto ms-xl-auto me-xl-7"></ul>
              <ul class="navbar-nav d-lg-block d-none ">
                <li class="nav-item">
                  <a href="../pages/index.php" class="btn btn-sm btn-round mb-0 me-1 bg-gradient-dark">กลับสู่หน้าหลัก</a>
                </li>
              </ul>
            </div>
          </div>
        </nav>
        <!-- End Navbar -->
      </div>
    </div>
  </div>
  <main class="main-content  mt-0">
    <section>
      <div class="page-header min-vh-75">
        <div class="container">
          <div class="row">
            <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
              <div class="card card-plain mt-8">
                <div class="card-header pb-0 text-left bg-transparent">
                  <h3 class="font-weight-bolder text-info text-gradient">เข้าสู่ระบบ</h3>
                  <p class="mb-0">เข้าใช้งานระบบบริหารและจัดการใบประกาศเข้าร่วมกิจกรรม</p>
                </div>
                <div class="card-body">
                  <form role="form" class="font-weight-bolder"action="loginAction.php" method="post">
                    <label>อีเมล</label>
                    <div class="mb-3">
                      <input type="text" id="email" name="email" class="form-control" placeholder="กรุณากรอกอีเมล" required>
                    </div>
                    <label>รหัสผ่าน</label>
                    <div class="mb-3">
                      <input type="password" id="password" name="password" class="form-control" placeholder="รหัสผ่าน" required>
                    </div>
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" id="rememberMe" checked="">
                      <label class="form-check-label" for="rememberMe">จดจำฉัน</label>
                    </div>
                    <div class="text-center">
                      <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">เข้าสู่ระบบ</button>
                      <!-- <button onclick="validateInput()" type="button" class="btn bg-gradient-info w-100 mt-4 mb-0">เข้าสู่ระบบ</button> -->
                    </div>
                  </form>
                </div>
                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                  <p class="mb-4 text-sm mx-auto">
                    ยังไม่มีบัญชีใช่ไหม ? 
                    <a href="signup.php" class="text-info text-gradient font-weight-bold">สมัครสมาชิก</a>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="oblique position-absolute top-0 h-100 d-md-block d-none me-n8">
                <div class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6" style="background-image:url('../assets/img/curved-images/curved6.jpg')"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

<script>
function validateInput() {
    var input = document.getElementById('user_id');
    var inputValue = input.value.trim();

    // ตรวจสอบว่าตัวอื่น ๆ เป็นตัวเลขหรือไม่
    var restOfCharacters = inputValue.slice(1);
    // ตรวจสอบความยาวของข้อมูล
    if (inputValue.length !== 11 || !/^\d+$/.test(restOfCharacters)) {
        alert('กรุณาตรวจสอบบัญชีผู้ใช้เครือข่ายนนทรีอีกครั้ง');
        return false;
    }

    // ตรวจสอบรูปแบบของข้อมูล
    var firstChar = inputValue.charAt(0);
    if (!(firstChar === 'b')) {
        alert('กรุณาตรวจสอบบัญชีผู้ใช้เครือข่ายนนทรีอีกครั้ง เช่น b63xxxxxxxx');
        return false;
    }

    // ผ่านการตรวจสอบทั้งหมด
    return true;
}
</script>

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