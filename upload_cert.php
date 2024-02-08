<?php
include "../backend/dbcon.php"; // เชื่อมต่อกับฐานข้อมูล

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["pdfFile"])) {
    $targetDir = "../assets/img/upload_cert_temp/"; // โฟลเดอร์ที่จะบันทึกไฟล์
    $targetFile = $targetDir . basename($_FILES["pdfFile"]["name"]);
    $uploadOk = 1;
    $pdfFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // ตรวจสอบว่าไฟล์เป็น PDF หรือไม่
    if ($pdfFileType != "pdf") {
        echo "ขออภัย! ไฟล์ที่อัพโหลดต้องเป็นไฟล์ PDF";
        $uploadOk = 0;
    }

    // ตรวจสอบว่ามีไฟล์นี้อยู่แล้วหรือไม่
    if (file_exists($targetFile)) {
        echo "ขออภัย! ไฟล์นี้ถูกอัพโหลดแล้ว";
        $uploadOk = 0;
    }

    // ตรวจสอบขนาดของไฟล์
    if ($_FILES["pdfFile"]["size"] > 5000000) { // 5 MB
        echo "ขออภัย! ไฟล์มีขนาดใหญ่เกินไป";
        $uploadOk = 0;
    }

    // ตรวจสอบว่า $uploadOk มีค่าเป็น 0 หรือไม่
    if ($uploadOk == 0) {
        echo "ขออภัย! ไฟล์ไม่ได้ถูกอัพโหลด";
    } else {
        // ถ้าทุกอย่างถูกต้อง ให้ย้ายไฟล์ไปยังโฟลเดอร์ปลายทาง
        if (move_uploaded_file($_FILES["pdfFile"]["tmp_name"], $targetFile)) {
            // เพิ่มที่อยู่ของไฟล์ลงในฐานข้อมูล
            $path_cert = $targetFile;

            // รับค่า activity_name จากฟอร์ม
            $activity_name = $_POST['activity_name'];
            
             // เพิ่ม activity_name และ path_cert_temp ลงในฐานข้อมูล
            $query = "INSERT INTO tb_certificate_template (activity_name, path_cert_temp) VALUES ('$activity_name', '$path_cert')";
            
            if ($conn->query($query) === TRUE) {
                echo "ไฟล์ ". htmlspecialchars(basename($_FILES["pdfFile"]["name"])). " ถูกอัพโหลดและบันทึกลงในฐานข้อมูลเรียบร้อย";
                // ทำการ redirect ไปยังหน้า Form ใส่ Certificate
                header("Location: form_cert.php");
                exit();
            } else {
                echo "ขออภัย! มีบางอย่างผิดพลาดในการบันทึกข้อมูลลงในฐานข้อมูล: " . $conn->error;
            }
        } else {
            echo "ขออภัย! มีบางอย่างผิดพลาดในการอัพโหลดไฟล์";
        }
    }
} else {
    echo "ขออภัย! มีบางอย่างผิดพลาดในการรับข้อมูล";
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>
