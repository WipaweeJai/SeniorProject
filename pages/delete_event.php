<?php
// เชื่อมต่อกับฐานข้อมูล
include('../backend/dbcon.php');

// ตรวจสอบว่ามีการส่งค่า activity_id มาหรือไม่
if(isset($_POST['activity_id']) && isset($_POST['status'])) {
    $activity_id = $_POST['activity_id'];
    $status = $_POST['status'];

    // สร้างคำสั่ง SQL สำหรับลบข้อมูลกิจกรรม
    $sql = "UPDATE tb_event SET status = '$status' WHERE activity_id = '$activity_id'";

    // ลบข้อมูลจากฐานข้อมูล
    if (mysqli_query($conn, $sql)) {
        echo "ลบกิจกรรมเรียบร้อยแล้ว";
    } else {
        echo "เกิดข้อผิดพลาดในการลบกิจกรรม: " . mysqli_error($conn);
    }
} else {
    echo "ไม่สามารถรับข้อมูลรหัสกิจกรรมได้";
}

// ปิดการเชื่อมต่อกับฐานข้อมูล
mysqli_close($conn);
?>
