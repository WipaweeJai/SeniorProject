<?php
require_once('../backend/dbcon.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check if user_id or email already exists
    $sql_check_existing = "SELECT * FROM tb_user WHERE user_id = 'b$user_id' OR email = '$email'";
    $result_check_existing = mysqli_query($conn, $sql_check_existing);
    if (mysqli_num_rows($result_check_existing) > 0) {
        echo "<script>
                if (confirm('พบผู้ใช้หรืออีเมลนี้ในระบบแล้ว ต้องการล็อกอินหรือไม่?')) {
                    window.location='login.php';
                } else {
                    window.location='signup.php';
                }
              </script>";
    } else {
        if ($status == "student") {
            $sql = "INSERT INTO tb_user (status, name, user_id, email, password)
                    VALUES ('$status','$name', 'b$user_id', '$email', '$password')";
            if (mysqli_query($conn, $sql)) {
                echo "<script>alert('ลงทะเบียนสมาชิกสำเร็จ'); window.location='login.php';</script>";
            } else {
                echo "มีข้อผิดพลาดในการบันทึกข้อมูล: " . mysqli_error($conn);
            }
        } else {
            // Get the latest user_id for external users
            $sql_get_latest_external_id = "SELECT user_id FROM tb_user WHERE status = 'external' ORDER BY user_id DESC LIMIT 1";
            $result = mysqli_query($conn, $sql_get_latest_external_id);
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $latest_external_id = $row['user_id'];
                $numeric_part = (int)substr($latest_external_id, 3);
                $numeric_part++;
                $new_user_id = 'ext' . str_pad($numeric_part, 4, "0", STR_PAD_LEFT);
            } else {
                // If no external user -start from ext0001
                $new_user_id = 'ext0001';
            }
            
            $sql = "INSERT INTO tb_user (status, name, user_id, email, password)
                    VALUES ('$status','$name', '$new_user_id', '$email', '$password')";
            if (mysqli_query($conn, $sql)) {
                echo "<script>alert('ลงทะเบียนสมาชิกสำเร็จ'); window.location='login.php';</script>";
            } else {
                echo "มีข้อผิดพลาดในการบันทึกข้อมูล: " . mysqli_error($conn);
            }
        }
    }
    mysqli_close($conn);
}
?>
