<?php
    session_start();
    require_once "conn.php";

    // it will never let you open index(login) page if session is set
    if (isset($_SESSION['username'])) {
        header("Location: index.php");
        exit();
    }

    $error = false;

    if (isset($_POST['btn-login'])) {
        // prevent sql injections/ clear user invalid inputs
        $email = trim($_POST['email']);
        $email = strip_tags($email);
        $email = htmlspecialchars($email);

        $pass = trim($_POST['pass']);
        $pass = strip_tags($pass);
        $pass = htmlspecialchars($pass);
        // prevent sql injections / clear user invalid inputs

    if (empty($email)) {
        $error = true;
        $emailError = "Please enter your email address.";
    } else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
        $error = true;
        $emailError = "Please enter valid email address.";
    }

    if (empty($pass)) {
        $error = true;
        $passError = "Please enter your password.";
    }

    // if there's no error, continue to login
    if (!$error) {
        //$password = hash('sha256', $pass); // password hashing using SHA256

        $theQuery = "SELECT * FROM users WHERE email= 'Bill@aol.com'";
        $res = $conn->query($theQuery);
        //$res->execute();
        $row=mysqli_fetch_array($res);
        // $count = mysqli_num_rows($res);  //if uname/pass correct it returns must be 1 row
        $count =1;

        if($row['password']==$pass ) {
            $_SESSION['username'] = $row['id'];
            header("Location: homepg.php");

            echo "Thank You!";
        } else {
            $errMSG = "Incorrect Credentials, Try again!...";
        }

    }
 }
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>WWYDH Login</title>
<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css"  />
<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>

<div class="container">

 <div id="login-form">
    <form method="post" action="" autocomplete="off">

     <div class="col-md-12">

         <div class="form-group">
             <h2 class="">Sign In.</h2>
            </div>

         <div class="form-group">
             <hr />
            </div>

            <?php
   if ( isset($errMSG) ) {

    ?>
    <div class="form-group">
             <div class="alert alert-danger">
    <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                </div>
             </div>
                <?php
   }
   ?>

            <div class="form-group">
             <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
             <input type="email" name="email" class="form-control" placeholder="Your Email" value="<?php echo isset($email) ? $email : ""; ?>" maxlength="40" />
                </div>
                <span class="text-danger"><?php echo isset($emailError) ? $emailError : ""; ?></span>
            </div>

            <div class="form-group">
             <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
             <input type="password" name="pass" class="form-control" placeholder="Your Password" value="<?php echo isset($pass) ? $pass : ""; ?>" maxlength="15" />
                </div>
                <span class="text-danger"><?php echo isset($passError) ? $passError : ""; ?></span>
            </div>

            <div class="form-group">
             <hr />
            </div>

            <div class="form-group">
             <button type="submit" class="btn btn-block btn-primary" name="btn-login">Sign In</button>
            </div>

            <div class="form-group">
             <hr />
            </div>

            <div class="form-group">
             <a href="register.php">Sign Up Here...</a>
            </div>

        </div>

    </form>
    </div>

</div>

</body>
</html>
