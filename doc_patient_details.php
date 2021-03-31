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
    $pat_id=$_SESSION["pat_id"];
    $pat_name="";
    $gender="";
    $age="";
    $email="";
    $sql="SELECT * FROM patient where patient_id='$pat_id'";
    $res=$mysqli->query($sql);
    $row=$res->fetch_assoc();
    $age=$row["age"];
    $email=$row["mail"];
    $gender=$row["gender"];
    $pat_name=$row["patient_name"];
    ?>

<div id="myPatientList" class="patientList">

            <div class="patientListHeader">PATIENT DETAILS</div>

            <br><br>

            <div class="details">

                <p>Patient ID:<?php echo $pat_id ?></p>
    
                <p>Patient Name:<?php echo $pat_name ?></p>
    
                <p>Gender:<?php echo $gender ?> </p>
    
                <p>Age:<?php echo $age ?> </p>

                <p>email:<?php echo $email ?> </p>

                <br>

                <button type="button" onclick="location.href = 'add_prescription.php';" >ADD PRESCRIPTION</button>

            </div>
            
        </div>
