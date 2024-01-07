<?php
    //echo "Welcome to Dr. Ferddie's website.";
    
    $myObj->fullname = "ferddie quiroz canlas";
    $myObj->userid = 1;
    $myObj->email = "ferddie@gmail.com";
    
    $myJSON = json_encode($myObj);
    
    echo $myJSON;
?>