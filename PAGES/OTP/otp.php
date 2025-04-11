<?php 
    session_start();

    if(!isset($_SESSION['user_otp_id'])){
        if(isset($_SESSION['user_id'])){
            header("Location: ../Profile/display_profile.php");
        } else {
            header("Location: ./index.html");
        }
    } 

?>
<html>
    <head>
    </head>
    <body>
        <form action="verify.php" method="post">
            <input type="number" name="otp" placeholder="Please enter the otp sent to your email">
            <input type="submit" value="Verify">
        </form>
    </body>
</html>