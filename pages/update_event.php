<?php

var_dump($_POST);
// เชื่อมต่อกับฐานข้อมูล
require_once('../backend/dbcon.php');

// ตรวจสอบว่ามีค่า $_POST['activity_id'] และ $_POST['status'] หรือไม่ก่อนที่จะดำเนินการ
if (isset($_POST['activity_id']) && !empty($_POST['activity_id'])) {
  $activity_id = $_POST['activity_id'];

  // ตรวจสอบและรับค่าอื่นๆจากฟอร์มเพื่ออัปเดตในฐานข้อมูล
  $event_name = isset($_POST['event_name']) ? $_POST['event_name'] : '';
  $status = isset($_POST['status']) ? $_POST['status'] : '';
  $type = isset($_POST['type']) ? $_POST['type'] : '';
  // $event_date = isset($_POST['event_date']) ? $_POST['event_date'] : '';
  $event_reg_to = isset($_POST['event_reg_to']) ? $_POST['event_reg_to'] : '';
  $event_number = isset($_POST['event_number']) ? $_POST['event_number'] : '';
  $event_fee = isset($_POST['event_fee']) ? $_POST['event_fee'] : '';
  $requirements = isset($_POST['requirements']) ? $_POST['requirements'] : '';
  $event_location = isset($_POST['event_location']) ? $_POST['event_location'] : '';
  $event_detail_full = isset($_POST['event_detail_full']) ? $_POST['event_detail_full'] : '';
  
  // ทำการอัปเดตข้อมูลในฐานข้อมูล
  $sql = "UPDATE tb_event SET 
          event_name = '$event_name',
          status = '$status',
          type = '$type',
          event_reg_to = '$event_reg_to',
          event_number = '$event_number',
          event_fee = '$event_fee',
          requirements = '$requirements',
          event_location = '$event_location',
          event_detail_full = '$event_detail_full'
          WHERE activity_id = '$activity_id'";

  $result = mysqli_query($conn, $sql);
  echo $sql;

  if (!$result) {
    echo "Error: " . mysqli_error($conn);
  }
  // ตรวจสอบคำสั่ง SQL query ว่าสำเร็จหรือไม่
  if ($result) {
      echo "อัปเดตข้อมูลสำเร็จ";
  } else {
      echo "เกิดข้อผิดพลาดในการอัปเดตข้อมูล";
  }
} else {
  echo "ไม่มีการรับค่ารหัสกิจกรรมจากฟอร์ม";
}

// ปิดการเชื่อมต่อฐานข้อมูล
mysqli_close($conn);
?>
