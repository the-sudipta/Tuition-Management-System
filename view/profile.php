<?php

    session_start();
    require_once '../model/UserRepo.php';

    $Login_page = '/Tuition-Management-System/view/login.php';
    $Logout_File = '/Tuition-Management-System/Controllers/LogoutController.php';
    $Homepage = '/Tuition-Management-System/view/homepage.php';
    $Profile_page = '/Tuition-Management-System/view/profile.php';

    if($_SESSION["user_id"] <= 0){
        //        echo '<h1>'.$_SESSION["user_id"] .'</h1>';
        header("Location: {$Login_page}");
    }




// Placeholder variables for user data and errors
$uname = $name = $email = $phone = "";
$err_name = $err_email = $err_phone = $success_message = "";


$data = findUserByUserID($_SESSION['user_id']);


// Check if the form is submitted for profile update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Placeholder validation logic (replace with your own validation)
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];

    if (empty($name)) {
        $err_name = "Name is required";
    }

    if (empty($email)) {
        $err_email = "Email is required";
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $err_email = "Use a proper Email Format";
    }

    if (empty($phone)) {
        $err_phone = "Phone is required";
    }

    if(strlen($phone) < 11){
        $err_phone = "Phone Number Must be 11 or More than that";
    }



    if (!empty($name) && empty($err_name)) {
        UpdateSingleUserInfoByUserID("name", $name, $_SESSION['user_id']);
        header("Location: {$Profile_page}");
    }

    if (!empty($email) && empty($err_email)) {
        UpdateSingleUserInfoByUserID("email", $email, $_SESSION['user_id']);
        header("Location: {$Profile_page}");
    }

    if (!empty($phone) && empty($err_phone)) {
        UpdateSingleUserInfoByUserID("phone", $phone, $_SESSION['user_id']);
        header("Location: {$Profile_page}");
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Profile</title>
    <!--    Library for AJAX-->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #cad2c5;
            color: #354f52;
            text-align: center;
            padding: 20px;
            background-color: #cad2c5;
        }

        h1 {
            color: #52796f;
        }

        section {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 20px;
        }

        h2 {
            color: #52796f;
        }

        table {
            width: 100%;
            margin-top: 10px;
        }

        table, th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        form {
            margin-top: 20px;
        }

        .profileInput {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            box-sizing: border-box;
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

        function updateProfile() {
            var formData = $('#updateProfileForm').serialize();

            $.ajax({
                type: "POST",
                url: "<?php echo $Profile_page; ?>",
                data: formData,
                success: function (response) {
                    // Handle success response, if needed
                    console.log(response);
                    // alert("Success");
                    location.reload();
                },
                error: function (error) {
                    // Handle error, if needed
                    console.log(error);
                }
            });
        }

        // This Function Always got call automatically and this will call the updateProfile() function each time when the input value got changed
        $(document).ready(function () {
            $('.profileInput').change(function () {
                updateProfile();
            });
        });

    </script>


</head>
<body>
    <h1>Tuition Management System</h1>

    <!-- View Profile Section -->
    <section>
        <h2>View Profile</h2>
        <p><strong>Name:</strong> <?php echo $data['name']; ?></p>
        <p><strong>Email:</strong> <?php echo $data['email']; ?></p>
        <p><strong>Phone:</strong> <?php echo $data['phone']; ?></p>

        <!-- Logout Form -->
        <form action="<?php echo $Logout_File; ?>" method="post">
            <input type="submit" name="logout" value="Logout">
        </form>
    </section>

    <!-- Update Profile Form -->
    <section>
        <h2>Update Profile</h2>
        <form action="" id="updateProfileForm" method="post">
            <table>
                <tr>
                    <td><strong>Name:</strong></td>
                    <td>
                        <input type="text" class="profileInput" name="name" id="name" value="<?php echo $name; ?>" placeholder="Name">
<!--                        <span style="color: red;" id="err_name">--><?php //echo $err_name; ?><!--</span>-->
                    </td>
                </tr>
                <tr>
                    <td><strong>Email:</strong></td>
                    <td>
                        <input type="email" class="profileInput" name="email" id="email" value="<?php echo $email; ?>" placeholder="Email">
<!--                        <span style="color: red;" id="err_email">--><?php //echo $err_email; ?><!--</span>-->
                    </td>
                </tr>
                <tr>
                    <td><strong>Phone:</strong></td>
                    <td>
                        <input type="text" class="profileInput" name="phone" id="phone" value="<?php echo $phone; ?>" placeholder="Phone">
<!--                        <span style="color: red;" id="err_phone">--><?php //echo $err_phone; ?><!--</span>-->
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                    <input type="submit" name="update_profile" value="Update Profile">
                    </td>
                </tr>
            </table>
        </form>
    </section>

    <!-- Display success message if applicable -->
    <p><?php echo $success_message; ?></p>

    <p>Want to go back? <a href="<?php echo $Homepage; ?>">Go back to Dashboard</a></p>
</body>
</html>
