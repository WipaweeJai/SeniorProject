<?php
// เชื่อมต่อกับฐานข้อมูล
require_once('../backend/dbcon.php');

// ดึงข้อมูลเหตุการณ์จากฐานข้อมูล
$sql = "SELECT event_date_from, event_date_to FROM tb_event WHERE status = 'Approved'";
$result = mysqli_query($conn, $sql);

// ตรวจสอบว่ามีข้อมูลในฐานข้อมูลหรือไม่
if ($result) {
    // สร้างตัวแปรเพื่อเก็บข้อมูลเหตุการณ์
    $events = array();
    while ($row = mysqli_fetch_assoc($result)) {
        // แปลงรหัส UTF-8 เป็นข้อความที่อ่านง่าย
        $start_date = utf8_decode($row["event_date_from"]);
        $end_date = utf8_decode($row["event_date_to"]);
        // เพิ่มข้อมูลเหตุการณ์ลงในอาร์เรย์
        $events[] = array("start_date" => $start_date, "end_date" => $end_date);
    }
    // ส่งข้อมูลเหตุการณ์กลับเป็น JSON
    echo json_encode($events);
} else {
    // ส่งข้อความแสดงว่าไม่พบข้อมูล
    echo json_encode(array("error" => "No data found"));
}

// ปิดการเชื่อมต่อกับฐานข้อมูล
mysqli_close($conn);
?>
