<?php
include "../backend/dbcon.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $uploadDir = '../assets/img/upload_event/';

        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // วนลูปตรวจสอบแต่ละรูปภาพ
        $imageTypes = ['event_poster', 'event_banner'];

        // สร้าง array เพื่อเก็บชื่อไฟล์ที่อัปโหลด
        $uploadedFiles = [];

        foreach ($imageTypes as $imageType) {
            $inputName = $imageType;

            if (isset($_FILES[$inputName]) && $_FILES[$inputName]['error'] === UPLOAD_ERR_OK) {
                $tmpName = $_FILES[$inputName]['tmp_name'];
                $fileName = basename($_FILES[$inputName]['name']);
                $uploadPath = $uploadDir . $fileName;

                move_uploaded_file($tmpName, $uploadPath);

                // เก็บชื่อไฟล์ที่อัปโหลดไว้ใน array
                $uploadedFiles[$imageType] = $fileName;
            } else {
                echo "เกิดข้อผิดพลาดในการอัปโหลดไฟล์ $imageType.<br>";
            }
        }

        // บันทึกรูปภาพในฐานข้อมูล
        $sql = "INSERT INTO tb_event (event_poster, event_banner) VALUES ('{$uploadedFiles['event_poster']}', '{$uploadedFiles['event_banner']}')";

        if ($conn->query($sql) === TRUE) {
            header("Location: form_event.php");
            exit();
            echo "อัปโหลดไฟล์และบันทึกข้อมูลเรียบร้อยแล้ว<br>";
        } else {
            echo "เกิดข้อผิดพลาดในการบันทึกข้อมูล: " . $conn->error . "<br>";
        }

    // ปิดการเชื่อมต่อฐานข้อมูล
    $conn->close();
}
?>
