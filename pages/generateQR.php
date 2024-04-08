<?php
    require_once('../backend/dbcon.php');
    var_dump($_POST);
    $activity_id = $_POST['activity_id'];

    // ********************** เพิ่มตัวอักษร b
    $folderPath = '../assets/img/zip/' . $activity_id; // ตำแหน่งของโฟลเดอร์ที่มีไฟล์ .png ++ชื่อโฟลเดอร์จะตามที่แอดมินกดมา ทำหลังจากทำหน้าแอดมินเสร็จแล้ว++
    $files = scandir($folderPath);
    $fileNames = array();
    foreach ($files as $file) {
        if (is_file($folderPath . '/' . $file)) {
            $fileName = pathinfo($file, PATHINFO_FILENAME);
            $fileNameWithB = 'b' . $fileName;
            $fileNames[] = $fileNameWithB;
        }
    }
    echo json_encode($fileNames); // ส่งออกเป็น JSON
    

/**************************************
            สร้างเลข Reference
*************************************/
// วนลูปเพื่อดึงข้อมูลจากฐานข้อมูลโดยใช้ชื่อไฟล์ .png ดึง
foreach ($fileNames as $fileName) {
    
    $sql = "SELECT * FROM tb_participants WHERE user_id = '$fileName'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // วนลูปเพื่อแสดงข้อมูลที่ดึงมา
        while ($row = $result->fetch_assoc()) {
            $user_id = substr($row["user_id"], 1); // ตัดตัวอักษร b ออก --> b633 = 633 เพื่อเอาไปสร้างเลขเรฟต่อ
            $name = $row["name"];
            
            $sql_certificate_template = "SELECT * FROM tb_certificate_template WHERE path_cert_temp LIKE '%$user_id.png'";
            $result_certificate_template = $conn->query($sql_certificate_template);
            
            if ($result_certificate_template->num_rows > 0) {
                // ดึงข้อมูล upload_date จาก tb_certificate_template
                $row_certificate_template = $result_certificate_template->fetch_assoc();
                $upload_date = $row_certificate_template['upload_date'];
                $dateTime = new DateTime($upload_date);
                $timestamp = $dateTime->getTimestamp();

                //$timestamp = mktime(16, 2, 1, 2, 15, 2024);
                
                $referenceNumber = $activity_id . $timestamp . $user_id;

                
                $sql_insert_certificate = "INSERT INTO tb_certificate (cert_Ref, activity_id, user_id) 
                    VALUES ('$referenceNumber', '$activity_id', 'b$user_id')";
                
                if ($conn->query($sql_insert_certificate) === TRUE) {
                    echo "Record inserted successfully";
                    // อัพเดต status เป็น complete
                    $updateSql = "UPDATE tb_certificate_template SET status = 'complete' WHERE activity_id = '$activity_id'";
                    if ($conn->query($updateSql) === TRUE) {
                        echo "Status updated successfully";
                    } else {
                        echo "Error updating status: " . $conn->error;
                    }
                } else {
                    echo "Error inserting record: " . $conn->error;
                }
            } else {
                echo "No data found in tb_certificate_template";
            }
        
            // เพิ่มชื่อไฟล์ในอาร์เรย์ $fileNames ตามที่พบ
            $fileNames[] = $fileName;
        }
    } else {
        echo "0 results";
    }
}



/**************************************
            สร้างภาพ QRCODE
*************************************/
require_once('qrlib.php');

// ดึงข้อมูลใบรับรองที่ยังไม่มี QR code
$sql = "SELECT cert_Ref, path_qrcode, user_id FROM tb_certificate WHERE activity_id = $activity_id AND path_qrcode = ''";
$result = $conn->query($sql);

// วนลูปเพื่อสร้าง QR code และอัปเดตข้อมูล
while ($row = $result->fetch_assoc()) {
    $cert_Ref = $row["cert_Ref"];
    $path_qrcode = $row["path_qrcode"];
    $user_id = substr($row["user_id"], 1);

    // เช็คว่าโฟลเดอร์ $activity_id มีอยู่หรือไม่
    $activityFolderPath = '../assets/img/qrcodes/' . $activity_id;
    if (!file_exists($activityFolderPath)) {
        mkdir($activityFolderPath, 0777, true);
    }

    // กำหนดที่อยู่ของ QR code ใหม่
    $qrCodeFilePath = $activityFolderPath . '/' . $user_id . '.png';

    // สร้าง QR code ชื่อเป็นรหัสนิสิต https://d2a4-158-108-229-149.ngrok-free.app/
    $targetURL = 'https://d2a4-158-108-229-149.ngrok-free.app/project/pages/check_certificate.php'; //สแกนคิวอาร์แล้วไปไหน?
    // $qrCodeFilePath = '../assets/img/qrcodes/' . $activity_id.'/' . $user_id . '.png';
    QRcode::png($targetURL . '?ref=' . urlencode($cert_Ref), $qrCodeFilePath, QR_ECLEVEL_L, 5, 2);

// กำหนดที่อยู่ของ QR code ใหม่
$qrCodeFilePath = $activityFolderPath . '/' . $user_id . '.png';
    // บันทึกข้อมูล QR code ลงในฐานข้อมูล
    $sql = "UPDATE tb_certificate 
    SET path_qrcode = '$qrCodeFilePath'
    WHERE cert_Ref = '$cert_Ref'";
    $conn->query($sql);
}


/***********************************************
        แก้ไขภาพใบประกาศ เพิ่ม QRCODE+Reference
************************************************/
$sql_cert = "SELECT cert_Ref, path_qrcode, path_cert,user_id FROM tb_certificate WHERE activity_id = $activity_id AND path_cert = ''";
$result_cert = $conn->query($sql_cert);

while ($row = $result_cert->fetch_assoc()) {
    $cert_Ref = $row["cert_Ref"];
    $path_qrcode = $row["path_qrcode"];
    $path_cert = $row["path_cert"];
    $user_id = substr($row["user_id"], 1);
    $text = $cert_Ref;

    // ตรวจสอบและสร้างโฟลเดอร์ modified ก่อน
    if (!file_exists('../assets/img/zip/' . $activity_id . '/modified')) {
        mkdir('../assets/img/zip/' . $activity_id . '/modified', 0777, true);
    }

    $originalImagePath = '../assets/img/zip/' . $activity_id .'/' . $user_id . '.png'; // ที่อยู่ของรูปภาพต้นฉบับ
    $outputImagePath = '../assets/img/zip/' . $activity_id.'/modified/'. $user_id . '.png'; // ที่อยู่ที่ต้องการบันทึกรูปภาพที่มี QR Code แทรก

    $originalImage = imagecreatefrompng($originalImagePath);
    $qrCodeImage = imagecreatefrompng($path_qrcode);

    // ตรวจสอบว่าสามารถสร้างรูปภาพได้หรือไม่
    if ($originalImage && $qrCodeImage) {
        // แทรก QR Code ในรูปภาพต้นฉบับ
        $qrCodeX = 30;
        $qrCodeY = imagesy($originalImage) - imagesy($qrCodeImage) - 30;
        imagecopy($originalImage, $qrCodeImage, $qrCodeX, $qrCodeY, 0, 0, imagesx($qrCodeImage), imagesy($qrCodeImage));

        $textColor = imagecolorallocate($originalImage, 0, 0, 0); // สีข้อความ
        $fontSize = 20;
        $textX = imagesx($originalImage) - 430; // ระยะห่างจากขอบภาพด้านขวา
        $textY = imagesy($originalImage) - 30; // ระยะห่างจากขอบภาพด้านล่าง
        $text = $cert_Ref;

        // สร้างกล่องข้อความพื้นหลังสีขาว
        $textBgColor = imagecolorallocate($originalImage, 255, 255, 255);
        $textBgX1 = $textX - 10;
        $textBgY1 = $textY - 30;
        $textBgX2 = $textX + 380;
        $textBgY2 = $textY + 10;
        imagefilledrectangle($originalImage, $textBgX1, $textBgY1, $textBgX2, $textBgY2, $textBgColor);

        $fontPath = __DIR__ . '/../assets/fonts/Prompt-Medium.ttf';
        imagettftext($originalImage, $fontSize, 0, $textX, $textY, $textColor, $fontPath, $text);

        // บันทึกรูปภาพที่มี QR Code และข้อความลง
        imagepng($originalImage, $outputImagePath);

        // อัปเดตที่อยู่ของรูปภาพใบรับรองในฐานข้อมูล
        $sql = "UPDATE tb_certificate 
        SET path_cert = '$outputImagePath'
        WHERE cert_Ref = '$cert_Ref'";
        $conn->query($sql);
    } else {
        echo 'ไม่สามารถสร้างรูปภาพจากไฟล์ได้';
    }
} 

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>


