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
        <form action="t_financial.php" method="post">
            <h3>Financial History</h3>
            <div class="inputbox">
          <input type="text" id="customer_name" name="account_number"><br>
          <label for="customer_name"> Account Number:</label>
            </div>
            <div class="inputbox_1">
          <select name="t_tyet" id="">
            <option value="deposit">เงินฝาก</option>
            <option value="withdraw">เงินถอน</option>
            <option value="all">แสดงทั้งหมด</option>
          </select>
          <label for="initial_deposit"> Transaction Type:</label>
            </div>
          <button type="submit">ตกลง</button>
        </form>
      </div>
    </div>
  </div>




</body>

</html>