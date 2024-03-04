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
                    
                    $sql = "INSERT INTO tb_certificate_template (activity_id, event_name, path_cert_temp, upload_date) 
                            VALUES (?, ?, ?, CURRENT_TIMESTAMP())";
                   
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

<!--Upload ไฟล์รายชื่อ-->
<?php
    require 'PHPExcel/Classes/PHPExcel.php';
    // ตรวจสอบว่ามีการส่งไฟล์ Excel มาหรือไม่
    if (isset($_FILES['excel_file']) && isset($_POST["upload_btn"])) {
        // กำหนด Folder ปลายทางที่จะบันทึกไฟล์ Excel
        $target_dir_excel = "../assets/img/zip/";

        // กำหนดชื่อไฟล์และตำแหน่งของไฟล์ชั่วคราว
        $file_name_excel = $_FILES['excel_file']['name'];
        $file_temp_excel = $_FILES['excel_file']['tmp_name'];

        // สร้างตัวอ่านไฟล์ Excel
        $objReader = PHPExcel_IOFactory::createReaderForFile($file_temp_excel);
        $objPHPExcel = $objReader->load($file_temp_excel);

        // แปลงข้อมูลจาก Excel เป็น array
        $sheet = $objPHPExcel->getActiveSheet();
        $data = $sheet->toArray(null, true, true, true);

        // เริ่มต้นเชื่อมต่อกับฐานข้อมูล
        include "../backend/dbcon.php";

        // เริ่มการเพิ่มข้อมูลลงในฐานข้อมูล
        foreach ($data as $row) {
            // ดึงข้อมูลจากแต่ละแถวใน Excel
            $event_name = $_POST['event_name']; // รับค่าชื่อกิจกรรมจาก Form

            // ค้นหา activity_id จาก event_name
            $sql_activity_id = "SELECT activity_id FROM tb_event WHERE event_name = ?";
            $stmt_activity_id = $conn->prepare($sql_activity_id);
            $stmt_activity_id->bind_param("s", $event_name);
            $stmt_activity_id->execute();
            $result_activity_id = $stmt_activity_id->get_result();
            if ($result_activity_id->num_rows > 0) {
                $row_activity_id = $result_activity_id->fetch_assoc();
                $activity_id = $row_activity_id['activity_id']; // ดึง activity_id จากผลลัพธ์
            } else {
                echo "ไม่พบข้อมูลกิจกรรม: $event_name";
                continue; // ข้ามการเพิ่มข้อมูลลงในฐานข้อมูลหากไม่พบ activity_id
            }
            $stmt_activity_id->close();

            $path_excel = $target_dir_excel . $file_name_excel; // กำหนดที่อยู่ของไฟล์ Excel
            $column1_data = $row['A']; // ดึงข้อมูลจากคอลัมน์ A ใน Excel
            $column2_data = $row['B']; // ดึงข้อมูลจากคอลัมน์ B ใน Excel

            // เพิ่มโค้ดที่ใช้ insert เข้าฐานข้อมูล
            $sql = "INSERT INTO tb_participants (activity_id, path_excel, user_id, name) 
                    VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $activity_id, $path_excel, $column1_data, $column2_data);
            if ($stmt->execute()) {
                echo "บันทึกข้อมูลเรียบร้อยแล้ว";
            } else {
                echo "เกิดข้อผิดพลาดในการบันทึกข้อมูล: " . $stmt->error;
            }
            $stmt->close();
        }

        // ปิดการเชื่อมต่อกับฐานข้อมูล
        $conn->close();
    }
?>
