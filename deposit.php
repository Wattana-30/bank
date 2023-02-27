<?php
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
  <div class="content">
    <div class="form-box">
      <div class="form-value">
        <form action="deposit_amount.php" method="post">
          <h3>Deposit</h3>
        <div class="inputbox">
          <input type="text" id="customer_name" name="account_number">
          <label for="customer_name"> Account Number:</label>
        </div>
        <div class="inputbox">
            <input type="password" name="password">
            <label for="initial_deposit"> Password:</label>
          </div>
          <button type="submit">ฝากเงิน</button>
        </form>
      </div>
    </div>
  </div>




</body>

</html>