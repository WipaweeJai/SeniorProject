<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TEST</title>
</head>
<body>
<?php
    require_once('../backend/dbcon.php');
    
    // ********************** แบบ 1 ไม่เพิ่มตัวอักษร b ไม่ได้ใช้ เก็บไว้เฉยๆ ค่อย clean 
    $folderPath = '../assets/img/zip/1001';
    $files = scandir($folderPath);
    $pngFiles = array();
    foreach ($files as $file) {
        if (pathinfo($file, PATHINFO_EXTENSION) === 'png') {
            $fileName = pathinfo($file, PATHINFO_FILENAME);
            $pngFiles[] = $fileName;
        }
    }
    echo json_encode($pngFiles);
    echo '<br>';

    // ********************** แบบ 2 เพิ่มตัวอักษร b
    $folderPath = '../assets/img/zip/1001'; // ตำแหน่งของโฟลเดอร์ที่มีไฟล์ .png ++ชื่อโฟลเดอร์จะตามที่แอดมินกดมา ทำหลังจากทำหน้าแอดมินเสร็จแล้ว++
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
    echo "<br>";
    

/**************************************
            สร้างเลข Reference
*************************************/
// วนลูปเพื่อดึงข้อมูลจากฐานข้อมูลโดยใช้ชื่อไฟล์ .png ดึง
foreach ($fileNames as $fileName) {
    // สร้างคำสั่ง SQL เพื่อดึงข้อมูล
    $sql = "SELECT * FROM tb_user WHERE user_id = '$fileName'";
    $result = $conn->query($sql);

    // ตรวจสอบว่ามีข้อมูลหรือไม่
    if ($result->num_rows > 0) {
        // วนลูปเพื่อแสดงข้อมูลที่ดึงมา
        while ($row = $result->fetch_assoc()) {
            $user_id = substr($row["user_id"], 1); // ตัดตัวอักษร b ออก --> b633 = 633 เพื่อเอาไปสร้างเลขเรฟต่อ
            $name = $row["name"];

// เพิ่มเงื่อนไข ถ้ายังไม่มีเลขเรฟ ++

            // $sql = "SELECT * FROM tb_certificate_template WHERE SUBSTRING_INDEX(path_cert_temp, '/', -1) = '$user_id';";
            // $result = $conn->query($sql);
            // $upload_date = $result['upload_date'];
            // แปลง upload_date เป็น timestamp
            // $timestamp = strtotime($upload_date);
            $timestamp = mktime(16, 2, 1, 2, 15, 2024);
            // สร้างรหัสอ้างอิง
            $referenceNumber = '1001' . $timestamp . $user_id;
            
            // บันทึกข้อมูลลงในตาราง tb_certificate
            // $sql = "INSERT INTO tb_certificate (cert_Ref, activity_id, user_id) 
            // VALUES ('$referenceNumber', '1001', 'b$user_id')";
            //     // ทำการ execute คำสั่ง SQL
            //     if ($conn->query($sql) === TRUE) {
            //         echo "Record inserted successfully";
            //     } else {
            //         echo "Error inserting record: " . $conn->error;
            //     }
            // แสดงข้อมูล
            echo "ID: $user_id - Name: $name - Reference Number: $referenceNumber<br>";

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
$sql = "SELECT cert_Ref, path_qrcode, user_id FROM tb_certificate WHERE activity_id = 1001 AND path_qrcode = ''";
$result = $conn->query($sql);

// วนลูปเพื่อสร้าง QR code และอัปเดตข้อมูล
while ($row = $result->fetch_assoc()) {
    $cert_Ref = $row["cert_Ref"];
    $path_qrcode = $row["path_qrcode"];
    $user_id = substr($row["user_id"], 1);

    // สร้าง QR code ชื่อเป็นรหัสนิสิต
    $targetURL = 'http://localhost/project/pages/check_certificate.php'; //สแกนคิวอาร์แล้วไปไหน?
    // $qrCodeFilePath = '../assets/img/qrcodes/1001/' . $cert_Ref . '.png';
    $qrCodeFilePath = '../assets/img/qrcodes/1001/' . $user_id . '.png';
    QRcode::png($targetURL . '?ref=' . urlencode($cert_Ref), $qrCodeFilePath, QR_ECLEVEL_L, 5, 2);

    // บันทึกข้อมูล QR code ลงในฐานข้อมูล
    $sql = "UPDATE tb_certificate 
    SET path_qrcode = '$qrCodeFilePath'
    WHERE cert_Ref = '$cert_Ref'";
    $conn->query($sql);
}


/***********************************************
        แก้ไขภาพใบประกาศ เพิ่ม QRCODE+Reference
************************************************/
$sql_cert = "SELECT cert_Ref, path_qrcode, path_cert,user_id FROM tb_certificate WHERE activity_id = 1001 AND path_cert = ''";
$result_cert = $conn->query($sql_cert);

while ($row = $result_cert->fetch_assoc()) {
    $cert_Ref = $row["cert_Ref"];
    $path_qrcode = $row["path_qrcode"];
    $path_cert = $row["path_cert"];
    $user_id = substr($row["user_id"], 1);
    $text = $cert_Ref;

    $originalImagePath = '../assets/img/zip/1001/' . $user_id . '.png'; // ที่อยู่ของรูปภาพต้นฉบับ
    $outputImagePath = '../assets/img/zip/1001/modified/'. $user_id . '.png'; // ที่อยู่ที่ต้องการบันทึกรูปภาพที่มี QR Code แทรก

    $originalImage = imagecreatefrompng($originalImagePath);
    $qrCodeImage = imagecreatefrompng($path_qrcode);

    // ตรวจสอบว่าสามารถสร้างรูปภาพได้หรือไม่
    if ($originalImage && $qrCodeImage) {
        // แทรก QR Code ในรูปภาพต้นฉบับ
        $qrCodeX = 30;
        $qrCodeY = 1265;
        imagecopy($originalImage, $qrCodeImage, $qrCodeX, $qrCodeY, 0, 0, imagesx($qrCodeImage), imagesy($qrCodeImage));

        // เพิ่มข้อความลงบนรูปภาพ ++ อยากดูโค้ดว่า นับจากมุมขอบภาพได้มั้ย จะได้ตามขนาดของภาพเลย จะได้สวยๆด้วย
        // ++ อยากเพิ่มพื้นหลังของเลขเรฟ เผื่อใบประกาศมีพื้นเป็นสีดำ
        $textColor = imagecolorallocate($originalImage, 0, 0, 0); // สีข้อความ
        $fontSize = 20;
        $textX = 1600;
        $textY = 1380;
        $text = $cert_Ref;

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


<script>
document.addEventListener('DOMContentLoaded', function () {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                var files = JSON.parse(xhr.responseText);
                // วนลูปผ่านรายการของไฟล์ .png และแสดงผลลัพธ์ที่ต้องการ
                files.forEach(function (file) {
                    console.log(file); // แสดงชื่อของไฟล์ .png ในคอนโซล
                    // ทำสิ่งที่คุณต้องการกับชื่อไฟล์ .png ที่นี่
                });
            } else {
                console.error('Failed to fetch PNG files');
            }
        }
    };
    xhr.open('GET', 'test.php', true); // เปลี่ยนเป็นชื่อของไฟล์ PHP ที่คุณใช้
    xhr.send();
});

</script>

</body>
</html>

