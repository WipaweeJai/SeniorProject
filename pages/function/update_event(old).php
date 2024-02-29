<?php
// เชื่อมต่อกับฐานข้อมูล
require_once('../../backend/dbcon.php');

// ตรวจสอบว่ามีค่า $_POST['activity_id'] และ $_POST['status'] หรือไม่ก่อนที่จะดำเนินการ
if (isset($_POST['activity_id'], $_POST['status'])) {
  // รับค่าจากฟอร์ม
  $activity_id = mysqli_real_escape_string($conn, $_POST['activity_id']);
  $status = mysqli_real_escape_string($conn, $_POST['status']);
  $type = mysqli_real_escape_string($conn, $_POST['type']);
  $event_date_from = mysqli_real_escape_string($conn, $_POST['event_date_from']);
  $event_date_to = mysqli_real_escape_string($conn, $_POST['event_date_to']);
  $event_reg_to = mysqli_real_escape_string($conn, $_POST['event_reg_to']);
  $event_number = mysqli_real_escape_string($conn, $_POST['event_number']);
  $event_fee = mysqli_real_escape_string($conn, $_POST['event_fee']);
  $requirements = mysqli_real_escape_string($conn, $_POST['requirements']);
  $event_location = mysqli_real_escape_string($conn, $_POST['event_location']);
  $event_detail_full = mysqli_real_escape_string($conn, $_POST['event_detail_full']);

  // เขียนคำสั่ง SQL เพื่ออัปเดตข้อมูล
  $sql = "UPDATE tb_event SET 
          status = '$status',
          type = '$type',
          event_date_from = '$event_date_from',
          event_date_to = '$event_date_to',
          event_reg_to = '$event_reg_to',
          event_number = '$event_number',
          event_fee = '$event_fee',
          requirements = '$requirements',
          event_location = '$event_location',
          event_detail_full = '$event_detail_full'
          WHERE activity_id = '$activity_id'"; // ใส่เงื่อนไข WHERE เพื่อระบุว่าจะอัปเดตแถวใด

  // ทำการอัปเดต
  if (mysqli_query($conn, $sql)) {
    echo "อัปเดตข้อมูลเรียบร้อยแล้ว";
  } else {
    echo "เกิดข้อผิดพลาดในการอัปเดตข้อมูลBack: " . mysqli_error($conn);
  }
} else {
  // ถ้าไม่มีค่า $_POST['activity_id'] หรือ $_POST['status'] ไม่ให้ดำเนินการ
  echo "ไม่มีข้อมูลที่จำเป็นสำหรับการอัปเดตข้อมูล";
}

// ปิดการเชื่อมต่อฐานข้อมูล
mysqli_close($conn);
?>
