<?php
session_start();
require_once 'config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $account_number = $_POST['account_number'];
  $password = $_POST['password'];

  // ตรวจสอบว่าหมายเลขบัญชีนี้มีอยู่ในฐานข้อมูลหรือไม่
  $sql = "SELECT * FROM account WHERE account_number = '$account_number'";
  $sql = "SELECT * FROM account WHERE  password = '$password'";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) == 0) {
    echo "<script>alert('ไม่พบบัญชีนี้ในระบบ หรือรหัสผ่านไม่ถูกต้อง')</script>";
    echo "<script>window.location = 'deposit.php'</script>";
    exit;
  } else {
    

    // ดึงข้อมูลบัญชีจากเลขบัญชี
    $sql = "SELECT balance FROM account WHERE account_number = '$account_number'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $balance = $row['balance'];

    // ตรวจสอบว่าจำนวนเงินที่ฝากมามีค่ามากกว่า 0 หรือไม่
    if ($deposit_amount > 0) {
      // ดำเนินการฝากเงิน
      $sql = "INSERT INTO deposit (account_number, amount, transaction_date) VALUES ('$account_number', '$deposit_amount', NOW())";
      mysqli_query($conn, $sql);
      // กรณีทำการฝากเงิน
      $transaction_type = 'deposit';
      $sql = "INSERT INTO financial_transaction (account_number, transaction_type, amount, transaction_date) VALUES ('$account_number', '$transaction_type', '$deposit_amount', NOW())";
      mysqli_query($conn, $sql);

      // อัพเดทยอดเงินในบัญชี
      $sql = "UPDATE account SET balance = balance + '$deposit_amount' WHERE account_number = '$account_number'";
      mysqli_query($conn, $sql);

      // ดึงข้อมูลบัญชีจากเลขบัญชี (อัพเดทยอดเงิน)
      $sql = "SELECT balance FROM account WHERE account_number = '$account_number'";
      $result = mysqli_query($conn, $sql);
      $row = mysqli_fetch_assoc($result);
      $balance = $row['balance'];

      // แสดงข้อความเมื่อฝากเงินสำเร็จ
      echo "<script>alert('ฝากเงินสำเร็จ ยอดคงเหลือ $balance')</script>";
      echo "<script>window.location = 'deposit.php'</script>";
    } else {
      // แสดงข้อความเมื่อเกิดข้อผิดพล
      echo "<script>alert('ฝากไม่สำเร็จ')</script>";
      echo "<script>window.location = 'deposit.php'</script>";
    }
  }
}
