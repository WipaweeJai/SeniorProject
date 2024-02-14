<?php
require_once('../backend/dbcon.php');

if (isset($_POST['activityId']) && isset($_POST['newStatus'])) {
  $activityId = $_POST['activityId'];
  $newStatus = $_POST['newStatus'];

  // ทำคำสั่ง SQL UPDATE เพื่ออัพเดทสถานะ
  $update_sql = "UPDATE tb_event SET status = '$newStatus' WHERE activity_id = '$activityId'";
  if (mysqli_query($conn, $update_sql)) {
    echo "สถานะถูกอัพเดทเรียบร้อยแล้ว";
  } else {
    echo "เกิดข้อผิดพลาดในการอัพเดทสถานะ: " . mysqli_error($conn);
  }
} else {
  echo "ไม่สามารถรับข้อมูลสถานะได้";
}
?>
