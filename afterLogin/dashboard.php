<?php
session_start();
ob_start();
require '../connection.php';
require '../nav/afternav.php';

$message = isset($_GET['message']) ? htmlspecialchars($_GET['message']) : '';

// Redirect if the user is not logged in
if (!isset($_SESSION['email'])) {
    header('Location: ../login.php');
    exit;
}

// Handle batch insertion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $verify_url = $_POST['verify_url'];

    // File upload handling
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
        $error_message = "Batch image is required.";
    }

    // Save to database
    if (!empty($name) && !empty($image_url) && !empty($verify_url)) {
        $stmt = $conn->prepare("INSERT INTO batch (email, name, image_url, verify_url) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('ssss', $_SESSION['email'], $name, $image_url, $verify_url);

        if ($stmt->execute()) {
            header("Location: dashboard.php?message=insert");
            exit();
        } else {
            header("Location: dashboard.php?message=err");
            exit();
        }

    } else {
        header("Location: dashboard.php?message=err");
        exit();
    }

}

// Fetch user-specific batches
$stmt = $conn->prepare("SELECT * FROM batch WHERE email = ?");
$stmt->bind_param('s', $_SESSION['email']);
$stmt->execute();
$result = $stmt->get_result();
$batches = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
<div class="content">
    <div class="container">
        <div class="video-wrapper">
            <video class="video-background" autoplay loop muted>
                <source src="../res/learn.mp4" type="video/mp4">
            </video>
        </div>
        <marquee direction="left" style="color: white;">Please rename your batch image with your username (username_batchname.png)</marquee>
        <h1>Welcome to Your Dashboard</h1>

        <!-- Batch Insertion Form -->
        <h2>Add a New Batch</h2>
        <?php if (isset($success_message)) echo "<p style='color:green;'>$success_message</p>"; ?>
        <?php if (isset($error_message)) echo "<p style='color:red;'>$error_message</p>"; ?>

        <?php if ($message == 'delete'): ?>
            <div class="alert alert-danger" id="alert">The Batch was deleted successfully.</div>
        <?php elseif ($message == 'update'): ?>
            <div class="alert alert-success" id="alert">The Batch was updated successfully.</div>
        <?php elseif ($message == 'insert'): ?>
            <div class="alert alert-success" id="alert">The Batch was added successfully.</div>
        <?php elseif ($message == 'error'): ?>
            <div class="alert alert-danger" id="alert"> <?= htmlspecialchars($_GET['error'] ?? '') ?></div>
        <?php endif; ?>

        <form action="dashboard.php" method="POST" enctype="multipart/form-data">
            <label for="name">Batch Name:</label>
            <input type="text" id="name" name="name" required><br>
            <label for="image_url">Batch Image:</label>
            <input type="file" id="image_url" name="image_url" required><br>
            <label for="verify_url">Verification URL:</label>
            <input type="text" id="verify_url" name="verify_url" required><br>
            <button type="submit" class="view-link">Add Batch</button>
        </form>
    </div>

    <div class="batchstore">
        <h2>Your Batches</h2>
        <?php if (empty($batches)): ?>
            <p>No batches added yet.</p>
        <?php else: ?>
            <div class="card-container">
                <?php foreach ($batches as $batch): ?>
                    <div class="batch-card">
                        <h3><?php echo htmlspecialchars($batch['name']); ?></h3>
                        <a href="<?php echo htmlspecialchars($batch['verify_url']); ?>" target="_blank">
                            <img src="<?php echo htmlspecialchars('../' . $batch['image_url']); ?>" alt="<?php echo htmlspecialchars($batch['name']); ?>" class="batch-image">
                        </a>
                        <div class="buttons">
                            <button class="update-link" onclick='openUpdateModal(<?php echo json_encode($batch); ?>)'>Update</button>
                            <button class="delete-link" onclick='openDeleteModal(<?php echo $batch['id']; ?>)'>Delete</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>


</div>

<div id="update-modal" class="modal">
    <div class="modal-content">
        <span onclick="closeModal('update-modal')" class="close">&times;</span>
        <h2>Update Batch</h2>
        <form action="update_batch.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" id="update-id" name="id">
            <label for="update-name">Batch Name:</label>
            <input type="text" id="update-name" name="name" required><br>
            <label for="update-image-url">Batch Image:</label>
            <input type="file" id="update-image-url" name="image_url"><br>
            <label for="update-verify-url">Verification URL:</label>
            <input type="text" id="update-verify-url" name="verify_url" required><br>
            <button type="submit" class="update-link">Update</button>
        </form>
    </div>
</div>

<div id="delete-modal" class="modal">
    <div class="modal-content">
        <span onclick="closeModal('delete-modal')" class="close">&times;</span>
        <h2>Delete Batch</h2>
        <p>Are you sure you want to delete this batch?</p>
        <form action="delete_batch.php" method="POST">
            <input type="hidden" id="delete-id" name="id">
            <button type="submit" class="delete-link">Delete</button>
            <button type="button" class="update-link" onclick="closeModal('delete-modal')">Cancel</button>
        </form>
    </div>
</div>


<script>
    function openUpdateModal(batch) {
        document.getElementById('update-modal').style.display = 'block';
        document.getElementById('update-id').value = batch.id;
        document.getElementById('update-name').value = batch.name;
        document.getElementById('update-verify-url').value = batch.verify_url;
    }

    function openDeleteModal(batchId) {
        document.getElementById('delete-modal').style.display = 'block';
        document.getElementById('delete-id').value = batchId;
    }

    // Hide the alert message after 10 seconds
    setTimeout(function() {
        var alert = document.getElementById('alert');
        if (alert) {
            alert.style.display = 'none';
        }
    }, 10000); // 10 seconds

</script>
</body>
</html>
