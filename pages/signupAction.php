<?php
// เชื่อมต่อกับฐานข้อมูล
require_once('../backend/dbcon.php');

// ตรวจสอบว่ามีการส่งข้อมูลจากแบบฟอร์มหรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับค่าจากฟอร์ม
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $sur_name = mysqli_real_escape_string($conn, $_POST['sur_name']);
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // เข้ารหัสรหัสผ่านก่อนบันทึกลงในฐานข้อมูล (เราสมมติใช้ฟังก์ชั่น password_hash() ที่ PHP มีให้)
    // $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // เตรียมคำสั่ง SQL สำหรับการเพิ่มข้อมูล
    $sql = "INSERT INTO tb_user (name, sur_name, user_id, email, password) VALUES ('$name', '$sur_name', '$user_id', '$email', '$password')";

    // ทำการเพิ่มข้อมูลลงในฐานข้อมูล
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('สมัครสำเร็จ');</script>";
        header("location: login.php");
    } else {
        echo "มีข้อผิดพลาดในการบันทึกข้อมูล: " . mysqli_error($conn);
    }

    // ปิดการเชื่อมต่อกับฐานข้อมูล
    mysqli_close($conn);
}
?>
