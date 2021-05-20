<?php // Script 13.11 - index.php
/* This is the home page for this site. It displays all the students information */

// Include the header:
include('templates/header.html');

// Log in and All Student button.
  print '<h2><a class="login" href="login.php">Log In</a> </h2>';

// Need the database connection:
include('includes/mysqli_connect.php');

$query = 'SELECT id, name, number_grade, start_date, completion_date, DATEDIFF(completion_date, start_date) AS diff_days FROM students ORDER BY id';

// Run the query:
if ($result = mysqli_query($dbc, $query)) {
   echo "<table>";
     echo "<tr>";
	print "<th><b>ID</b></th> 
	       <th><b>Name</b></th> 
	       <th><b>Number<br>Grade</b></th> 
	       <th><b>Letter<br>Grade</b></th>
	       <th><b>Adjusted<br>Grade</b></th>
	       <th><b>Adjusted<br>Letter Grade</b></th>			       
	       <th><b>Start Date</b></th> 
	       <th><b>Completion<br>Date</b></th>
	       <th><b>Number<br>of Days</b></th> ";
     echo "</tr>";
   echo "</table>";  			
	// Retrieve the returned record:
	while ($row = mysqli_fetch_array($result)) {
	
	   
	 // Check the number grade and letter grade.	
	 if (($row['number_grade']>= 90) && ($row['number_grade']<= 100)) {
	      $letter = 'A';	      
	   }  else if (($row['number_grade']>= 80) && ($row['number_grade']<=89)) {
	       $letter = 'B';
	   } else if (($row['number_grade']>= 70) && ($row['number_grade']<=79)) {
	      $letter = 'C';
	   } else if (($row['number_grade']>= 60) && ($row['number_grade']<=69)) {
	       $letter = 'D';
	   } else if (($row['number_grade']>= 0) && ($row['number_grade']<= 59)) {
	       $letter = 'F';
	   } 
	   
	 // Check the adjusted number grade.	 
	 $adjusted_grade = $row['number_grade'] + ($row['number_grade'] * 0.1);
	 if (($row['number_grade']>= 90) && ($row['number_grade']<= 100)) {
	      $letter = 'A';	      
	   }  else if (($row['number_grade']>= 80) && ($row['number_grade']<=89)) {
	       $letter = 'B';
	   } else if (($row['number_grade']>= 70) && ($row['number_grade']<=79)) {
	      $letter = 'C';
	   } else if (($row['number_grade']>= 60) && ($row['number_grade']<=69)) {
	       $letter = 'D';
	   } else if (($row['number_grade']>= 0) && ($row['number_grade']<= 59)) {
	       $letter = 'F';
	   } 	 
 
   	 // Check the adjusted letter grade.
         if ($adjusted_grade >= 90) {
      	 	$a_letter = 'A';
   	   }  else if ($adjusted_grade >= 80 && $adjusted_grade <=89) {
       	 	$a_letter = 'B';
   	   } else if ($adjusted_grade >= 70 && $adjusted_grade <=79) {
      	 	$a_letter = 'C';
   	   } else if ($adjusted_grade >= 60 && $adjusted_grade <=69) {
         	$a_letter = 'D';
   	   } else if ($adjusted_grade >= 0 && $adjusted_grade <= 59) {
       	  	$a_letter = 'F';
   	 } 
   	 
   	  
		       	   	   
	// Print the record:   
	echo "<table>";
	  echo "<tr>";
		print "<td>{$row['id']}</td> 
		       <td>{$row['name']}</td> 
		       <td>{$row['number_grade']}</td> 	
		       <td>$letter</td>
		       <td>$adjusted_grade</td>
	               <td>$a_letter</td>		       
		       <td>{$row['start_date']}</td> 
		       <td>{$row['completion_date']}</td>
		       <td>"; 
		           if ($row['diff_days'] <= 0) {
				print "TBD";
	  		      } else {
				print $row['diff_days'];
         		      }  
                print "</td>";
	  echo "</tr>";
   	echo "</table>";  				
	}
	
// Run the query:
if ($result = mysqli_query($dbc, $query)) {  
   // Retrieve the returned record:
   $total = 0; 	 
   while ($row = mysqli_fetch_array($result)) {
	$total += $row['number_grade']; 
	$rowcount = mysqli_num_rows($result);		 	 	
	}	 		 	
}

$average = $total/$rowcount;
print "<p>The total of students grades are: $total<br>
The number of students are: $rowcount<br>
The average of the students original grades are: $average</p>"; 

// If the admin is logged in, display admin links for this record:
if (is_administrator()) {
	print "<p><b>The Admin is logged in to add, edit, or delete a student information</b> </p>\n";		
   }
} else { // Query didn't run.
	print '<p class="error">Could not retrieve the data because:<br>' . mysqli_error($dbc) . '.</p><p>The query being run was: ' . $query . '</p>';
   } // End of query IF.

mysqli_close($dbc); // Close the connection.


include('templates/footer.html'); // Include the footer.
?>