<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
  if($_SESSION["isfarmer"]=="farmer")  
  header("location: farmers.php");
  else
  header("location: agriculture.php");
  exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
$isfarmer = $isfarmer_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Check if 'isfarmer' is empty
    if(empty(trim($_POST["isfarmer"]))){
        $isfarmer_err = "Please fill in this.";
    } else{
        $isfarmer = trim($_POST["isfarmer"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err) && empty($isfarmer_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password, isfarmer FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password, $isfarmer);
                    if(mysqli_stmt_fetch($stmt)){
                        if($password==$hashed_password){           //if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            $_SESSION["isfarmer"] = $isfarmer;
                            // Redirect user to welcome page
                            if($_SESSION["isfarmer"]=="farmer")
                                header("location: farmers.php");
                            else
                                header("location: agriculture.php");    
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html >
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1"> 
        <title>FarmAlly - Login Page</title>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <script src="js/bootstrap.min.js"></script>
    </head>
    <body style="background-image: url(images/background.jpg);">
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <div class="container mx-auto">
            <div class="d-flex justify-content-center">
                <div class="card bg-light">
                    <div class="card-header">
                        <h3>Log In</h3>
                        
                    </div>
                    <div class="card-body">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <div class="input-group form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>" placeholder="username">
                                <span class="help-block"><?php echo $username_err; ?></span>
                            </div>
                            <div class="input-group form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                                </div>
                                <input type="password"  name="password" class="form-control" placeholder="password">
                                <span class="help-block"><?php echo $password_err; ?></span>
                            </div>
                            <label for id="person" class="from-group">Are you a Farmer ?</label>
                            <div class="input-group form-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                                </div>
                                <select name="isfarmer" class="form-control">
                                    <option value="farmer">Yes</option>
                                    <option value="non-farmer">No</option>
                                  </select>
                            </div>
                            <div class="row align-items-center remember">
                                <input type="checkbox">Remember Me
                            </div>
                            <div class="form-group">
                                <input type="submit" value="Login" class="btn btn-primary float-right">
                            </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-center links">
                            Don't have an account? <a href="register.php">Sign Up</a>
                        </div>
                        <!--<div class="d-flex justify-content-center">
                            <a href="reset-password.php">Forgot your password?</a>
                        </div>-->
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div style="display:flex; flex-wrap: wrap;justify-content: center;"> 
            <form method="GET" action="index.html">
                <button type="submit" class="btn btn-success btn-lg">Home</button>
            </form>
        </div>
    </body>
</html>