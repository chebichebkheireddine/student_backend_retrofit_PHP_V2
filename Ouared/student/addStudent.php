<?php
include "../connect.php";

$first_name = filterRequest("first_name");
$last_name = filterRequest("last_name");
$date_of_birth = filterRequest("date_of_birth");
$email = filterRequest("email");
$phone_number = filterRequest("phone_number");

$data = array(
    "first_name" => $first_name,
    "last_name" => $last_name,
    "date_of_birth" => $date_of_birth,
    "email" => $email,
    "phone_number" => $phone_number
);

 // Assuming your table name is 'student', you can replace it with your actual table name.
insertData("student", $data, $json = false);

?>
