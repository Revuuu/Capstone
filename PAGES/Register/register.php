<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="./styles/register.module.css">
<link rel="stylesheet" href="../../CSS/styles.css">
<!-- <script src="submitform.js"></script> -->
<title>GACHA</title>
</head>
<body>
    <nav class="row">
      <div class="left-div">
        <div class="img-container">
          <img src="../../ASSETSGACHA/GACHA LOGO-REVISED.png">
        </div>
        <p>GACHA</p>
      </div>
      <div class="right-div">
        <div>
          <a href="../../index.html">Home</a>
        </div>
        <div>
          <a href="../ContactUs/contactus.html">Contact Us</a>
        </div>
        <div>
          <a href="../SignIn/signin.html"><img src="../../ASSETSGACHA/SIGN IN BUTTON-REVISED.png"></a>
        </div>
      </div>                        
    </nav>
    <div class="container">
      <form id="registrationForm" action="user_registration.php" method="post">
        <div class="form-group1">
          <div> 
            <label for="name">Name:</label>
            <input type="name" id="name" name="name" required placeholder="E.g: Juan Dela Cruz">
          </div>

          <div> 
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required placeholder="E.g: JuanDelaCruz123@gmail.com">
            <?php
                    if (isset($_SESSION['error'])) {
                        echo '<span style="color: red;">' . $_SESSION['error'] . '</span>';
                        unset($_SESSION['error']); // Clear the error after displaying it
                    }
            ?>
          
          </div>
          
          <div>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required>
          </div>

          <div> 
            <label for="age">Age:</label>
            <input type="age" id="age" name="age" required placeholder="18">
          </div>

          <div>
            <label for="contactno">Contact No.:</label><br>
            <input type="contactno" id="contactno" name="contactno" required placeholder="0912 345 6789">
          </div>

          <div>
            <label for="gamegenre">Game Genre:</label><br>
            <input type="gamegenre" id="gamegenre" name="gamegenre" required placeholder="Horror">
          </div>

        </div>
        <br>

       
        <div class="register-btn">
          <button type="submit">
            Register
            <!-- <img src="../Register/assets/images/REGISTER BUTTON REVISED.png" alt="Register"> -->
          </button>
        </div>
          <!-- <div class="add-btn">
            <img src="../../ASSETSGACHA/ADD BUTTON REVISED.png"></a>
          </div> -->
        
      </form>
      
    </div>


  </body>
  </html>
    