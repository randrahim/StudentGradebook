<!doctype html>
 <html lang="en">
 <head>
 <meta charset="utf-8">
 <title>Create a Table</title>
 </head>
 <body>
 <?php // Script 12.3 - create_table.php
 /* This script connects to the MySQL server, selects the database, and creates a table. */

 // Connect and select:
 if ($dbc = @mysqli_connect('localhost', 'ranrah5_wp', 'Ranooda_83', 'ranrah5_wp')) {

 // Define the query:
         			
$query = 'CREATE TABLE students ( id INT UNSIGNED NOT NULL AUTO_INCREMENT,
				  name TEXT NOT NULL,
				  number_grade INT NOT NULL,				
				  start_date TIMESTAMP NOT NULL ,				 
				  completion_date TIMESTAMP NULL ,
				PRIMARY KEY (id) ) 
				CHARACTER SET utf8';

 // Execute the query:
 if (@mysqli_query($dbc, $query)) {
    print '<p>The table has been created!</p>';
 } else {
    print '<p style="color: red;">Could not create the table because:<br>' . mysqli_error($dbc) . '.</p>
    <p>The query being run was: ' . $query. '</p>';
 }

 mysqli_close($dbc); // Close theconnection.

 } else { // Connection failure.
    print '<p style="color: red;">Could not connect to the database:<br>' .mysqli_connect_error() . '.</p>';
 }
 ?>
 </body>
 </html>