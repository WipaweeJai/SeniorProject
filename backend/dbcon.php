<?php
    $server = 'localhost';
    $port = 3306; // ระบุพอร์ตที่ใช้ (ถ้าไม่ได้กำหนด จะใช้พอร์ตเริ่มต้น 3306)
    $username = 'root';
    $password = ''; // ใส่รหัสผ่าน
    $database = 'db_project';

    $conn = mysqli_connect($server, $username, $password, $database, $port);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    } else {
        // echo "Connect success!!";
    }
?>