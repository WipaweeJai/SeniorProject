<?php
// เชื่อมต่อกับฐานข้อมูล
require_once('../backend/dbcon.php');

// ดึงข้อมูล start_event และ end_event จากฐานข้อมูล
$sql = "SELECT event_date_from AS start_date, event_date_to AS end_date FROM tb_event";
$result = mysqli_query($conn, $sql);

// ตรวจสอบว่ามีข้อมูลในฐานข้อมูลหรือไม่
if ($result) {
    // ส่งข้อมูลกลับเป็น JSON หากมีข้อมูล
    $data = mysqli_fetch_assoc($result);
    echo json_encode($data);
} else {
    // ส่งข้อความแสดงว่าไม่พบข้อมูล
    echo json_encode(array("error" => "No data found"));
}

// ปิดการเชื่อมต่อกับฐานข้อมูล
mysqli_close($conn);
?>
