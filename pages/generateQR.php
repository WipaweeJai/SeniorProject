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
    
<?php
    require_once('qrlib.php');
        $referenceNumber = $_GET['ref'];
        $targetURL = 'http://localhost/project/pages/check_certificate.php';

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

?>


</body>
</html>


