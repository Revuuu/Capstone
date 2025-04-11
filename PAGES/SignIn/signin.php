<?php 
   session_start();

   if(isset($_SESSION['user_id']))
   {
      header("Location: ../Profile/display_profile.php");
   }
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="../Signin/styles/signin.module.css">
<link rel="stylesheet" href="../../CSS/styles.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<title>GACHA</title>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<style>

</style>
</head>
<body>
   <nav class="row">
      <div class="left-div">
         <div class="img-container">
            <img src="../../ASSETSGACHA/GACHA LOGO-REVISED.png" alt="GACHA Logo">
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
            <a href="../SignIn/signin.php"><img src="../../ASSETSGACHA/SIGN IN BUTTON-REVISED.png" alt="Sign In Button"></a>
         </div>
      </div>
   </nav>
   <div class="container">
      <form id="login-form" action="login.php" method="post">
         <div class="form-group">
            <div> 
               <label for="email">Email:</label>
            </div>
            <div>
               <input type="email" id="email" name="email" required placeholder="E.g: JuanDelaCruz123@gmail.com">
            </div>
            <div>
               <label for="password">Password:</label>
            </div>
            <div class="form-group">
               <input type="password" id="password" name="password" required>
               <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
            </div>
         </div>
         <a href="../Updateprofile/updateprofile.php" style="color:black;">Forgot password?</a>
         <p>Don't have an account? <a href="../Register/register.php">Register</a></p>
         <br>
         <div>
            <div class="login-btn">
               <button type="submit">Log In</button>
            </div>
         </div>
      </form>
   </div>
    <script>
        $(".toggle-password").click(function() {
            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $(this).siblings("input");
            if (input.attr("type") === "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
    </script>
</body>
</html>