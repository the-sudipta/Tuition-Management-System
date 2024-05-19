<?php
    // Placeholder variables for user input and errors
    $email = "";
    $err_email = $success_message = "";

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Placeholder validation logic (replace with your own validation)
        $email = $_POST["email"];

        if (empty($email)) {
            $err_email = "Email is required";
        } else {
            // Process and send the password reset link (replace with your own logic)
            // For simplicity, this example assumes success and displays a success message
            $success_message = "Password reset link sent successfully to $email";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forget Password</title>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            background-color: #cad2c5;
            color: #333;
            text-align: center;
            padding: 20px;
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

        fieldset {
            border: none;
        }

        legend {
            color: #52796f;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
        }

        td {
            padding: 10px;
            text-align: left;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        span {
            color: red;
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

</head>
<body>
<center>

    <h1>Tuition Management System</h1>

    <!-- Forget Password Form -->
    <form action="" onsubmit="return validate()" method="post">
        <fieldset>
            <legend>Forget Password</legend>
            <table>
                <tr>
                    <td><strong>Email:</strong></td>
                    <td>
                        <input type="email" name="email" id="email" value="<?php echo $email; ?>" placeholder="Email">
                        <span id="err_email"><?php echo $err_email; ?></span>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type="submit" name="reset_password" value="Reset Password">
                    </td>
                </tr>
            </table>
        </fieldset>
    </form>

    <!-- Display success message if applicable -->
    <p><?php echo $success_message; ?></p>

    <p>Remember your password? <br><br> <a href="login.php">Login</a></p>
</body>
</center>
</html>
