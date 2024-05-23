<?php

    $LoginController = '/Controllers/LoginController.php';
    $Registration_Page = '/view/registration.php';


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/login.css">


    <style>
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



        #loginForm {
            width: 50%;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex; /* Add Flexbox display */
            flex-direction: column; /* Stack children vertically */
            justify-content: center; /* Vertically center children */
            align-items: center; /* Horizontally center children */
            margin-top: 80px;
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

        div {
            margin-top: 20px;
            text-align: center;
        }

        span {
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



        function validateLoginForm() {
            var email = document.getElementById("loginEmail").value;
            var password = document.getElementById("loginPassword").value;
            // var emailErrorLabel = document.getElementById("loginEmailError");

            // Reset previous error messages
            // emailErrorLabel.innerHTML = "";

            // Validate email
            if (email === "" || email === null) {
                // emailErrorLabel.innerHTML = "Email is required.";
                showModal("Email is Required");
                return false;
            }
            // You can add more email validation logic here if needed

            // Validate password

            if (password === "" || password === null) {
                // Display error message
                showModal("Password is Required");
                return false;
            }

            return true; // Return true if all validations pass
        }

        // Attach the validation function to the form's onsubmit event
        document.getElementById("loginForm").onsubmit = function () {
            return validateLoginForm();
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



    <!-- Login Form -->
    <form action="<?php echo $LoginController; ?>" id="loginForm" onsubmit="return validateLoginForm()" method="post">
        
                 <fieldset>
                <h3 align="middle">Login</h3> 
            <table align="center">
                <tr>
                    <td>
                        <input type="text" name="loginEmail" id="loginEmail"  placeholder="Email">
                    </td>
                </tr>
                <tr>
                    <td>
                    <input type="password" name="loginPassword" id="loginPassword" placeholder="Password">
                    </td>
                </tr>
                <tr>
                    <td align="center">
                        <input type="submit" name="login" value="Login">
                    </td>
                </tr>
            </table>
           <br>
           <div>
               <center>
                   <span>Don't have an account?</span>
                   <span>
                       <a href="<?php echo $Registration_Page; ?>">Register</a>
                   </span>
               </center>
           </div>

          
 
            </fieldset>
               

    </form>


</body>

</html>