<?php
session_start();
require '../connection.php';

// Redirect if the user is not logged in
if (!isset($_SESSION['email'])) {
    header('Location: ../login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get batch details from the form
    $batch_id = $_POST['id'];
    $name = $_POST['name'];
    $verify_url = $_POST['verify_url'];
    $image_url = null;

    // Check if the user uploaded a new image
    if (!empty($_FILES['image_url']['name'])) {
        $upload_dir = '../batch_images/';
        $image_name = basename($_FILES['image_url']['name']);
        $target_file = $upload_dir . $image_name;

        if (move_uploaded_file($_FILES['image_url']['tmp_name'], $target_file)) {
            $image_url = 'batch_images/' . $image_name;
        } else {
            $error_message = "Failed to upload image.";
        }
    } else {
        // If no new image, retain the current image URL
        $stmt = $conn->prepare("SELECT image_url FROM batch WHERE id = ?");
        $stmt->bind_param('i', $batch_id);
        $stmt->execute();
        $stmt->bind_result($image_url);
        $stmt->fetch();
        $stmt->close();
    }

    // Validate inputs
    if (!empty($name) && !empty($verify_url) && $image_url !== null) {
        // Update the batch in the database
        $stmt = $conn->prepare("UPDATE batch SET name = ?, image_url = ?, verify_url = ? WHERE id = ?");
        $stmt->bind_param('sssi', $name, $image_url, $verify_url, $batch_id);

        if ($stmt->execute()) {
            header("Location: dashboard.php?message=update");
            exit();
        } else {
            header("Location: dashboard.php?message=err");
        exit();
        }

    } else {
        $error_message = "All fields are required.";
    }
}
?>