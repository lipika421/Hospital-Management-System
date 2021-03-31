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

            <div class="patientListHeader">MANAGE DEPARTMENT TABLE</div>

            <br><br>

            <div class="details">

                
                    <center>
                        <form action="managedepartments.php" method="POST">

                            <label for="depID">Department ID:</label><br>
                            <input type="text" id="depID" name="depID" value="" required><br><br>
    
                            <label for="depName">Department Name:</label><br>
                            <input type="text" id="depName" name="depName" value="" required><br><br>
    
                            <label for="hod">HOD ID:</label><br>
                            <input type="text" id="hod" name="hod" value="" required><br><br>
                        
                            <input type="submit" name="add_button" value="ADD DEPARTMENT">
    
                            <input type="submit" name="update_button" value="UPDATE DEPARTMENT">
    
                        </form> 
    
                        <br>
                        <hr>

                        <?php
                        
                            require_once "db.php";
                            // Check connection    
                 
                            if ($mysqli->connect_error) {
                                die("Connection failed: " . $mysqli->connect_error); 
                            } 

                            $dept_code = "";
                            $dept_name = "";
                            $dept_hod = "";

                            $display_msg = "";
                            
                            if(isset($_POST['add_button'])){
                                //insert into table department

                                $dept_code = $_POST["depID"];
                                $dept_name = $_POST["depName"];
                                $dept_hod = $_POST["hod"];
       
                                $st = "SELECT department_code from department where department_code='$dept_code'";
                                $res = $mysqli->query($st);
                                
                                if($res->num_rows){
                                    $display_msg = "Error: This department code already exists!";
                                }
                                else{
                                    $sql = "INSERT INTO department (department_code, department_name, hod_id)
                                        VALUES ('$dept_code', '$dept_name', '$dept_hod')";

                                    if(mysqli_query($mysqli, $sql)){
                                        $display_msg = "Department added successfully!";
                                    }
                                    else{
                                        $display_msg = "Some error occured, please try again later!";
                                    }
                                }  

                            }
                            else if(isset($_POST['update_button'])){
                                //update table department

                                $dept_code = $_POST["depID"];
                                $dept_name = $_POST["depName"];
                                $dept_hod = $_POST["hod"];
    
                                $st = "SELECT department_code from department where department_code='$dept_code'";
                                $res = $mysqli->query($st);
                               
                                if(!$res->num_rows){
                                    $display_msg = "Error: The department code does not exist!";
                                }
                               else{
                                    $sql = "UPDATE department 
                                    SET department_name = '$dept_name', hod_id = '$dept_hod'
                                    WHERE department_code = '$dept_code'";
                                    if(mysqli_query($mysqli, $sql)){
                                        $display_msg = "Department updated successfully!";
                                    }
                                    else{
                                        $display_msg = "Some error occured, please try again later!";
                                    }
                               }

                            }
                            
                            ?>

                            <!-- <form action="managedepartments.php" method="POST">
                                <label for="depID">Department ID:</label><br>
                                <input type="text" id="depID" name="depID" value=""><br><br>
        
                                <input type="submit" name="delete_button" value="DELETE DEPARTMENT">
        
                            </form> -->

                            <?php
                            
                                // if(isset($_POST['delete_button'])){
                                //     //delete record in department
                                //     $dept_code = $_POST["depID"];
                                //     $st = "SELECT department_code from department where department_code='$dept_code'";
                                //     $res = $mysqli->query($st);
                                //     if(!$res->num_rows){
                                //         $display_msg = "Error: The department code does not exist!";
                                //     }
                                //     else{
                                //         $sql = "DELETE FROM department WHERE department_code='$dept_code'";
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
                    <p><?php echo $display_msg?></p>

                    <button type="button" onclick="location.href = 'managedepartments.php';">CLEAR</button>
                </center>

            </div>
            
        </div>
 
<?php include('incl/footer.php');?>