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

        <center>
            <h3>TREATMENT</h3>
            <button type="button" onclick="location.href = 'assign_admit_discharge_patient.php';">ASSIGN / ADMIT / DISCHARGE PATIENT</button> 
            
            <h3>MANAGE DOCTORS</h3>
            <button type="button" onclick="location.href = 'managedoctors.php';">MANAGE DOCTORS</button>

            <h3>MANAGE PATIENTS</h3>
            <button type="button" onclick="location.href = 'managepatients.php';">MANAGE PATIENTS</button> <!-- wallet can get created/deleted, but cannot be edited -->
            
            <h3>MANAGE ROOMS AND NURSES</h3>
            <button type="button" onclick="location.href = 'manage_rooms_nurses.php';">MANAGE ROOMS AND NURSES</button>

            <h3>MANAGE MEDICINES</h3>
            <button type="button" onclick="location.href = 'managemedicines.php';">MANAGE MEDICINES</button>

            <h3>MANAGE DEPARTMENTS</h3>
            <button type="button" onclick="location.href = 'managedepartments.php';">MANAGE DEPARTMENTS</button>

            <h3>VIEW DETAILS</h3>
            <form action="display.php" method="POST">
                <input type="submit" name="prescription_button" value="VIEW PRESCRIPTIONS">
                <input type="submit" name="payments_button" value="VIEW PAYMENTS">
                <input type="submit" name="doctor_button" value="VIEW DOCTORS">
                <input type="submit" name="departments_button" value="VIEW DEPARTMENTS">
                <br>
                <input type="submit" name="med_button" value="VIEW MEDICINES">
                <input type="submit" name="patient_button" value="VIEW PATIENT">
                <input type="submit" name="rooms_button" value="VIEW ROOMS">
                <input type="submit" name="nurse_button" value="VIEW NURSES">
                <br>
                <input type="submit" name="assign_button" value="VIEW DOCOTR ASSIGNMETS">
                <input type="submit" name="admit_button" value="VIEW PATIENT ADMISSIONS">
            </form> 

        </center>

<?php include('incl/footer.php');?>