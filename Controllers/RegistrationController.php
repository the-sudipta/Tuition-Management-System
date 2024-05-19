<?php

require_once '../model/UserRepo.php';


session_start();

$Login_page =   '/Tuition-Management-System/view/login.php';
$Signup_Page = '/Tuition-Management-System/view/registration.php';

$everythingOK = FALSE;
$everythingOKCounter = 0;
$emailError = "";
$passwordError = "";
$checkBoxError = "";

$email = "";
$password = "";
$name = "";
$phone = "";


$_SESSION['emailError'] = "";
$_SESSION['passwordError'] = "";

$_SESSION['cookie_mail'] = "";
$_SESSION['cookie_pass'] = "";

//echo $_SERVER['REQUEST_METHOD'];

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    echo "Got Req";

//* Email Validation
    $email = $_POST['email'];
    if (empty($email)) {
        $emailError = "Email is required";
        $_POST['loginEmail'] = "";
        $email = "";
        $everythingOK = FALSE;
        $everythingOKCounter += 1;

        echo "Mail error 1";
    }elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailError = "Invalid email format";
        $_POST['loginEmail'] = "";
        $email = "";
        $everythingOK = FALSE;
        $everythingOKCounter += 1;
        echo "Mail error 2";
    } else {
        $everythingOK = TRUE;
    }

//* Password Validation
    $password = $_POST['password'];
    if (empty($password) || strlen($password) < 8) {
        // check if password size in 8 or more and  check if it is empty
        $passwordError = "Write at least 8 Character";
        $_POST['loginPassword'] = "";
        $password = "";
        $everythingOK = FALSE;
        $everythingOKCounter += 1;
        echo "Pass error 1";
    } else if (!preg_match('/[@#$%]/', $password)) {
        // check if password contains at least one special character
        $passwordError = "Password must contain at least one special character (@, #, $, %).";
        $_POST['loginPassword'] = "";
        $password = "";
        $everythingOK = FALSE;
        $everythingOKCounter += 1;
        echo "Pass error 2";
    } else {
        $everythingOK = TRUE;
    }

    $phone = $_POST['phone'];
    if (empty($phone) || strlen($phone) < 11) {
        // check if password size in 8 or more and  check if it is empty
        $phone = "";
        $everythingOK = FALSE;
        $everythingOKCounter += 1;
        echo "Pass error 1";
    }else {
        $everythingOK = TRUE;
    }

    $name = $_POST['name'];
    if (empty($name)) {
        // check if password size in 8 or more and  check if it is empty
        $passwordError = "Write at least 8 Character";
        $name = "";
        $everythingOK = FALSE;
        $everythingOKCounter += 1;
        echo "Pass error 1";
    }else {
        $everythingOK = TRUE;
    }

    $confirm_password = $_POST['confirm_password'];
    if(empty($confirm_password) || $password !== $confirm_password){
        $everythingOK = FALSE;
        $everythingOKCounter += 1;
    }else {
        $everythingOK = TRUE;
    }




    if ($everythingOK && $everythingOKCounter === 0){

        echo "all ok";
        $inserted_id = createUser($email, $password, $name, $phone, "teacher");
        if ($inserted_id > 0){
            header("Location: {$Login_page}");
        }


    }else{
        $_SESSION['signup_error'] = "Signup Unsuccessful";
        header("Location: {$Signup_Page}");
    }



}


