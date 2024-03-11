<?php
/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Asia/Bangkok');
// http://php.net/manual/en/timezones.php
require_once("Classes/PHPExcel.php");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@3.3.7/dist/css/bootstrap.min.css">
      
</head>
<body>
  
<br>
<br>
 
<!-- ส่วนของฟอร์มส่งค่า --> 
<div class="container" style="width:600px;margin:auto;">
<form action="" method="post" enctype="multipart/form-data" name="form1">
FILE: <input type="file" name="_fileup" id="_fileup"><br>
<button type="submit" name="btn_submit">Send</button>
 
</form>
</div>
 
<br>
<br>
<!--  ส่วนของการแสดงค่า -->
 <div class="container" style="width:600px;margin:auto;">
 <pre>
<?php 
if(isset($_POST['btn_submit'])  && isset($_FILES['_fileup']['name']) && $_FILES['_fileup']['name']!=""){
    $tmpFile = $_FILES['_fileup']['tmp_name'];  
    $fileName = $_FILES['_fileup']['name'];  // เก็บชื่อไฟล์
    $_fileup = $_FILES['_fileup'];
    $info = pathinfo($fileName);
    $allow_file = array("csv","xls","xlsx");
/*  print_r($info);         // ข้อมูลไฟล์   
    print_r($_fileup);*/
    if($fileName!="" && in_array($info['extension'],$allow_file)){
        // อ่านไฟล์จาก path temp ชั่วคราวที่เราอัพโหลด
        $objPHPExcel = PHPExcel_IOFactory::load($tmpFile);      
         
         
        // ดึงข้อมูลของแต่ละเซลในตารางมาไว้ใช้งานในรูปแบบตัวแปร array
        $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
          
        // วนลูปแสดงข้อมูล
        $data_arr=array();
        foreach ($cell_collection as $cell) {
            // ค่าสำหรับดูว่าเป็นคอลัมน์ไหน เช่น A B C ....
            $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
            // คำสำหรับดูว่าเป็นแถวที่เท่าไหร่ เช่น 1 2 3 .....
            $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
            // ค่าของข้อมูลในเซลล์นั้นๆ เช่น A1 B1 C1 ....
            $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();          
             
            // เริ่มขึ้นตอนจัดเตรียมข้อมูล
            // เริ่มเก็บข้อมูลบรรทัดที่ 2 เป็นต้นไป
            $start_row = 2;
            // กำหนดชื่อ column ที่ต้องการไปเรียกใช้งาน
            $col_name = array(
                "A"=>"cus_id",
                "B"=>"cus_name",
            );
            if($row >= $start_row){
                $data_arr[$row-$start_row][$col_name[$column]] = $data_value;                                               
            }
        }       
//      print_r($data_arr);
    }
} 
?>
 </pre>
  
 <br>
<pre>
<table class="table table-bordered">
<?php
// สร้างฟังก์ชั่นสำหรับจัดการกับข้อมุลที่เป็นค่าว่าง หรือไม่มีข้อมูลน้้น
function prepare_data($data){
    // กำหนดชื่อ filed ให้ตรงกับ $col_name ด้านบน
    $arr_field = array("cus_id","cus_name","order_id","pro_id","pro_name");
    if(is_array($data)){
        foreach($arr_field as $v){
            if(!isset($data[$v])){
                $data[$v]="";           
            }
        }
    }
    return $data;
}
 
// นำข้อมูลที่ดึงจาก excel หรือ csv ไฟล์ มาวนลูปแสดง
if(isset($data_arr) && count($data_arr)>0){
    foreach($data_arr as $row){
        $row = prepare_data($row);
?>
    <tr>
        <td><?=$row['cus_id']?></td>
        <td><?=$row['cus_name']?></td>
    </tr>
<?php
    }
}
?>    
</table>
</pre>
</div>
 
</body>
</html>