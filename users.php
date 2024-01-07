<?php
    require_once('dbcon.php');

    $id_student=0;
    $studentName="";
    $studentEmail="";
    $Classement="";

    if(isset($_POST['add']))
    {
        //echo "ADD";
        $studentName = $_POST['studentName'];
        $studentEmail = $_POST['email'];
        $Classement = $_POST['Classement'];
        addUser();
    }
    elseif(isset($_POST['update']))
    {
        $id_student = $_POST['id_student'];
        $studentName = $_POST['studentName'];
        $studentEmail = $_POST['studentEmail'];
        $Classement = $_POST['Classement'];
        updateUser();

    }
    elseif(isset($_POST['updatepassword']))
    {
        $id_student = $_POST['id_student'];
        $password = $_POST['password'];
    
        updatePassword($password);

    }
    elseif(isset($_POST['delete']))
    {
        $id_student = $_POST['id_student'];
        deleteUser($id_student);
    }
    elseif(isset($_POST['search']))
    {
        $search = $_POST['search'];
        searchUser($search);
    }
    elseif(isset($_POST['showall']))
    {
        showstudent();
    }


    function addUser()
    {
       global $conn,$studentName,$studentEmail,$Classement;

       $sql = "INSERT INTO student (studentName,email, Classement)
        VALUES (?,?,?)";
        $statement = $conn->prepare($sql);
        $statement->bind_param("sss", $studentName,$studentEmail,$Classement);
      
        if($statement->execute())
        {
            echo "User successfully added!";
        }
        else
        {
            $error=$conn->connect_error;
            echo "$error";
        }
        $statement->close();
    }


    function updateUser()
    {
        global $conn,$id_student,$studentName,$studentEmail,$Classement;
        
        $sql = "UPDATE student SET studentName=?, email=?, Classement=?  
        WHERE id_student=?";
        $statement = $conn->prepare($sql);
        $statement->bind_param("sssi", $studentName,$studentEmail,$Classement,$id_student);
      
        if($statement->execute())
        {
            echo "User successfully updated!";
        }
        else
        {
            $error=$conn->connect_error;
            echo "$error";
        }
        $statement->close();
    }
    
    function updatePassword($password)
    {
        global $conn,$id_student;
        
        $sql = "UPDATE student SET password=?  
        WHERE id_student=?";
        $statement = $conn->prepare($sql);
        $statement->bind_param("si", $password,$id_student);
      
        if($statement->execute())
        {
            echo "User password successfully updated!";
        }
        else
        {
            $error=$conn->connect_error;
            echo "$error";
        }
        $statement->close();
    }


    function  deleteUser($id_student)
    {
        global $conn;

        $sql = "DELETE FROM student WHERE id_student=?";
        $statement = $conn->prepare($sql);
        $statement->bind_param("i",$id_student);
      
        if($statement->execute())
        {
            echo "User successfully deleted!";
        }
        else
        {
            $error=$conn->connect_error;
            echo "$error";
        }
        $statement->close();

    }

    function searchUser($search)
    {
        global $conn;
        $id_student=$search;
        $search = "%$search%";
        $json=null;
       
        $sql="SELECT * FROM student 
           WHERE studentName LIKE ? OR email LIKE ? OR id_student=?";
           
        $statement = $conn->prepare($sql);
        $statement->bind_param("ssi", $search,$search,$id_student);
        //$statement->bind_param("s", $studentName);
        $statement->execute();
        $result=$statement->get_result();
        $data=$result->fetch_all(MYSQLI_ASSOC);
        $statement->close();
       
       if($data)
       {
            $json = json_encode($data);
            echo $json;
       }
       else
       {
            echo "No user found";
       }
    }

    function showstudent()
    {
        global $conn, $id_student, $studentName,$studentEmail;

        $studentName = "%$studentName%";
        $studentEmail = "%$studentEmail%";
        
        $json=null;
       
        $sql="SELECT * FROM student 
           ORDER BY id_student ASC";
           
        $result=$conn->query($sql);
        $data=$result->fetch_all(MYSQLI_ASSOC);      
       
       if($data)
       {
            $json = json_encode($data);
            echo $json;
            //echo trim($json,"[]");
       }
       else
       {
            echo "No student found.";
          
       }
    }

    function  validateEntries($studentName,$studentEmail)
    {
        if($studentName=="" || $studentEmail=="" )
        {
            return false;
        }
        else
        {
            return true;     
        }

    }


?>