<?php

    session_start();
    require_once '../model/UserRepo.php';

    $Login_page = '/view/login.php';
    $Profile_Page = '/view/profile.php';

    if($_SESSION["user_id"] <= 0){
        //        echo '<h1>'.$_SESSION["user_id"] .'</h1>';
        header("Location: {$Login_page}");
    }

    // Placeholder variables for user input and errors
    $current_password = $new_password = $confirm_password = "";
    $err_current_password = $err_new_password = $err_confirm_password = $success_message = "";

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Placeholder validation logic (replace with your own validation)
        $current_password = $_POST["current_password"];
        $new_password = $_POST["new_password"];
        $confirm_password = $_POST["confirm_password"];

        if (empty($current_password)) {
            $err_current_password = "Current Password is required";
        }

        if (empty($new_password) || strlen($new_password) < 8) {
            // check if password size in 8 or more and  check if it is empty
            $err_new_password = "Write at least 8 Character";
            $everythingOK = FALSE;
//            echo "Pass error 1";
        } else if (!preg_match('/[@#$%]/', $new_password)) {
            // check if password contains at least one special character
            $err_new_password = "Password must contain at least one special character (@, #, $, %).";
            $everythingOK = FALSE;
//            echo "Pass error 2";
        }

        if (empty($new_password)) {
            $err_new_password = "New Password is required";
        }

        if (empty($confirm_password)) {
            $err_confirm_password = "Please confirm the new password";
        } elseif ($new_password != $confirm_password) {
            $err_confirm_password = "Passwords do not match";
        }

        // If there are no validation errors, you can proceed with updating the password
        // For simplicity, this example assumes success and displays a success message
        if (empty($err_current_password) && empty($err_new_password) && empty($err_confirm_password)) {

            $update_decision = updateUserPasswordByUserID($new_password, $_SESSION["user_id"]);
            if($update_decision === FALSE){
                die('Failed up Update Password. Database Issue');
            }

//            $success_message = "Password updated successfully";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/login.css">

    <style>

        #validationModal {
            display: none;
            position: fixed;
            top: 0;
            right: 0;
            width: 40%;
            background-color: #ffdddd;
            color: #721c24;
            border: 1px solid #f5c6cb;
            padding: 10px;
            z-index: 1000;
        }

        #close_button {
            cursor: pointer;
            font-size: 30px;
            color: #721c24;
            position: absolute;
            top: 0;
            right: 0;
            /*padding: 10px;*/
            padding-bottom: 30px;
            padding-right: 10px;
        }

        #validationModal p {
            margin: 0;
        }

        .close {
            cursor: pointer;
            font-size: 30px;
            color: #721c24;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #cad2c5;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        h1 {
            color: #52796f;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 20px;
        }

        legend {
            font-size: 24px;
            color: #52796f;
            font-weight: bold;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            text-align: left;
        }

        td {
            padding: 10px;
        }

        input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        span {
            color: red;
            font-size: 14px;
            display: block;
            margin-top: 5px;
        }

        input[type="submit"] {
            background-color: #52796f;
            color: #ffffff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #354f52;
        }

        p {
            margin-top: 20px;
            font-size: 18px;
        }

        a {
            color: #52796f;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>

    <script>

        // Function to show modal with validation message
        function showModal(message) {
            document.getElementById("validationMessage").innerHTML = message;
            document.getElementById("validationModal").style.display = "block";
        }

        close_modal = () => {
            document.getElementById("validationModal").style.display = "none";
            // location.reload(true);
        }



        function validateChangePassForm() {
            var current_password = document.getElementById("current_password").value;
            var new_password = document.getElementById("new_password").value;
            var confirm_password = document.getElementById("confirm_password").value;

            if (current_password === "" || current_password === null) {
                // Display error message
                showModal("Current Password is Required");
                return false;
            }

            if (new_password === "" || new_password === null) {
                // Display error message
                showModal("New Password is Required");
                return false;
            }

            if (confirm_password === "" || confirm_password === null) {
                // Display error message
                showModal("Confirm Password is Required");
                return false;
            }

            if (new_password !== confirm_password) {
                // Display error message
                showModal("New Password and Confirm Password must be same");
                return false;
            }



            return true; // Return true if all validations pass
        }

        // Attach the validation function to the form's onsubmit event
        document.getElementById("changePassForm").onsubmit = function () {
            return validateChangePassForm();
        };

    </script>
</head>
<body>

    <center>


    <h1>Tuition Management System</h1>


    <!-- Validation Modal -->
    <div id="validationModal" style="display: none; position: fixed; top: 0; right: 0; width: 40%;" class="alert alert-danger alert-dismissible fade show" role="alert">
        <span id="close_button" aria-hidden="true" onclick="close_modal();">&times;</span>
        <div style="position: absolute; top: 0; right: 0;">
            <p style="cursor: pointer; font-size: 30px;" class="close" data-dismiss="alert" aria-label="Close" >
            </p>
        </div>
        <p id="validationMessage"></p>
    </div>

    <!-- Change Password Form -->
    <form action="" id="changePassForm" onsubmit="return validateChangePassForm()" method="post">
        <fieldset>
            <legend>Change Password</legend>
            <table>
                <tr>
                    <td><strong>Current Password:</strong></td>
                    <td>
                        <input type="password" name="current_password" id="current_password"  placeholder="Current Password">
                        <span style="color: red;" id="err_current_password"><?php echo $err_current_password; ?></span>
                    </td>
                </tr>
                <tr>
                    <td><strong>New Password:</strong></td>
                    <td>
                        <input type="password" name="new_password" id="new_password" placeholder="New Password">
                        <span style="color: red;" id="err_new_password"><?php echo $err_new_password; ?></span>
                    </td>
                </tr>
                <tr>
                    <td><strong>Confirm Password:</strong></td>
                    <td>
                        <input type="password" name="confirm_password" id="confirm_password"  placeholder="Confirm New Password">
                        <span style="color: red;" id="err_confirm_password"><?php echo $err_confirm_password; ?></span>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type="submit" name="change_password" value="Change Password">
                    </td>
                </tr>
            </table>
        </fieldset>
    </form>

    <!-- Display success message if applicable -->
    <p><?php echo $success_message; ?></p>

    <p>Want to go back? <a href="<?php echo $Profile_Page; ?>">Go back to Profile</a></p>
    </center>
</body>
</html>
