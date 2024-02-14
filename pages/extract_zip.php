<?php
include "../backend/dbcon.php";

// ตรวจสอบว่ามีการส่งไฟล์มาหรือไม่
if (isset($_FILES['zip_file']) && isset($_POST["upload_btn"])) {
    // กำหนด Folder ปลายทางที่จะบันทึกไฟล์
    $target_dir = "../assets/img/zip/";
    $target_file = $target_dir . basename($_FILES["zip_file"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // ตรวจสอบไฟล์ว่าเป็น zip หรือไม่
    if ($imageFileType != "zip") {
        echo "กรุณาอัพโหลดไฟล์ zip เท่านั้น";
        $uploadOk = 0;
    }

    // ตรวจสอบขนาดของไฟล์
    if ($_FILES["zip_file"]["size"] > 500000000) { // 5 MB
        echo "ขออภัย! ไฟล์มีขนาดใหญ่เกินไป";
        $uploadOk = 0;
    }

    // ตรวจสอบว่ามีข้อผิดพลาดในการอัพโหลดไฟล์หรือไม่
    if ($uploadOk == 0) {
        echo "ขออภัย! ไฟล์ของคุณไม่ได้ถูกอัพโหลด";
    } else {
        // ถ้าไม่มีข้อผิดพลาด ก็ทำการย้ายไฟล์ zip ไปที่ต้นทาง
        if (move_uploaded_file($_FILES["zip_file"]["tmp_name"], $target_file)) {
            echo "ไฟล์ ". basename($_FILES["zip_file"]["name"]). " ถูกอัพโหลดเรียบร้อยแล้ว.";

            // เริ่มแตกไฟล์
            $zip = new ZipArchive;
            if ($zip->open($target_file) === TRUE) {
                // สร้างโฟลเดอร์ถ้ายังไม่มี
                $activity_name = $_POST['activity_name']; //รับค่าชื่อกิจกรรมจาก Form
                $target_dir = "../assets/img/zip/" . $activity_name . "/"; //Rename Folderตามชื่อกิจกรรม
                if (!is_dir($target_dir)) {
                    mkdir($target_dir, 0755, true);
                }
                $zip->extractTo($target_dir);
                // เรียกใช้ไฟล์ที่แตกแล้ว
                for ($i = 0; $i < $zip->numFiles; $i++) {
                    $file_name = $zip->getNameIndex($i); // ดึงชื่อไฟล์ใน zip
                    $file_content = $zip->getFromIndex($i); // ดึงเนื้อหาของไฟล์ใน zip
                    
                    // เพิ่มโค้ดที่ใช้ insert เข้า database
                    $file_path = $target_dir . $file_name;
                    $activity_name = $_POST['activity_name'];
                    $sql = "INSERT INTO tb_certificate_template (activity_name, path_cert_temp, upload_date) 
                            VALUES (?, ?, CURRENT_TIMESTAMP())";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ss", $activity_name, $file_path);
                    if ($stmt->execute()) {
                        echo "บันทึกข้อมูล $file_name เข้าฐานข้อมูลเรียบร้อยแล้ว";
                    } else {
                        echo "เกิดข้อผิดพลาดในการบันทึกข้อมูล: " . $conn->error;
                    }
                    $stmt->close();
                }
                $zip->close();
                echo "ไฟล์ zip ถูกแตกและบันทึกลงฐานข้อมูลเรียบร้อยแล้ว";
            } else {
                echo "ขออภัย! เกิดข้อผิดพลาดในการแตกไฟล์ zip";
            }

        } else {
            echo "ขออภัย! เกิดข้อผิดพลาดในการอัพโหลดไฟล์";
        }
    }
    
}

$conn->close();
?>
