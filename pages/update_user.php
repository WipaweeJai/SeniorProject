<?php

var_dump($_POST);
// เชื่อมต่อกับฐานข้อมูล
require_once('../backend/dbcon.php');

// ตรวจสอบว่ามีค่า user_id หรือไม่ก่อนที่จะดำเนินการ
if (isset($_POST['user_id']) && !empty($_POST['user_id'])) {
  $user_id = $_POST['user_id'];

  // ตรวจสอบและรับค่าอื่นๆจากฟอร์มเพื่ออัปเดตในฐานข้อมูล
  $email = isset($_POST['email']) ? $_POST['email'] : '';
  $password = isset($_POST['password']) ? $_POST['password'] : '';
  $name = isset($_POST['name']) ? $_POST['name'] : '';
  
  // ทำการอัปเดตข้อมูลในฐานข้อมูล
  $sql = "UPDATE tb_user SET 
          email = '$email',
          password = '$password',
          name = '$name'
          WHERE user_id = '$user_id'";

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
  echo "ไม่มีการรับค่ารหัสผู้ใช้จากฟอร์ม";
}

// ปิดการเชื่อมต่อฐานข้อมูล
mysqli_close($conn);
?>
