<?php
session_start();
include "connection.php";

$email = $_POST['e-mail'];
$pass = $_POST['password'];

if(isset($_POST['btn_login'])){

    // Check Required Email and Password

        if(empty($email)){
        echo "<script>alert('Your email is required') </script>";
        echo "<script>window.location='login.php'</script>";
        }
        if(empty($pass)){
        echo '<script> alert("Your password is required") </script>';
        echo "<script>window.location='login.php'</script>";
        }
        // กรอก Email และ Password ครบถ้วน
        if(!empty($email) and !empty($pass)){
        //echo $email, $pass;
        $sql = "SELECT * FROM member WHERE email = '$email' and password = '$pass' ";
        //echo $sql;
        $query = mysqli_query($conn, $sql);
        $data = mysqli_fetch_array($query);
        //echo $data['firstname'];
        }

    // Validate Email and Password

        if(mysqli_num_rows($query)==1){
            $_SESSSSION['name'] = $data['firstname'];
            //echo ($_SESSSSION['name']);
            //echo "<script>alert('You login successfully') </script>";
            echo "<script>window.location='index.php'</script>";
            }else{
            echo "<script>alert('Your E-mail or password is incorrect')</script>";
            echo "<script>window.location='login.php'</script>";
            
        }
    }
    // Check Role !
?>