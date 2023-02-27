<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="css/style_ac.css">
  <title>Open bank account</title>
</head>
<body>
  <nav>
    <div class="logo"><i class="fa fa-bank"></i> BANK<b>.</b></div>
    <ul class="navItem">
      <li><a href="index.php">Home</a></li>
      <li><a href="#">about</a></li>
    </ul>
  </nav>
  
<?php 
session_start();
require_once 'config/db.php';
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // รับค่าจากฟอร์ม
    $account_number = $_POST['account_number'];
    $t_type = $_POST['t_tyet'];
    

      // ตรวจสอบว่าหมายเลขบัญชีนี้มีอยู่ในฐานข้อมูลหรือไม่
  $sql = "SELECT * FROM account WHERE account_number = '$account_number'";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) == 0) {
    echo "<script>alert('ไม่พบบัญชีนี้ในระบบ')</script>";
    echo "<script>window.location = 'financial.php'</script>";
    exit;
  } else {
    $sql = "SELECT * FROM account WHERE account_number = '$account_number'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    echo "<h2>"."Financial History"."</h2>";
    echo "<h5>".$row['account_name']."</h5>";

  }
    

    if ($t_type == "all") {
        $sql = "SELECT * FROM financial_transaction WHERE account_number = '$account_number'";
    } else {
        $sql = "SELECT * FROM financial_transaction WHERE account_number = '$account_number' AND transaction_type = '$t_type'";
    }

    $result = $conn->query($sql);

    // การแสดงผลเป็นตาราง
    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr>
        <th>Account Number</th>
        <th>Transaction Type</th>
        <th>Amount</th>
        <th>Transaction Date</th>
        </tr>";
        while($row = $result->fetch_assoc()) {
          $transaction_type = $row["transaction_type"] == "deposit" ? "เงินเข้า" : "เงินออก";
          $amount = $row['amount'];
          if ($transaction_type == "เงินเข้า") {
            $symbol = "+";
          } elseif ($transaction_type == "เงินออก") {
            $symbol = "-";
          }
          echo "<tr>
          <td>".$row["account_number"]."</td>
          <td>".$transaction_type."</td>
          <td>".$symbol.$amount."</td>
          <td>".$row["transaction_date"]."</td>
          </tr>";
        }
        echo "</table>";
      } else {
        echo "0 results";
      }
      

    // ปิดการเชื่อมต่อฐานข้อมูล
    $conn->close();
}
?>
<div class="back"><a href="financial.php"><input type="button" value="back"></a></div>


</body>
</html>