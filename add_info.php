<?php // Script 13.7 - add_info.php
 /* This script adds the student information. */

 // Define a page title and include the header:
 define('TITLE', 'Add Student Information');
 include('templates/header.html');

 print '<h2>Add the Student Information</h2>';

 // Restrict access to administrators only:
 if (!is_administrator()) {
    print '<h2>Access Denied!</h2><p class="error">You do not have permission to access this page.</p>';
    include('templates/footer.html');
    exit();
 }

 // Check for a form submission:
 if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Handle the form.

 if ( !empty($_POST['name']) && !empty($_POST['number_grade']) && !empty($_POST['start_date']) ) {
    // Need the database connection:
    include('includes/mysqli_connect.php');

 // Prepare the values for storing:
 $name = mysqli_real_escape_string($dbc, trim(strip_tags($_POST['name'])));
 $number_grade = mysqli_real_escape_string($dbc, trim(strip_tags($_POST['number_grade'])));
 $start_date = mysqli_real_escape_string($dbc, trim(strip_tags($_POST['start_date'])));
 $completion_date = mysqli_real_escape_string($dbc, trim(strip_tags($_POST['completion_date'])));

 $query = "INSERT INTO students (name, number_grade, start_date, completion_date ) VALUES ('$name', '$number_grade', '$start_date', '$completion_date')";
 mysqli_query($dbc, $query);

 if (mysqli_affected_rows($dbc) == 1){
    // Print a message:
    print '<p>The entered information for a student has been stored.</p>';
 } else {
    print '<p class="error">Could not store the student information because:<br>' . mysqli_error($dbc) . '.</p><p>The query being run was: ' . $query . '</p>';
 }

 // Close the connection:
 mysqli_close($dbc);

 } else { // Failed to enter a quotation.
 print '<p class="error">Please enter the student information!</p>';
 }

 } // End of submitted IF.
 // Leave PHP and display the form:
 ?>

 <form action="add_info.php" method="post">
    <p><label>Name		<input type="text" name="name" required></label></p>
    <p><label>Number Grade	<input type="number" name="number_grade" min="0" max="100" required></label></p>
    <p><label>Start Date	<input type="date" name="start_date" required></label></p>
    <p><label>Completion Date	<input type="date" name="completion_date"></label></p>    
    <p><input type="submit" name="submit" value="Submit"></p>
 </form>

 <?php include('templates/footer.html'); ?>