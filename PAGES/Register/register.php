<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GACHA - Registration</title>
    <link rel="stylesheet" href="../Register/styles/register.module.css">
    <link rel="stylesheet" href="../../CSS/styles.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
            <a href="../../index.html">Home</a>
            <a href="../ContactUs/contactus.html">Contact Us</a>
            <a href="../SignIn/signin.html"><img src="../../ASSETSGACHA/SIGN IN BUTTON-REVISED.png" alt="Sign In"></a>
        </div>
    </nav>

    <div class="container">
        <h1>Register</h1>
        <form id="registrationForm" action="user_registration.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">First Name:</label>
                <input type="text" id="name" name="name" required placeholder="E.g: Juan">
           
            
           
                <label for="mname">Middle Name:</label>
                <input type="text" id="mname" name="mname" required placeholder="E.g: Dela">
          
            
                <label for="lname">Last Name:</label>
                <input type="text" id="lname" name="lname" required placeholder="E.g: Cruz">
           

           
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required placeholder="E.g: JuanDelaCruz123@gmail.com" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$">
      

         
                <!-- <label for="password">Password:</label>
                <input type="password" id="password" name="password" required> -->

                <label for="password">Password:</label>
                <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                <input type="password" id="password" name="password" required>
          
                
          
                <label for="age">Age:</label>
                <input type="number" id="age" name="age" required placeholder="18">
          
                <label for="contactno">Contact No.:</label>
                <div class="contactno-container">
                    <span class="country-code">+63</span>
                    <input type="tel" id="contactno" name="contactno" required placeholder="912 345 6789" pattern="[1-9]\d{2} \d{3} \d{4}">
                </div>
                
                
                
                
                
                
         
                <label for="gamegenre">Game Genre:</label>
                <input type="text" id="gamegenre" name="gamegenre" required placeholder="Horror">
           
                <label for="profile_picture">Profile Picture:</label>
                <input type="file" name="profile_picture" id="profile_picture" accept="image/*">
            </div>

            <div class="register-btn">
                <button type="submit">Register</button>
            </div>
        </form>
    </div>

    <script>
        $(".toggle-password").click(function() {
            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
    </script>
</body>
</html>
