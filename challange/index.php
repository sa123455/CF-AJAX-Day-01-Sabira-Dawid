<?php
ob_start();
session_start();
require_once 'db_connect.php';

// it will never let you open index(login) page if session is set
if ( isset($_SESSION['user' ])!="" ) {
 header("Location: challange.php");
 exit;
}

$error = false;

if( isset($_POST['btn-login']) ) {

  // prevent sql injections/ clear user invalid inputs
 $email = trim($_POST['email']);
 $email = strip_tags($email);
 $email = htmlspecialchars($email);

 $password = trim($_POST[ 'password']);
 $password = strip_tags($password);
 $password = htmlspecialchars($password);
 // prevent sql injections / clear user invalid inputs

 if(empty($email)){
  $error = true;
  $emailError = "Please enter your email address.";
 } else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
  $error = true;
  $emailError = "Please enter valid email address.";
 }

 if (empty($password)){
  $error = true;
  $passError = "Please enter your password." ;
 }

 // if there's no error, continue to login
 if (!$error) {
 
  $pass = hash( 'sha256', $password); // password hashing

  $res=mysqli_query($conn, "SELECT * FROM user WHERE email='$email'" );
  $row=mysqli_fetch_array($res, MYSQLI_ASSOC);
  $count = mysqli_num_rows($res); // if uname/pass is correct it returns must be 1 row
 
  if( $count == 1 && $row['password' ]==$pass ) {
   $_SESSION['user'] = $row['user_id'];
   header( "Location: challange.php");
  } else {
   $errMSG = "Incorrect Credentials, Try again..." ;
  }
 
 }

}
?>
<!DOCTYPE html>
<html>
<head>
<title>Login & Registration System</title>

<link rel="stylesheet" href ="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"  crossorigin="anonymous">
</head>
<body>
   <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete= "off">
 
   
            <h2>Sign In.</h2>
            <hr />
           
            <?php
  if ( isset($errMSG) ) {
echo  $errMSG; ?>
             
               <?php
  }
  ?>
           
         
           
            <input type="email" name="email" class="form-control" placeholder="Your Email" value="<?php echo $email; ?>"  maxlength="40" />
       
            <span class="text-danger"><?php  echo $emailError; ?></span>
 
         
            <input type="password" name="password"  class="form-control" placeholder="Your Password" maxlength="15"  />
       
           <span class="text-danger"><?php  echo $passError; ?></span>
            <hr />
            <button type="submit" name="btn-login">Sign In</button>
         
         
            <hr />
 
            <a href="register.php">Sign Up Here...</a>
     
         
   </form>
   </div>
</div>
</body>
</html>
<?php ob_end_flush(); ?>