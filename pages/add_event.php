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
  <!-- jQ -->
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body class="g-sidenav-show  bg-gray-100">
<?php
  include "navbar.php";
?>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">หน้า</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">กรอกข้อมูลกิจกรรม</li>
          </ol>
          <h6 class="font-weight-bolder mb-0">กรอกข้อมูลกิจกรรม</h6>
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
    <div class="container-fluid py-4">
      <div class="page-header min-height-300 border-radius-xl mt-4" style="background-image: url('../assets/img/add_activity3.png'); background-position-y: 50%;">
      </div>
      <!-- <div class="card card-body blur shadow-blur mx-4 mt-n6 overflow-hidden"> -->
        <!-- <div class="row gx-4">
          <div class="col-auto">
            <div class="avatar avatar-xl position-relative">
              <img src="../assets/img/bruce-mars.jpg" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
            </div>
          </div>
          <div class="col-auto my-auto">
            <div class="h-100">
              <h5 class="mb-1">
                Alec Thompson
              </h5>
              <p class="mb-0 font-weight-bold text-sm">
                CEO / Co-Founder
              </p>
            </div>
          </div>
        </div> -->
      <!-- </div> -->
      <div class="row">

        <div class="container-fluid py-4">
        <div class="row">
            <!-- ส่วนที่ 1 ข้อมูลผู้ส่งข่าว -->
            <!-- <div class="card mb-4">
                <div class="card-header pb-0 p-3">
                    <h3 class="text-dark ">ส่วนที่ 1 ข้อมูลผู้ส่งข่าวกิจกรรม</h3>
                </div>
                <div class="card-body p-3">
                    <p class="text-dark text-lg font-weight-normal ">
                        ชื่อผู้ติดต่อ
                        <span class="text-dark ms-sm-2 font-weight-bold">
                            <input class="form-control custom-width" type="text" id="sender_name" placeholder="กรุณากรอกชื่อคนที่สามารถติดต่อได้ ไม่ใช่ชื่อเพจหรือองค์กร">
                        </span>
                    </p>
                    <p class="text-dark text-lg font-weight-normal ">
                        นามสกุล
                        <span class="text-dark ms-sm-2 font-weight-bold">
                            <input class="form-control custom-width" type="text" id="sender_surname" placeholder="กรุณากรอกนามสกุลคนที่สามารถติดต่อได้ ไม่ใช่ชื่อเพจหรือองค์กร">
                        </span>
                    </p>
                    <p class="text-dark text-lg font-weight-normal ">
                        อีเมล
                        <span class="text-dark ms-sm-2 font-weight-bold">
                            <input class="form-control custom-width" type="email" id="sender_email" placeholder="สำหรับการติดต่อและแจ้งข่าว">
                        </span>
                    </p>
                    <p class="text-dark text-lg font-weight-normal ">
                        เบอร์โทรศัพท์
                        <span class="text-nddark ms-sm-2 font-weight-bold">
                            <input class="form-control custom-width" type="text" id="sender_tel" placeholder="สำหรับการติดต่อเร่งด่วน">
                        </span>
                    </p>
                </div>
            </div> -->
            <!-- ส่วนที่ 1 พาดหัวข่าว และรูปภาพกิจกรรม -->
            <div class="card mb-4">
                <div class="card-header pb-0 p-3">
                    <h3 class="text-dark ">ส่วนที่ 1 พาดหัวข่าว และรูปภาพกิจกรรม</h3>
                </div>
                <div class="parent-container">
                    <img src="../assets/img/activity4.png" alt="" class="responsive-image40" style="padding: 15px;">
                    <img src="../assets/img/activity2.png" alt="" class="responsive-image" style="max-width: 50%;" >
                </div>
                <div class="card-body p-3">

                <form action="upload_event.php" method="post" enctype="multipart/form-data">

                <p class="text-dark text-lg font-weight-normal">
                    อัปโหลดภาพหัวข่าว ขนาด 1200 x 630 พิกเซล (ไม่เกิน 2MB)
                </p>

                    <div class="mb-3">
                        <p class="text-dark text-sm font-weight-normal ">หากไม่อัปโหลดภาพให้ตรงตามขนาด หรือไม่อัปโหลดภาพนี้เข้ามาให้ถูกต้อง ทางเพจจะไม่เพิ่มลงเว็บให้</p>
                        <input class="form-control custom-width" type="file" id="event_banner" name="event_banner">
                    </div>
                    <p class="text-dark text-lg font-weight-normal ">
                        ชื่อกิจกรรม
                        <span class="text-dark ms-sm-2 font-weight-bold">
                            <p class="text-sm font-weight-light ">จำกัดจำนวนตัวอักษร 60 ตัว</p>
                            <input class="form-control custom-width" type="text" id="event_name" placeholder="กรุณาพิมพ์ชื่อกิจกรรม"  maxlength="60">
                        </span>
                    </p>
                    <p class="text-dark text-lg font-weight-normal ">
                        คำโปรยของกิจกรรม
                        <span class="text-dark ms-sm-2 font-weight-bold">
                            <p class="text-sm font-weight-light ">จำกัดจำนวนตัวอักษร 120 ตัว</p>
                            <textarea class="form-control custom-width" type="text" rows="3" id="event_detail_short" placeholder="กรุณาพิมพ์คำอธิบายกิจกรรมคร่าว ๆ ที่เชิญชวนให้คนสนใจ"  maxlength="120"></textarea>
                        </span>
                    </p>
                </div>
            </div>
            <!-- ส่วนที่ 2 ข้อมูลเบื้องต้นของกิจกรรม -->
            <div class="card mb-4">
                <div class="card-header pb-0 p-3">
                    <h3 class="text-dark ">ส่วนที่ 2 ข้อมูลเบื้องต้นของกิจกรรม</h3>
                </div>
                <div class="card-body p-3">
                    <p class="text-dark text-lg font-weight-normal ">
                        วันที่จัดกิจกรรม
                        <span class="text-dark ms-sm-2">
                            <p class="text-sm font-weight-light ">(กรุณากรอกข้อมูลวัน เดือน ปี ให้เต็มรูปแบบ เช่น 1 มกราคม พ.ศ. 2567)</p>
                            <p class="text-dark font-weight-bold ">วันที่เริ่มต้น</p>
                            <input class="form-control custom-width" type="text" id="event_date_from" placeholder="วัน เดือน ปี พ.ศ.">
                        </span>
                        <span class="text-dark ms-sm-2">
                            <p class="text-dark font-weight-bold ">วันที่สิ้นสุด</p>
                            <input class="form-control custom-width" type="text" id="event_date_to" placeholder="วัน เดือน ปี พ.ศ.">
                        </span>
                    </p>
                    <p class="text-dark text-lg font-weight-normal ">
                        วันที่รับสมัครวันสุดท้าย
                        <span class="text-dark ms-sm-2">
                            <p class="text-sm font-weight-light ">(กรุณากรอกข้อมูลวัน เดือน ปี ให้เต็มรูปแบบ เช่น 1 มกราคม พ.ศ. 2567)</p>
                            <input class="form-control custom-width" type="text" id="event_reg_to" placeholder="วัน เดือน ปี พ.ศ.">
                        </span>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="ปิดรับสมัครทันทีหลังเต็ม" id="event_reg_detail">
                            <label class="form-check-label" for="flexCheckIndeterminate">
                                ปิดรับสมัครทันทีเมื่อมีผู้สมัครครบตามจำนวน - หากปิดรับสมัครก่อนกำหนด รบกวนแจ้งทางเพจด้วย
                            </label>
                        </div>
                    </p>
                    <div class="divider"></div>
                    <p class="text-dark text-lg font-weight-normal ">
                        จำนวนคนที่เปิดรับ
                        <span class="text-nddark ms-sm-2 font-weight-bold">
                            <input class="form-control custom-width" type="text" id="event_number" placeholder="เช่น 50 คน , ไม่จำกัด">
                        </span>
                    </p>
                    <div class="divider"></div>
                    <p class="text-dark text-lg font-weight-normal ">
                        ค่าใช้จ่าย
                        <span class="text-nddark ms-sm-2 font-weight-bold">
                            <p class="text-sm font-weight-light ">(กรุณากรอกเฉพาะราคาปกติต่อ 1 คน เท่านั้น)</p>
                            <input class="form-control custom-width" type="text" id="event_fee" placeholder="เช่น 500 บาท , ฟรี">
                        </span>
                    </p>
                    <div class="divider"></div>
                    <p class="text-dark text-lg font-weight-normal ">
                        คุณสมบัติ
                        <span class="text-nddark ms-sm-2 font-weight-bold">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="ชั้นปี 1" id="event_level_">
                                <label class="form-check-label" >ชั้นปี 1</label>
                                </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="ชั้นปี 2" id="event_level">
                                <label class="form-check-label">ชั้นปี 2</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="ชั้นปี 3" id="event_level">
                                <label class="form-check-label">ชั้นปี 3</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="ชั้นปี 4" id="event_level">
                                <label class="form-check-label">ชั้นปี 4</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="ชั้นปี 5 ขึ้นไป" id="event_level">
                                <label class="form-check-label">ชั้นปีมากกว่า 5 ขึ้นไป</label>
                            </div>
                        </span>
                    </p>
                    <p class="text-dark text-lg font-weight-normal ">
                        คุณสมบัติเพิ่มเติม
                        <span class="text-nddark ms-sm-2 font-weight-bold">
                            <p class="text-sm font-weight-light ">(ข้อจำกัดต่าง ๆ เช่น อายุ สาขา เกรดเฉลี่ย)</p>
                            <input class="form-control custom-width" type="text" id="event_require" placeholder="คุณสมบัติเพิ่มเติม">
                        </span>
                    </p>
                    <div class="divider"></div>
                    <p class="text-dark text-lg font-weight-normal ">
                        สถานที่จัดกิจกรรม
                        <span class="text-nddark ms-sm-2 font-weight-bold">
                            <div class="form-check" style="display: block;">
                                <input class="form-check-input" type="radio" value= "ออนไลน์" id="event_location">
                                <label class="form-check-label" >ออนไลน์</label>
                                <input class="form-control custom-width" type="text" id="event_location" placeholder="กรอกช่องทางทางออนไลน์ที่จัดกิจกรรม">
                            </div>
                            <div class="form-check" style="display: block;">
                                <input class="form-check-input" type="radio" value= "ออฟไลน์" id="event_location">
                                <label class="form-check-label" >ออนไซต์</label>
                                <input class="form-control custom-width" type="text" id="event_location" placeholder="สถานที่จัดกิจกรรม">
                            </div>
                        </span>
                    </p>
                    <div class="divider"></div>
                    <p class="text-dark text-lg font-weight-normal ">
                        ลิงค์ดาวน์โหลดใบสมัคร/ลิงค์สมัครออนไลน์
                        <span class="text-nddark ms-sm-2 font-weight-bold">
                            <input class="form-control custom-width" type="text" id="event_download_url" placeholder="https://">
                        </span>
                    </p>
                </div>
            </div>
            <!-- ส่วนที่ 3 ระบุรายละเอียดกิจกรรม -->
            <div class="card mb-4">
                <div class="card-header pb-0 p-3">
                    <h3 class="text-dark ">ส่วนที่ 3 ระบุรายละเอียดกิจกรรม</h3>
                </div>
                <div class="parent-container">
                    <img src="../assets/img/activity5.png" alt="" class="responsive-image40" style="padding: 15px;">
                    <img src="../assets/img/activity3.png" alt="" class="responsive-image40">
                </div>
                <div class="card-body p-3">
                    <p class="text-dark text-lg font-weight-normal">
                        อัปโหลดภาพโปสเตอร์เพิ่มเติม (ไม่เกิน 2MB)
                        <div class="mb-3">
                            <p class="text-dark text-sm font-weight-normal ">หากคุณมีภาพโปสเตอร์ค่ายไซส์ A2 หรือสี่เหลี่ยมจัตุรัส</p>
                            <input class="form-control custom-width" type="file" id="event_poster" name="event_poster">
                        </div>
                    </p>
                    <p class="text-dark text-lg font-weight-normal ">
                        รายละเอียดกิจกรรม
                        <span class="text-dark ms-sm-2 font-weight-bold">
                            <textarea class="form-control" id="event_detail_full" rows="3" placeholder="กรุณาระบุรายละเอียดของกิจกรรมทั้งหมด"></textarea>
                        </span>
                    </p>
                </div>
            </div>
        </div>
      </div>
    <!-- ปุ่มส่งข้อมูลกิจกรรม -->
    <p class="text-sm font-weight-light ">การส่งข้อมูลนี้เป็นการส่งข้อมูลเพื่อประชาสัมพันธ์บนเว็บไซต์เท่านั้น ทางทีมงานจะคัดเลือกกิจกรรมที่น่าสนใจไปลงเว็บไซต์ตามความเหมาะสม</p>
    <div class="col-6 text-end">
        <button class="btn bg-gradient-dark mb-0 text-lg" type="submit" id="btn_add_event"><i class="fas fa-plus"></i>&nbsp;&nbsp;ส่งข้อมูลกิจกรรม</button>
    </div>
</form>
    
       
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
    $(document).ready(function() {
        $("#btn_add_event").on("click", function() {
            var sender_name = $("#sender_name").val();
            var sender_email = $("#sender_email").val();
            var sender_tel = $("#sender_tel").val();
            var event_banner = $("#event_banner").val();
            var event_name = $("#event_name").val();
            var event_detail_short = $("#event_detail_short").val();
            var event_date_from = $("#event_date_from").val();
            var event_date_to = $("#event_date_to").val();
            var event_reg_to = $("#event_reg_to").val();
            var event_reg_detail = $("#event_reg_detail").val();
            var event_number = $("#event_number").val();
            var event_fee = $("#event_fee").val();
            // var event_first = $("#event_first").val();
            var event_require = $("#event_require").val();
            var event_location = $("#event_location").val();
            var event_download_url = $("#event_download_url").val();
            var event_detail_full = $("#event_detail_full").val();
            var event_poster = $("#event_poster").val();
            a = {
                sender_name:sender_name,
                sender_email:sender_email,
                sender_tel:sender_tel,
                event_banner:event_banner,
                event_name:event_name,
                event_detail_short:event_detail_short,
                event_date_from:event_date_from,
                event_date_to:event_date_to,
                event_reg_to:event_reg_to,
                event_reg_detail:event_reg_detail,
                event_number:event_number,
                event_fee:event_fee,
                event_require:event_require,
                event_location:event_location,
                event_download_url:event_download_url,
                event_detail_full:event_detail_full,
                event_poster:event_poster
            }
            console.log(a);
            if (confirm("Are you want to add ?") == true) {
                $.ajax({
                    url: "function/api_add_event.php",
                    method: "POST",
                    data: {
                        sender_name:sender_name,
                        sender_email:sender_email,
                        sender_tel:sender_tel,
                        event_banner:event_banner,
                        event_name:event_name,
                        event_detail_short:event_detail_short,
                        event_date_from:event_date_from,
                        event_date_to:event_date_to,
                        event_reg_to:event_reg_to,
                        event_reg_detail:event_reg_detail,
                        event_number:event_number,
                        event_fee:event_fee,
                        event_require:event_require,
                        event_location:event_location,
                        event_download_url:event_download_url,
                        event_detail_full:event_detail_full,
                        event_poster:event_poster
                    }
                    ,success: function(result_insert) {
                        if(result_insert == 1){
                            alert("fail.");
                        }else{
                            alert("success.");
                            // console.log('success');
                            // location.reload();
                        }
                    },
                    error: function(request, status, error) {
                        console.log(request.responseText);
                    }
                });
            }
        });
    });

//     $(document).ready(function() {
//         $("#btn_add_event").on("click", function() {
//             if (confirm("Are you want to add ?") == true) {
//         var sender_name = $("#sender_name").val();
//         var sender_email = $("#sender_email").val();
//         var sender_tel = $("#sender_tel").val();
//         // var event_banner = $("#event_banner").val();
//         var event_name = $("#event_name").val();
//         var event_detail_short = $("#event_detail_short").val();
//         var event_date_from = $("#event_date_from").val();
//         var event_date_to = $("#event_date_to").val();
//         var event_reg_to = $("#event_reg_to").val();
//         var event_reg_detail = $("#event_reg_detail").val();
//         var event_number = $("#event_number").val();
//         var event_fee = $("#event_fee").val();
//         // var event_first = $("#event_first").val();
//         var event_require = $("#event_require").val();
//         var event_location = $("#event_location").val();
//         var event_download_url = $("#event_download_url").val();
//         var event_detail_full = $("#event_detail_full").val();
//         var event_poster = $("#event_poster").val();
//             // if (confirm("Are you want to add ?") == true) {
//                 $.ajax({
//                     url: "function/api_add_event.php",
//                     method: "POST",
//                     data: {
//                         sender_name:sender_name,
//                         sender_email:sender_email,
//                         sender_tel:sender_tel,
//                         event_name:event_name,
//                         event_detail_short:event_detail_short,
//                         event_date_from:event_date_from,
//                         event_date_to:event_date_to,
//                         event_reg_to:event_reg_to,
//                         event_reg_detail:event_reg_detail,
//                         event_number:event_number,
//                         event_fee:event_fee,
//                         event_require:event_require,
//                         event_location:event_location,
//                         event_download_url:event_download_url,
//                         event_detail_full:event_detail_full,
//                         event_poster:event_poster
//                     }
//                     ,success: function($result_insert) {
//                         console.log("success");
//                     }
//                     ,error: function(request, status, error) {
//                         console.log(request.responseText);
//                     }
//                 });
//     });
//   });
</script>
