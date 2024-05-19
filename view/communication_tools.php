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
    $_SESSION['sent_messages'] = findAllCommunications();

    // Check if the form is submitted to send a message
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $recipientId = $_POST['recipient_id'];
        $message = $_POST['message'];

        // Process and save the message data (replace this with your database logic)
        // For simplicity, we'll just display the submitted data
        $submittedData = [
            'recipient_id' => $recipientId,
            'recipient_name' => getStudentName($students, $recipientId),
            'message' => $message,
            'timestamp' => date('Y-m-d H:i:s'),
        ];

        $inserted_id = createCommunication($submittedData);

        if($inserted_id > 0){
            // Store the data in the session variable
            if (!isset($_SESSION['sent_messages'])) {
                $_SESSION['sent_messages'] = [];
            }
            $_SESSION['sent_messages'] = findAllCommunications();
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
    <title>Tuition Management System - Communication Tools</title>

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
            background-color: #cad2c5;
            color: #333;
            text-align: center;
            padding: 20px;
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

        select,
        textarea {
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

        th,
        td {
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



        function validateCommunicationForm() {
            var message = document.getElementById("message").value;



            // alert("Feedback = "+feedback);
            if (message === "" || message === null) {
                // Display error message
                // alert("Feedback Null");
                showModal("Message is Required to Communicate");
                return false;
            }

            return true; // Return true if all validations pass
        }

        // Attach the validation function to the form's onsubmit event
        document.getElementById("communicationForm").onsubmit = function () {
            return validateCommunicationForm();
        };

    </script>
</head>
<body>
    <div>
        <center>


        <h2>Communication Tools</h2>

            <!-- Validation Modal -->
            <div id="validationModal" style="display: none; position: fixed; top: 0; right: 0; width: 40%;" class="alert alert-danger alert-dismissible fade show" role="alert">
                <span id="close_button" aria-hidden="true" onclick="close_modal();">&times;</span>
                <div style="position: absolute; top: 0; right: 0;">
                    <p style="cursor: pointer; font-size: 30px;" class="close" data-dismiss="alert" aria-label="Close" >
                    </p>
                </div>
                <p id="validationMessage"></p>
            </div>

        <!-- Form for sending a message -->
        <form method="post" id="communicationForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="return validateCommunicationForm()">
            <div>
                <label for="recipient_id">Select Recipient:</label>
                <select name="recipient_id" required>
                    <?php foreach ($students as $student): ?>
                        <option value="<?php echo $student['id']; ?>"><?php echo $student['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <br>
            <div>
                <label for="message">Message:</label>
                <textarea name="message" id="message" rows="4"></textarea>
            </div>
            <br>

            <div>
                <button type="submit" name="send_message">Send Message</button>
            </div>
        </form>
        <br>
        <?php
            // Display submitted message data
            if (isset($_SESSION['sent_messages'])) {
                echo "<h3>Messages Sent:</h3>";
                echo "<table border='1'>";
                echo "<thead><tr><th>Recipient Name</th><th>Recipient ID</th><th>Message</th><th>Timestamp</th></tr></thead>";
                echo "<tbody>";
                foreach ($_SESSION['sent_messages'] as $message) {
                    echo "<tr>";
                    echo "<td>{$message['name']}</td>";
                    echo "<td>{$message['user_id']}</td>";
                    echo "<td>{$message['message']}</td>";
                    echo "<td>{$message['time']}</td>";
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
