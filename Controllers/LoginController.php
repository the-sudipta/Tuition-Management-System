<?php

require_once '../model/UserRepo.php';


session_start();

$Login_page =   '/view/login.php';

$Dashboard_page = '/view/homepage.php';

$everythingOK = FALSE;
$everythingOKCounter = 0;
$emailError = "";
$passwordError = "";
$checkBoxError = "";

$email = "";
$password = "";
$_SESSION['emailError'] = "";
$_SESSION['passwordError'] = "";

$_SESSION['cookie_mail'] = "";
$_SESSION['cookie_pass'] = "";

//echo $_SERVER['REQUEST_METHOD'];

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    echo "Got Req";

//* Email Validation
    $email = $_POST['loginEmail'];
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
    $password = $_POST['loginPassword'];
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

    if ($everythingOK && $everythingOKCounter === 0){

        echo "<br>all ok<br>";
        $data = findUserByEmailAndPassword($email, $password);
        echo 'Data id = '.$data["id"].'<br>';
        $_SESSION["data"] = $data;
        $_SESSION["user_id"] = $data["id"];
        // Set the cookie with an expiration time
        setcookie("user_id", $data["id"], time() + 3600, "/");


        if($_SESSION["data"]["id"] > 0){
            echo "<br><br>All Clear to Dashboard<br>";
            header("Location: {$Dashboard_page}");
        }else{
            echo "<br>Redirecting to first page because id not found<br>";
            header("Location: {$Login_page}");
        }

    }else{
        $_SESSION['emailError'] = $emailError;
        $_SESSION['passwordError'] = $passwordError;
        echo "<br>Redirecting to first page because Email or Password Error<br>";
        header("Location: {$Login_page}");
    }



}


