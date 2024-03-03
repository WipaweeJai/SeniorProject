<?php
require_once('../../backend/dbcon.php');

session_start();

// รับค่าจาก upload_event
$path_banner = $_SESSION['path_banner'];
$path_poster = $_SESSION['path_poster'];

// รับข้อมูลอื่น ๆ จากฟอร์ม
$sender_name = $_POST['sender_name'];
$sender_email = $_POST['sender_email'];
$sender_tel = $_POST['sender_tel'];
$event_name = $_POST['event_name'];
$event_detail_short = $_POST['event_detail_short'];
$event_date_from = $_POST['event_date_from'];
$event_date_to = $_POST['event_date_to'];
$event_reg_to = $_POST['event_reg_to'];
$event_reg_detail = $_POST['event_reg_detail'];
$event_number = $_POST['event_number'];
$event_fee = $_POST['event_fee'];
$event_require = $_POST['event_require'];
$event_location = $_POST['event_location'];
$event_download_url = $_POST['event_download_url'];
$event_detail_full = $_POST['event_detail_full'];

// สร้างคำสั่ง SQL และบันทึกข้อมูล
$sql_insert = "INSERT INTO tb_event(sender_name, sender_email, sender_tel, event_banner, event_poster, event_name, event_detail_short, event_date_from,
event_date_to, event_reg_to, event_reg_detail, event_number, event_fee, event_require, event_location, event_download_url, event_detail_full) 
VALUES ('$sender_name', '$sender_email', '$sender_tel', '$path_banner', '$path_poster', '$event_name', '$event_detail_short', '$event_date_from', '$event_date_to',
'$event_reg_to', '$event_reg_detail', '$event_number', '$event_fee', '$event_require', '$event_location', '$event_download_url',
'$event_detail_full')";
//รูปไม่รวมเป็น1recordกับข้อมูลอื่น

$result_insert = mysqli_query($conn, $sql_insert);

if (!$result_insert) {
    echo "เกิดข้อผิดพลาดในการบันทึกข้อมูล: " . $conn->error . "<br>";
} else {
    echo "อัปโหลดไฟล์และบันทึกข้อมูลเรียบร้อยแล้ว<br>";
    // header("Location: add_event.php");
    exit();
}

if(!$result_insert){
    echo 1;
} else {
    echo 2;
}
$conn->close();

?>