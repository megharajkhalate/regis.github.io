<?php
require_once "pdo.php";
session_start();

$status = false;

if ( isset($_SESSION['status']) ) {
	$status = htmlentities($_SESSION['status']);
	$status_color = htmlentities($_SESSION['color']);

	unset($_SESSION['status']);
	unset($_SESSION['color']);
}

try 
{
    $pdo = new PDO("mysql:host=localhost;dbname=register", "fred", "zap");
    // set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
    die();
}


$_SESSION['color'] = 'red';

// Check to see if we have some POST data, if we do process it
if (isset($_POST['Division']) && isset($_POST['Branch']) && isset($_POST['Username']) && isset($_POST['Password']) && isset($_POST['confirm_password']) && isset($_POST['Contact'])  && isset($_POST['year'])) 
{
    
    if (strlen($_POST['Username']) < 1 || strlen($_POST['Password']) < 1 || strlen($_POST['confirm_password']) < 1 || strlen($_POST['Contact']) < 1 || strlen($_POST['Branch']) < 1 || strlen($_POST['year']) < 1 || strlen($_POST['Division']) < 1)
    {
        $_SESSION['status'] = "All fields are required";
        header("Location: add.php");
        return;
    }

    if ( !is_numeric($_POST['Contact'])) 
    {
        $_SESSION['status'] = "Contact No. must be numeric";
        header("Location: add.php");
        return;
    } 

    $Username = htmlentities($_POST['Username']);
    $Password = htmlentities($_POST['Password']);
    $confirm_password = htmlentities($_POST['confirm_password']);
    $Contact = htmlentities($_POST['Contact']);
    $Branch = htmlentities($_POST['Branch']);
    $year = htmlentities($_POST['year']);
    $Division = htmlentities($_POST['Division']);



    $stmt = $pdo->prepare("
        INSERT INTO student (Username, Password,confirm_password,Contact, Branch, year, Division) 
        VALUES (:Username,:Password, :confirm_password, :Contact, :Branch, :year, :Division)
    ");

    $stmt->execute([
        ':Username' => $Username, 
        ':Password' => $Password, 
        ':confirm_password' => $confirm_password, 
        ':Contact' => $Contact, 
        ':Branch' => $Branch,
        ':year' => $year,
        ':Division' => $Division,

       

    ]);

    $_SESSION['status'] = 'Record added';
    $_SESSION['color'] = 'green';

    header('Location: index.php');
	return;
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Colorlib Templates">
    <meta name="author" content="Colorlib">
    <meta name="keywords" content="Colorlib Templates">

    <!-- Title Page-->
    <title>Register Page</title>

    <!-- Icons font CSS-->
    <!-- <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css
 s">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/fonts/Material-Design-Iconic-Font.eot
">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/fonts/Material-Design-Iconic-Font.svg
">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/fonts/Material-Design-Iconic-Font.ttf

">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/fonts/Material-Design-Iconic-Font.woff">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/fonts/Material-Design-Iconic-Font.woff2

    ">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
 
 
    <!-- Main CSS-->
   <link href="css/main.css" rel="stylesheet" media="all">
   <script src="jscr/confirm.js"></script>


   
</head>


<!--BODY-->

<body>



    <div class="page-wrapper bg-img p-t-180 p-b-100 font-robo">
     

        <div class="wrapper wrapper--w960">
            <div class="card card-2">
                <div class="card-heading"></div>
                <div class="card-body">
                    <h2 class="title">Registration</h2>
                    
                    <form method="POST">

                        <div class="input-group">
                            <input class="input--style-2" type="text"  placeholder="Username"  name="Username" id="Username" autocomplete="off">
                        </div>
                        <div class="input-group">
                            <input class="input--style-2" type="password"  placeholder="Password" name="Password"  id="Password" autocomplete="off" required>
                            
                        </div>
                        <div class="input-group">
                        <input class="input--style-2" type="password" placeholder="Confirm Password" name="confirm_password"  id="confirm_password" autocomplete="off" required>

                        </div>
                        <div class="input-group">
                            <input class="input--style-2" type="integer" placeholder="Contact"  name="Contact" id="Contact" autocomplete="off">
                        </div>
                        <div class="row row-space">
                            <div class="col-2">
                                <div class="input-group">
                                    <input class="input--style-2" type="text" placeholder="Branch"  name="Branch" id="Branch" autocomplete="off">

                                </div>
                            </div>

                            <div class="input-group">
                            <input class="input--style-2" type="text" placeholder="year"  name="year" id="year" autocomplete="off">
                        </div>
                        
                  
                        <div class="input-group">
                            <input class="input--style-2" type="text" placeholder="Division"  name="Division" id="Division" autocomplete="off">
                        </div>
                        
                        <div class="p-t-30">
                            <button class="btn btn--radius btn--green" type="submit" onclick="return  validatePassword()" >Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
    var Password = document.getElementById("Password");
var confirm_password = document.getElementById("confirm_password");

function validatePassword(){
  if(Password.value != confirm_password.value) {
    confirm_password.setCustomValidity("Passwords Don't Match");


  } else {
        confirm_password.setCustomValidity('');


  }
}
Password.onchange = validatePassword;
confirm_password.onkeyup = validatePassword;



    
</script>
</body>

</html>
<!-- end document-->