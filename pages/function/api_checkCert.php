<?php
require_once('../../backend/dbcon.php');
$refInput = $_POST['refInput'];

$sql_check_cert = "SELECT cert_Ref FROM tb_certificate WHERE cert_Ref = '$refInput'";
$result_check_cert = mysqli_query($conn, $sql_check_cert);

// พบใบประกาศ
if(mysqli_num_rows($result_check_cert) != 0) {
    echo 'true';
// ไม่พบใบประกาศ
} else {
    echo 'false';
}

?>

