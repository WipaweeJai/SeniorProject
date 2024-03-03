<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $uploadDirPoster = '../assets/img/upload_event/poster/';
    $uploadDirBanner = '../assets/img/upload_event/banner/';

    if (!file_exists($uploadDirPoster)) {
        mkdir($uploadDirPoster, 0777, true);
    }

    if (!file_exists($uploadDirBanner)) {
        mkdir($uploadDirBanner, 0777, true);
    }

    // วนลูปตรวจสอบแต่ละรูปภาพ
    $imageTypes = ['event_poster', 'event_banner'];

    // สร้าง array เพื่อเก็บเส้นทางของไฟล์ที่อัปโหลด
    $uploadedFiles = [];

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

    // ส่งค่าไปยัง api_add_event
    $_SESSION['path_banner'] = $uploadedFiles['event_poster'];
    $_SESSION['path_poster'] = $$uploadedFiles['event_banner'];

    // ลิ้งค์ไปหน้าที่ต้องการ
    header("Location: api_add_event.php");
    exit();
}
?>
