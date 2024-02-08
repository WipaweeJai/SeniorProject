    // document.addEventListener('DOMContentLoaded', function () {
    //     // รหัสกิจกรรม
    //     var idevent = '1001';
    //     // var timestamp = Math.floor(new Date().getTime() / 1000);
    //     var id = '6330200076';

    //     var timestampNumber = timestamp.toString().slice(-6);
    //     // var idNumber = parseInt(id);
    //     var sum = timestampNumber + id;
    //     var sumString = sum.toString();
    //     var referenceNumber = idevent + sumString;

    //     // แสดงผลลัพธ์ใน HTML
    //     document.getElementById('referenceNumber').innerHTML = 'Reference Number: ' + referenceNumber;

    //     // เพิ่มการเรียกใช้งาน PHP ด้วย XMLHttpRequest และส่งค่า referenceNumber ไปใน URL parameters
    //     var xhr = new XMLHttpRequest();
    //     xhr.open('GET', 'generateQR.php?ref=' + encodeURIComponent(referenceNumber), true);
    //     xhr.send();
    // });

    document.addEventListener('DOMContentLoaded', function () {
        var idevent = '1001';
        var timestamp = '2024-02-07 13:11:52';
        var id = '6330200076';
    
        // แปลง timestamp เป็นวัตถุ Date
        var dateObj = new Date(timestamp);
    
        // ดึงข้อมูลวันที่ เดือน ปี และเวลาออกมา
        var year = dateObj.getFullYear(); // ปี
        var month = dateObj.getMonth() + 1; // เดือน (เริ่มจาก 0 เพราะเดือนมีค่าตั้งแต่ 0 - 11)
        var day = dateObj.getDate(); // วันที่
        var hour = dateObj.getHours(); // ชั่วโมง
        var minute = dateObj.getMinutes(); // นาที
    
        var timestampNumber = year + '' + month + '' + day + '' + hour + '' + minute;
    
        // คำนวณเลข ref
        var sum = timestampNumber + id;
        var sumString = sum.toString();
        var referenceNumber = idevent + sumString;
    
        // แสดงผลลัพธ์ใน HTML
        document.getElementById('referenceNumber').innerHTML = 'Reference Number: ' + referenceNumber;
    
        // เพิ่มการเรียกใช้งาน PHP ด้วย XMLHttpRequest และส่งค่า referenceNumber ไปใน URL parameters
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'generateQR.php?ref=' + encodeURIComponent(referenceNumber), true);
        xhr.send();
    });
    
    
    