<?php

    session_start();

    $Login_page = '/view/login.php';
    $Homepage = '/view/homepage.php';

    if($_SESSION["user_id"] <= 0){
        //        echo '<h1>'.$_SESSION["user_id"] .'</h1>';
        header("Location: {$Login_page}");
    }


require_once '../model/QuestionRepo.php';

    $Assessment_Page = 'view/assessment_authoring.php';

    // Mock data for demonstration purposes
    $questions = findAllQuestions();
    $assessmentTitle = "";
    $questionText = "";

//     && isset($_POST['author_assessment'])
    // Check if the form is submitted to author an assessment
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $assessmentTitle =  isset($_POST['assessment_title']) ? $_POST['assessment_title'] :  null;
        $questionText = isset($_POST['question_text']) ? $_POST['question_text'] :  null;
        if($questionText !== "" && $questionText !== null){
            // Add Question to the Database
            $inserted_id = createQuestion($questionText);
            if ($inserted_id <= 0){
                die('Question Could not be inserted. Database issue');
            }
            header("Location: {$Assessment_Page}");
//            echo '<script type="text/javascript">location.reload();</script>';
        }
        $selectedQuestions = isset($_POST['selected_questions']) ? $_POST['selected_questions'] : [];
        $selectedQuestions_size = count($selectedQuestions);

        if($assessmentTitle !== "" && $assessmentTitle !== null && $selectedQuestions_size >0){
            // Process and save the assessment data (replace this with your database logic)
            // For simplicity, we'll just display the selected questions
            $assessmentData = [
                'title' => $assessmentTitle,
                'selected_questions' => $selectedQuestions,
                'timestamp' => date('Y-m-d H:i:s'),
            ];
        }


    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tuition Management System - Assessment Authoring</title>

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
            font-size: 18px;
            color: #52796f;
            display: block;
            margin-bottom: 8px;
        }

        textarea, input[type="text"], select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
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

        h3 {
            margin-top: 20px;
            color: #52796f;
        }

        table {
            width: 100%;
            margin-top: 15px;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #dddddd;
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



        function validateAddQuestionForm() {
            var question = document.getElementById("question_textX").value;



            // alert("Feedback = "+feedback);
            if (question === "" || question === null) {
                // Display error message
                // alert("Feedback Null");
                showModal("Question is required to add Questions");
                return false;
            }

            return true; // Return true if all validations pass
        }

        function validateAssessmentForm() {
            var assessment_title = document.getElementById("assessment_title").value;
            var selected_questions = document.getElementById("selected_questions").value;



            // alert("Feedback = "+feedback);
            if (assessment_title === "" || assessment_title === null) {
                // Display error message
                // alert("Feedback Null");
                showModal("Assessment Title is required");
                return false;
            }

            if (selected_questions === "" || selected_questions === null) {
                // Display error message
                // alert("Feedback Null");
                showModal("Please Select a Question first");
                return false;
            }

            return true; // Return true if all validations pass
        }

        // Attach the validation function to the form's onsubmit event
        document.getElementById("addQuestionForm").onsubmit = function () {
            return validateAddQuestionForm();
        };

        document.getElementById("assessmentForm").onsubmit = function () {
            return validateAssessmentForm();
        };

    </script>
</head>
<body>
<center>

    <div>
        <h2>Assessment Authoring</h2>

        <!-- Validation Modal -->
        <div id="validationModal" style="display: none; position: fixed; top: 0; right: 0; width: 40%;" class="alert alert-danger alert-dismissible fade show" role="alert">
            <span id="close_button" aria-hidden="true" onclick="close_modal();">&times;</span>
            <div style="position: absolute; top: 0; right: 0;">
                <p style="cursor: pointer; font-size: 30px;" class="close" data-dismiss="alert" aria-label="Close" >
                </p>
            </div>
            <p id="validationMessage"></p>
        </div>

        <!-- Form for authoring an assessment -->
        <form method="post" id="addQuestionForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="return validateAddQuestionForm()">
            <div>
                <label for="question_text">New Question Text:</label>
                <textarea id="question_textX" name="question_text" rows="4" ></textarea>
            </div>
            <br>
            <div>
                <button type="submit" name="add_question">Add Question</button>
            </div>
        </form>

            <br>

        <form method="post" id="assessmentForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="return validateAssessmentForm()">
            <div>
                <label for="assessment_title">Assessment Title:</label>
                <input type="text" id="assessment_title" name="assessment_title" >
            </div>
            <br>
            <div>
                <label for="selected_questions">Selected Questions:</label>
                <select id="selected_questions" name="selected_questions[]" multiple>
                    <?php foreach ($questions as $question): ?>
                        <option value="<?php echo $question['id']; ?>"><?php echo $question['text']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <br>
            <div>
                <button type="submit" name="author_assessment">Author Assessment</button>
            </div>
        </form>
        <br>
        <?php
            // Display submitted assessment data
            if (isset($assessmentData)) {
                echo "<h3>Assessment Authored:</h3>";
                echo "<p>Title: " . $assessmentData['title'] . "</p>";
                echo "<h4>Selected Questions:</h4>";
                echo "<table border='1'>";
                echo "<thead><tr><th>Question ID</th><th>Question Text</th></tr></thead>";
                echo "<tbody>";
                foreach ($assessmentData['selected_questions'] as $selectedQuestion) {
                    $selectedQuestionText = getQuestionText($questions, $selectedQuestion);
                    echo "<tr>";
                    echo "<td>{$selectedQuestion}</td>";
                    echo "<td>{$selectedQuestionText}</td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
                echo "<p>Timestamp: " . $assessmentData['timestamp'] . "</p>";
            }

            // Function to get question text based on ID
            function getQuestionText($questions, $questionId) {
                foreach ($questions as $question) {
                    if ($question['id'] == $questionId) {
                        return $question['text'];
                    }
                }
                return "Unknown";
            }
        ?>
                <p>Want to go back? <a href="<?php echo $Homepage; ?>">Go back to Dashboard</a></p>
    </div>
</center>
</body>
</html>
