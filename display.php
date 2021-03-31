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

            <div class="patientListHeader">DETAILS</div>

            <br><br>

            
            <?php
                      require_once "db.php";
                      // Check connection    
           
                       if ($mysqli->connect_error) {
                           die("Connection failed: " . $mysqli->connect_error); 
                       } ?>
                <?php
                
                if(isset($_POST['patient_button'])){?>
                    
                        <table>
                            <tr>
                            <th>Patient ID</th>
                            <th>Patient Name</th>
                            <th>House Number</th>
                            <th>Street</th>
                            <th>State</th>
                            <th>Pin Code</th>
                            <th>Gender</th>
                            <th>Age</th>
                            <th>Mail ID</th>
                            <th>Mobile No</th>
                            <th>Balance</th>
                            <th></th>
                            </tr>
                   <?php

                       $display_msg = "";
                       $phone = "";
                       
                       $sql="SELECT patient_id, patient_name, house_no, street_name, state_name, pin_code, gender, age, mail, wallet from patient";
                       $res=$mysqli->query($sql);
                       if(!$res->num_rows){
                        $display_msg = "No records found!";
                        echo "<h3>".$display_msg."</h3>";
                    }
                    else{
                       while($row=$res->fetch_assoc()){
                        $sql_1="SELECT phone_no from phone where patient_id = '$row[patient_id]'";
                        $res_1=$mysqli->query($sql_1);
                        $row_1 = $res_1->fetch_assoc();
                        if(!$res_1->num_rows){
                            $display_msg = "No records found!";
                        }else{
                        $phone = $row_1["phone_no"];
                        ?>
                        <tr>
                        <td><?php echo $row["patient_id"] ?></td>
                        <td><?php echo $row["patient_name"] ?></td>
                        <td><?php echo $row["house_no"] ?></td>
                        <td><?php echo $row["street_name"] ?></td>
                        <td><?php echo $row["state_name"] ?></td>
                        <td><?php echo $row["pin_code"] ?></td>
                        <td><?php echo $row["gender"] ?></td>
                        <td><?php echo $row["age"] ?></td>
                        <td><?php echo $row["mail"] ?></td>
                        <td><?php echo $phone ?></td>
                        <td><?php echo $row["wallet"] ?></td>
                     </tr>
                     <?php
                       }
                    }
                    echo "<h3>".$display_msg."</h3>";

                    }?>
                    </table>
                

                <?php } ?>
                
                <?php
                if(isset($_POST['doctor_button'])){?>
                    <center>
                        <table>
                            <tr>
                            <th>Doctor ID</th>
                            <th>Doctor Name</th>
                            <th>Department code</th>
                            <th>Highest degree</th>
                            <th></th>
                            </tr>
                        <?php
                            $sql="SELECT doctor_id, doctor_name, department_code, highest_degree from doctor";
                            $res=$mysqli->query($sql);
                            if(!$res->num_rows){
                                $display_msg = "No records found!";
                                echo "<h3>".$display_msg."</h3>";
                            }
                            else{
                                while($row=$res->fetch_assoc()){ ?>
                                 <tr>
                                 <td><?php echo $row["doctor_id"] ?></td>
                                 <td><?php echo $row["doctor_name"] ?></td>
                                 <td><?php echo $row["department_code"] ?></td>
                                 <td><?php echo $row["highest_degree"] ?></td>
                              </tr>
                              <?php
                                }
                             }?>
                                                 </table>

                         </center>
         
                         <?php } ?>


                <?php

                if(isset($_POST['departments_button'])){?>
                    <center>
                        <table>
                            <tr>
                            <th>Department ID</th>
                            <th>Department Name</th>
                            <th>HOD ID</th>
                            <th></th>
                            </tr>
                        <?php
                            $sql="SELECT department_code, department_name, hod_id from department";
                            $res=$mysqli->query($sql);
                            if(!$res->num_rows){
                                $display_msg = "No records found!";
                                echo "<h3>".$display_msg."</h3>";
                            }
                            else{
                                while($row=$res->fetch_assoc()){ ?>
                                 <tr>
                                 <td><?php echo $row["department_code"] ?></td>
                                 <td><?php echo $row["department_name"] ?></td>
                                 <td><?php echo $row["hod_id"] ?></td>
                              </tr>
                              <?php
                                }
                             }?>
                                                 </table>

                         </center>
         
                         <?php } ?>

                <?php

                if(isset($_POST['med_button'])){?>
                    <center>
                        <table>
                            <tr>
                            <th>Medicine ID</th>
                            <th>Medicine Name</th>
                            <th>Price</th>
                            <th></th>
                            </tr>
                        <?php
                            $sql="SELECT medicine_id, medicine_name, price from medicine";
                            $res=$mysqli->query($sql);
                            if(!$res->num_rows){
                                $display_msg = "No records found!";
                                echo "<h3>".$display_msg."</h3>";
                            }
                            else{
                                while($row=$res->fetch_assoc()){ ?>
                                 <tr>
                                 <td><?php echo $row["medicine_id"] ?></td>
                                 <td><?php echo $row["medicine_name"] ?></td>
                                 <td><?php echo $row["price"] ?></td>
                              </tr>
                              <?php
                                }
                             }?>
                                                 </table>

                         </center>
         
                         <?php } ?>

                <?php

                if(isset($_POST['prescription_button'])){?>
                    <center>
                    <table>
                        <tr>
                        <th>Prescription ID</th>
                        <th>Patient ID</th>
                        <th>Doctor ID</th>
                        <th>Medicine ID</th>
                        <th>Quantity</th>
                        <th>Status</th>
                        <th></th>
                        </tr>
                        <?php
                        $sql="SELECT prescription_id, patient_id, doctor_id, medicine_id, quantity, bought_status from prescription";
                        $res=$mysqli->query($sql);
                        if(!$res->num_rows){
                            $display_msg = "No records found!";
                            echo "<h3>".$display_msg."</h3>";
                        }
                        else{
                            while($row=$res->fetch_assoc()){ ?>
                             <tr>
                             <td><?php echo $row["prescription_id"] ?></td>
                             <td><?php echo $row["patient_id"] ?></td>
                             <td><?php echo $row["doctor_id"] ?></td>
                             <td><?php echo $row["medicine_id"] ?></td>
                             <td><?php echo $row["quantity"] ?></td>
                             <td><?php echo $row["bought_status"] ?></td>
                          </tr>
                          <?php
                            }
                         }?>
                                             </table>

                     </center>
     
                     <?php } ?>

            <?php

                if(isset($_POST['payments_button'])){?>
                    <center>
                        <table>
                        <tr>
                        <th>Payment ID</th>
                        <th>Patient ID</th>
                        <th>Amount</th>
                        <th></th>
                        </tr>
                        <?php
                        $sql="SELECT payment_id, patient_id, amount from payment";
                        $res=$mysqli->query($sql);
                        if(!$res->num_rows){
                            $display_msg = "No records found!";
                            echo "<h3>".$display_msg."</h3>";
                        }
                        else{
                            while($row=$res->fetch_assoc()){ ?>
                             <tr>
                             <td><?php echo $row["payment_id"] ?></td>
                             <td><?php echo $row["patient_id"] ?></td>
                             <td><?php echo $row["amount"] ?></td>
                          </tr>
                          <?php
                            }
                         }?>
                                             </table>

                     </center>
     
                     <?php } ?>

            <?php

                if(isset($_POST['rooms_button'])){?>
                    
                    <center>
                    <table>
                    <tr>
                    <th>Room ID</th>
                    <th>Nurse ID</th>
                    <th>Total Beds</th>
                    <th>Beds Occupied</th>
                    <th></th>
                    </tr>
                    <?php
                    $sql="SELECT room_id, nurse_id, no_of_beds, beds_occupied from room";
                    $res=$mysqli->query($sql);
                    if(!$res->num_rows){
                        $display_msg = "No records found!";
                        echo "<h3>".$display_msg."</h3>";
                    }
                    else{
                        while($row=$res->fetch_assoc()){ ?>
                         <tr>
                         <td><?php echo $row["room_id"] ?></td>
                         <td><?php echo $row["nurse_id"] ?></td>
                         <td><?php echo $row["no_of_beds"] ?></td>
                         <td><?php echo $row["beds_occupied"] ?></td>
                      </tr>
                      <?php
                        }
                     }?>
                                         </table>

                 </center>
 
                 <?php } ?>

        <?php

                if(isset($_POST['nurse_button'])){?>
                    <center>
                    <table>
                    <tr>
                    <th>Nurse ID</th>
                    <th>Nurse Name</th>
                    <th>Room ID</th>
                    <th></th>
                </tr>
                    <?php
                    $sql="SELECT nurse_id, nurse_name, room_id from nurse";
                    $res=$mysqli->query($sql);
                    if(!$res->num_rows){
                        $display_msg = "No records found!";
                        echo "<h3>".$display_msg."</h3>";
                    }
                    else{
                        while($row=$res->fetch_assoc()){ ?>
                         <tr>
                         <td><?php echo $row["nurse_id"] ?></td>
                         <td><?php echo $row["nurse_name"] ?></td>
                         <td><?php echo $row["room_id"] ?></td>
                      </tr>
                      <?php
                        }
                     }?>
                                         </table>

                 </center>
 
                 <?php } ?>

        <?php

                if(isset($_POST['assign_button'])){?>
                    <center>
                    <table>
                    <tr>
                    <th>Patient ID</th>
                    <th>Doctor ID</th>
                    <th>Date of Assign</th>
                    <th>Date of Release</th>
                    <th></th>
                    </tr>
                    <?php
                    $sql="SELECT patient_id, doctor_id, date_of_assign, date_of_release from assign";
                    $res=$mysqli->query($sql);
                    if(!$res->num_rows){
                        $display_msg = "No records found!";
                        echo "<h3>".$display_msg."</h3>";
                    }
                    else{
                        while($row=$res->fetch_assoc()){ ?>
                         <tr>
                         <td><?php echo $row["patient_id"] ?></td>
                         <td><?php echo $row["doctor_id"] ?></td>
                         <td><?php echo $row["date_of_assign"] ?></td>
                         <td><?php echo $row["date_of_release"] ?></td>
                      </tr>
                      <?php
                        }
                     }?>
                                         </table>

                 </center>
 
                 <?php } ?>

        <?php

                if(isset($_POST['admit_button'])){?>
                    <center>
                    <table>
                    <tr>
                    <th>Patient ID</th>
                    <th>Room ID</th>
                    <th>Date of Admit</th>
                    <th>Date of Release</th>
                    <th></th>
                    </tr>
                    <?php
                    $sql="SELECT patient_id, room_id, date_of_admit, date_of_release from admit";
                    $res=$mysqli->query($sql);
                    if(!$res->num_rows){
                        $display_msg = "No records found!";
                        echo "<h3>".$display_msg."</h3>";
                    }
                    else{
                        while($row=$res->fetch_assoc()){ ?>
                         <tr>
                         <td><?php echo $row["patient_id"] ?></td>
                         <td><?php echo $row["room_id"] ?></td>
                         <td><?php echo $row["date_of_admit"] ?></td>
                         <td><?php echo $row["date_of_release"] ?></td>
                      </tr>
                      <?php
                        }
                     }?>
                                                              </table>

                 </center>
 
                 <?php } ?>

            
                    </div>
<?php include('incl/footer.php');?>