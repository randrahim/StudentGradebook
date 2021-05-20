<?php // Script 13.9 - edit_info.php
 /* This script edits a student informtion. */

 // Define a page title and include the header:
 define('TITLE', 'Edit a Student Informtion');
 include('templates/header.html');
 print '<h2>Edit a Student Informtion</h2>';

 // Restrict access to administrators only:
 if (!is_administrator()) {
      print '<h2>Access Denied!</h2><p class="error">You do not have permission to access this page.</p>';
      include('templates/footer.html');
      exit();
 }

 // Need the database connection:
 include('includes/mysqli_connect.php');

 if (isset($_GET['id']) && is_numeric($_GET['id']) && ($_GET['id'] > 0) ) { // Display the entry in a form:
      // Define the query.
      $query = "SELECT id, name, number_grade, start_date, completion_date FROM students WHERE id={$_GET['id']}";
 if ($result = mysqli_query($dbc, $query)) { // Run the query.
      $row = mysqli_fetch_array($result); // Retrieve the information.

      // Make the form:
      print '<form action="edit_info.php" method="post">
      	    <p><label>Name<input type="text" name="name" value="' .htmlentities($row['name']) . '"></label></p>
            <p><label>Number grade<input type="number" name="number_grade" min="0" max="100" size="20" value="' .htmlentities($row['number_grade']) . '"></label></p>
            <p><label>Start Date<input type="date" name="start_date" value="' .htmlentities($row['start_date']) . '"></label></p>
            <p><label>Completion Date<input type="date" name="completion_date" value="' .htmlentities($row['completion_date']) . '"></label></p>

            <input type="hidden" name="id" value="' . $_GET['id'] . '">
            <p><input type="submit" name="submit" value="Update The Student Information!"></p>
         </form>';
} else { // Couldn't get the information.
     print '<p class="error">Could not retrieve the student information because:<br>' . mysqli_error($dbc) . '.</p><p>The query being run was: ' . $query . '</p>';
   }
    
   } elseif (isset($_POST['id']) && is_numeric($_POST['id']) && ($_POST['id'] > 0)) { // Handle     the form.    
      // Validate and secure the form data:
      $problem = FALSE;

if ( !empty($_POST['name']) && !empty($_POST['number_grade']) ) {
    
     // Prepare the values for storing:     
     $name = mysqli_real_escape_string($dbc, trim(strip_tags($_POST['name'])));
     $number_grade = mysqli_real_escape_string($dbc, trim(strip_tags($_POST['number_grade'])));
     $start_date = mysqli_real_escape_string($dbc, trim(strip_tags($_POST['start_date'])));
     $completion_date = mysqli_real_escape_string($dbc, trim(strip_tags($_POST['completion_date'])));
    
     
     } else {
         print '<p class="error">Please submit both a name, a number grade, and the start date.</p>';
         $problem = TRUE;
     }
    
     if (!$problem) {
    
     // Define the query.
     $query = "UPDATE students SET      		
     		name ='$name', 
     		number_grade ='$number_grade', 
     		start_date ='$start_date', 
     		completion_date ='$completion_date' 
     		WHERE id ={$_POST['id']}";
     		
     if ($result = mysqli_query($dbc, $query)) {
         print '<p>The student information has been updated.</p>';
     } else {
         print '<p class="error">Could not update the student information because:<br>' . mysqli_error($dbc) . '.</p><p>The query being run was: ' . $query . '</p>';
     }
    
     } // No problem!
    
     } else { // No ID set.
         print '<p class="error">This page has been accessed in error.</p>';
     } // End of main IF.
    
     mysqli_close($dbc); // Close the connection.
    
     include('templates/footer.html'); // Include the footer.
     ?>