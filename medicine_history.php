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

            <div class="patientListHeader">PRESCRIPTIONS</div>

            <br><br>

            <div class="details">
            <center>
                <table>
                    <tr>
                      <th>Prescription Id</th>
                      <th>Doctor Name</th>
                      <th>Medicine Name</th>
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
                       $pat_id=$_SESSION["uid"];
                       $doc_name="";
                       $med_name="";
                       $quantity="";
                       $price="";
                       $display_msg="";
                       $pres_id="";

                       $sql="SELECT d.doctor_name,m.medicine_name,pr.quantity,m.price,pr.prescription_id from doctor d,prescription pr,medicine m
                       where pr.patient_id='$pat_id' and pr.doctor_id=d.doctor_id and m.medicine_id=pr.medicine_id and pr.bought_status='Y' ORDER BY pr.prescription_id ASC ";
                       $res=$mysqli->query($sql);
                       if(!$res->num_rows){
                        $display_msg = "No new records found!";
                        echo "<h3>".$display_msg."</h3>";
                    }
                    else{
                       while($row=$res->fetch_assoc()){?>
                        <tr>
                        <td><?php echo $row["prescription_id"] ?></td>
                        <td><?php echo $row["doctor_name"] ?></td>
                        <td><?php echo $row["medicine_name"] ?></td>
                        <td><?php echo $row["quantity"] ?></td>
                        <td><?php echo $row["price"] ?></td>
                     </tr>
                     <?php
                       }
                    }?>
                </center>
            </div>
</div>