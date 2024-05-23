<?php

    session_start();
    require_once '../model/UserRepo.php';
    require_once '../model/AttendanceRepo.php';

    $Login_page = '/view/login.php';
    $Homepage = '/view/homepage.php';

    if($_SESSION["user_id"] <= 0){
        //        echo '<h1>'.$_SESSION["user_id"] .'</h1>';
        header("Location: {$Login_page}");
    }


// Mock data for demonstration purposes
    $students = findAllStudents();

    // Check if the form is submitted to track attendance
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_attendance'])) {
        $date = date('Y-m-d');
        $attendanceData = [];

        foreach ($students as $student) {
            $studentId = $student['id'];
            $attended = isset($_POST['attendance'][$studentId]) ? 1 : 0;
            $inserted_id = createAttendance($student['name'], $attended, $date, $studentId);
            if($inserted_id > 0){
                $attendanceData[] = [
                    'student_id' => $studentId,
                    'student_name' => $student['name'],
                    'attended' => $attended,
                    'date' => $date
                ];
            }
        }

        // Process and save the attendance data (replace this with your database logic)
        // For simplicity, we'll just display the submitted data
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tuition Management System - Attendance Tracking</title>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            text-align: center;
            background-color: #cad2c5;
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

        input[type="checkbox"] {
            margin-top: 5px;
        }

        button {
            background-color: #52796f;
            color: #ffffff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 15px;
        }

        button:hover {
            background-color: #354f52;
        }

        h3 {
            margin-top: 20px;
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
    <div>
        <center>


        <h2>Attendance Tracking</h2>

        <!-- Form for tracking attendance -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div>
                <label>Current Date: <?php echo date('Y-m-d'); ?></label>
            </div>

            <table border="1">
                <thead>
                    <tr>
                        <th>Student Name</th>
                        <th>Attendance</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($students as $student): ?>
                        <tr>
                            <td><?php echo $student['name']; ?></td>
                            <td>
                                <input type="checkbox" name="attendance[<?php echo $student['id']; ?>]" value="attended">
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <br>

            <button type="submit" name="submit_attendance">Submit Attendance</button>
        </form>

        <?php
            // Display submitted attendance data
            if (isset($attendanceData)) {
                echo "<h3>Submitted Attendance:</h3>";
                echo "<table border='1'>";
                echo "<thead><tr><th>Student Name</th><th>Student ID</th><th>Attendance</th><th>Date</th></tr></thead>";
                echo "<tbody>";
                foreach ($attendanceData as $attendance) {
                    echo "<tr>";
                    echo "<td>{$attendance['student_name']}</td>";
                    echo "<td>{$attendance['student_id']}</td>";
                    echo "<td>" . ($attendance['attended'] ? 'Yes' : 'No') . "</td>";
                    echo "<td>{$attendance['date']}</td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
            }
        ?>
        <p>Want to go back? <a href="<?php echo $Homepage; ?>">Go back to Dashboard</a></p>
        </center>
    </div>
</body>
</html>
