<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate QR Code</title>
</head>
<body>

    <div id="referenceNumber">
        <script src="generateReference.js"></script>
    </div>
    
    <!-- อันเก่า -->
    <?php
        // require_once('qrlib.php');

        // // ข้อมูลที่ให้มา
        // $referenceNumber = 'COMSCI';

        // // ตรวจสอบและสร้างโฟลเดอร์ qrcodes ถ้าไม่มี
        // $directory = 'qrcodes';
        // if (!file_exists($directory) && !is_dir($directory)) {
        //     mkdir($directory);
        // }

        // // สร้าง URL ที่ต้องการไป
        // $targetURL = 'http://localhost/project/pages/index.php';

        // // สร้างไฟล์ QR code
        // QRcode::png($targetURL . '?ref=' . urlencode($referenceNumber), $directory . '/' . $referenceNumber . '.png');

        // // แสดง QR code
        // echo '<img src="' . $directory . '/' . $referenceNumber . '.png" alt="QR Code">';
    ?>

<?php
    require_once('qrlib.php');

    // ตรวจสอบว่ามีคีย์ 'ref' ใน $_GET
    // if (isset($_GET['ref'])) {
    //     // รับค่า referenceNumber จาก URL parameters
    //     $referenceNumber = $_GET['ref'];
        $referenceNumber = '100120242713116330200076';
        // สร้าง URL ที่ต้องการไป
        $targetURL = 'http://localhost/project/pages/index.php';

        // สร้างไฟล์ QR code
        $qrCodeFilePath = 'qrcodes/' . $referenceNumber . '.png';
        QRcode::png($targetURL . '?ref=' . urlencode($referenceNumber), $qrCodeFilePath, QR_ECLEVEL_L, 3.5, 2);

        // สร้างรูปภาพใหม่โดยแทรก QR Code ในตำแหน่งที่ต้องการ
        $originalImagePath = 'certificate/certificate.png'; // แก้ไขเป็นที่อยู่ของรูปภาพใบประกาศ
        $outputImagePath = 'certificate/modified/certificate.png'; // แก้ไขเป็นที่อยู่ที่ต้องการบันทึกรูปภาพที่มี QR Code แทรก

        $originalImage = imagecreatefrompng($originalImagePath);
        $qrCodeImage = imagecreatefrompng($qrCodeFilePath);

        // กำหนดตำแหน่งที่จะแทรก QR Code (ปรับตำแหน่งตามความต้องการ)
        $qrCodeX = 30;
        $qrCodeY = 1265;

        // แทรก QR Code ลงในรูปภาพ
        imagecopy($originalImage, $qrCodeImage, $qrCodeX, $qrCodeY, 0, 0, imagesx($qrCodeImage), imagesy($qrCodeImage));

        // เพิ่มข้อความลงบนรูปภาพ
        $textColor = imagecolorallocate($originalImage, 0, 0, 0); // สีข้อความ (put your RGB values)
        $fontSize = 20;
        $textX = 1600;
        $textY = 1380;
        $text = $referenceNumber;

        $fontPath = __DIR__ . '/../assets/fonts/Prompt-Medium.ttf';
        imagettftext($originalImage, $fontSize, 0, $textX, $textY, $textColor, $fontPath, $text);

        // บันทึกรูปภาพที่มี QR Code และข้อความลง
        imagepng($originalImage, $outputImagePath);

        // แสดง QR code
        echo '<div style="width: 100%; max-width: 900px; margin: 0 auto;">';
        echo '<img src="' . $outputImagePath . '" alt="Modified Image with QR Code" style="width: 100%; height: auto;">';
        echo '</div>';
    // } else {
    //     echo 'Missing reference number in the request.';
    // }
?>


</body>
</html>

