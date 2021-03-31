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

            <div class="patientListHeader">EDIT PROFILE</div>

            <div class="details">
                
                    <center>

                    <form action="editprofile.php" method="POST">

                    <?php
                            require_once "db.php";
                            // Check connection    
                            
                            if ($mysqli->connect_error) {
                                die("Connection failed: " . $mysqli->connect_error); 
                            } 

                            $usertype = "patient";
                            $id=$_SESSION["uid"];
                            $pat_name="";
                            $pat_house="";
                            $pat_street="";
                            $pat_state="";
                            $pat_pin="";
                            $pat_age="";
                            $pat_dob="";
                            $pat_gender="";
                            $display_msg = "";
                                
                            if(strcmp($usertype,$_SESSION["usertype"]) == 0){

                                $get_details = "SELECT patient_name, house_no, street_name, state_name, pin_code, age, dob, gender FROM patient WHERE patient_id = '$id'";
        
                                $result = $mysqli->query($get_details);

                                $get_phone = "SELECT phone_no FROM phone WHERE patient_id = '$id'";
        
                                $phone_result = $mysqli->query($get_phone);
                                if($phone_result->num_rows > 0){
                                    $phone_row=$phone_result->fetch_assoc();
                                    $phone_no=$phone_row["phone_no"];
                                }
            
                            }

                            if ($result->num_rows > 0) {

                                while($row = $result->fetch_assoc()) {
                                  $pat_name = $row["patient_name"];
                                  $pat_house = $row["house_no"];
                                  $pat_street = $row["street_name"];
                                  $pat_state = $row["state_name"];
                                  $pat_pin = $row["pin_code"];
                                  $pat_age = $row["age"];
                                  $pat_dob = $row["dob"];
                                  $pat_gender = $row["gender"];
                                }

                            } 
                            else{
                                $display_msg = "No patient record found";
                            }

                            ?>
                            <label for="patientName">Patient Name:</label><br>
                            <input type="text" id="patientName" name="patientName" value='<?php echo $pat_name?>' required><br>
        
                            <label for="house">House Number:</label><br>
                            <input type="text" id="house" name="house" value='<?php echo $pat_house ?>'><br>
        
                            <label for="street">Street Name:</label><br>
                            <input type="text" id="street" name="street" value='<?php echo $pat_street ?>'><br>
        
                            <label for="state">State:</label><br>
                            <input type="text" id="state" name="state" value='<?php echo $pat_state ?>'><br>

                            <label for="pin">Pincode:</label><br>
                            <input type="text" id="pin" name="pin" value='<?php echo $pat_pin ?>'><br>
        
                            <label for="age">Age:</label><br>
                            <input type="text" id="age" name="age" value='<?php echo $pat_age ?>'><br>
        
                            <label for="dob">DOB:</label><br>
                            <input type="text" id="dob" name="dob" value='<?php echo $pat_dob ?>'><br><br>
        
                           <label for="male">Gender:</label><br>
                            <input type="radio" id="male" name="gender" value="m"  <?php  if($pat_gender=='m'){ echo "checked";} ?> >
                            <label for="male">Male</label>
                            <input type="radio" id="female" name="gender" value="f" <?php if($pat_gender=='f'){echo "checked";} ?>>
                            <label for="female">Female</label><br><br>
                        
                            <label for="phone">Phone Number:</label><br>
                            <input type="text" id="phone1" name="phone1" value='<?php echo $phone_no ?>'><br>
                            
                            <input type="submit"  name="submit" value="EDIT PROFILE">
    
                            </form>
                            <?php
                            if(isset($_POST['submit'])){
                                $pat_name = $_POST["patientName"];
                                $pat_house = $_POST["house"];
                                $pat_street = $_POST["street"];
                                $pat_state = $_POST["state"];
                                $pat_pin = $_POST["pin"];
                                $pat_age = $_POST["age"];
                                $pat_dob = $_POST["dob"];
                                $pat_gender = $_POST["gender"];

                                $sql = "UPDATE  patient
                                        SET patient_name= '$pat_name', house_no='$pat_house', street_name= '$pat_street', state_name='$pat_state', pin_code= '$pat_pin', age='$pat_age',dob= '$pat_dob',gender='$pat_gender'
                                        WHERE  patient_id ='$id' ";

                                if(!mysqli_query($mysqli,$sql))
                                {
                                    $display_msg =  "Server Busy! Please try again";
                                } 
                                header("location:editprofile.php");
                                exit;
                            }
                            ?>
                            </center>

                            <br>

                            </div>

                            <div class="details">

                                <center>
                                    <p><?php echo $display_msg ?> </p>
                            

                <button type="button" onclick="location.href = 'editprofile.php';">CLEAR</button>

                </center>

            </div>

            
        </div>

<?php include('incl/footer.php');?>