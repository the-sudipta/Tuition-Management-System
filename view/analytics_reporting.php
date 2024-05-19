<?php

    session_start();
    require_once '../model/UserRepo.php';
    require_once '../model/CommunicationRepo.php';


    $Login_page = '/Tuition-Management-System/view/login.php';
    $Homepage = '/Tuition-Management-System/view/homepage.php';

    if($_SESSION["user_id"] <= 0){
        //        echo '<h1>'.$_SESSION["user_id"] .'</h1>';
        header("Location: {$Login_page}");
    }


// Mock data for demonstration purposes
    $students = findAllStudents();

    // Check if the form is submitted to generate a report
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['generate_report'])) {
        $selectedStudents = $_POST['selected_students'];

        // Process and generate the analytics report (replace this with your database logic)
        // For simplicity, we'll just display the selected student IDs
        $reportData = [
            'selected_students' => $selectedStudents,
            'timestamp' => date('Y-m-d H:i:s'),
        ];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tuition Management System - Analytics and Reporting</title>

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

        select {
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



        function validateReportForm() {
            var selected_students = document.getElementById("selected_students").value;



            // alert("Feedback = "+feedback);
            if (selected_students === "" || selected_students === null) {
                // Display error message
                // alert("Feedback Null");
                showModal("You must select a student to generate report");
                return false;
            }

            return true; // Return true if all validations pass
        }

        // Attach the validation function to the form's onsubmit event
        document.getElementById("reportForm").onsubmit = function () {
            return validateReportForm();
        };

    </script>
</head>
<body>
<center>

    <div>
        <h2>Analytics and Reporting</h2>

        <!-- Validation Modal -->
        <div id="validationModal" style="display: none; position: fixed; top: 0; right: 0; width: 40%;" class="alert alert-danger alert-dismissible fade show" role="alert">
            <span id="close_button" aria-hidden="true" onclick="close_modal();">&times;</span>
            <div style="position: absolute; top: 0; right: 0;">
                <p style="cursor: pointer; font-size: 30px;" class="close" data-dismiss="alert" aria-label="Close" >
                </p>
            </div>
            <p id="validationMessage"></p>
        </div>


        <!-- Form for generating a report -->
        <form method="post" id="reportForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="return validateReportForm()">
            <div>
                <label for="selected_students">Select Students:</label>
                <select id="selected_students" name="selected_students[]" multiple>
                    <?php foreach ($students as $student): ?>
                        <option value="<?php echo $student['id']; ?>"><?php echo $student['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <br><br>
            <div>
                <button type="submit" name="generate_report">Generate Report</button>
            </div>
        </form>
        <br><br>
        <?php
            // Display submitted report data
            if (isset($reportData)) {
                echo "<h3>Report Generated:</h3>";
                echo "<table border='1'>";
                echo "<thead><tr><th>Student ID</th><th>Student Name</th></tr></thead>";
                echo "<tbody>";
                foreach ($reportData['selected_students'] as $selectedStudent) {
                    echo "<tr>";
                    echo "<td>{$selectedStudent}</td>";
                    echo "<td>" . getStudentName($students, $selectedStudent) . "</td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
                echo "<p>Timestamp: " . $reportData['timestamp'] . "</p>";
            }
        ?>

        <?php
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
    </div>
    <p>Want to go back? <a href="<?php echo $Homepage; ?>">Go back to Dashboard</a></p>

</center>

</body>
</html>
