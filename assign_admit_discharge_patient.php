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

        <div class="patientListHeader">ASSIGN DOCTOR</div>

        <br><br>

        <div class="details">

            
                <center>
                    <form action="assign_admit_discharge_patient.php" method="POST">
                        <label for="patientID">Patient ID:</label><br>
                        <input type="text" id="patientID" name="patientID" value="" required><br><br>
                        <label for="depCode">Department:</label><br>
                        <input type="text" id="depCode" name="depCode" value="" required><br><br>
                        <label for="date_of_assign">Date of Assign:</label><br>
                        <input type="text" name="date_of_assign" placeholder="YYYY-MM-DD" required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" title="Enter a date in this formart YYYY-MM-DD"/><br>
                        <input type="submit" name="assign_button" value="ASSIGN DOCTOR">
                        <input type="submit" name="admit_button" value="ADMIT PATIENT">
                    </form> 
                </center>
            
                <br>
                <hr>

                    <?php
                                
                        require_once "db.php";
                        // Check connection    
                        
                        if ($mysqli->connect_error) {
                            die("Connection failed: " . $mysqli->connect_error); 
                        
                        }
                        $pat_id = "" ;
                        $dept_code = "" ;
                        $date_assign = "" ;
                        $date_release ="" ;

                        $display_msg = "";

                        if(isset($_POST['assign_button'])){
                            //insert into table department

                            $pat_id = $_POST["patientID"];
                            $dept_code = $_POST["depCode"];
                            $date_assign = $_POST["date_of_assign"];
   
                            $st = "SELECT doctor_id from doctor where department_code='$dept_code' 
                            and doctor_id not in (select a.doctor_id from assign a,doctor d where a.doctor_id=d.doctor_id and d.department_code='$dept_code'
                            and a.date_of_release is NULL group by a.doctor_id having count(*)>=5 ) ";
                            $res = $mysqli->query($st);
                            $display_msg="error ";
                            if(!$res->num_rows){
                                $display_msg = "No doctor available";
                            }
                            else{
                                $row = mysqli_fetch_row($res);
                                $sql = "INSERT INTO assign (patient_id,doctor_id,date_of_assign)
                                    VALUES ('$pat_id', '$row[0]','$date_assign')";

                                if(mysqli_query($mysqli, $sql)){
                                    $display_msg = "Assigned successfully!";
                                }
                                else{
                                    $display_msg = "Some error occured, please try again later!";
                                }
                            }  

                        }
                        else if(isset($_POST['admit_button'])){
                            $pat_id = $_POST["patientID"];
                            $dept_code = $_POST["depCode"];
                            $date_assign = $_POST["date_of_assign"];
                            $st="SELECT patient_id from admit where patient_id='$pat_id' and date_of_release is NULL";
                            $res = $mysqli->query($st);
                            if($res->num_rows){
                                $display_msg = "patient already admitted!";
                            }
                            else{
                                    $st = "SELECT room_id from room where beds_occupied<no_of_beds and beds_occupied in (select MIN(beds_occupied) from room where beds_occupied<no_of_beds)";
                                    $res = $mysqli->query($st);
                                    $row=$res->fetch_assoc();
                                    if(!$res->num_rows){
                                        $display_msg = "Error: No rooms available!";
                                    }
                                    else{
                                        $sql = "INSERT into admit(patient_id,room_id,date_of_admit)
                                        values ('$pat_id','$row[room_id]','$date_assign')" ;
                                        if(mysqli_query($mysqli, $sql)){
                                            $display_msg = "admitted!";
                                            $sql="UPDATE room set beds_occupied=beds_occupied+1 where room_id='$row[room_id]'";
                                            
                                            if(!mysqli_query($mysqli,$sql)){
                                                $display_msg="Error";
                                            }
                                        }
                                        else{
                                            $display_msg = "Some error occured, please try again later!";
                                        }
                                    }
                                }
                        }
                    

?>
                    <div class="details">
                    <center>
                    <form action="assign_admit_discharge_patient.php" method="POST">
                        <label for="patientID">Patient ID:</label><br>
                        <input type="text" id="patientID" name="patientID" value="" required><br><br>
                        
                        <label for="date_of_release">Date of Discharge:</label><br>
                        <input type="text" name="date_of_release" placeholder="YYYY-MM-DD" required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" title="Enter a date in this formart YYYY-MM-DD"/><br>
                        <br>
                        <input type="submit" name="discharge_button" value="DISCHARGE PATIENT">
                        
                      </form> 
                      <?php
                            
                                if(isset($_POST['discharge_button'])){
                                    //delete record in department
                                    $pat_id = $_POST["patientID"];
                                    $date_release=$_POST["date_of_release"];
                                        $st="SELECT room_id from admit where patient_id='$pat_id' and date_of_release is NULL";
                                        $res = $mysqli->query($st);
                                        $row=$res->fetch_assoc();
                                        if(!$res->num_rows){
                                            $display_msg = "Error:patient_Not admitted!";
                                        }
                                        else{
                                            $sql = "UPDATE admit set date_of_release='$date_release' where patient_id='$pat_id' and date_of_release is NULL ";
                                            if(mysqli_query($mysqli, $sql)){
                                                $sqlm= "UPDATE assign set date_of_release='$date_release' where patient_id='$pat_id' and date_of_release is NULL ";
                                                if(mysqli_query($mysqli, $sqlm)){
                                                    $display_msg = "Record updated successfully!";

                                                    $sqln="UPDATE room set beds_occupied=beds_occupied-1 where room_id='$row[room_id]'";
                                                    
                                                    if(!mysqli_query($mysqli,$sqln)){
                                                        $display_msg="Error";
                                                    }
                                                }
                                                else{
                                                    $display_msg="Error";
                                                }
                                            }
                                            else{
                                                $display_msg = "Some error occured, please try again later!";
                                            }
                                        }

                                }
                            
                            ?>
                </center>
                
</div>
<div class="details">
                    <center>
                    <form action="assign_admit_discharge_patient.php" method="POST">
                        <label for="patientID">Patient ID:</label><br>
                        <input type="text" id="patientID" name="patientID" value="" required><br><br>
                        <label for="date_of_release">Date of release:</label><br>
                        <input type="text" name="date_of_release" placeholder="YYYY-MM-DD" required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" title="Enter a date in this formart YYYY-MM-DD"/><br>
                        <br>
                        <input type="submit" name="release_button" value="Release Patient">
                        
                      </form> 
                      <?php
                            
                                if(isset($_POST['release_button'])){
                            
                                    $pat_id = $_POST["patientID"];
                                    
                                    $date_release=$_POST["date_of_release"];
                                        $st="SELECT patient_id from assign where patient_id='$pat_id' and date_of_release is NULL";
                                        $res = $mysqli->query($st);
                                        $row=$res->fetch_assoc();
                                        if(!$res->num_rows){
                                            $display_msg = "Error:patient_Not assigned to doctor!";
                                        }
                                        else{
                                            $sql = "UPDATE assign set date_of_release='$date_release' where patient_id='$pat_id' and date_of_release is NULL ";
                                            
                                                if(mysqli_query($mysqli, $sql)){
                                                    $display_msg = "Record updated successfully!";
                                                }
                                                else{
                                                    $display_msg="Error";
                                                }
                                            }

                                }
                            
                            ?>
                </center>
                
</div>

</div>
<div class="details">
                <center>
                    <p><?php echo $display_msg?> </p>
                    <button type="button" onclick="location.href='assign_admit_discharge_patient.php';">CLEAR</button>
                </center>
</div>
