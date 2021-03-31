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

            <div class="patientListHeader">Patient</div>

            <br><br>
        <center>
            <div class="details">
            <h3>History:</h3>

            <table>
                    <tr>
                      <th>Doctor Name</th>
                      <th>Doctor Id</th>
                      <th>Contact Details</th>
                      <th>Date of Assigning</th>
                      <th>Date of Release</th>
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
                       $doc_id="";
                       $email="";
                       $date_assign="";
                       $date_release="";
                       $display_msg="";

                    
                       $sql="SELECT d.doctor_name,d.doctor_id,d.mail,a.date_of_assign,a.date_of_release from doctor d,assign a
                       where a.patient_id='$pat_id' and a.doctor_id=d.doctor_id  ORDER BY a.date_of_assign DESC ";
                       $res=$mysqli->query($sql);
                       if(!$res->num_rows){
                        $display_msg = "No new records found!";
                        echo "<h3>".$display_msg."</h3>";
                    }
                    else{
                       while($row=$res->fetch_assoc()){?>
                        <tr>
                        <td><?php echo $row["doctor_name"] ?></td>
                        <td><?php echo $row["doctor_id"] ?></td>
                        <td><?php echo $row["mail"] ?></td>
                        <td><?php echo $row["date_of_assign"] ?></td>
                        <td><?php echo $row["date_of_release"] ?></td>
                     </tr>
                     <?php
                       }
                    }?>
                </center>
            </div>
</div>
