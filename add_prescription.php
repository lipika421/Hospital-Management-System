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

            <div class="patientListHeader">ADD PRESCRIPTION</div>

            <br><br>

            <div class="details">

            <?php

            //check available nurses
            require_once "db.php";
            // Check connection    
 
            if ($mysqli->connect_error) {
                die("Connection failed: " . $mysqli->connect_error); 
            } 
            $display_msg="";
            
            $prescription_id = 0;
            $st = "SELECT count(*) as cur_count
                    FROM prescription";
            $res = $mysqli->query($st);
            if(!$res->num_rows){
                $display_msg = "Seems like count did not work!";
            }
            else{
                $row = $res->fetch_assoc();
                $prescription_id = $row["cur_count"]+1;
            }
        
            
            ?>

                
                    <form action="add_prescription.php" method="POST">
                        <label for="prescriptionID">Prescription ID:</label><br>
                        <input type="text" id="prescriptionID" name="prescriptionID" value="<?php echo $prescription_id ?>" readonly><br><br>
                        <label for="medicineID">Medicine ID:</label><br>
                        <input type="text" id="medicineID" name="medicineID" value=""><br><br>
                        <label for="quantity">Quantity:</label><br>
                        <input type="text" id="quantity" name="quantity" value=""><br><br>
                        <br>
                        <label for="submit" >patient id:<?php echo $_SESSION["pat_id"]?> <br>
                        <input type="submit" name="submit" value="ADD PRESCRIPTION">
                      </form> 

                      <?php
                      
                       if(isset($_POST['submit'])){
                            $doc_id = $_SESSION["uid"];
                            $pat_id = $_SESSION["pat_id"];
                            $med_id = $_POST["medicineID"];
                            $quantity = $_POST["quantity"];

                            $sql = "INSERT INTO prescription (prescription_id, patient_id, doctor_id, medicine_id, quantity, bought_status)
                                    VALUES ('$prescription_id', '$pat_id', '$doc_id', '$med_id', '$quantity', 'N')";

                            if(mysqli_query($mysqli, $sql)){
                                $display_msg = "Prescription added successfully!";
                            }
                            else{
                                $display_msg = "Incorrect medicine id or patient id!";
                            }

                       }
                      
                      ?>
                

            </div>

            <div class="details">

                <center>
                    <p><?php echo $display_msg ?></p>
                    <button type="button" onclick="location.href = 'add_prescription.php';">CLEAR</button>
                </center>

            </div>
            
        </div>

<?php include('incl/footer.php');?>