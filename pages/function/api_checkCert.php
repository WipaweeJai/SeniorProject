<?php
// require_once('../../backend/dbcon.php');
// $refInput = $_POST['refInput'];

// $sql_check_cert = "SELECT cert_Ref FROM tb_certificate WHERE cert_Ref = '$refInput'";
// $result_check_cert = mysqli_query($conn, $sql_check_cert);

// // พบใบประกาศ
// if(mysqli_num_rows($result_check_cert) != 0) {
//     echo 'true';
// // ไม่พบใบประกาศ
// } else {
//     echo 'false';
// }

require_once('../../backend/dbcon.php');

// รับค่า refInput จาก AJAX
$refInput = $_POST['refInput'];

$sql_check_cert = "SELECT cert_Ref, name, activity_id FROM tb_certificate WHERE cert_Ref = '$refInput'";
$result_check_cert = mysqli_query($conn, $sql_check_cert);

// ตรวจสอบว่าพบใบประกาศหรือไม่
if(mysqli_num_rows($result_check_cert) != 0) {
    // ดึงข้อมูลจากฐานข้อมูล
    $row = mysqli_fetch_assoc($result_check_cert);
    // ส่งข้อมูลในรูปแบบ JSON
    echo json_encode($row);
} else {
    echo 'false ';
}

mysqli_close($conn);



?>

