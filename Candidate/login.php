<?php
// Include the database connection file
include('db_connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Fetch user from the database based on email
    $sql = "SELECT * FROM candidate WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Verify the password
        if (password_verify($password, $row['password'])) {
            echo "Login successful!";
            // Start the session and store user data
            session_start();
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_email'] = $row['email'];
            header("Location: success.html"); // Redirect to a user dashboard page
        } else {
            echo "Invalid credentials!";
        }
    } else {
        echo "No user found with that email.";
    }

    // Close the connection
    $conn->close();
}
?>
