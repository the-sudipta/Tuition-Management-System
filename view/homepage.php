<?php

session_start();
$Login_page = '/Tuition-Management-System/view/login.php';
$Logout_file = '/Tuition-Management-System/Controllers/LogoutController.php';
$Profile_Page = '/Tuition-Management-System/view/profile.php';

if($_SESSION["user_id"] <= 0){
//    echo '<h1>'.$_SESSION["user_id"] .'</h1>';
    header("Location: {$Login_page}");
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tuition Management System</title>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #cad2c5;
            color: #333;
            text-align: justify;
        }

        header {
            background-color: #4CAF50;
            color: #ffffff;
            padding: 20px;
            text-align: left;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header h1{
            margin-right: 400px;
        }

        .logo img {
            max-width: 50px;
            margin-right: 10px;
        }

        h1 {
            margin: 0;
            color: #ffffff;
        }

        nav {
            text-align: right;
        }

        nav a {
            margin-left: 15px;
            color: #ffffff;
            text-decoration: none;
            font-weight: bold;
        }

        nav a:hover {
            text-decoration: underline;
        }

        img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }

        section {
            margin: 20px 0;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        ul {
            list-style-type: lower-greek;
            padding: 0;

        }

        ul li {
            margin-bottom: 15px;
        }

        ul li::marker {
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 15px;
            text-align: left;
        }

        th {
            background-color: #4CAF50;
            color: #ffffff;
        }

        footer {
            background-color: #333;
            color: #ffffff;
            padding: 20px 0;
            text-align: center;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            align-items: center;
        }

        .col-md-6 {
            width: 45%;
            margin: 10px;
        }

        hr {
            border: 0;
            height: 1px;
            background-color: #ddd;
            margin: 20px 0;
        }
    </style>

</head>

<body>

<header>
    <div class="logo">
        <img src="image/logo.jpg" alt="Logo" width="50" height="50">
    </div>
    <div>
        <h1>Tuition Management System</h1>
        <nav>
            <a href="<?php echo $Logout_file; ?>">Logout</a> |
            <a href="<?php echo $Profile_Page; ?>">Profile</a>
        </nav>
    </div>
</header>

<nav align="center">
    <a style="color: #2f3e46;" href="course_management.php">Course Management</a> |
    <a style="color: #2f3e46;" href="grading_feedback.php">Grading and Feedback</a> |
    <a style="color: #2f3e46;" href="attendance_tracking.php">Attendance Tracking</a> |
    <a style="color: #2f3e46;" href="communication_tools.php">Communication Tools</a> |
    <a style="color: #2f3e46;" href="analytics_reporting.php">Analytics and Reporting</a> |
    <a style="color: #2f3e46;" href="assessment_authoring.php">Assessment Authoring</a>
</nav>

<br>
<br>

<img src="image/Tuition.jpg" alt="Image description" width="1505" height="500">

<p>
<center>
    <h2>Unlock the Future of Seamless Tuition Administration</h2>
</center>
<section>
    <center>
        <h3>Key Highlights</h3>
        <ul style="text-align: justify;
            max-width: 600px;">
            <li>Effortless Tuition Tracking: From enrollment to graduation, our automated system takes the hassle out of tuition tracking.</li>
            <li>Secure Online Payments: Experience peace of mind with our robust and secure online payment processing.</li>
            <li>Customized Fee Structures: Tailor tuition fee structures to suit your institution's unique needs.</li>
            <li>Real-Time Financial Insights: Stay informed with real-time financial reporting.</li>
            <li>Enhanced Communication: Foster better communication among administrators, teachers, parents, and students.</li>
        </ul>
    </center>
</section>
</p>

<br>
<br>

<div>
    <table>
        <tbody>
        <tr align="center">
            <td>
                <img src="image/pic1.jpg" alt="Image" width="100" height="100">
                <h5>Automated Tuition Tracking</h5>
                <p>Effortlessly manage and track tuition fees from enrollment to graduation with our intuitive and automated tracking system.</p>
            </td>
            <td>
                <img src="image/pic2.jpeg" alt="Image" width="100" height="100">
                <h5>Customized Fee Structures</h5>
                <p>Tailor tuition fee plans to fit the unique needs of your educational institution, providing flexibility and adaptability.</p>
            </td>
            <td>
                <img src="image/pic3.jpg" alt="Image" width="100" height="100">
                <h5>Enhanced Communication</h5>
                <p>Foster better communication between administrators, teachers, parents, and students through a centralized platform for announcements and notifications.</p>
            </td>
            <td>
                <img src="image/pic5.jpg" alt="Image" width="100" height="100">
                <h5>User-Friendly Interface</h5>
                <p>Our intuitive design ensures a seamless experience for all users, reducing the learning curve and optimizing efficiency.</p>
            </td>
        </tr>
        </tbody>
    </table>
</div>

<!-- Footer Section -->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h4>Contact Us</h4>
                <p>Email: anik@gmail.com</p>
                <p>Phone: +8801625252525</p>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <p>&copy; 2023 Tuition Management System. All rights reserved.</p>
            </div>
        </div>
    </div>
</footer>

</body>

</html>
