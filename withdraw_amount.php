<?php
session_start();
require_once 'config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับค่าจากฟอร์ม
    $account_number = $_POST["account_number"];
    $withdraw_amount = $_POST["withdraw_amount"];

    // ตรวจสอบว่าหมายเลขบัญชีนี้มีอยู่ในฐานข้อมูลหรือไม่
    $sql = "SELECT * FROM account WHERE account_number = '$account_number'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 0) {
        echo "<script>alert('ไม่พบบัญชีนี้ในระบบ')</script>";
        echo "<script>window.location = 'withdraw.php'</script>";
        exit;
    } else

        // ตรวจสอบว่ายอดเงินในบัญชีพอสำหรับการถอนเงินหรือไม่
        $sql = "SELECT balance FROM account WHERE account_number = $account_number";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $balance = $row['balance'];

    if ($balance >= $withdraw_amount) {
        // ดำเนินการถอนเงิน
        $sql = "INSERT INTO withdraw (account_number, amount, transaction_date) VALUES ($account_number, $withdraw_amount, NOW())";
        mysqli_query($conn, $sql);
        $new_balance = $balance - $withdraw_amount;
        //Add เข้ามูลเข้าตาราง financial_transaction
        $transaction_type = 'withdraw';
        $sql = "INSERT INTO financial_transaction (account_number, transaction_type, amount, transaction_date) VALUES ('$account_number', '$transaction_type', '$withdraw_amount', NOW())";
        mysqli_query($conn, $sql);
        // อัปเดตยอดเงินในบัญชี
        $sql = "UPDATE account SET balance = $new_balance WHERE account_number = $account_number";
        mysqli_query($conn, $sql);
        // แสดงข้อความว่าทำการถอนเงินสำเร็จ
        echo "<script>alert('ทำการถอนเงิน $withdraw_amount บาท สำเร็จ  ยอดคงเหลือ $new_balance บาท')</script>";
        echo "<script>window.location = 'withdraw.php'</script>";
    } else {
        // แสดงข้อความว่ายอดเงินในบัญชีไม่เพียงพอสำหรับการถอนเงิน
        echo "<script>alert('ยอดเงินในบัญชีไม่เพียงพอสำหรับการถอนเงิน')</script>";
        echo "<script>window.location = 'withdraw.php'</script>";
    }
}
