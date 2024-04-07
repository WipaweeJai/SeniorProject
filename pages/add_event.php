<?php
session_start();
@$name = $_SESSION['name'];
if (!isset($_SESSION['name'])) {
    header("Location: login.php");
    exit();
}
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
    <!-- jQ -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body class="g-sidenav-show  bg-gray-100">
    <?php
    include "layout/navbar.php";
    require_once ('../backend/dbcon.php');
    ?>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur"
            navbar-scroll="true">
            <div class="container-fluid py-1 px-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">หน้า</a>
                        </li>
                        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">กรอกข้อมูลกิจกรรม</li>
                    </ol>
                    <h6 class="font-weight-bolder mb-0">กรอกข้อมูลกิจกรรม</h6>
                </nav>
                <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                    <ul class="ms-md-auto pe-md-3 d-flex align-items-center navbar-nav  justify-content-end">
                        <li class="nav-item d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-body font-weight-bold px-0">
                                <?php
                                if (isset($name)) {
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
        <div class="container-fluid py-4">
            <div class="page-header min-height-300 border-radius-xl mt-4"
                style="background-image: url('../assets/img/add_activity3.png'); background-position-y: 50%;">
            </div>
            <div class="row">

                <div class="container-fluid py-4">
                    <div class="row">
                        <!-- ส่วนที่ 1 พาดหัวข่าว และรูปภาพกิจกรรม -->
                        <div class="card mb-4">
                            <div class="card-header pb-0 p-3">
                                <h3 class="text-dark ">ส่วนที่ 1 พาดหัวข่าว และรูปภาพกิจกรรม</h3>
                            </div>
                            <div class="card-body p-3">
                                <form action="" method="post" enctype="multipart/form-data" id="event_form">
                                    <?php
                                    $name = $_SESSION['name'];
                                    $sql = "SELECT email FROM tb_user WHERE name = '$name'";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        $row = $result->fetch_assoc();
                                        $email = $row['email'];
                                    }
                                    ?>
                                    <input type="text" id="sender_name" name="sender_name" value="<?php echo $name; ?>"
                                        hidden>
                                    <input type="text" id="sender_email" name="sender_email"
                                        value="<?php echo $email; ?>" hidden>

                                    <p class="text-dark text-lg font-weight-normal">
                                        อัปโหลดภาพหัวข่าว ขนาด 1200 x 630 พิกเซล (ไม่เกิน 2MB)
                                        <a class="btn bg-gradient-info btn-sm mt-3 font-weight-normal"
                                            onclick="openModal('myModal1')">ข้อกำหนด</a>
                                    <div id="myModal1" class="modal1">
                                        <div class="modal2-content-wrapper">
                                            <img class="modal1-content responsive-image40" style="max-width: 50%;"
                                                id="img01" src="../assets/img/activity4.png" alt="">
                                            <span class="close" onclick="closeModal('myModal1')">&times;</span>
                                        </div>
                                    </div>
                                    </p>
                                    <div class="mb-3">
                                        <p class="text-dark text-sm font-weight-normal ">หากไม่อัปโหลดภาพให้ตรงตามขนาด
                                            หรือไม่อัปโหลดภาพนี้เข้ามาให้ถูกต้อง ทางเพจจะไม่เพิ่มลงเว็บให้</p>
                                        <input class="form-control custom-width" type="file" id="event_banner"
                                            name="event_banner" required>
                                    </div>
                                    <p class="text-dark text-lg font-weight-normal ">
                                        ชื่อกิจกรรม
                                        <span class="text-dark ms-sm-2 font-weight-bold">
                                            <p class="text-sm font-weight-light ">จำกัดจำนวนตัวอักษร 60 ตัว</p>
                                            <input class="form-control custom-width" type="text" id="event_name"
                                                name="event_name" placeholder="กรุณาพิมพ์ชื่อกิจกรรม" maxlength="60"
                                                required>
                                        </span>
                                    </p>
                                    <p class="text-dark text-lg font-weight-normal ">
                                        คำโปรยของกิจกรรม
                                        <span class="text-dark ms-sm-2 font-weight-bold">
                                            <p class="text-sm font-weight-light ">จำกัดจำนวนตัวอักษร 120 ตัว</p>
                                            <textarea class="form-control custom-width" type="text" rows="3"
                                                id="event_detail_short" name="event_detail_short"
                                                placeholder="กรุณาพิมพ์คำอธิบายกิจกรรมคร่าว ๆ ที่เชิญชวนให้คนสนใจ"
                                                maxlength="120" required></textarea>
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
                                        <p class="text-dark font-weight-bold ">วันที่เริ่มต้น</p>
                                        <input class="form-control custom-width" type="date" id="event_date_from"
                                            name="event_date_from" required>
                                    </span>
                                    <span class="text-dark ms-sm-2">
                                        <p class="text-dark font-weight-bold ">วันที่สิ้นสุด</p>
                                        <input class="form-control custom-width" type="date" id="event_date_to"
                                            name="event_date_to" required>
                                    </span>
                                </p>
                                <p class="text-dark text-lg font-weight-normal ">
                                    วันที่รับสมัครวันสุดท้าย
                                    <span class="text-dark ms-sm-2">
                                        <input class="form-control custom-width" type="date" id="event_reg_to"
                                            name="event_reg_to" required>
                                    </span>
                                </p>
                                <div class="divider"></div>
                                <p class="text-dark text-lg font-weight-normal">
                                    จำนวนคนที่เปิดรับ
                                    <span class="text-nddark ms-sm-2 font-weight-bold">
                                        <input class="form-control custom-width" type="text" id="event_number"
                                            name="event_number" placeholder="เช่น 50 คน , ไม่จำกัด" required>
                                    </span>
                                </p>
                                <div class="divider"></div>
                                <p class="text-dark text-lg font-weight-normal">
                                    ค่าใช้จ่าย
                                    <span class="text-nddark ms-sm-2 font-weight-bold">
                                        <p class="text-sm font-weight-light ">(กรุณากรอกเฉพาะราคาปกติต่อ 1 คน เท่านั้น)
                                        </p>
                                        <input class="form-control custom-width" type="text" id="event_fee"
                                            name="event_fee" placeholder="เช่น 500 บาท , ฟรี" required>
                                    </span>
                                </p>
                                <div class="divider"></div>
                                <p class="text-dark text-lg font-weight-normal ">
                                    คุณสมบัติ
                                    <span class="text-nddark ms-sm-2 font-weight-bold">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="ชั้นปี 1"
                                                id="event_level_1" name="event_levels[]">
                                            <label class="form-check-label">ชั้นปี 1</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="ชั้นปี 2"
                                                id="event_level_2" name="event_levels[]">
                                            <label class="form-check-label">ชั้นปี 2</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="ชั้นปี 3"
                                                id="event_level_3" name="event_levels[]">
                                            <label class="form-check-label">ชั้นปี 3</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="ชั้นปี 4"
                                                id="event_level_4" name="event_levels[]">
                                            <label class="form-check-label">ชั้นปี 4</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="ชั้นปี 5 ขึ้นไป"
                                                id="event_level_5" name="event_levels[]">
                                            <label class="form-check-label">ชั้นปีมากกว่า 5 ขึ้นไป</label>
                                        </div>
                                    </span>
                                </p>
                                <p class="text-dark text-lg font-weight-normal ">
                                    คุณสมบัติเพิ่มเติม
                                    <span class="text-nddark ms-sm-2 font-weight-bold">
                                        <p class="text-sm font-weight-light ">(ข้อจำกัดต่าง ๆ เช่น อายุ สาขา เกรดเฉลี่ย)
                                        </p>
                                        <input class="form-control custom-width" type="text" id="event_require"
                                            name="event_require" placeholder="คุณสมบัติเพิ่มเติม" required>
                                    </span>
                                </p>
                                <div class="divider"></div>
                                <p class="text-dark text-lg font-weight-normal ">
                                    สถานที่จัดกิจกรรม
                                    <span class="text-nddark ms-sm-2 font-weight-bold">
                                        <div class="form-check" style="display: block;">
                                            <input class="form-check-input" type="radio" value="1" id="online"
                                                name="type">
                                            <label class="form-check-label">ออนไลน์</label>
                                        </div>
                                        <div class="form-check" style="display: block;">
                                            <input class="form-check-input" type="radio" value="2" id="onsite"
                                                name="type">
                                            <label class="form-check-label">ออนไซต์</label>
                                        </div>
                                        <input class="form-control custom-width" type="text" id="event_location"
                                            name="event_location"
                                            placeholder="กรอกสถานที่จัดกิจกรรม หรือช่องทางทางออนไลน์ที่จัดกิจกรรม"
                                            required>
                                    </span>
                                </p>
                                <div class="divider"></div>
                                <p class="text-dark text-lg font-weight-normal ">
                                    ลิงค์ดาวน์โหลดใบสมัคร/ลิงค์สมัครออนไลน์
                                    <span class="text-nddark ms-sm-2 font-weight-bold">
                                        <input class="form-control custom-width" type="text" id="event_download_url"
                                            name="event_download_url" placeholder="https://" required>
                                    </span>
                                </p>
                            </div>
                        </div>
                        <!-- ส่วนที่ 3 ระบุรายละเอียดกิจกรรม -->
                        <div class="card mb-4">
                            <div class="card-header pb-0 p-3">
                                <h3 class="text-dark ">ส่วนที่ 3 ระบุรายละเอียดกิจกรรม</h3>
                            </div>
                            <div class="card-body p-3">
                                <p class="text-dark text-lg font-weight-normal">
                                    อัปโหลดภาพโปสเตอร์เพิ่มเติม (ไม่เกิน 2MB)
                                    <a class="btn bg-gradient-info btn-sm mt-3 font-weight-normal"
                                        onclick="openModal('myModal2')">ข้อกำหนด</a>
                                <div id="myModal2" class="modal1">
                                    <div class="modal1-content-wrapper">
                                        <img class="modal1-content" id="img02" src="../assets/img/activity5.png" alt="">
                                        <span class="close" onclick="closeModal('myModal2')">&times;</span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <p class="text-dark text-sm font-weight-normal ">หากคุณมีภาพโปสเตอร์ค่ายไซส์ A2
                                        หรือสี่เหลี่ยมจัตุรัส</p>
                                    <input class="form-control custom-width" type="file" id="event_poster"
                                        name="event_poster">
                                </div>
                                </p>
                                <p class="text-dark text-lg font-weight-normal ">
                                    รายละเอียดกิจกรรม
                                    <span class="text-dark ms-sm-2 font-weight-bold">
                                        <textarea class="form-control" id="event_detail_full" rows="3"
                                            name="event_detail_full"
                                            placeholder="กรุณาระบุรายละเอียดของกิจกรรมทั้งหมด"></textarea>
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ปุ่มส่งข้อมูลกิจกรรม -->
                <p class="text-sm font-weight-light ">
                    การส่งข้อมูลนี้เป็นการส่งข้อมูลเพื่อประชาสัมพันธ์บนเว็บไซต์เท่านั้น
                    ทางทีมงานจะคัดเลือกกิจกรรมที่น่าสนใจไปลงเว็บไซต์ตามความเหมาะสม</p>
                <div class="col-6 text-end">
                    <button class="btn bg-gradient-dark mb-0 text-lg" type="submit" id="btn_add_event"><i
                            class="fas fa-plus"></i>&nbsp;&nbsp;ส่งข้อมูลกิจกรรม</button>
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
    // document.getElementById('btn_add_event').addEventListener('click', function() {
    //     var formData = new FormData(document.getElementById('event_form'));
    //     var event_name = formData.get('event_name'); // ดึงค่าชื่อกิจกรรมจาก FormData

    //     if(event_name.trim() !== '') { // ตรวจสอบว่ามีค่าว่างหรือไม่
    //         fetch('api_add_event.php', {
    //             method: 'POST',
    //             body: formData
    //         })
    //         .then(response => response.text())
    //         .then(result => {
    //             console.log(result);
    //             alert("เพิ่มกิจกรรมเรียบร้อยแล้ว");
    //             window.location.href = "index.php";
    //         })
    //         .catch(error => {
    //             console.error('Error:', error);
    //         });
    //     } else {
    //         alert("กรุณากรอกข้อมูลให้ครบถ้วน"); // แสดงข้อความเตือน
    //     }
    // });
    document.getElementById('btn_add_event').addEventListener('click', function () {
        var formData = new FormData(document.getElementById('event_form'));
        var isValid = true;
        for (var value of formData.values()) {
            if (value === '' || value === null) {
                isValid = false;
                break;
            }
        }

        if (isValid) {
            fetch('api_add_event.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.text())
                .then(result => {
                    console.log(result);
                    alert("เพิ่มกิจกรรมเรียบร้อยแล้ว");
                    window.location.href = "index.php";
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        } else {
            alert("กรุณากรอกข้อมูลให้ครบถ้วน");
        }
    });



    function openModal(modalId) {
        var modal = document.getElementById(modalId);
        modal.style.display = "block";
    }

    function closeModal(modalId) {
        var modal = document.getElementById(modalId);
        modal.style.display = "none";
    }
</script>