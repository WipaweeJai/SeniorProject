<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TEST</title>
</head>
<body>

<!-- <button id="referenceNumber">TEST</button> -->

<?php
    // ********************** แบบ 1 ไม่เพิ่มตัวอักษร b
    $folderPath = 'C:/xampp/htdocs/project/assets/img/zip/1001';
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
    // **********************

    // ********************** แบบ 2 เพิ่มตัวอักษร b
    require_once('../backend/dbcon.php');
    $folderPath = 'C:/xampp/htdocs/project/assets/img/zip/1001'; // ตำแหน่งของโฟลเดอร์ที่มีไฟล์ .png
    $files = scandir($folderPath); // ดึงรายชื่อไฟล์ทั้งหมดในโฟลเดอร์
    $fileNames = array();
    foreach ($files as $file) {
        if (is_file($folderPath . '/' . $file)) { // ตรวจสอบว่าไฟล์หรือไม่
            $fileName = pathinfo($file, PATHINFO_FILENAME); // ดึงชื่อไฟล์โดยไม่รวมนามสกุล
            $fileNameWithB = 'b' . $fileName; // เพิ่มตัวอักษร 'b' นำหน้าชื่อไฟล์
            $fileNames[] = $fileNameWithB; // เพิ่มชื่อไฟล์ลงในอาร์เรย์
        }
    }
    echo json_encode($fileNames); // ส่งออกเป็น JSON
    echo "<br>";
    // **********************
    
    // วนลูปเพื่อดึงข้อมูลจากฐานข้อมูลโดยใช้ชื่อไฟล์ .png เป็นค่าอ้างอิง
    foreach ($fileNames as $fileName) {
        // สร้างคำสั่ง SQL เพื่อดึงข้อมูล
        $sql = "SELECT * FROM tb_user WHERE user_id = '$fileName'";
        $result = $conn->query($sql);
    
        // ตรวจสอบว่ามีข้อมูลหรือไม่
        if ($result->num_rows > 0) {
            // วนลูปเพื่อแสดงข้อมูลที่ดึงมา
            while ($row = $result->fetch_assoc()) {
                // ดำเนินการตามที่ต้องการกับข้อมูล
                $user_id = substr($row["user_id"], 1); // ตัดตัวอักษร b ออก --> b633 = 633
                $name = $row["name"];
    
                $sql = "SELECT * FROM tb_certificate_template WHERE SUBSTRING_INDEX(path_cert_temp, '/', -1) = '$user_id';";
                $result = $conn->query($sql);

                // ใช้วันที่ที่กำหนดไปก่อน ไม่อยากให้มันเปลี่ยนไปเปลี่ยนมา เพราะต้องเอาเข้าดาต้าเบส
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

// ปิดการเชื่อมต่อฐานข้อมูล
// $conn->close();
?>

<?php
    require_once('qrlib.php');
    // สร้างคำสั่ง SQL เพื่อดึงข้อมูล
    $sql = "SELECT cert_Ref, path_cert FROM tb_certificate WHERE activity_id = 1001 AND path_cert = ''";
    $result = $conn->query($sql);

    // ตรวจสอบว่ามีข้อมูลหรือไม่
    if ($result->num_rows > 0) {
        // วนลูปเพื่อแสดงข้อมูลที่ดึงมา
        while ($row = $result->fetch_assoc()) {
            // ดำเนินการตามที่ต้องการกับข้อมูล
            $cert_Ref = $row["cert_Ref"];
            $path_cert = $row["path_cert"];

            // ทำสร้าง QR code หรือการประมวลผลอื่นๆ ตามที่ต้องการ
            // เช่น สร้างไฟล์ QR code
            $targetURL = 'http://localhost/project/pages/check_certificate.php';
            $qrCodeFilePath = 'C:/xampp/htdocs/project/assets/img/qrcodes/1001/' . $cert_Ref . '.png';
            QRcode::png($targetURL . '?ref=' . urlencode($cert_Ref), $qrCodeFilePath, QR_ECLEVEL_L, 5, 2);

            // สร้างรูปภาพใหม่โดยแทรก QR Code ในตำแหน่งที่ต้องการ
            $originalImagePath = 'C:/xampp/htdocs/project/assets/img/zip/1001/' . substr($fileName, 1) . '.png';
            $outputImagePath = 'C:/xampp/htdocs/project/assets/img/zip/1001/modified/' . $cert_Ref . '.png';

            $originalImage = imagecreatefrompng($originalImagePath);
            $qrCodeImage = imagecreatefrompng($qrCodeFilePath);

            // กำหนดตำแหน่งที่จะแทรก QR Code (ปรับตำแหน่งตามความต้องการ)
            $qrCodeX = 55;
            $qrCodeY = 2232;

            // แทรก QR Code ลงในรูปภาพ
            imagecopy($originalImage, $qrCodeImage, $qrCodeX, $qrCodeY, 0, 0, imagesx($qrCodeImage), imagesy($qrCodeImage));

            // เพิ่มข้อความลงบนรูปภาพ
            $textColor = imagecolorallocate($originalImage, 0, 0, 0); // สีข้อความ (put your RGB values)
            $fontSize = 40;
            $textX = 2700;
            $textY = 2400;
            $text = $referenceNumber;

            $fontPath = __DIR__ . '/../assets/fonts/Prompt-Medium.ttf';
            imagettftext($originalImage, $fontSize, 0, $textX, $textY, $textColor, $fontPath, $text);

            // บันทึกรูปภาพที่มี QR Code และข้อความลง
            imagepng($originalImage, $outputImagePath);

            $ImagePath = "http://localhost/project/assets/img/zip/1001/modified/" . $cert_Ref . ".png";
            // แสดง QR code
            echo '<div style="width: 50%;margin: 0 auto;">';
            echo '<img src="' . $ImagePath . '" alt="Modified Image with QR Code" style="width: 100%; height: auto;">';
            echo '</div>';
        }
    } else {
        echo "ไม่พบข้อมูลที่ต้องการ";
    }
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

