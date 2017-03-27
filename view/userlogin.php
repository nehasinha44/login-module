<?php
 ob_start();
 session_start();
 
 if(isset($_SESSION['name'])!="" && $_SESSION['name']!=""){
  header("Location: login.php");
 }
 $name      =  trim($_POST['username']) ;
 $password  =   $_POST['pass'];


/*$error = false;
 if ( isset($_POST['Submit']) ) {
  if (empty($name)) {
   $error = true;
   echo $nameError = "Please enter your full name.";
   die();
  } else if (strlen($name) < 3) {
   $error = true;
   $nameError = "Name must have atleat 3 characters.";
  } 
  // password validation
  if (empty($password)){
   $error = true;
   $passError = "Please enter password.";
  } else if(strlen($password) < 6) {
   $error = true;
   $passError = "Password must have atleast 6 characters.";
  }*/
 // if there's no error, continue to signup
  //print_r($error);
 
    $sql    =   "SELECT * from login where username= '".$name."'";
          $result = $conn->query($sql);
          if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
              if (MD5($password)== $row['password'] ) {
                $errMSG = "inside";
                $_SESSION['name'] = $name;

                unset($name);
                unset($password);
                header("Location: login.php");
              }
            }
        } else {
          $errMSG = "wrong password ";
           // header("Location:login.php");
          }
        
      }

 ?>