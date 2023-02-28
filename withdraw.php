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
  <title>Withdraw</title>
</head>

<body>
  <nav>
    <div class="logo"><i class="fa fa-bank"></i> BANK<b>.</b></div>
    <ul class="navItem">
      <li><a href="index.php">Home</a></li>
      <li><a href="about.php">about</a></li>
    </ul>
  </nav>
  <div class="content">
    <div class="form-box">
      <div class="form-value">

</html>
<form action="withdraw.php" method="post">
  <h3>Withdraw.</h3>
  <div class="inputbox">
    <input type="text" id="customer_name" name="account_number">
    <label for="customer_name"> Account Number:</label>
  </div>
  <div class="inputbox">
    <input type="password" name="password">
    <label for="initial_deposit"> Password:</label>
  </div>
  <button type="submit">ถอนเงิน</button>
</form>
</div>
</div>
</div>

</body>
<?php


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $account_number = $_POST['account_number'];
  $password = $_POST['password'];

  // ตรวจสอบว่าหมายเลขบัญชีนี้และรหัสผ่านถูกต้องหรือไม่
  $sql = "SELECT * FROM account WHERE account_number = '$account_number' AND password = '$password'";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) == 0) {
    echo "<script>alert('ไม่พบบัญชีนี้ในระบบ หรือรหัสผ่านไม่ถูกต้อง')</script>";
    echo "<script>window.location = 'withdraw.php'</script>";
    exit;
  }else {
    // ถ้าพบบัญชีในระบบ
    $account = mysqli_fetch_assoc($result);
    $account_id = $account['id'];
    $account_number = $account['account_number'];
    mysqli_close($conn);
    // ส่งค่า account_number ไปที่ withdraw_amount.php เพื่อทำการฝากเงิน
    header("Location: withdraw_amount.php?account_number=$account_number");
    exit;
  }
}