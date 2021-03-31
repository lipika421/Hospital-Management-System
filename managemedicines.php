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

            <div class="patientListHeader">MANAGE MEDICINE TABLE</div>

            <br><br>

            <div class="details">

                
                    <center>
                        <form action="managemedicines.php" method="POST">
                            <label for="medicineID">Medicine ID:</label><br>
                            <input type="text" id="medicineID" name="medicineID" value="" required><br><br>
    
                            <label for="medicineName">Medicine Name:</label><br>
                            <input type="text" id="medicineName" name="medicineName" value="" required><br><br>
    
                            <label for="price">Price:</label><br>
                            <input type="text" id="price" name="price" value="" required><br><br>
                        
                            <input type="submit" name="add_button" value="ADD MEDICINE">
    
                            <input type="submit" name="update_button" value="UPDATE MEDICINE">
    
                        </form> 
    
                        <br>
                        <hr>

                        <?php
                        
                            require_once "db.php";
                            // Check connection    
                 
                            if ($mysqli->connect_error) {
                                die("Connection failed: " . $mysqli->connect_error); 
                            } 

                            $med_id = "";
                            $med_name = "";
                            $price = "";

                            $display_msg = "";
                            
                            if(isset($_POST['add_button'])){
                                //insert into table medicine

                                $med_id = $_POST["medicineID"];
                                $med_name = $_POST["medicineName"];
                                $price = $_POST["price"];
                                
                                $st = "SELECT medicine_id from medicine where medicine_id='$med_id'";
                                $res = $mysqli->query($st);
                                if($res->num_rows){
                                    $display_msg = "Error: This medicine id is already exists!";
                                }
                                else{
                                    $sql = "INSERT INTO medicine (medicine_id, medicine_name, price)
                                        VALUES ('$med_id', '$med_name', '$price')";

                                    if(mysqli_query($mysqli, $sql)){
                                        $display_msg = "Record added successfully!";
                                    }
                                    else{
                                        $display_msg = "Some error occured, please try again later!";
                                    }
                                }  
                            }
                            else if(isset($_POST['update_button'])){
                                //update table medicine

                                $med_id = $_POST["medicineID"];
                                $med_name = $_POST["medicineName"];
                                $price = $_POST["price"];
                            
                                $st = "SELECT medicine_id from medicine where medicine_id='$med_id'";
                                $res = $mysqli->query($st);
                                if(!$res->num_rows){
                                    $display_msg = "Error: The medicine is not available!";
                                }
                                else{
                                    $sql = "UPDATE medicine
                                    SET medicine_name = '$med_name', price = '$price'
                                    WHERE medicine_id = '$med_id'";
                                    if(mysqli_query($mysqli, $sql)){
                                        $display_msg = "Record updated successfully!";
                                    }
                                    else{
                                        $display_msg = "Some error occured, please try again later!";
                                    }
                                }

                            }
                            
                        ?>
    
                        <!-- <form action="managemedicines.php" method="POST">
                            <label for="medicineID">Medicine ID:</label><br>
                            <input type="text" id="medicineID" name="medicineID" value=""><br><br>
    
                            <input type="submit" name="delete_button" value="DELETE MEDICINE">
    
                        </form>  -->

                        <?php
                            
                            // if(isset($_POST['delete_button'])){
                            //     //delete record in medicine
                            //     $med_id = $_POST["medicineID"];
                            //     $st = "SELECT medicine_id from medicine where medicine_id='$med_id'";
                            //     $res = $mysqli->query($st);
                            //     if(!$res->num_rows){
                            //         $display_msg = "Error: The record does not exist!";
                            //     }
                            //     else{
                            //         $sql = "DELETE FROM medicine WHERE medicine_id='$med_id'";
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
                    <button type="button" onclick="location.href = 'managemedicines.php';">CLEAR</button>
                </center>

            </div>
            
        </div>

<?php include('incl/footer.php');?>