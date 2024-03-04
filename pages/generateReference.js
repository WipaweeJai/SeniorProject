    document.addEventListener('DOMContentLoaded', function () {
        // ระบุชื่อโฟลเดอร์
        var folderName = '1002';
    
        // สร้าง XMLHttpRequest object
        var xhr = new XMLHttpRequest();
    
        // กำหนดการร้องขอข้อมูล
        xhr.open('GET', 'generateQR.php?folder=' + encodeURIComponent(folderName), true);
        console.log(folderName);
        // กำหนด callback function เมื่อรับข้อมูลเสร็จสิ้น
        xhr.onload = function() {
            if (xhr.status === 200) {
                var files = JSON.parse(xhr.responseText);

                // วนลูปผ่านไฟล์รูปภาพทั้งหมด
                files.forEach(function(file) {
                    // ดึง id จากชื่อไฟล์
                    var id = file.split('.png')[0];
    
                    // สร้าง XMLHttpRequest object
                    var xhrFile = new XMLHttpRequest();
    
                    // กำหนดการร้องขอข้อมูล
                    xhrFile.open('GET', 'generateQR.php?id=' + id, true);
                    console.log(100);
                    // กำหนด callback function เมื่อรับข้อมูลเสร็จสิ้น
                    xhrFile.onload = function() {
                        if (xhrFile.status === 200) {
                            console.log(200);
                            var data = JSON.parse(xhrFile.responseText);
                            var idevent = data.idevent;
                            var timestamp = data.timestamp;
    
                            // แปลง timestamp เป็นวัตถุ Date
                            var dateObj = new Date(timestamp);
                            var year = dateObj.getFullYear();
                            var month = dateObj.getMonth() + 1;
                            var day = dateObj.getDate();
                            var hour = dateObj.getHours();
                            var minute = dateObj.getMinutes();
                            var timestampNumber = year + '' + month + '' + day + '' + hour + '' + minute;
    
                            // คำนวณเลข ref
                            var sum = timestampNumber + id;
                            var referenceNumber = idevent + sum.toString();
    
                            // แสดงผล referenceNumber ใน HTML
                            document.getElementById('referenceNumber').innerHTML += 'Reference Number: ' + referenceNumber + '<br>';
    
                            // เก็บข้อมูล referenceNumber, activity_id, user_id ลงในฐานข้อมูล tb_certificate
                            saveCertificateData(referenceNumber, idevent, id);
                        }
                    };
                    // ส่งคำขอข้อมูลไปยังเซิร์ฟเวอร์
                    xhrFile.send();
                });
            }
        };
    
        // ส่งคำขอข้อมูลไปยังเซิร์ฟเวอร์
        xhr.send();
    });
    
    // Function สำหรับเก็บข้อมูล referenceNumber, activity_id, user_id ลงในฐานข้อมูล tb_certificate
    function saveCertificateData(referenceNumber, activity_id, user_id) {
        // สร้าง XMLHttpRequest object
        var xhr = new XMLHttpRequest();
    
        // กำหนดการร้องขอเพื่อเก็บข้อมูล
        xhr.open('POST', 'saveCertificateData.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    
        // กำหนด callback function เมื่อรับข้อมูลเสร็จสิ้น
        xhr.onload = function() {
            if (xhr.status === 200) {
                console.log('Certificate data saved successfully!');
            }
        };
    
        // กำหนดข้อมูลที่จะส่ง
        var data = 'referenceNumber=' + encodeURIComponent(referenceNumber) + '&activity_id=' + encodeURIComponent(activity_id) + '&user_id=' + encodeURIComponent(user_id);
    
        // ส่งข้อมูลไปยังเซิร์ฟเวอร์
        xhr.send(data);
    }  