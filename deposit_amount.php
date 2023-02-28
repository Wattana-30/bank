<?php
session_start();
require_once 'config/db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="css/style_ac.css">
  <title>Deposit</title>
</head>
<body>
<nav>
    <div class="logo"><i class="fa fa-bank"></i> BANK<b>.</b></div>
    <ul class="navItem">
      <li><a href="index.php">Home</a></li>
      <li><a href="about.php">about</a></li>
    </ul>
  </nav>
<?php
$account_number = "";
if (isset($_POST['account_number'])) {
  $account_number = $_POST['account_number'];
} elseif (isset($_GET['account_number'])) {
  $account_number = $_GET['account_number'];
} else {
  // If account_number is not specified, redirect to homepage
  header('Location: index.php');
  exit();
}

$account_number = filter_var($account_number, FILTER_SANITIZE_STRING);

$stmt = mysqli_prepare($conn, "SELECT * FROM account WHERE account_number = ?");
mysqli_stmt_bind_param($stmt, "s", $account_number);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>
<div style="width: 100%; height: 100%; display: flex; justify-content: center; align-items: center; flex-direction: column; margin-top: 20px; ">
  <div style="background-color: #F0F0F0; border-radius: 10%; width: 500px; height: 400px;">
  <div class="ci" style=" display: flex; justify-content: center; align-items: center; flex-direction: column; margin-top: 50px;">
  <?php 
  if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
  
    // Display account information
    echo "<img src='".$row['image']."' style='height: 200px; width: 200px; border-radius: 20%; '><br>";
    echo "Account Number: ".$row['account_number']."<br>";
    echo "Account Name: ".$row['account_name']."<br>";
    echo "Balance: ".$row['balance']."<br>";
  } else {
    echo "Account number not found.";
  }
  ?>
</div>
</div>
</div>

</body>
</html>

<?php
//from 
echo <<<HTML
<div style="width: 100%; height: 100%; display: flex; justify-content: center; align-items: center; flex-direction: column; margin-top: 20px; ">
<div style="background-color: #F0F0F0; border-radius: 20px; width: 500px; height: 100px;">
<form action="deposit_amount.php" method="POST">  
  <div class="" style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
    <input type="hidden" name="account_number" value="$account_number">
    <label for="initial_deposit">Initial Amount :</label>
    <input type="number" id="initial_deposit" name="deposit_amount">
    <div style="">
      <input type="submit" value="ฝากเงิน" >
    </div>
    
  </div>
</form>
</div>
</div>
HTML;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['deposit_amount']) && is_numeric($_POST['deposit_amount']) && $_POST['deposit_amount'] > 0) {
    $deposit_amount = $_POST['deposit_amount'];

    // ตรวจสอบว่ามีตัวแปร account_number ที่ถูกตั้งค่าหรือไม่ และทำการ purify ข้อมูล input
    $account_number = filter_var($account_number, FILTER_SANITIZE_STRING);

    // เรียกยอดคงเหลือจากตารางบัญชี
    $stmt = mysqli_prepare($conn, "SELECT balance FROM account WHERE account_number = ?");
    mysqli_stmt_bind_param($stmt, "s", $account_number);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // ตรวจสอบว่าแบบสอบถามส่งคืนผลลัพธ์หรือไม่
    if (mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_assoc($result);
      $balance = $row['balance'];

      // ฝากเงินเข้าบัญชี
      $stmt = mysqli_prepare($conn, "INSERT INTO deposit (account_number, amount, transaction_date) VALUES (?, ?, NOW())");
      mysqli_stmt_bind_param($stmt, "sd", $account_number, $deposit_amount);
      mysqli_stmt_execute($stmt);

      // บันทึกการทำธุรกรรมทางการเงิน
      $transaction_type = 'deposit';
      $stmt = mysqli_prepare($conn, "INSERT INTO financial_transaction (account_number, transaction_type, amount, transaction_date) VALUES (?, ?, ?, NOW())");
      mysqli_stmt_bind_param($stmt, "ssd", $account_number, $transaction_type, $deposit_amount);
      mysqli_stmt_execute($stmt);

      // อัพเดทยอดเงินในบัญชี
      $stmt = mysqli_prepare($conn, "UPDATE account SET balance = balance + ? WHERE account_number = ?");
      mysqli_stmt_bind_param($stmt, "ds", $deposit_amount, $account_number);
      mysqli_stmt_execute($stmt);

      // รับยอดคงเหลือที่อัปเดต
      $stmt = mysqli_prepare($conn, "SELECT balance FROM account WHERE account_number = ?");
      mysqli_stmt_bind_param($stmt, "s", $account_number);
      // รับยอดคงเหลือที่อัปเดต
      $stmt = mysqli_prepare($conn, "SELECT balance FROM account WHERE account_number = ?");
      mysqli_stmt_bind_param($stmt, "s", $account_number);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);

      // ตรวจสอบว่าแบบสอบถามส่งคืนผลลัพธ์หรือไม่
      if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $new_balance = $row['balance'];

        // แสดงข้อความแสดงความสำเร็จด้วยยอดเงินใหม่
        echo "ฝากเงินเรียบร้อยแล้ว<br>";
        echo "ยอดเงินในบัญชีของคุณคือ: $new_balance"."<br>";
        echo '<a href="index.php" ><--Go to homepage</a>';
      } else {
        // แสดงข้อความแสดงข้อผิดพลาดหากไม่พบหมายเลขบัญชี
        echo "ไม่พบหมายเลขบัญชีนี้ในระบบ";
      }
    }
  }
}
