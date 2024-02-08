<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Reference Number</title>
</head>
<body>

    <div id="referenceNumber"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var englishLetters = 'COMSCI';
            var timestamp = Math.floor(new Date().getTime() / 1000);
            var id = '6330200076';

            var timestampNumber = timestamp.toString().slice(-6);
            var idNumber = parseInt(id);
            var sum = timestampNumber + idNumber;
            var sumString = sum.toString();
            var referenceNumber = englishLetters + sumString;

            // แสดงผลลัพธ์ใน HTML
            document.getElementById('referenceNumber').innerHTML = 'Reference Number: ' + referenceNumber;
        });
    </script>

</body>
</html>
