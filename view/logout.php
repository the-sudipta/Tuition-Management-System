<?php

    $Login_Page = '/Tuition-Management-System/view/login.php';


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>

    <style>

        .customLogout{
            margin-top: 200px;
        }

        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #cad2c5;
            color: #354f52;
            text-align: center;
            padding: 20px;
        }

        h1 {
            color: #52796f;
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
    <div class="customLogout">
        <h1>Tuition Management System</h1>

        <p>You have been successfully logged out. <br> <br> <a href="<?php echo $Login_Page; ?>">Login again</a></p>
    </div>
</body>

</html>
