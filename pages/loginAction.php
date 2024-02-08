<?php
session_start();
// var_dump($_POST);
require_once('../backend/dbcon.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT * FROM tb_user WHERE user_id = '$user_id' and password = '$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $row['user_id'];
        header("location: index.php");
    } else {
        // ไม่พบผู้ใช้ในฐานข้อมูล
        echo "<script>alert('ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง');</script>";
        header("refresh:0; url=login.php");
    }
}
?>
