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
      <li><a href="about.php">about</a></li>
    </ul>
  </nav>
  <div class="content">
    <div class="form-box">
      <div class="form-value">
        <form action="create_account.php" method="post">
        <h3>Open bank account</h3>
          <div class="inputbox">
            <input type="text" id="customer_name" name="name">
            <label for="customer_name"> Name:</label>
          </div>
          <div  class="inputbox">
            <input type="text" id="email" name="email">
            <label for="customer_name"> Email:</label>
          </div>
          <div class="inputbox">
            <input type="number" id="initial_deposit" name="balance">
            <label for="initial_deposit">Initial Amount :</label>
          </div>
          <button type="submit">สร้างบัญชี</button>
        </form> 

      </div>
    </div>
  </div>




</body>

</html>
<?php

?>









<!-- -->