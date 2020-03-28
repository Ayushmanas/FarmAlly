<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1"> 
        <title>Farmers page</title>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <script src="js/bootstrap.min.js"></script>
        <style type="text/css">
            body{ font: 14px sans-serif; text-align: center; background-image: url(images/background.jpg); }
        </style>
    </head>
    <body>
        <div class="display-6 float-left">
            <h3>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>, Welcome to our site.</h3>
        </div>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <div style="display:flex; flex-wrap: wrap;justify-content: center;"> 
            <form method="GET" action="file.php" style="margin-right:25%;">
                <button type="submit" class="btn btn-success btn-lg">Option 1</button>
            </form>
            <form method="GET" action="#">
                <button type="submit"class="btn btn-success btn-lg" >Option 2</button>
            </form>
        </div>
        <br>
        <br>
        <br>
        <br>
        <div style="display:flex; flex-wrap: wrap;justify-content: center;">    
            <form method="GET" action="#" style="margin-right:25%;">
                <button type="submit" class="btn btn-success btn-lg">Option 3</button>
            </form>
            <form method="GET" action="#">
                <button type="submit" class="btn btn-success btn-lg">Option 4</button>
            </form>
        </div>
        </center>
        <footer class="fixed-bottom container-fluid p-2 ext-center">
            <p>
                <a href="reset-password.php" class="btn btn-warning" style="margin-right:10%;">Reset Your Password</a>
                <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
            </p>
        </footer>
    </body>
</html>