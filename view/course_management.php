<?php

session_start();
require_once '../model/CourseRepo.php';

$Homepage = '/Tuition-Management-System/view/homepage.php';
$Login_page = '/Tuition-Management-System/view/login.php';
if($_SESSION["user_id"] <= 0){
//        echo '<h1>'.$_SESSION["user_id"] .'</h1>';
    header("Location: {$Login_page}");
}

// Mock data for demonstration purposes
$courses = findAllCourses();

$errors = [];

// Check if the form is submitted to add a new course
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newCourseName = isset($_POST['new_course_name']) ? trim($_POST['new_course_name']) : '';
    $newCourseCode = isset($_POST['new_course_code']) ? trim($_POST['new_course_code']) : '';

    // Validate course name
    if (empty($newCourseName)) {
        $errors['new_course_name'] = "Course name cannot be empty.";
    }

    // Validate course code
    if (empty($newCourseCode)) {
        $errors['new_course_code'] = "Course code cannot be empty.";
    }

    // If no validation errors, add the new course
    if (empty($errors)) {
//        $newCourse = ['id' => count($courses) + 1, 'name' => $newCourseName, 'code' => $newCourseCode];
        $inserted_id = createCourse($newCourseName, $newCourseCode);
        if($inserted_id > 0){
            $courses = findAllCourses();
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tuition Management System - Course Management</title>

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
            background-color: #f5f5f5;
            color: #333;
            text-align: center;
            padding: 20px;
            background-color: #cad2c5;
        }

        h2 {
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

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #52796f;
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

        button {
            background-color: #52796f;
            color: #ffffff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #354f52;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #52796f;
            color: #ffffff;
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

        function validateCourseForm() {
            var course_name = document.getElementById("course_name").value;
            var code = document.getElementById("code").value;

            if (course_name === "" || course_name === null) {
                // emailErrorLabel.innerHTML = "Email is required.";
                showModal("Course Name is Required");
                return false;
            }


            if (code === "" || code === null) {
                // Display error message
                showModal("Course Code is Required");
                return false;
            }

            return true; // Return true if all validations pass
        }

        // Attach the validation function to the form's onsubmit event
        document.getElementById("courseForm").onsubmit = function () {
            return validateCourseForm();
        };

    </script>

</head>
<body>
<center>


    <div>
        <h2>Course Management</h2>

        <!-- Validation Modal -->
        <div id="validationModal" style="display: none; position: fixed; top: 0; right: 0; width: 40%;" class="alert alert-danger alert-dismissible fade show" role="alert">
            <span id="close_button" aria-hidden="true" onclick="close_modal();">&times;</span>
            <div style="position: absolute; top: 0; right: 0;">
                <p style="cursor: pointer; font-size: 30px;" class="close" data-dismiss="alert" aria-label="Close" >
                </p>
            </div>
            <p id="validationMessage"></p>
        </div>


        <!-- Form for adding a new course -->
        <form method="post" id="courseForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="return validateCourseForm()">
            <label for="new_course_name">Course Name:</label>
            <input type="text" id="course_name" name="new_course_name">
            <?php if(isset($errors['new_course_name'])): ?>
                <span style="color: red;"><?php echo $errors['new_course_name']; ?></span>
            <?php endif; ?>
            <br> <br>
            
            <label for="new_course_code">Course Code:</label>
            <input type="text" id="code" name="new_course_code">
            <?php if(isset($errors['new_course_code'])): ?>
                <span style="color: red;"><?php echo $errors['new_course_code']; ?></span>
            <?php endif; ?>
            <br><br>
            
            <button type="submit" name="add_course">Add Course</button>

            <br><br>
        </form>

        <br><br>

        <!-- Display existing courses in a table -->
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th><strong>Name</strong></th>
                    <th><strong>Code</strong></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($courses as $course): ?>
                    <tr>
                        <td><?php echo $course['id']; ?></td>
                        <td><?php echo $course['course_name']; ?></td>
                        <td><?php echo $course['code']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <p>Want to go back? <a href="<?php echo $Homepage; ?>">Go back to Dashboard</a></p>
</center>
</body>
</html>
