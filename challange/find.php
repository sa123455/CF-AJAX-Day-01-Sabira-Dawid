<?php
include_once 'db_connect.php';
//take value from input
$search=$_POST["email"];


$sql = "SELECT * FROM user WHERE `email` =  '$search'";
$result = mysqli_query($conn,$sql);
if($result->num_rows == 0) {
echo "<button type='submit' class='btn btn-block btn-primary' name='btn-signup'>Sign Up</button>";
}elseif ($result->num_rows == 1) {
    $row=$result->fetch_assoc();
    #echo $row["email"];
    
    echo "email exists";
    
}


?>