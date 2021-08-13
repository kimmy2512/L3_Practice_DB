<?php

if(isset($_REQUEST['Login'])) {

// get username from form
$username = $_REQUEST['username'];

$options = ['cost' => 9,];

// Get username and hashed password from database
$login_sql="SELECT * FROM `users` WHERE `username` = '$username'";
$login_query=mysqli_query($dbconnect,$login_sql);
$login_rs = mysqli_fetch_assoc($login_query);

// Hash password and compare with password in database
if (password_verify($_REQUEST['password'] ,$login_rs['password'])) {

    // password matches
    echo 'Password is valid!';
    $_SESSION['admin']=$login_rs['username'];
    header("Location: index.php?page=../admin/new_quote");

}    // end valid password if

// invalid password
else {
    echo 'Invalid password.';
    unset($_SESSION);

}    // end invalid password else

}    // end isset login if

?>