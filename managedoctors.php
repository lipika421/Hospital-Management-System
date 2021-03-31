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

            <div class="patientListHeader">MANAGE DOCTOR TABLE</div>

            <br><br>

            <div class="details">

                
                    <center>
                        <form action="managedoctors.php" method="POST">
                            <label for="doctorID">Doctor ID:</label><br>
                            <input type="text" id="doctorID" name="doctorID" value="" required><br><br>
    
                            <label for="doctorName">Doctor Name:</label><br>
                            <input type="text" id="doctorName" name="doctorName" value="" required><br><br>
    
                            <label for="degree">Highest Degree:</label><br>
                            <input type="text" id="degree" name="degree" value=""><br><br>
    
                            <label for="depcode">Department code:</label><br>
                            <input type="text" id="depcode" name="depcode" value="" required><br><br>
    
                        <label for="dob">Date of Birth:</label><br>
                        <input type="text" name="dob" placeholder="YYYY-MM-DD" required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" title="Enter a date in this formart YYYY-MM-DD"/><br>

                            <label for="mail">Mail:</label><br>
                            <input type="text" id="mail" name="mail" value=""><br><br>
    
                            <!-- default password is set to dob -->
                        
                            <input type="submit" name="add_button" value="ADD DOCTOR">
    
                            <input type="submit" name="update_button" value="UPDATE DOCTOR">
    
                        </form> 
    
                        <br>
                        <hr>

                        <?php
                        
                            require_once "db.php";
                            // Check connection    
                 
                            if ($mysqli->connect_error) {
                                die("Connection failed: " . $mysqli->connect_error); 
                            } 

                            $doc_id = "";
                            $doc_name = "";
                            $doc_degree = "";
                            $doc_dep = "";
                            $doc_dob = "";
                            $doc_mail = "";

                            $display_msg = "";
                            
                            if(isset($_POST['add_button'])){
                                //insert into table doctor

                                $doc_id = $_POST["doctorID"];
                                $doc_name = $_POST["doctorName"];
                                $doc_degree = $_POST["degree"];
                                $doc_dep = $_POST["depcode"];
                                $doc_dob = $_POST["dob"];
                                $doc_mail = $_POST["mail"];

                                $st = "SELECT doctor_id from doctor where doctor_id='$doc_id'";
                                $res = $mysqli->query($st);
                                if($res->num_rows){
                                    $display_msg = "Error: This doctor code already exists!";
                                }
                                else{
                                    $st = "SELECT department_code from department where department_code='$doc_dep'";
                                    $res = $mysqli->query($st);
                                    if(!$res->num_rows){
                                        $display_msg = "Error: This department does not exist!";
                                    }
                                    else{
                                        $sql = "INSERT INTO doctor (doctor_id, doctor_name, highest_degree, department_code, dob, login_password, mail)
                                            VALUES ('$doc_id', '$doc_name', '$doc_degree', '$doc_dep', '$doc_dob', '$doc_dob', '$doc_mail')";

                                        if(mysqli_query($mysqli, $sql)){
                                            $display_msg = "Record added successfully!";
                                        }
                                        else{
                                            $display_msg = "Some error occured, please try again later!";
                                        }
                                    }  
                                }
                            }
                            else if(isset($_POST['update_button'])){
                                //update table doctor

                                $doc_id = $_POST["doctorID"];
                                $doc_name = $_POST["doctorName"];
                                $doc_degree = $_POST["degree"];
                                $doc_dep = $_POST["depcode"];
                                $doc_dob = $_POST["dob"];
                                $doc_mail = $_POST["mail"];

                                $st = "SELECT doctor_id from doctor where doctor_id='$doc_id'";
                                $res = $mysqli->query($st);
                                if(!$res->num_rows){
                                    $display_msg = "Error: The doctor code does not exist!";
                                }
                                else{
                                    $sql = "UPDATE doctor
                                    SET doctor_name = '$doc_name', highest_degree = '$doc_degree', department_code = '$doc_dep', dob = '$doc_dob', mail = '$doc_mail'
                                    WHERE doctor_id = '$doc_id'";
                                    if(mysqli_query($mysqli, $sql)){
                                        $display_msg = "Record updated successfully!";
                                    }
                                    else{
                                        $display_msg = "Some error occured, please try again later!";
                                    }
                                }

                            }
                            
                        ?>
    
                        <!-- <form action="managedoctors.php" method="POST">
                            <label for="doctorID">Doctor ID:</label><br>
                            <input type="text" id="doctorID" name="doctorID" value=""><br><br>
    
                            <input type="submit" name="delete_button" value="DELETE DOCTOR">
    
                        </form>  -->

                        <?php
                            
                            // if(isset($_POST['delete_button'])){
                            //     //delete record in doctor
                            //     $doc_id = $_POST["doctorID"];
                            //     $st = "SELECT doctor_id from doctor where doctor_id='$doc_id'";
                            //     $res = $mysqli->query($st);
                            //     if(!$res->num_rows){
                            //         $display_msg = "Error: The record does not exist!";
                            //     }
                            //     else{
                            //         $sql = "DELETE FROM doctor WHERE doctor_id='$doc_id'";
                            //         if(mysqli_query($mysqli, $sql)){
                            //             $display_msg = "Record deleted successfully!";
                            //         }
                            //         else{
                            //             $display_msg = "Some error occured, please try again later!";
                            //         }
                            //     }

                            // }
                            
                        ?>

                    </center>

            </div>

            <div class="details">

                <center>
                    <p><?php echo $display_msg ?></p>
                    <button type="button" onclick="location.href = 'managedoctors.php';">CLEAR</button>
                </center>

            </div>
            
        </div>

<?php include('incl/footer.php');?>