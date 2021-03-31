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

        <?php 

            require_once "db.php";
            // Check connection    

            if ($mysqli->connect_error) {
                die("Connection failed: " . $mysqli->connect_error); 
            } 

            $amount = 0;
            $display_msg = "";
            $balance = 0;
            $payment_id = 0;
            $pat_id=$_SESSION["uid"];

            $amount = $_SESSION["total"];

            $st = "SELECT wallet
                    FROM patient WHERE patient_id = '$_SESSION[uid]'";
            $res = $mysqli->query($st);
            if(!$res->num_rows){
                $display_msg = "Some error occured, please try again later!";
            }
            else{
                $row = $res->fetch_assoc();
                $balance = $row["wallet"];
            }

            $st = "SELECT count(*) as cur_count
                    FROM payment";
            $res = $mysqli->query($st);
            if(!$res->num_rows){
                $display_msg = "Seems like count did not work!";
            }
            else{
                $row = $res->fetch_assoc();
                $payment_id = $row["cur_count"]+1;
            }
        
        ?>


        <div id="mypatientHeader" class="patientList">
            <div class="patientListHeader"><b>Payment</b></div>
            <br><br>
            
            <div class="details">
                <form action="payment.php" method="POST">
                    <label for="paymentID"><b>Payment ID: </b></label><br>
                    <input type="text" name="paymentID" id="paymentID" value="<?php echo $payment_id ?>" readonly><br><br>
                
                    <label for="patientID"><b>Patient ID:</b></label><br>
                    <input type="text" name="patientID" id = "patientID" value = "<?php echo $_SESSION["uid"] ?>" readonly><br><br>

                    <label for="amount"><b>Amount:</b></label><br>
                    <input type="text" name="amount" id = "amount" value = "<?php echo $amount ?>" readonly><br><br>

                    <label for="balance"><b>Available balance:</b></label><br>
                    <input type="text" name="balance" id = "balance" value = "<?php echo $balance ?>" readonly><br><br>

                    <input type="submit" name = "make_payment" id="make_payment" value="MAKE PAYMENT">
                    
                </form>

                <?php 
                
                if(isset($_POST["make_payment"])){
                    $display_msg="entered";
                    if($balance < $amount){
                        $display_msg = "There is no enough balance in the wallet, please try again later!";
                    }
                    else{
                        $st = "SELECT payment_id FROM payment WHERE payment_id = '$payment_id'";
                        $res = $mysqli->query($st);
                        if($res->num_rows){
                            $display_msg = "This payment id already exists!";
                        }
                        else{
                            $sql = "INSERT INTO payment (payment_id, patient_id, amount)
                                    VALUES ('$payment_id', '$pat_id', '$amount')";
                    
                            if(mysqli_query($mysqli, $sql)){
                                $display_msg = "Payment successful-1!";

                            }
                            else{
                                $display_msg = "Some error occured-1!";
                            }

                            $sql = "UPDATE patient SET wallet = wallet - '$amount' WHERE patient_id = '$pat_id'";
                            if(mysqli_query($mysqli, $sql)){
                                $display_msg = "Payment successful-2!";
                            }
                            else{
                                $display_msg = "Some error occured-2!";
                            }

                            $sql = "UPDATE prescription SET bought_status = 'Y' WHERE patient_id = '$pat_id'";
                            if(mysqli_query($mysqli, $sql)){
                                $display_msg = "Payment successful!";
                                $_SESSION["displaymsg"]=$display_msg;
                                header("location:view_medicines.php");
                                exit;
                            }
                            else{
                                $display_msg = "Some error occured-3!";
                            }

                        }
                    }

                }
                
                ?>
            </div>   

            <div class="details">

                <center>
                    <p><?php echo $display_msg ?></p>
                    <button type="button" onclick="location.href = 'payment.php';">CLEAR</button>
                </center>

            </div>

        </div>    


<?php include('incl/footer.php');?>