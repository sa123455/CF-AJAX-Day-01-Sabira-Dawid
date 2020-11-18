<?php
ob_start();
session_start(); // start a new session or continues the previous
if( isset($_SESSION['user'])!="" ){
 header("Location: index.php" ); // redirects to home.php
}
include_once 'db_connect.php';
$error = false;
if ( isset($_POST['btn-signup']) ) {
 
 // sanitize user input to prevent sql injection
 $user_name = trim($_POST['user_name']);

  //trim - strips whitespace (or other characters) from the beginning and end of a string
  $user_name = strip_tags($user_name);

  // strip_tags — strips HTML and PHP tags from a string

  $user_name = htmlspecialchars($user_name);
 // htmlspecialchars converts special characters to HTML entities
 $email = trim($_POST[ 'email']);
 $email = strip_tags($email);
 $email = htmlspecialchars($email);

 $password = trim($_POST['password']);
 $password = strip_tags($password);
 $password = htmlspecialchars($password);

  // basic name validation
 if (empty($user_name)) {
  $error = true ;
  $nameError = "Please enter your full name.";
 } else if (strlen($user_name) < 3) {
  $error = true;
  $nameError = "Name must have at least 3 characters.";
 } else if (!preg_match("/^[a-zA-Z ]+$/",$user_name)) {
  $error = true ;
  $nameError = "Name must contain alphabets and space.";
 }

 //basic email validation
  if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
  $error = true;
  $emailError = "Please enter valid email address." ;
 } else {
  // checks whether the email exists or not
  $query = "SELECT email FROM user WHERE email='$email'";
  $result = mysqli_query($conn, $query);
  $count = mysqli_num_rows($result);
  if($count!=0){
   $error = true;
   $emailError = "Provided Email is already in use.";
  }
 }
 // password validation
  if (empty($password)){
  $error = true;
  $passError = "Please enter password.";
 } else if(strlen($password) < 6) {
  $error = true;
  $passError = "Password must have atleast 6 characters." ;
 }

 // password hashing for security
$pass = hash('sha256' , $password);


 // if there's no error, continue to signup
 if( !$error ) {
 
  $query = "INSERT INTO user(user_name,email,password) VALUES('$user_name','$email','$pass')";
  $res = mysqli_query($conn, $query);
 
  if ($res) {
   $errTyp = "success";
   $errMSG = "Successfully registered, you may login now";
   unset($user_name);
    unset($email);
   unset($pass);
  } else  {
   $errTyp = "danger";
   $errMSG = "Something went wrong, try again later..." ;
  }
 
 }


}
?>
<!DOCTYPE html>
<html>
<head>
<title>Login & Registration System</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet"  href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"  integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"  crossorigin="anonymous">
</head>
<body>
   <form method="post" id="form"  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"  autocomplete="off" >
 
     
            <h2>Sign Up.</h2>
            <hr />
         
            <?php
   if ( isset($errMSG) ) {
 
   ?>
           <div class="alert alert-<?php echo $errTyp ?>" >
                         <?php echo $errMSG; ?>
       </div>

<?php
  }
  ?>
         
     
         

            <input type ="text"  name="user_name"  class="form-control"  placeholder="Enter Name" maxlength="50" value="<?php echo $user_name ?>"  />
     
               <span class="text-danger"> <?php echo $nameError; ?> </span>
         
   

            <input type="email" name="email" class="form-control" id="mail" placeholder="Enter Your Email" maxlength="40" value ="<?php echo $email ?>"  />
   
               <span  class="text-danger"> <?php echo $emailError; ?> </span>
     
         
     
           
       
            <input type="password" name="password" class="form-control" placeholder="Enter Password" maxlength="15"  />
           
               <span class="text-danger"> <?php echo $passError; ?> </span>
     
            <hr />

            <p id="output"></p>
           <!--  <button type="submit" class="btn btn-block btn-primary" name="btn-signup">Sign Up</button> -->
            <hr  />
         
            <a href="index.php">Sign in Here...</a>
    </form>
    

<script>
    var request;

$("#mail").keyup(function(event){

   
   event.preventDefault();

   if (request) {
       request.abort();
   }
  
   var $form = $(this);

   var $inputs = $form.find("input, select, button, textarea");
   

  
   var serializedData = $form.serialize();
   var search=document.getElementById("mail").value;
   if(search.length>0){

   


   
   $inputs.prop("disabled", true);

  
   request = $.ajax({
       url: "find.php",
       type: "post",
       data: serializedData
   });

   request.done(function (response, textStatus, jqXHR){
       document.getElementById("output").innerHTML=response;
      
       console.log("Hooray, it worked!");
   });

   request.fail(function (jqXHR, textStatus, errorThrown){
      
       console.error(
           "The following error occurred: "+
           textStatus, errorThrown
       );
   });

   request.always(function () {
       
       $inputs.prop("disabled", false);
   });
   }else {
    document.getElementById("output").innerHTML = "";
   }
});
</script>

</body>
</html>
<?php ob_end_flush(); ?>