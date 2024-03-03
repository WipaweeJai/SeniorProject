<?php
require_once('../backend/dbcon.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Path ยังไม่ไป
    $uploadDirBanner = '../assets/img/upload_event/banner/';
    $uploadDirPoster = '../assets/img/upload_event/poster/';

    // สร้างโฟลเดอร์หากยังไม่มี
    if (!file_exists($uploadDirBanner)) {
        mkdir($uploadDirBanner, 0777, true);
    }
    if (!file_exists($uploadDirPoster)) {
        mkdir($uploadDirPoster, 0777, true);
    }

    // รับข้อมูลจากการอัปโหลดไฟล์
    $uploadedFiles = [];
    $imageTypes = ['event_banner', 'event_poster'];

    foreach ($imageTypes as $imageType) {
        $inputName = $imageType;

        if (isset($_FILES[$inputName]) && $_FILES[$inputName]['error'] === UPLOAD_ERR_OK) {
            $tmpName = $_FILES[$inputName]['tmp_name'];
            $fileName = basename($_FILES[$inputName]['name']);
            $uploadPath = ($imageType === 'event_poster') ? $uploadDirPoster . $fileName : $uploadDirBanner . $fileName;

            move_uploaded_file($tmpName, $uploadPath);

            // เก็บเส้นทางของไฟล์ที่อัปโหลดไว้ใน array
            $uploadedFiles[$imageType] = $uploadPath;
        } else {
            echo "เกิดข้อผิดพลาดในการอัปโหลดไฟล์ $imageType.<br>";
        }
    }


    // รับข้อมูลอื่น ๆ จากฟอร์ม
    // $sender_name = $_POST['sender_name'];
    // $sender_email = $_POST['sender_email'];
    // $sender_tel = $_POST['sender_tel'];
    $event_name = $_POST['event_name'];
    $event_detail_short = $_POST['event_detail_short'];
    $event_date_from = $_POST['event_date_from'];
    $event_date_to = $_POST['event_date_to'];
    $event_reg_to = $_POST['event_reg_to'];
    $event_reg_detail = $_POST['event_reg_detail'];
    $event_number = $_POST['event_number'];
    $event_fee = $_POST['event_fee'];
    $event_require = $_POST['event_require'];
    $event_location = $_POST['event_location'];
    $event_download_url = $_POST['event_download_url'];
    $event_detail_full = $_POST['event_detail_full'];

    // สร้างคำสั่ง SQL และบันทึกข้อมูล
    $sql_insert = "INSERT INTO tb_event(event_banner, event_poster, event_name, event_detail_short, event_date_from,
    event_date_to, event_reg_to, event_reg_detail, event_number, event_fee, event_require, event_location, event_download_url, event_detail_full) 
    VALUES ('{$uploadedFiles['event_banner']}', '{$uploadedFiles['event_poster']}', '$event_name', '$event_detail_short', '$event_date_from', '$event_date_to',
    '$event_reg_to', '$event_reg_detail', '$event_number', '$event_fee', '$event_require', '$event_location', '$event_download_url',
    '$event_detail_full')";
    //รูปไม่รวมเป็น1recordกับข้อมูลอื่น

    $result_insert = mysqli_query($conn, $sql_insert);

    if (!$result_insert) {
        echo "เกิดข้อผิดพลาดในการบันทึกข้อมูล: " . $conn->error . "<br>";
    } else {
        echo "อัปโหลดไฟล์และบันทึกข้อมูลเรียบร้อยแล้ว<br>";
        // header("Location: add_event.php");
        exit();
    }

    if(!$result_insert){
        echo 1;
    } else {
        echo 2;
    }
    $conn->close();
}
?>