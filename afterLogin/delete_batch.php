<?php
session_start();
require '../connection.php';

// Redirect if the user is not logged in
if (!isset($_SESSION['email'])) {
    header('Location: ../login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get batch ID from the form
    $batch_id = $_POST['id'];

    // Check if the batch exists
    $stmt = $conn->prepare("SELECT image_url FROM batch WHERE id = ?");
    $stmt->bind_param('i', $batch_id);
    $stmt->execute();
    $stmt->bind_result($image_url);
    $stmt->fetch();
    $stmt->close();

    if ($image_url) {
        // Delete the image file from the server
        $image_path = '../' . $image_url;
        if (file_exists($image_path)) {
            unlink($image_path); // Delete the image file
        }
    }

    // Delete the batch from the database
    $stmt = $conn->prepare("DELETE FROM batch WHERE id = ?");
    $stmt->bind_param('i', $batch_id);

    if ($stmt->execute()) {
        header("Location: dashboard.php?message=delete");
        exit();
    } else {
        header("Location: dashboard.php?message=err");
        exit();
    }

}
?>