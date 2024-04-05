<?php 
  session_start();
  @$name = $_SESSION['name'];
?>
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
  <!-- jQ -->
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body class="g-sidenav-show  bg-gray-100">
<?php
  include "layout/navbar.php";
?>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">หน้า</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">ตรวจสอบใบประกาศ</li>
          </ol>
          <h6 class="font-weight-bolder mb-0">ตรวจสอบใบประกาศ</h6>
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

    <?php
      $ref = '';
      if(isset($_GET['ref'])) {
          $ref = $_GET['ref'];
      } elseif (isset($_POST['refInput'])) {
          $ref = $_POST['refInput'];
      }
    ?>

    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-lg-8">
          <div class="row">
            <div class="col-md-12 mb-lg-0 mb-4">
              <div class="card-header pb-0 p-3">
                <div class="row">
                  <div class="col-6 d-flex align-items-center">
                    <h6 class="mb-0">ตรวจสอบใบประกาศ</h6>
                  </div>
                </div>
              </div>

              <!-- <form method="post" action=""> -->
                <div class="card-body p-3">
                  <div class="row">
                    <?php
                    $ref = '';
                    if(isset($_GET['ref'])) {
                        $ref = $_GET['ref'];
                    }
                    ?>
                  
                    <div class="col-md-8 mb-md-0 mb-4">
                      <input class="form-control" type="text" name="refInput" id="refInput" placeholder="กรอกหมายเลขใบประกาศ" value="<?= $ref ?>">
                    </div>
                    <div class="col-2 text-end">
                      <button type="submit" id="checkBtn" class="btn bg-gradient-dark mb-0">ตรวจสอบ</button>
                    </div>

                  </div>
                </div>
              <!-- </form> -->
            </div>
          </div>
        </div>
      </div>
      
      <!-- ถ้าระบบหาใบประกาศพบ -->
      <?php
        // ดึงเลข ref ที่ส่งมาจาก url
        if (isset($_GET['ref'])) {
            $ref = $_GET['ref'];
            echo '<script>';
            echo 'document.getElementById("refInput").value = "' . $ref . '";';
            echo '</script>';
            
            // ถ้ามีค่า ref ใน URL ให้ดึงข้อมูลจากฐานข้อมูล
            require_once('../backend/dbcon.php');

            // คำสั่ง SQL สำหรับดึงข้อมูล cert_Ref, name และ event_name จากตาราง tb_certificate และ tb_event
            $sql_cert_event = "SELECT c.cert_Ref, u.name, e.event_name, c.user_id, c.activity_id
                              FROM tb_certificate c
                              INNER JOIN tb_user u ON c.user_id = u.user_id
                              INNER JOIN tb_event e ON c.activity_id = e.activity_id
                              WHERE c.cert_Ref = '$ref'";
            $result_cert_event = mysqli_query($conn, $sql_cert_event);

            // ตรวจสอบว่ามีผลลัพธ์จากคำสั่ง SQL
            if (mysqli_num_rows($result_cert_event) > 0) {
                $row_cert_event = mysqli_fetch_assoc($result_cert_event);
                $cert_Ref = $row_cert_event["cert_Ref"];
                $name = $row_cert_event["name"];
                $event_name = $row_cert_event["event_name"];
                $activity_id = $row_cert_event["activity_id"];
                $user_id = $row_cert_event["user_id"];
                $user_id_without_b = substr($user_id, 1);
                $image_url = "https://d2a4-158-108-229-149.ngrok-free.app/project/assets/img/zip/{$activity_id}/modified/{$user_id_without_b}.png";
      ?>
      <div id="resultRowFound" class="row">
          <div class="col-md-7 mt-4">
              <div class="card">
                  <div class="card-header pb-0 px-3 text-success text-lg">
                      <i class="fa fa-solid fa-check"></i>
                      <span id="refInputValue" class="ms-2"><?= $cert_Ref ?></span>
                  </div>
                  <div class="card-body pt-4 p-3">
                    <ul class="list-group">
                        <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                            <div class="d-flex flex-column">
                                <span class="mb-2 text-sm">กิจกรรม : <span id="event_name" class="text-dark font-weight-bold ms-sm-2"><?= $event_name ?></span></span>
                                <span class="mb-2 text-sm">ชื่อ : <span id="name" class="text-dark font-weight-bold ms-sm-2"><?= $name ?></span></span>
                                <a class="download-link" href="<?php echo $image_url; ?>" download>
                                    <button type="button" class="btn bg-gradient-info btn-sm font-weight-normal">ดาวน์โหลดใบประกาศ</button>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
              </div>
          </div>
      </div>

    <!-- ถ้าไม่พบข้อมูลในฐานข้อมูล -->
    <?php 
    } else {
        echo '<div id="resultRowNotFound" class="row" style="display: block;">';
        echo '<div class="col-md-7 mt-4">';
        echo '<div class="card">';
        echo '<div class="card-header pb-0 px-3 text-danger text-lg">';
        echo '<i class="fas fa-f00d"></i>';
        echo '<span class="ms-2">ไม่พบใบประกาศดังกล่าว</span>';
        echo '</div>';
        echo '<div class="card-body"></div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }

    // ถ้าไม่มีค่า ref ใน URL
    } else {
        echo '<div id="resultRowNotFound" class="row" style="display: none;">';
        echo '<div class="col-md-7 mt-4">';
        echo '<div class="card">';
        echo '<div class="card-header pb-0 px-3 text-danger text-lg">';
        echo '<i class="fas fa-f00d"></i>';
        echo '<span class="ms-2">ไม่พบใบประกาศดังกล่าว</span>';
        echo '</div>';
        echo '<div class="card-body"></div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
    ?>

    </div>
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

<script>
$("#checkBtn").click(function() {
    var refInput = $("#refInput").val();
    console.log(refInput)
    if (refInput != 0) {
        $.ajax({
            url: "function/api_checkCert.php",
            type: "POST",
            data: { refInput },
            success: function(response) {
                if (jQuery.trim(response) == 'false') {
                    // หากไม่พบใบประกาศ
                    console.log(response);
                    $("#resultRowFound").hide();
                    $("#resultRowNotFound").show();
                } else {
                    console.log(response);
                    // หากพบใบประกาศ
                    $("#resultRowFound").show();
                    $("#resultRowNotFound").hide();
                }
            },
            error: function(request, status, error) {
                console.log(request.responseText);
            }
        });
    // กรณี ไม่ได้กรอกเลข จะซ่อนทั้งหมด
    } else {
        alert('กรุณากรอกหมายเลขใบประกาศ');
        $("#resultRowFound").hide();
        $("#resultRowNotFound").hide();
    }
});



$(".download-link").click(function(event) {
    event.preventDefault();
    var fileUrl = $(this).attr('href');
    var xhr = new XMLHttpRequest();
    xhr.open('GET', fileUrl, true);
    xhr.responseType = 'blob';

    xhr.onload = function() {
        if (xhr.status === 200) {
            var downloadLink = document.createElement('a');
            var url = window.URL.createObjectURL(xhr.response);
            downloadLink.href = url;
            downloadLink.setAttribute('download', fileUrl.split('/').pop());
            document.body.appendChild(downloadLink);
            downloadLink.click();
            document.body.removeChild(downloadLink);
        }
    };
    xhr.send();
});

</script>




  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/soft-ui-dashboard.min.js?v=1.0.7"></script>
</body>

</html>