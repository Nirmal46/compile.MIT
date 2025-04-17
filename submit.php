<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database configuration
$host = 'localhost';
$db   = 'compilemit';
$user = 'root';
$pass = '';

// Create a new MySQLi connection
$conn = new mysqli($host, $user, $pass, $db);

// Check for a connection error
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if request method is POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize and retrieve inputs
    $name = htmlspecialchars(trim($_POST["name"]));
    $contact = htmlspecialchars(trim($_POST["contact"]));
    $session = htmlspecialchars(trim($_POST["session"]));
    $section = htmlspecialchars(trim($_POST["section"]));
    $message = htmlspecialchars(trim($_POST["message"]));

    // Prepare the insert query
    $stmt = $conn->prepare("INSERT INTO details (name, contact, session, section, message) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $contact, $session, $section, $message);

    // Execute and handle result
    if ($stmt->execute()) {
        echo "<script>alert('Form submitted successfully!'); window.location.href='index.html';</script>";
    } else {
        $errorMessage = addslashes($stmt->error);
        echo "<script>alert('Failed: $errorMessage'); window.history.back();</script>";
            }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>
