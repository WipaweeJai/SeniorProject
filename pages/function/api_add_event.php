<?php

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $uploadDir = '../assets/img/upload_event/';
//     if (!file_exists($uploadDir)) {
//         mkdir($uploadDir, 0777, true);
//     }

//     // วนลูปตรวจสอบแต่ละรูปภาพ
//     $imageTypes = ['event_banner', 'event_poster'];

//     // สร้าง array เพื่อเก็บชื่อไฟล์ที่อัปโหลด
//     $uploadedFiles = [];
//     foreach ($imageTypes as $imageType) {
//         $inputName = $imageType;
//         if (isset($_FILES[$inputName]) && $_FILES[$inputName]['error'] === UPLOAD_ERR_OK) {
//             $tmpName = $_FILES[$inputName]['tmp_name'];
//             $fileName = basename($_FILES[$inputName]['name']);
//             $uploadPath = $uploadDir . $fileName;
//             move_uploaded_file($tmpName, $uploadPath);
//             // เก็บชื่อไฟล์ที่อัปโหลดไว้ใน array
//             $uploadedFiles[$imageType] = $fileName;
//         } else {
//             echo "เกิดข้อผิดพลาดในการอัปโหลดไฟล์ $imageType.<br>";
//         }
//     }

//     // ทำการบันทึกรูปภาพในฐานข้อมูล
//     $sender_name = $_POST['sender_name'];
//     $sender_email = $_POST['sender_email'];
//     $sender_tel = $_POST['sender_tel'];
//     $event_banner = $uploadedFiles['event_banner'];
//     $event_name = $_POST['event_name'];
//     $event_detail_short = $_POST['event_detail_short'];
//     $event_date_from = $_POST['event_date_from'];
//     $event_date_to = $_POST['event_date_to'];
//     $event_reg_to = $_POST['event_reg_to'];
//     $event_reg_detail = $_POST['event_reg_detail'];
//     $event_number = $_POST['event_number'];
//     $event_fee = $_POST['event_fee'];
//     $event_require = $_POST['event_require'];
//     $event_location = $_POST['event_location'];
//     $event_download_url = $_POST['event_download_url'];
//     $event_detail_full = $_POST['event_detail_full'];
//     $event_poster = $uploadedFiles['event_poster'];

//     // SQL Query เพื่อบันทึกข้อมูลลงในฐานข้อมูล
//     $sql_insert = "INSERT INTO tb_event(sender_name, sender_email, sender_tel, event_banner, event_name, event_detail_short, event_date_from,
//         event_date_to, event_reg_to, event_reg_detail, event_number, event_fee, event_require, event_location, event_download_url, event_detail_full, event_poster) 
//         VALUES ('$sender_name', '$sender_email', '$sender_tel', '$event_banner', '$event_name', '$event_detail_short', '$event_date_from', '$event_date_to',
//         '$event_reg_to', '$event_reg_detail', '$event_number', '$event_fee', '$event_require', '$event_location', '$event_download_url',
//         '$event_detail_full', '$event_poster')";
    
//     // ทำการส่ง Query ไปที่ฐานข้อมูล
//     $result_insert = mysqli_query($conn, $sql_insert);

//     // ตรวจสอบว่า Query สำเร็จหรือไม่
//     if (!$result_insert) {
//         echo "เกิดข้อผิดพลาดในการบันทึกข้อมูล: " . $conn->error . "<br>";
//     } else {
//         echo "อัปโหลดไฟล์และบันทึกข้อมูลเรียบร้อยแล้ว<br>";
//         // header("Location: form_event.php");
//         exit();
//     }

//     if(!$result_insert){
//             echo 1;
//         } else {
//             echo 2;
            
//         }
//     // ปิดการเชื่อมต่อฐานข้อมูล
//     $conn->close();
// }


require_once('../../backend/dbcon.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if(isset($_FILES['event_banner'])) {
        $file_name = $_FILES['event_banner']['name'];
        $file_size = $_FILES['event_banner']['size'];
        $file_tmp = $_FILES['event_banner']['tmp_name'];
        $file_type = $_FILES['event_banner']['type'];
        $extensions = array("jpeg","jpg","png");
    
        // Check file size
        if($file_size > 2097152) {
            echo "File size must be less than 2 MB";
            exit();
        }
    
        // Check file type
        $file_ext = strtolower(end(explode('.',$file_name)));
        if(!in_array($file_ext, $extensions)) {
            echo "Only JPEG, JPG, and PNG files are allowed";
            exit();
        }
    
        // Move uploaded file to desired directory
        $event_id = 1; // Assuming event ID is 1
        $upload_dir = "C:/xampp/htdocs/project/assets/img/upload_event/banner/";
        $upload_file = $upload_dir . "banner_event" . $event_id . ".png";
        move_uploaded_file($file_tmp, $upload_file);
    
        // Insert image file information into database
        // Your database insert query here
    
        echo "File uploaded successfully.";
    } else {
        echo "Error uploading file.";
    }


    // $uploadDir = '../assets/img/upload_event/';

    // if (!file_exists($uploadDir)) {
    //     mkdir($uploadDir, 0777, true);
    // }

    // $imageTypes = ['event_banner', 'event_poster'];

    // $uploadedFiles = [];
    // foreach ($imageTypes as $imageType) {
    //     $inputName = $imageType;
    //     if (isset($_FILES[$inputName]) && $_FILES[$inputName]['error'] === UPLOAD_ERR_OK) {
    //         $tmpName = $_FILES[$inputName]['tmp_name'];
    //         $fileName = basename($_FILES[$inputName]['name']);
    //         $uploadPath = $uploadDir . $fileName;
    //         move_uploaded_file($tmpName, $uploadPath);
    //         $uploadedFiles[$imageType] = $uploadPath;
    //     } else {
    //         echo "เกิดข้อผิดพลาดในการอัปโหลดไฟล์ $imageType.<br>";
    //     }
    // }

    $sender_name = $_POST['sender_name'];
    $sender_email = $_POST['sender_email'];
    $sender_tel = $_POST['sender_tel'];
    $event_banner = $uploadedFiles['event_banner'];
    $event_name = $_POST['event_name'];
    $event_detail_short = $_POST['event_detail_short'];
    $event_date_from = $_POST['event_date_from'];
    $event_date_to = $_POST['event_date_to'];
    $event_reg_to = $_POST['event_reg_to'];
    $event_reg_detail = $_POST['event_reg_detail'];
    $event_number = $_POST['event_number'];
    $event_fee = $_POST['event_fee'];
    $event_require = $_POST['event_require'];
    $event_location = $_POST['event_location'];
    $event_download_url = $_POST['event_download_url'];
    $event_detail_full = $_POST['event_detail_full'];
    $event_poster = $uploadedFiles['event_poster'];

    $sql_insert = "INSERT INTO tb_event(sender_name, sender_email, sender_tel, event_banner, event_name, event_detail_short, event_date_from,
    event_date_to, event_reg_to, event_reg_detail, event_number, event_fee, event_require, event_location, event_download_url, event_detail_full, event_poster) 
    VALUES ('$sender_name', '$sender_email', '$sender_tel', '$event_banner', '$event_name', '$event_detail_short', '$event_date_from', '$event_date_to',
    '$event_reg_to', '$event_reg_detail', '$event_number', '$event_fee', '$event_require', '$event_location', '$event_download_url',
    '$event_detail_full', '$event_poster')";

    $result_insert = mysqli_query($conn, $sql_insert);

    if (!$result_insert) {
        echo "เกิดข้อผิดพลาดในการบันทึกข้อมูล: " . $conn->error . "<br>";
    } else {
        echo "อัปโหลดไฟล์และบันทึกข้อมูลเรียบร้อยแล้ว<br>";
        // header("Location: form_event.php");
        exit();
    }

    if(!$result_insert){
        echo 1;
    } else {
        echo 2;
    }
    $conn->close();
}
?>

