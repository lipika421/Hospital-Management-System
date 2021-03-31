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
          <a href="doctor_history.php">Doctor History</a>
        </div><br>
        <div class="details">
            <a href="editprofile.php">Edit Profile</a>
</div><br>
        <div class="details">
          <a href="view_medicines.php">Check Medicines</a>
        </div><br>
          <div class="details">
          <a href="medicine_history.php">Medicine History</a>
        </div><br>
</center>
</div>