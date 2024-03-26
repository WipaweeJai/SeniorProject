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
                $event_name = $_POST['event_name']; //รับค่าชื่อกิจกรรมจาก Form

                $sql = "SELECT activity_id FROM tb_event WHERE event_name = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $event_name);
                $stmt->execute();
                $result = $stmt->get_result();

                // ตรวจสอบว่ามีผลลัพธ์ที่สอดคล้องหรือไม่
                if ($result->num_rows > 0) {
                    // ดึงข้อมูล activity_id จากผลลัพธ์
                    $row = $result->fetch_assoc();
                    $activity_id = $row['activity_id'];

                    // ใช้ activity_id ในการสร้างชื่อโฟลเดอร์
                    $target_dir = "../assets/img/zip/" . $activity_id . "/";
                } else {
                    // หากไม่พบ activity_id ที่สอดคล้องกับ event_name ที่รับมา
                    echo "ไม่พบกิจกรรมที่ตรงกับชื่อที่ระบุ";
                }
                    
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
                    $event_name = $_POST['event_name'];
                    
                    $sql = "INSERT INTO tb_certificate_template (activity_id, event_name, path_cert_temp, upload_date,status) 
                            VALUES (?, ?, ?, CURRENT_TIMESTAMP(), 'waiting')";
                   
                    $stmt = $conn->prepare($sql);
                    
                    $stmt->bind_param("sss", $activity_id, $event_name, $file_path); 
                    if ($stmt->execute()) {
                        echo "บันทึกข้อมูล $file_name เข้าฐานข้อมูลเรียบร้อยแล้ว";
                    } else {
                        echo "เกิดข้อผิดพลาดในการบันทึกข้อมูล: " . $conn->error;
                    }
                    $stmt->close();
                }
                $zip->close();
                echo "ไฟล์ zip ถูกแตกและบันทึกลงฐานข้อมูลเรียบร้อยแล้ว";
                echo "<script>alert('อัปโหลดเรียบร้อยแล้ว'); window.location.href = 'event_detail.php?id=$activity_id';</script>";
            } else {
                echo "ขออภัย! เกิดข้อผิดพลาดในการแตกไฟล์ zip";
            }

        } else {
            echo "ขออภัย! เกิดข้อผิดพลาดในการอัพโหลดไฟล์";
        }
    }
}

require_once("excel/Classes/PHPExcel.php");
// ตรวจสอบไฟล์ Excel และการกดปุ่ม Upload
if (isset($_FILES['excel_file']) && isset($_POST["upload_btn"])) {
    // กำหนด Folder ปลายทางที่จะบันทึกไฟล์ Excel
    $excel_target_dir = "../assets/img/excel/";
    $excel_target_file = $excel_target_dir . basename($_FILES["excel_file"]["name"]);
    $excel_uploadOk = 1;
    $excelFileType = strtolower(pathinfo($excel_target_file, PATHINFO_EXTENSION));

    // ตรวจสอบไฟล์ว่าเป็น Excel หรือไม่
    if ($excelFileType != "xls" && $excelFileType != "xlsx") {
        echo "กรุณาอัพโหลดไฟล์ Excel เท่านั้น";
        $excel_uploadOk = 0;
    }

    // ตรวจสอบขนาดของไฟล์
    if ($_FILES["excel_file"]["size"] > 5000000) { // 5 MB
        echo "ขออภัย! ไฟล์ Excel มีขนาดใหญ่เกินไป";
        $excel_uploadOk = 0;
    }

    // ตรวจสอบว่ามีข้อผิดพลาดในการอัพโหลดไฟล์ Excel หรือไม่
    if ($excel_uploadOk == 0) {
        echo "ขออภัย! ไฟล์ Excel ของคุณไม่ได้ถูกอัพโหลด";
    } else {
        // ถ้าไม่มีข้อผิดพลาด ก็ทำการย้ายไฟล์ Excel ไปที่ต้นทาง
        if (move_uploaded_file($_FILES["excel_file"]["tmp_name"], $excel_target_file)) {
            echo "ไฟล์ Excel ". basename($_FILES["excel_file"]["name"]). " ถูกอัพโหลดเรียบร้อยแล้ว.";

            // อ่านข้อมูลจากไฟล์ Excel
            $objPHPExcel = PHPExcel_IOFactory::load($excel_target_file);
            $sheet = $objPHPExcel->getActiveSheet();
            $highestRow = $sheet->getHighestRow();

            // ดึงข้อมูล activity_id จากฐานข้อมูล
            $event_name = $_POST['event_name'];
            $sql = "SELECT activity_id FROM tb_event WHERE event_name = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $event_name);
            $stmt->execute();
            $result = $stmt->get_result();

            // ตรวจสอบว่ามีผลลัพธ์ที่สอดคล้องหรือไม่
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $activity_id = $row['activity_id'];

                // เพิ่มข้อมูลลงในฐานข้อมูล
                $sql = "INSERT INTO tb_participants (activity_id, path_excel, user_id, name) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);

                // วนลูปเพื่อเพิ่มข้อมูลลงในฐานข้อมูล
                for ($row = 2; $row <= $highestRow; $row++) {
                    $user_id = $sheet->getCellByColumnAndRow(0, $row)->getValue();
                    $name = $sheet->getCellByColumnAndRow(1, $row)->getValue();

                    // เปลี่ยนการเก็บค่า user_id เป็นแบบ 'b$user_id'
                    $user_id_modified = 'b' . $user_id;

                    // แสดงค่า user_id และ name ออกมาก่อนที่จะทำการบันทึกลงในฐานข้อมูล
                    echo "user_id: $user_id, name: $name <br>";

                    $stmt->bind_param("ssss", $activity_id, $excel_target_file, $user_id_modified, $name);
                    $stmt->execute();
                }

                echo "บันทึก path ไฟล์ Excel เรียบร้อยแล้ว";
                echo "<script>alert('อัปโหลดเรียบร้อยแล้ว');</script>";
                // header("Location: index.php");

            } else {
                echo "ไม่พบกิจกรรมที่ตรงกับชื่อที่ระบุ";
            }
        } else {
            echo "ขออภัย! เกิดข้อผิดพลาดในการอัพโหลดไฟล์ Excel";
        }
    }
}


$conn->close();