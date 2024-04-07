<?php
  // เชื่อมต่อฐานข้อมูล
  require_once('../backend/dbcon.php');

  if (isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];

    // สร้างคำสั่ง SQL สำหรับลบข้อมูล
    $sql = "DELETE FROM tb_user WHERE user_id = '$user_id'";

    // ทำการลบข้อมูล
    if (mysqli_query($conn, $sql)) {
      echo 'ลบข้อมูลเรียบร้อยแล้ว';
    } else {
      echo 'เกิดข้อผิดพลาดในการลบข้อมูล: ' . mysqli_error($conn);
    }

    // ปิดการเชื่อมต่อฐานข้อมูล
    mysqli_close($conn);
  } else {
    echo 'ไม่ได้รับข้อมูลการลบ';
  }
?>
