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
    <div class="form-box" style="height: 600px;">
      <div class="form-value">
        <form action="create_account.php" method="post" enctype="multipart/form-data">
          <h3>account</h3>
          <div class="upload">
            <img id="preview" src="../bank/img/pngegg.png" alt="preview" style="width: 100px; height: 100px;">
            <div class="round">
              <input type="file" name="image" accept="image/*" onchange="previewImage(event)">
              <i class="fa fa-camera"></i>
            </div>
          </div>
          <div class="l"><label for="image">Profile Image:</label></div>
          


          <div class="inputbox">
            <input type="text" id="customer_name" name="name">
            <label for="customer_name"> Name:</label>
          </div>
          <div class="inputbox">
            <input type="text" id="email" name="email">
            <label for="customer_name"> Email:</label>
          </div>
          <div class="inputbox">
            <input type="number" id="initial_deposit" name="balance">
            <label for="initial_deposit">Initial Amount :</label>
          </div>
          <div class="inputbox">
            <input type="password" name="password">
            <label for="initial_deposit"> Password:</label>
          </div>
          <button type="submit">สร้างบัญชี</button>
        </form>
      </div>
    </div>
  </div>

  <script>
    function previewImage(event) {
      var preview = document.querySelector('#preview');
      var file = event.target.files[0];
      var reader = new FileReader();

      if (file) {
        reader.readAsDataURL(file);
        reader.onload = function() {
          preview.src = reader.result;
        }
      } else {
        preview.src = "";
      }
    }

    var form = document.querySelector('form');
    form.addEventListener('submit', function(event) {
      var image = document.querySelector('input[type="file"]');
      if (image.files.length === 0) {
        event.preventDefault();
        alert("โปรดเลือกภาพโปรไฟล์");
      }
    });
  </script>
</body>

</html>