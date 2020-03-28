<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
$isfarmer = $isfarmer_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate isFarmer
    if(empty(trim($_POST["isfarmer"]))){
        $isfarmer_err = "Please select from given options.";     
    } else{
        $isfarmer = trim($_POST["isfarmer"]);
    }

    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($isfarmer_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password, isfarmer) VALUES (?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_password, $param_isfarmer);
            
            // Set parameters
            $param_username = $username;
            $param_password = $password;//password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_isfarmer = $isfarmer;
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");                                                          //
            } else{
                echo "Something went wrong. Please try again later.";
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
        <div class="container mx-auto">
            <div class="d-flex justify-content-center">
                <div class="card jumbotron bg-light">
                    <div class="card-header">
                        <h3>Sign Up</h3>
                        
                    </div>
                    <div class="card-body">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                <p>Please fill this form to create an account.</p>
                                <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                                  <label>Enter your user name: <span style="color:red;">*</span></label>
                                  <input type="text" name="username" class="form-control" placeholder="Enter username" value="<?php echo $username; ?>">
                                  <span class="help-block"><?php echo $username_err; ?></span>
                                </div>
                                <div class="form-group">
                                    <label>Are you a farmer ? <span style="color:red;">*</span></label>
                                    <select name="isfarmer" class="btn-sm btn-secondary">
                                        <option value="farmer" class="btn-light">Yes</option>
                                        <option value="non-farmer" class="btn-light">No</option>
                                    </select>
                                    <span class="help-block"><?php echo $isfarmer_err; ?></span>
                                </div> 
                                <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                                  <label>Password: <span style="color:red;">*</span></label>
                                  <input type="password" name="password" class="form-control value="<?php echo $password; ?>" placeholder="Enter password">
                                  <span class="help-block"><?php echo $password_err; ?></span>
                                </div>
                                <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                                    <label>Confirm Password</label>
                                    <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                                    <span class="help-block"><?php echo $confirm_password_err; ?></span>
                                </div> 
                                <div class="form-group form-check">
                                  <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox"> Remember me
                                  </label>
                                </div>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary" value="Submit">
                                    <input type="reset" class="btn btn-default" value="Reset">
                                </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-center links">
                         Already have an account? <a href="login.php">Sign In</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div style="display:flex; flex-wrap: wrap;justify-content: center;"> 
            <form method="GET" action="index.html">
                <button type="submit" class="btn btn-success btn-lg">Home</button>
            </form>
        </div> 
        <br>   
    </body>
</html>