<?php
session_start();
require_once 'config/db.php';

// ตรวจสอบว่ามีการส่งค่ามาจากฟอร์มหรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับค่าจากฟอร์ม
    $name = $_POST["name"];
    $email = $_POST["email"];
    $balance = $_POST["balance"];
    $password = $_POST["password"];
    $image_name = $_FILES['image']['name'];
    $image_temp =$_FILES['image']['tmp_name'];

    $image_dir = "profile_image/";


    // ค้นหาข้อมูลจากฐานข้อมูล
    $sql = "SELECT * FROM account WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);


    // ตรวจสอบว่ามีข้อมูลอีเมลที่ตรงกันหรือไม่
    if (mysqli_num_rows($result) > 0) {
        // แสดงข้อความแจ้งเตือนในหน้าฟอร์ม
        echo "<script>alert('มี Email นี้อยู่แล้ว กรุณาใส่ Email อื่น')</script>";
        echo "<script>window.location = 'account.php'</script>";
        exit();
    } else {
        if(move_uploaded_file($image_temp, $image_name)){
        // เพิ่มข้อมูลใหม่ลงในฐานข้อมูล
        $sql = "INSERT INTO account (account_name, email, balance, image, password) VALUES ('$name', '$email', $balance, '$image_name', $password)";
        mysqli_query($conn, $sql);

        // รับค่า account_number ที่เพิ่งเพิ่มเข้าไป
        $account_number = mysqli_insert_id($conn);

        // ดำเนินการฝากเงิน
        $sql = "INSERT INTO deposit (account_number, amount, transaction_date) VALUES ('$account_number', '$balance', NOW())";
        mysqli_query($conn, $sql);

        // กรณีทำการฝากเงิน
        $transaction_type = 'deposit';
        $sql = "INSERT INTO financial_transaction (account_number, transaction_type, amount, transaction_date) VALUES ('$account_number', '$transaction_type', '$balance', NOW())";
        mysqli_query($conn, $sql);


        // แสดงข้อความแจ้งเตือนในหน้าฟอร์มพร้อมกับแสดง account_number
        echo "<script>alert('สร้างบัญชีเสร็จแล้ว หมายเลขบัญชีของคุณคือ $account_number')</script>";
        echo "<script>window.location = 'index.php'</script>";
        exit();
        }
    }
}