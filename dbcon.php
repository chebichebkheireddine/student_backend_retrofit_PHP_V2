<?php
   
    // Create connection
    $coon=mysqli_connect("localhost","root","","student_class");
    
    
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    
?>