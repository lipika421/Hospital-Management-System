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

            <div class="patientListHeader">MANAGE NURSE TABLE</div>

            <br><br>

            <div class="details">

                
                    <center>

                        <form action="manage_rooms_nurses.php" method="POST">

                            <input type="submit" name="check_nurses" value="CHECK AVAILABLE NURSES">
    
                        </form> 

                        <?php
                            //check available nurses
                            require_once "db.php";
                            // Check connection    
                 
                            if ($mysqli->connect_error) {
                                die("Connection failed: " . $mysqli->connect_error); 
                            } 

                            $available_nurses = array();
                            $count = 0;
                            $display_msg_1="";
                            $display_msg_2="";
                            $display_msg_3="";
                            $display_msg_4="";

                            if(isset($_POST['check_nurses'])){
                                $st = "SELECT nurse_id from nurse where room_id is NULL";
                                $res = $mysqli->query($st);
                                $count = $res->num_rows;

                                if ($res->num_rows > 0) {

                                    while($row = $res->fetch_assoc()) {
                                      array_push($available_nurses, $row["nurse_id"]);
                                    }
    
                                } 

                            }
                        
                        ?>

                        <div class="details">

                            <center>
                                <p>Available nurses:</p>
                                <?php
                                    $i = 0;
                                    echo "<p>";
                                    while($i < $count){
                                        echo " ".$available_nurses[$i]." ";
                                        $i++;
                                    }
                                    echo "</p>";
                                
                                ?>

                                <button type="button" onclick="location.href = 'manage_rooms_nurses.php';">CLEAR</button>
                            </center>
            
                        </div>

                        <br>
                        <hr>

                        <form action="manage_rooms_nurses.php" method="POST">

                            <label for="roomID">Room ID:</label><br>
                            <input type="text" id="roomID" name="roomID" value="" required><br><br>

                            <label for="beds">Number of Beds:</label><br>
                            <input type="text" id="beds" name="beds" value="" required><br><br>

                            <label for="nurseID">Nurse ID:</label><br>
                            <input type="text" id="nurseID" name="nurseID" value="" required><br><br>
    
                            <!-- default beds_occupied is set to zero -->
    
                            <input type="submit" name="add_room" value="ADD ROOM">
    
                            <input type="submit" name="update_room" value="UPDATE ROOM">
    
                        </form> 

                        <?php
                        
                        if(isset($_POST['add_room'])){
                            $room_id = $_POST["roomID"];
                            $no_beds = $_POST["beds"];
                            $nurse_id = $_POST["nurseID"];

                            $display_msg_1 = "";

                            $st = "SELECT room_id from room where room_id='$room_id'";
                            $res = $mysqli->query($st);
                            if($res->num_rows){
                                $display_msg_1 = "Error: This room id is already exists!";
                            }
                            else{
                                $st = "SELECT room_id from nurse where nurse_id='$nurse_id'";
                                $res = $mysqli->query($st);
                                if(!$res->num_rows){
                                    $display_msg_1 = "Error: This nurse does not exist!";
                                }
                                else{
                                    while($row = $res->fetch_assoc()) {
                                        if($row["room_id"]){
                                            $display_msg_1 = "Error: This nurse is not available!";
                                        }
                                        else{
                                            $sql = "INSERT INTO room (room_id, no_of_beds, beds_occupied, nurse_id)
                                                    VALUES ('$room_id', '$no_beds', 0, '$nurse_id')";
                                    
                                            if(mysqli_query($mysqli, $sql)){
                                                $display_msg_1 = "Record added successfully!";
                                            }
                                            else{
                                                $display_msg_1 = "Some error occured, please try again later!";
                                            }
                                            $sql = "UPDATE nurse SET room_id = '$room_id' WHERE nurse_id = '$nurse_id'";
                                    
                                            if(mysqli_query($mysqli, $sql)){
                                                $display_msg_1 = "Record added successfully!";
                                            }
                                            else{
                                                $display_msg_1 = "Some error occured, please try again later!";
                                            }

                                        }
                                    }
                                }
                            }

                        }  
                        
                        if(isset($_POST['update_room'])){
                            $room_id = $_POST["roomID"];
                            $no_beds = $_POST["beds"];
                            $nurse_id = $_POST["nurseID"];
                            $initial_nurse = "";

                            $display_msg_1 = "";

                            $st = "SELECT room_id from room where room_id='$room_id'";
                            $res = $mysqli->query($st);
                            if(!$res->num_rows){
                                $display_msg_1 = "Error: This room id does not exist!";
                            }
                            else{
                                $st = "SELECT room_id, nurse_id from nurse where nurse_id='$nurse_id'";
                                $res = $mysqli->query($st);
                                if(!$res->num_rows){
                                    $display_msg_1 = "Error: This nurse does not exist!";
                                }
                                else{
                                    while($row = $res->fetch_assoc()) {
                                        if($row["room_id"]!=NULL&&$row["room_id"]!=$room_id){
                                            $display_msg_1 = "Error: This nurse is not available!";
                                        }
                                        else{
                                            $st = "SELECT  nurse_id from room where room_id='$room_id'";
                                            $res = $mysqli->query($st);
                                            $row=$res->fetch_assoc();
                                            $initial_nurse = $row["nurse_id"];
                                            $st = "SELECT beds_occupied from room where room_id='$room_id'";
                                            $res = $mysqli->query($st);
                                            if($res->num_rows){
                                                while($row = $res->fetch_assoc()) {
                                                    if($no_beds < $row["beds_occupied"]){
                                                        $display_msg_1 = "Error: The room has some occupied beds, kindly shift the patients first!";
                                                    }
                                                    else{
                                                        $sql = "UPDATE room SET no_of_beds = '$no_beds', nurse_id = '$nurse_id'
                                                                WHERE room_id = '$room_id'";
                                                
                                                        if(mysqli_query($mysqli, $sql)){
                                                            $display_msg_1 = "Room status updated successfully!";
                                                        }
                                                        else{
                                                            $display_msg_1 = "Some error occured, please try again later!";
                                                        }
                                                        $sql = "UPDATE nurse SET room_id = '$room_id'
                                                                WHERE nurse_id = '$nurse_id'";
                                                        if(mysqli_query($mysqli, $sql)){
                                                            $display_msg_1 = "Room status updated successfully!";
                                                        }
                                                        else{
                                                            $display_msg_1 = "Some error occured, please try again later!";
                                                        }
                                                        $sql = "UPDATE nurse SET room_id = NULL
                                                                WHERE nurse_id = '$initial_nurse'";
                                                        if(mysqli_query($mysqli, $sql)){
                                                            $display_msg_1 = "Room status updated successfully!";
                                                        }
                                                        else{
                                                            $display_msg_1 = "Some error occured, please try again later!";
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        
                        ?>

                        <div class="details">

                            <center>
                                <p><?php echo $display_msg_1 ?></p>
                                <button type="button" onclick="location.href = 'manage_rooms_nurses.php';">CLEAR</button>
                            </center>
            
                        </div>
    
                        <br>
                        <hr>

                        <!-- <form action="manage_rooms_nurses.php" method="POST">

                            <label for="roomID">Room ID:</label><br>
                            <input type="text" id="roomID" name="roomID" value=""><br><br>
    
                            <input type="submit" name="delete_room" value="DELETE ROOM">

    
                        </form>  -->
                    
                         <?php

                        // if(isset($_POST['delete_room'])){
                        //     $room_id = $_POST["roomID"];
                        //     $display_msg_2 = "";

                        //     $st = "SELECT room_id from room where room_id='$room_id'";
                        //     $res = $mysqli->query($st);
                        //     if(!$res->num_rows){
                        //         $display_msg_2 = "Error: This room id does not exist!";
                        //     }
                        //     else{
                        //         $st = "SELECT nurse_id from nurse where room_id='$room_id'";
                        //         $res = $mysqli->query($st);
                        //         if($res->num_rows){
                        //             while($row = $res->fetch_assoc()) {
                        //                 $nurse_id = $row["nurse_id"];
                        //             }
                        //         }

                        //         $sql = "DELETE from room
                        //                 WHERE room_id = '$room_id'";
                        //         if(mysqli_query($mysqli, $sql)){
                        //             $display_msg_2 = "Record deleted successfully!";
                        //         }
                        //         else{
                        //             $display_msg_2 = "Some error occured, please try again later!";
                        //         }

                        //         $sql = "UPDATE nurse SET room_id = NULL
                        //                 WHERE nurse_id = '$nurse_id'";
                        //         if(mysqli_query($mysqli, $sql)){
                        //             $display_msg_2 = "Record deleted successfully!";
                        //         }
                        //         else{
                        //             $display_msg_2 = "Some error occured, please try again later!";
                        //         }
                        //     }
                        // }
                        
                        ?> 

                        <br>
                        <hr>
    
                        <form action="manage_rooms_nurses.php" method="POST">

                            <label for="nurseID">Nurse ID:</label><br>
                            <input type="text" id="nurseID" name="nurseID" value="" required><br><br>

                            <label for="nurseID">Nurse Name:</label><br>
                            <input type="text" id="nursename" name="nursename" value="" required><br><br>
    
                            <input type="submit" name="add_nurse" value="ADD NURSE">
    
                        </form> 
                        <?php

                        if(isset($_POST['add_nurse'])){
                            $nurse_id = $_POST["nurseID"];
                            $nurse_name = $_POST["nursename"];
                            $display_msg_3 = "";

                            $st = "SELECT nurse_id from nurse where nurse_id='$nurse_id'";
                            $res = $mysqli->query($st);
                            if($res->num_rows){
                                $display_msg_3 = "Error: This nurse id already exists!";
                            }
                            else{
                                
                                $sql = "INSERT INTO nurse(nurse_id, nurse_name, room_id)
                                        VALUES ('$nurse_id', '$nurse_name', NULL)";
                                if(mysqli_query($mysqli, $sql)){
                                    $display_msg_3 = "Nurse added successfully!";
                                }
                                else{
                                    $display_msg_3 = "Some error occured, please try again later!";
                                }

                            }
                        }
                        
                        ?>
                        <div class="details">

                            <center>
                                <p><?php echo $display_msg_3 ?></p>
                                <button type="button" onclick="location.href = 'manage_rooms_nurses.php';">CLEAR</button>
                            </center>
            
                        </div>

                        <br>
                        <hr>
    
                        <!-- <form action="manage_rooms_nurses.php" method="POST">

                            <label for="nurseID">Nurse ID:</label><br>
                            <input type="text" id="nurseID" name="nurseID" value=""><br><br>
    
                            <input type="submit" name="delete_nurse" value="DELETE NURSE">
    
                        </form>  -->
                        <?php

                        // if(isset($_POST['delete_nurse'])){
                        //     $nurse_id = $_POST["nurseID"];
                        //     $display_msg_4 = "";

                        //     $st = "SELECT nurse_id,room_id from nurse where nurse_id='$nurse_id'";
                        //     $res = $mysqli->query($st);
                        //     if(!$res->num_rows){
                        //         $display_msg_4 = "Error: This nurse id does not exist!";
                        //     }
                        //     else{
                        //         while($row = $res->fetch_assoc()) {
                        //             if($row["room_id"]){
                        //                 $display_msg_4 = "Error: This nurse is assigned to a room, assign the room first to another available nurse!";
                        //             }
                        //             else{
                        //                 $sql = "DELETE FROM nurse WHERE nurse_id = '$nurse_id'";
                        //                 if(mysqli_query($mysqli, $sql)){
                        //                     $display_msg_4 = "Record deleted successfully!";
                        //                 }
                        //                 else{
                        //                     $display_msg_4 = "Some error occured, please try again later!";
                        //                 }
                        //             }
                        //         }
                        //     }
                        // }
                        
                        ?>
                        
                    </center>
            
        </div>

<?php include('incl/footer.php');?>