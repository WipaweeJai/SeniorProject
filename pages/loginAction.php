<?php
session_start();
require_once('../backend/dbcon.php');
$_SESSION = array();
session_destroy(); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT * FROM tb_user WHERE email = '$email' and password = '$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        session_start();
        $_SESSION['name'] = $row['name'];
        header("location: index.php");
    } else {
        // ไม่พบผู้ใช้ในฐานข้อมูล
        echo "<script>alert('ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง');</script>";
        header("refresh:0; url=login.php");
    }
}
?>
