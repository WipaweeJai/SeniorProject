<?php
include "../backend/dbcon.php";
require __DIR__ . '/../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

    $uploadFilePath = '../pages/import/' . basename($_FILES['file']['name']);
    move_uploaded_file($_FILES['file']['tmp_name'], $uploadFilePath);

    $inputFileName = $uploadFilePath;
    $inputFileType = PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);
    $objReader = PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
    $objReader->setReadDataOnly(true);
    $objPHPExcel = $objReader->load($inputFileName); 

    // below
    $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
    $highestRow = $objWorksheet->getHighestRow();
    $highestColumn = $objWorksheet->getHighestColumn();

    $headingsArray = $objWorksheet->rangeToArray('A1:'.$highestColumn.'1',null, true, true, true);
    $headingsArray = $headingsArray[1];

    $r = -1;
    $namedDataArray = array();
    for ($row = 2; $row <= $highestRow; ++$row) {
    $dataRow = $objWorksheet->rangeToArray('A'.$row.':'.$highestColumn.$row,null, true, true, true);
    if ((isset($dataRow[$row]['A'])) && ($dataRow[$row]['A'] > '')) {
    ++$r;
    foreach($headingsArray as $columnKey => $columnHeading) {
    $namedDataArray[$r][$columnHeading] = $dataRow[$row][$columnKey];
    }
    }
    }

    foreach ($namedDataArray as $resx) {

    // Prepare data=
    $user_id = $resx['รหัสนิสิต']; 
    $name = $resx['ชื่อ']; 
    $sur_name = $resx['นามสกุล']; 
    // Insert
    $query = "INSERT INTO tb_user ( user_id	, name, sur_name)
    VALUES  ('".$resx['รหัสนิสิต']."' ,
    '".$resx['ชื่อ']."',
    '".$resx['นามสกุล']."')";
    $res_i = $mysqli->query($query);
    }
    $mysqli->close();

    // // ตรวจสอบว่าไฟล์ถูกอัปโหลดเรียบร้อย
    // if ($file['error'] === UPLOAD_ERR_OK) {
    //     $uploadedFileName = $file['name'];
    //     $tempFileName = $file['tmp_name'];

    //     // ทำการอ่านข้อมูลจากไฟล์ Excel และบันทึกในฐานข้อมูล
    //     // (ใช้ไลบรารีต่าง ๆ เช่น PhpSpreadsheet)

    //     // เมื่อทำการ Import เรียบร้อย
    //     echo "Imported file: $uploadedFileName successfully.";
    // } else {
    //     echo "Error uploading file.";
    // }

?>