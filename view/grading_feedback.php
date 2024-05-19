<?php
    session_start();


    require_once '../model/UserRepo.php';
    require_once '../model/Grade_FeedbackRepo.php';

    $Login_page = '/Tuition-Management-System/view/login.php';
    $Homepage = '/Tuition-Management-System/view/homepage.php';
    $Grade_Feedback_Page = '/Tuition-Management-System/view/grading_feedback.php';

    if($_SESSION["user_id"] <= 0){
//        echo '<h1>'.$_SESSION["user_id"] .'</h1>';
        header("Location: {$Login_page}");
    }


    $students = findAllStudents();
    $feedback = null;
    $_SESSION['all_data'] = findAllGrade_feedbacks();

    // Check if the form is submitted to provide grading and feedback
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $studentId = $_POST['student_id'];
        $grade = $_POST['grade'];
        $feedback = $_POST['feedback'];



        // Process and save the grading and feedback data (replace this with your database logic)
        // For simplicity, we'll store the data in a session variable
        $submittedData = [
            'name' => getStudentName($students, $studentId),
            'grade' => $grade,
            'feedback' => $feedback,
            'user_id' => $studentId,
        ];

        $inserted_id = -1;
       if($feedback !== "" && $feedback !== null){
           $previous_data = findGrade_feedbackByUserID($studentId);
           $inserted_id = -1;
           if($previous_data === null){
               $inserted_id = createGrade_feedback($submittedData);
           }else{
               $inserted_id = updateGrade_feedbackByUserID($submittedData, $studentId);
           }
       }


        if($inserted_id > 0){
            // Store the data in the session variable
            if (!isset($_SESSION['all_data'])) {
                $_SESSION['all_data'] = [];
            }
            $_SESSION['all_data'] = findAllGrade_feedbacks();
        }else{
            die('Grade and Feedbacks could not be inserted');
        }
    }

    // Function to get student name based on ID
    function getStudentName($students, $studentId) {
        foreach ($students as $student) {
            if ($student['id'] == $studentId) {
                return $student['name'];
            }
        }
        return "Unknown";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tuition Management System - Grading and Feedback</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/login.css">
    <!--    Library for AJAX-->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

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
            color: #354f52;
            text-align: center;
            padding: 20px;
        }

        h2 {
            color: #52796f;
        }

        form {
            max-width: 600px;
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
            color: #52796f;
            font-weight: bold;
        }

        select, textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            box-sizing: border-box;
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

        table, th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th, td {
            background-color: #f2f2f2;
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



        function validateGradeForm() {
            var feedback = document.getElementById("feedback").value;



            // alert("Feedback = "+feedback);
            if (feedback === "" || feedback === null) {
                // Display error message
                // alert("Feedback Null");
                showModal("Feedback is Required");
                return false;
            }

            return true; // Return true if all validations pass
        }

        // Attach the validation function to the form's onsubmit event
        document.getElementById("gradeForm").onsubmit = function () {
            return validateGradeForm();
        };

    //     Using AJAX

        function updateGrade() {
            var formData = $('#gradeForm').serialize();

            $.ajax({
                type: "POST",
                url: "<?php echo $Grade_Feedback_Page; ?>",
                data: formData,
                success: function (response) {
                    // Handle success response, if needed
                    console.log(response);
                    alert("Success");
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
            $('.GradeInput').change(function () {
                updateGrade();
            });
        });

    </script>

</head>
<body>
    <div >
        <center>
        <h2>Grading and Feedback</h2>

            <!-- Validation Modal -->
            <div id="validationModal" style="display: none; position: fixed; top: 0; right: 0; width: 40%;" class="alert alert-danger alert-dismissible fade show" role="alert">
                <span id="close_button" aria-hidden="true" onclick="close_modal();">&times;</span>
                <div style="position: absolute; top: 0; right: 0;">
                    <p style="cursor: pointer; font-size: 30px;" class="close" data-dismiss="alert" aria-label="Close" >
                    </p>
                </div>
                <p id="validationMessage"></p>
            </div>

        <!-- Form for providing grading and feedback -->
        <form method="post" id="gradeForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="return validateGradeForm()">
            <div>
                <label for="student_id">Select Student:</label>
                <select name="student_id" required>
                    <?php foreach ($students as $student): ?>
                        <option value="<?php echo $student['id']; ?>"><?php echo $student['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <br>
            <div>
                <label for="grade">Grade:</label>
                <select class="GradeInput" name="grade" required>
                    <option value="A+">A+</option>
                    <option value="A">A</option>
                    <option value="B+">B+</option>
                    <option value="B">B</option>
                    <option value="C+">C+</option>
                    <option value="C">C</option>
                    <option value="D+">D+</option>
                    <option value="D">D</option>
                    <option value="F">F</option>
                </select>
            </div>
            <br>
            <div>
                <label for="feedback">Feedback:</label>
                <textarea class="GradeInput" name="feedback" id="feedback" rows="4" ></textarea>
            </div>
            <br>
            <div>
                <button type="submit" name="submit_grades">Submit Grades</button>
            </div>
        </form>
       <br>
        <?php
            // Display submitted grading and feedback data
            if (isset($_SESSION['all_data'])) {
                echo "<h3>All Submitted Grading and Feedback:</h3>";
                echo "<table border='1'>";
                echo "<thead><tr><th>Student Name</th><th>Student ID</th><th>Grade</th><th>Feedback</th></tr></thead>";
                echo "<tbody>";
                foreach ($_SESSION['all_data'] as $data) {
                    echo "<tr>";
                    echo "<td>{$data['name']}</td>";
                    echo "<td>{$data['user_id']}</td>";
                    echo "<td>{$data['grade']}</td>";
                    echo "<td>{$data['feedback']}</td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
            }
        ?>
    </div>
    <center>
        <p>Want to go back? <a href="<?php echo $Homepage; ?>">Go back to Dashboard</a></p>
    </center>
    </center>
</body>
</html>
