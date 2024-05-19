<?php

require_once __DIR__ . '/../model/db_connect.php';


function findAllGrade_feedbacks()
{
    $conn = db_conn();
    $selectQuery = 'SELECT * FROM `grade_feedback`';

    try {
        $result = $conn->query($selectQuery);

        // Check if the query was successful
        if (!$result) {
            throw new Exception("Query failed: " . $conn->error);
        }

        $rows = array();

        // Fetch rows one by one
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }

        // Check for an empty result set
        if (empty($rows)) {
            throw new Exception("No rows found in the 'user' table.");
        }

        return $rows;
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        return null;
    } finally {
        // Close the database connection
        $conn->close();
    }
}

function createGrade_feedback($data) {
    $conn = db_conn();

    // Hash the password using a secure hashing algorithm (e.g., password_hash)
//    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Construct the SQL query
    $insertQuery = "INSERT INTO `grade_feedback` (`name`, `grade`, `feedback`, `user_id`) VALUES (?, ?, ?, ?)";

    try {
        // Prepare the statement
        $stmt = $conn->prepare($insertQuery);

        // Check if the prepare statement was successful
        if (!$stmt) {
            throw new Exception("Prepare statement failed: " . $conn->error);
        }


        // Bind parameters
        $stmt->bind_param('sssi', $data['name'], $data['grade'], $data['feedback'], $data['user_id']);

        // Execute the query
        $stmt->execute();

        // Return the ID of the newly inserted user
        $newUserId = $conn->insert_id;

        // Close the statement
        $stmt->close();

        return $newUserId;
    } catch (Exception $e) {
        // Handle the exception, you might want to log it or return false
        echo "Error: " . $e->getMessage();
        return -1;
    } finally {
        // Close the database connection
        $conn->close();
    }
}


function findGrade_feedbackByUserID($id)
{
    $conn = db_conn();
    $selectQuery = 'SELECT * FROM `grade_feedback` WHERE `user_id` = ?';


    try {
        $stmt = $conn->prepare($selectQuery);

        // Check if the prepare statement was successful
        if (!$stmt) {
            throw new Exception("Prepare statement failed: " . $conn->error);
        }

        // Bind the parameter
        $stmt->bind_param("i", $id);

        // Execute the query
        $stmt->execute();

        // Get the result
        $result = $stmt->get_result();

        // Fetch the user as an associative array
        $user = $result->fetch_assoc();

        // Check for an empty result set
        if (!$user) {
            return null;
//            throw new Exception("No user found with ID: " . $id);
        }

        // Close the statement
        $stmt->close();

        return $user;
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        return null;
    } finally {
        // Close the database connection
        $conn->close();
    }
}

function updateGrade_feedbackByUserID($data, $user_id)
{
    $conn = db_conn();
    $updateQuery = 'UPDATE `grade_feedback` SET `grade` = ?, `feedback` = ? /* Add more columns as needed */ WHERE `user_id` = ?';

    try {
        $stmt = $conn->prepare($updateQuery);

        // Check if the prepare statement was successful
        if (!$stmt) {
            throw new Exception("Prepare statement failed: " . $conn->error);
        }

        // Bind parameters
        $stmt->bind_param("ssi", $data['grade'], $data['feedback'], $user_id);

        // Execute the query
        $stmt->execute();

        // Check if any row was affected (updated)
        if ($stmt->affected_rows < 1) {
            throw new Exception("No row found or updated with user_id: " . $user_id);
        }

        // Close the statement
        $stmt->close();

        return 1; // Indicates success
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        return -1; // Indicates failure
    } finally {
        // Close the database connection
        $conn->close();
    }
}
