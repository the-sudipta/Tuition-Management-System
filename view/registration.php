<?php


$RegistrationController_File = "/Controllers/RegistrationController.php";


// Initialize variables to store user input and errors
$uname = $password = $confirm_password = $name = $email = $phone = "";
$err_uname = $err_password = $err_confirm_password = $err_name = $err_email = $err_phone = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and process registration data
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
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
            margin: 0;
            padding: 0;
            background-color: #cad2c5;
            color: #333;
        }

        h1 {
            text-align: center;
            color: #52796f;
        }

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
            border-radius: 5px;
        }

        #close_button {
            cursor: pointer;
            font-size: 30px;
            color: #721c24;
            position: absolute;
            top: 5px;
            right: 10px;
        }

        #validationModal p {
            margin: 0;
        }

        #registrationForm {
            width: 50%;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        fieldset {
            border: none;
        }

        h3 {
            text-align: center;
            color: #2f3e46;
        }

        table {
            width: 100%;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            box-sizing: border-box;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color: #52796f;
            color: #ffffff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #354f52;
        }

        p {
            text-align: center;
            color: #2f3e46;
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

        // Function to validate email format
        function validateEmail(email) {
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }

        // Function to show modal with validation message
        function showModal(message) {
            document.getElementById("validationMessage").innerHTML = message;
            document.getElementById("validationModal").style.display = "block";
        }

        close_modal = () => {
            document.getElementById("validationModal").style.display = "none";
            // location.reload(true);
        }



        function validateRegistrationForm() {
            var email = document.getElementById("registration_email").value;
            var password = document.getElementById("registration_password").value;
            var name = document.getElementById("registration_name").value;
            var phone = document.getElementById("registration_phone").value;
            var confirm_password = document.getElementById("registration_confirm_password").value;
            // var emailErrorLabel = document.getElementById("loginEmailError");

            // Reset previous error messages
            // emailErrorLabel.innerHTML = "";

            if (name === "" || name === null) {
                // Display error message
                showModal("Name is Required");
                return false;
            }

            if(validateEmail(email) !== true){
                showModal("Use a valid Email Format");
                return false;
            }

            // Validate email
            if (email === "" || email === null) {
                // emailErrorLabel.innerHTML = "Email is required.";
                showModal("Email is Required");
                return false;
            }

            if (phone === "" || phone === null || phone.length < 11) {
                // Display error message
                if(phone.length < 11){
                    showModal("Phone Number size must be 11 or more");
                    return false;
                }
                showModal("Phone is Required");
                return false;
            }

            // Validate password

            if (password === "" || password === null) {
                // Display error message
                showModal("Password is Required");
                return false;
            }


            // alert("Confirm Pass = "+confirm_password);

            if (confirm_password === "" || confirm_password === null) {
                showModal("Confirm Password is Required");
                return false;
            }

            if(confirm_password !== password){
                showModal("Password and Confirm password must be same");
                return false;
            }



            return true; // Return true if all validations pass
        }

        // Attach the validation function to the form's onsubmit event
        document.getElementById("registrationForm").onsubmit = function () {
            return validateRegistrationForm();
        };

    </script>


</head>
<body>

    <center>
        <h1>Tuition Management System</h1>
    </center>

    <!-- Validation Modal -->
    <div id="validationModal" style="display: none; position: fixed; top: 0; right: 0; width: 40%;" class="alert alert-danger alert-dismissible fade show" role="alert">
        <span id="close_button" aria-hidden="true" onclick="close_modal();">&times;</span>
        <div style="position: absolute; top: 0; right: 0;">
            <p style="cursor: pointer; font-size: 30px;" class="close" data-dismiss="alert" aria-label="Close" >
            </p>
        </div>
        <p id="validationMessage"></p>
    </div>


    <!-- Registration Form -->
    <form action="<?php echo $RegistrationController_File; ?>" id="registrationForm" onsubmit="return validateRegistrationForm()" method="post">
        <fieldset>
        <h3 align="middle"> Sign Up</h3>
            <table align="center">
            <tr>
                    <td><strong>Full Name:</strong></td>
                    <td>
                        <input type="text" name="name" id="registration_name"  placeholder="Full Name">
                    </td>
                </tr>
                <tr>
                <tr>
                    <td><strong>Email:</strong></td>
                    <td>
                        <input type="email" name="email" id="registration_email" placeholder="Email">
                    </td>
                </tr>
                <tr>
                    <td><strong>Phone:</strong></td>
                    <td>
                        <input type="text" name="phone" id="registration_phone"  placeholder="Phone">
                    </td>
                </tr>
                <tr>
                    <td><strong>Password:</strong></td>
                    <td>
                        <input type="password" name="password" id="registration_password" placeholder="Password">
                    </td>
                </tr>
                <tr>
                    <td><strong>Confirm Password:</strong></td>
                    <td>
                        <input type="password" name="confirm_password" id="registration_confirm_password" placeholder="Confirm Password">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type="submit" name="submit" value="Submit">
                    </td>
                </tr>
            </table>

    </form>
    <center>
        <p>Already have an account? <a href="login.php">Login</a></p>
    </center>
    </fieldset>


    
</body>
</html>
