<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    if($_SESSION["usertype"]=="patient")
        header("location: patient.php");
    if($_SESSION["usertype"]=="doctor")
        header("location: doctor.php");
    if($_SESSION["usertype"]=="admin")
        header("location: admin.php");
    exit;
}
 
// Include config file
require_once "db.php";

// Define variables and initialize with empty values
$uid = $password = $usertype = "";
$uid_err = $password_err = $usertype_err = "";
$_SESSION["displaymsg"]="";
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["uid"]))){
        $uid_err = "Please enter User Id.";
    } else{
        $uid = trim($_POST["uid"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter password.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Check if usertype is selected
    if(!isset(($_POST["usertype"]))){
        $usertype_err = "Please Select User type.";
    } else{
        $usertype = ($_POST["usertype"]);
    }
    
    // Validate credentials
    if(empty($uid_err) && empty($password_err) && empty($usertype_err)){

        //patient
        if($usertype == "patient"){
            // Prepare a select statement
            $sql = "SELECT patient_id,patient_name,mail,login_password FROM patient WHERE patient_id= ?";
            
            if($stmt = $mysqli->prepare($sql)){
                // Bind variables to the prepared statement as parameters
                $stmt->bind_param("s", $param_uid);
                
                // Set parameters
                $param_uid = $uid;
                
                // Attempt to execute the prepared statement
                if($stmt->execute()){
                    // Store result
                    $stmt->store_result();
                    
                    // Check if username exists, if yes then verify password
                    if($stmt->num_rows == 1){                    
                        // Bind result variables
                        $stmt->bind_result($uid, $name,$mail,$hashed_password);
                        if($stmt->fetch()){
                            if(strcmp($password, $hashed_password)==0){
                                // Password is correct, so start a new session
                                session_start();
                                
                                // Store data in session variables
                                $_SESSION["loggedin"] = true;
                                $_SESSION["uid"] = $uid;
                                $_SESSION["usertype"] = $usertype;                            
                                $_SESSION["mail"]=$mail;
                                $_SESSION["name"]=$name;
                                $_SESSION["password"]=$hashed_password;
                                
                                // Redirect user to welcome page
                                    header("location: patient.php");

                            } else{
                                // Display an error message if password is not valid
                                $password_err = "Wrong password";
                            }
                        }
                    } else{
                        // Display an error message if username doesn't exist
                        $uid_err = "No account found with that User Id.";
                    }
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
    
                // Close statement
                $stmt->close();
            }
        }

        //doctor
        if($usertype == "doctor"){
            // Prepare a select statement
            $sql = "SELECT doctor_id,doctor_name,mail,login_password FROM doctor WHERE doctor_id = ?";
            
            if($stmt = $mysqli->prepare($sql)){
                // Bind variables to the prepared statement as parameters
                $stmt->bind_param("s", $param_uid);
                
                // Set parameters
                $param_uid = $uid;
                
                // Attempt to execute the prepared statement
                if($stmt->execute()){
                    // Store result
                    $stmt->store_result();
                    
                    // Check if username exists, if yes then verify password
                    if($stmt->num_rows == 1){                    
                        // Bind result variables
                        $stmt->bind_result($id, $name,$mail,$hashed_password);
                        if($stmt->fetch()){
                            if(strcmp($password, $hashed_password)==0){
                                // Password is correct, so start a new session
                                session_start();
                                
                                // Store data in session variables
                                $_SESSION["loggedin"] = true;
                                $_SESSION["uid"] = $uid;
                                $_SESSION["usertype"] = $usertype;                            
                                $_SESSION["mail"]=$mail;
                                $_SESSION["name"]=$name;
                                $_SESSION["password"]=$hashed_password;
                                
                                // Redirect user to welcome page
                                    header("location: doctor.php");

                            } else{
                                // Display an error message if password is not valid
                                $password_err = "Wrong password";
                            }
                        }
                    } else{
                        // Display an error message if username doesn't exist
                        $uid_err = "No account found with that User Id.";
                    }
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
    
                // Close statement
                $stmt->close();
            }
        }

        //admin
        if($usertype == "admin"){
            // Prepare a select statement
            $sql = "SELECT admin_id,admin_name,mail,login_password FROM admin WHERE admin_id = ?";
            
            if($stmt = $mysqli->prepare($sql)){
                // Bind variables to the prepared statement as parameters
                $stmt->bind_param("s", $param_uid);
                
                // Set parameters
                $param_uid = $uid;
                
                // Attempt to execute the prepared statement
                if($stmt->execute()){
                    // Store result
                    $stmt->store_result();
                    
                    // Check if username exists, if yes then verify password
                    if($stmt->num_rows == 1){                    
                        // Bind result variables
                        $stmt->bind_result($id, $name,$mail,$hashed_password);
                        if($stmt->fetch()){
                            if(strcmp($password, $hashed_password)==0){
                                // Password is correct, so start a new session
                                session_start();
                                
                                // Store data in session variables
                                $_SESSION["loggedin"] = true;
                                $_SESSION["uid"] = $uid;
                                $_SESSION["usertype"] = $usertype;                            
                                $_SESSION["mail"]=$mail;
                                $_SESSION["name"]=$name;
                                $_SESSION["password"]=$hashed_password;
                                
                                // Redirect user to welcome page
                                    header("location: admin.php");

                            } else{
                                // Display an error message if password is not valid
                                $password_err = "Wrong password";
                            }
                        }
                    } else{
                        // Display an error message if username doesn't exist
                        $uid_err = "No account found with that User Id.";
                    }
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
    
                // Close statement
                $stmt->close();
            }
        }

    }
    
    // Close connection
    $mysqli->close();
}

?>
<?php include('incl/header.php');?>
<head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="mystyle.css">  
    </head>
    <body>
        <div id="login" class="patientList">
            <div class="patientListHeader"><b>Login</b></div>
            <br><br>
            
            <div class="details">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <center>
                    <label for="uid"><b>UserId</b></label><?php echo (!empty($uid_err)) ? $uid_err : ''; ?><br>
                    <input type="text" id="uid" placeholder="Enter UserId" name="uid" required><br><br>
                
                    <label for="password"><b>Password</b></label><?php echo (!empty($password_err)) ? $password_err : ''; ?><br>
                    <input type="password" id="password" placeholder="Enter Password" name="password" required><br><br>

                    <label for="usertype"><b>Login as:</b></label><?php echo (!empty($usertype_err)) ? $usertype_err : ''; ?><br>
                    <select name="usertype" id="usertype">
                        <option value="patient">Patient</option>
                        <option value="doctor">Doctor</option>
                        <option value="admin">Admin</option>
                    </select><br><br>
                    
                    <input type="submit" value="Submit"><br><br>

                    <center>
                </form>
            </div>   
        </div>    
    </body>

    <?php include('incl/footer.php');?>