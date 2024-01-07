<?php
    require_once('dbcon.php');
    
   
        //echo "Connected successfully";
        $studentEmail="";
        $studentPassword="";
        $id_student=0;
        $studentName="";
        $Classement="";
   
 
    if(isset($_POST['email']) && isset($_POST['password']) )
    {
	    $studentEmail=$_POST['email'];
        $studentPassword=$_POST['password'];
        
        login();
	}
	else
	{
	    echo"Illegal Access";
	}
	
	function login()
	{
	    global $conn, $studentEmail,$studentPassword;
	     $json=null;
	    
	    $sql="SELECT * FROM student 
	        WHERE 	email=? AND password=?";
	        
	    $statement = $conn->prepare($sql);
    	$statement->bind_param($studentEmail,$studentPassword);
    	$statement->execute();
    	$result=$statement->get_result();
    	$data=$result->fetch_all(MYSQLI_ASSOC);
    	$statement->close();
    	
    	if($data)
    	{
    	   	$json = json_encode($data);
			echo trim($json,"[]");
    	}
    	else
    	{
    	    echo "no user found";
    	   
    	}
	}
   
?>