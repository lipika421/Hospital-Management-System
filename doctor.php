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

            <div class="patientListHeader">PATIENTS LIST</div>

            <br><br>

            <div class="Listtable">
                <table>
                    <tr>
                      <th>Patient ID</th>
                      <th>Patient Name</th>
                      <th>Date of Assign</th>
                      <th></th>
                    </tr>
                    <?php 
                     require_once "db.php";
                     // Check connection    
                     
                     if ($mysqli->connect_error) {
                         die("Connection failed: " . $mysqli->connect_error); 
                     
                     }
                    $doc_id=$_SESSION["uid"];
                    $pat_id="";
                    $pat_name="";
                    $date_assign="";
                    
                    $sql="SELECT p.patient_id,p.patient_name,a.date_of_assign from patient p,assign a where a.doctor_id='$doc_id' and p.patient_id=a.patient_id and a.date_of_release is NULL";
                    $res=$mysqli->query($sql);
                    while($row=$res->fetch_assoc()){
                        $pat_id=$row["patient_id"];
                        $pat_name=$row["patient_name"];
                        $date_assign=$row["date_of_assign"];
                        ?>
                            <!-- example table rows -->

                        <tr>
                        <td><?php echo $pat_id ?></td>
                        <td><?php echo $pat_name ?></td>
                        <td><?php echo $date_assign ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                    
                  </table>
                  <?php
                    if($_SERVER["REQUEST_METHOD"] == "POST"){
                        $_SESSION["pat_id"]=$_POST["patientID"];
                      header("location:doc_patient_details.php");
                      exit;
                  }
                   ?>
                  <div class="details">
                      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" >
                      <label for="patientID">Patient Id:</label>
                      <input type="text" name="patientID" id="patientID" placeholder="ID" required></input>
                      <input type="submit" value="check"></input>
                    </form>
                </div>
            </div>
            
        </div>
