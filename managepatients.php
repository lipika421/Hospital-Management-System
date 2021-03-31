<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>

<?php include('incl/header.php');?>
        
        <div id="myPatientList" class="patientList">

            <div class="patientListHeader">MANAGE PATIENT TABLE</div>

            <br><br>

            <div class="details">
                
                    <center>
                        <form action="managepatients.php" method="POST">
                            <label for="patientID">Patient ID:</label><br>
                            <input type="text" id="patientID" name="patientID" value="" required><br>
    
                            <label for="patientName">Patient Name:</label><br>
                            <input type="text" id="patientName" name="patientName" value="" required><br>
    
                            <label for="house">House Number:</label><br>
                            <input type="text" id="house" name="house" value=""><br>
    
                            <label for="street">Street Name:</label><br>
                            <input type="text" id="street" name="street" value=""><br>
    
                            <label for="state">State:</label><br>
                            <input type="text" id="state" name="state" value=""><br>

                            <label for="pin">Pincode:</label><br>
                            <input type="text" id="pin" name="pin" value=""><br>
    
                            <label for="age">Age:</label><br>
                            <input type="text" id="age" name="age" value=""><br>
    
                            <label for="dob">Date of Assign:</label><br>
                        <input type="text" name="dob" placeholder="YYYY-MM-DD" required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" title="Enter a date in this formart YYYY-MM-DD"/><br>

                            <label for="mail">Mail:</label><br>
                            <input type="text" id="mail" name="mail" value=""><br><br>
    
                            <label for="male">Gender:</label><br>
                            <input type="radio" id="male" name="gender" value="male">
                            <label for="male">Male</label>
                            <input type="radio" id="female" name="gender" value="female">
                            <label for="female">Female</label><br><br>
    
                            <label for="phone">Phone Number:</label><br>
                            <input type="text" id="phone" name="phone" value="" required><br><br>
    
                            <!-- default password is set to dob -->
                            <!-- default wallet is set to zero -->
                        
                            <input type="submit" name="add_button" value="ADD PATIENT">
    
                            <input type="submit" name="update_button" value="UPDATE PATIENT">
    
                        </form> 
    
                        <br>
                        <hr>

                        <?php
                        
                            require_once "db.php";
                            // Check connection    
                 
                            if ($mysqli->connect_error) {
                                die("Connection failed: " . $mysqli->connect_error); 
                            } 

                            $id = "";
                            $name = "";
                            $house = "";
                            $street = "";
                            $state = "";
                            $pin = "";
                            $age = "";
                            $dob = "";
                            $gender = "";
                            $phone = "";
                            $mail = "";

                            $display_msg = "";
                            
                            if(isset($_POST['add_button'])){
                                //insert into table patient
                                $id = $_POST["patientID"];
                                $name = $_POST["patientName"];
                                $house = $_POST["house"];
                                $street = $_POST["street"];
                                $state = $_POST["state"];
                                $pin = $_POST["pin"];
                                $age = $_POST["age"];
                                $dob = $_POST["dob"];
                                $gender = $_POST["gender"];
                                $mail = $_POST["mail"];
                                $phone = $_POST["phone"];                               
                                
                                $st = "SELECT patient_id from patient where patient_id='$id'";
                                $res = $mysqli->query($st);
                                if($res->num_rows){
                                    $display_msg = "Error: This patient id is already exists!";
                                }
                                else{
                                    $sql = "INSERT INTO patient (patient_id, patient_name, house_no, street_name, state_name, pin_code, age, dob, gender, login_password, wallet, mail)
                                        VALUES ('$id', '$name', '$house', '$street', '$state', '$pin', '$age', '$dob', '$gender', '$dob', 0, '$mail')";
                                    
                                    if(mysqli_query($mysqli, $sql)){
                                        $display_msg = "Record added successfully!";
                                    }
                                    else{
                                        $display_msg = "Some error occured, please try again later-patient!";
                                    }

                                    $sql = "INSERT INTO phone (patient_id, phone_no)
                                        VALUES ('$id', '$phone')";
                                    if(mysqli_query($mysqli, $sql)){
                                        $display_msg = "Record added successfully!";
                                    }
                                    else{
                                        $display_msg = "Some error occured, please try again later-phone!";
                                    }
                                }  
                            }
                            else if(isset($_POST['update_button'])){
                                //update table patient
                                $id = $_POST["patientID"];
                                $name = $_POST["patientName"];
                                $house = $_POST["house"];
                                $street = $_POST["street"];
                                $state = $_POST["state"];
                                $pin = $_POST["pin"];
                                $age = $_POST["age"];
                                $dob = $_POST["dob"];
                                $gender = $_POST["gender"];
                                $phone = $_POST["phone"];
                            
                                $st = "SELECT patient_id from patient where patient_id='$id'";
                                $res = $mysqli->query($st);
                                if(!($res->num_rows)){
                                    $display_msg = "Error: This patient id does not exist!";
                                }
                                else{
                                    $sql = "UPDATE patient
                                    SET patient_name = '$name', house_no = '$house', street_name = '$street', state_name = '$state', pin_code = '$pin', age = '$age', dob =  '$dob', gender = '$gender', mail = '$mail'
                                    WHERE patient_id = '$id'";
                                    if(mysqli_query($mysqli, $sql)){
                                        $display_msg = "Record updated successfully!";
                                    }
                                    else{
                                        $display_msg = "Some error occured, please try again later-patient!";
                                    }

                                    $sql = "UPDATE phone SET phone_no = '$phone'
                                            WHERE patient_id = '$id'";
                                    if(mysqli_query($mysqli, $sql)){
                                        $display_msg = "Record updated successfully!";
                                    }
                                    else{
                                        $display_msg = "Some error occured, please try again later-phone!";
                                    }
                                }

                            }
                            
                        ?>
    
                        <br>
                        <hr>

                        <form action="managepatients.php" method="POST">
                            <label for="patientID">Patient ID:</label><br>
                            <input type="text" id="patientID" name="patientID" value=""><br>

                            <label for="amount">Amount:</label><br>
                            <input type="text" id="amount" name="amount" value=""><br><br>
    
                            <input type="submit" name="increment_button" value="INCREMENT BALANCE">
    
                        </form> 

                        <?php
                            
                            if(isset($_POST['increment_button'])){
                                $id = $_POST["patientID"];
                                $st = "SELECT patient_id from patient where patient_id='$id'";
                                $res = $mysqli->query($st);
                                if(!$res->num_rows){
                                    $display_msg = "Error: This patient id does not exist!";
                                }
                                else{
                                    //update record in patient table
                                   
                                    $amount = $_POST["amount"];
                                    $sql = "UPDATE patient SET wallet = wallet + '$amount'
                                        WHERE patient_id = '$id'";
                                    if(mysqli_query($mysqli, $sql)){
                                        $display_msg = "Wallet incremented successfully!";
                                    }
                                    else{
                                        $display_msg = "Some error occured, please try again later!";
                                    }
                                }

                            }
                            
                        ?>

                    </center>

            </div>

            
        </div>
        <div class="details">

<center>
    <p><?php echo $display_msg ?></p>
    <button type="button" onclick="location.href = 'managepatients.php';">CLEAR</button>
</center>

</div>

<?php include('incl/footer.php');?>