<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>

<?php include('incl/header.php');
        ?>
        <div id="myPatientList" class="patientList">

            <div class="patientListHeader">PRESCRIPTIONS</div>

            <br><br>

            <div class="details">
                <center>
                <table>
                    <tr>
                      <th>Prescription id</th>
                      <th>doctor id</th>
                      <th>medicine id</th>
                      <th>quantity</th>
                      <th>price</th>
                      <th></th>
                    </tr>
                <?php
                      
                      require_once "db.php";
                      // Check connection    
           
                       if ($mysqli->connect_error) {
                           die("Connection failed: " . $mysqli->connect_error); 
                       } 

                       $pat_id = $_SESSION["uid"];
                       $display_msg = "";
                       $total = 0;

                       $st ="SELECT p.prescription_id, p.doctor_id, p.medicine_id, p.quantity, m.price 
                       FROM prescription p, medicine m WHERE p.patient_id = '$pat_id' AND p.bought_status = 'N' AND p.medicine_id=m.medicine_id";
                       $res = $mysqli->query($st);
                       if(!$res->num_rows){
                           $display_msg = "No new records found!";
                           echo "<h3>".$display_msg."</h3>";
                       }
                       else{
                           while($row = $res->fetch_assoc()) {?>
                           <tr>
                              <td><?php echo $row["prescription_id"] ?></td>
                              <td><?php echo $row["doctor_id"] ?></td>
                              <td><?php echo $row["medicine_id"] ?></td>
                              <td><?php echo $row["quantity"] ?></td>
                              <td><?php echo $row["price"] ?></td>
                           </tr>
                           <?php
                               $total = $total + ($row["price"] * $row["quantity"]);
                           }
                       }
                       $_SESSION["total"]=$total;
                   ?>

                </center>
                    </table>
            </div>

            <div class="details">

                <center>
                    <form action="payment.php" method='POST'>
                        <label for="total">Total Amount:</label><br>
                        <input type="text" id="total" name="total" value="<?php echo $total ?>" readonly><br><br>
                        <input type="submit" name = "payment_button" value="MAKE PAYMENT">
                    </form>
                </center>

            </div>
            <div class="details">

                <center>
                    <p><?php echo $_SESSION["displaymsg"] ?></p>
                    <button type="button" onclick="location.href = 'view_medicines.php';">CLEAR</button>
                </center>

            </div>
        </div>

<?php include('incl/footer.php');?>