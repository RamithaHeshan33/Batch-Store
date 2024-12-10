<?php
require '../connection.php';
require '../nav/nav.php';

$batches = []; // Initialize batches array
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'])) {
    $username = $_POST['name'];

    // Fetch the user's email based on the given username
    $userQuery = $conn->prepare("SELECT email FROM user WHERE username = ?");
    $userQuery->bind_param("s", $username);
    $userQuery->execute();
    $userResult = $userQuery->get_result();

    if ($userResult->num_rows > 0) {
        $user = $userResult->fetch_assoc();
        $userEmail = $user['email'];

        // Fetch batches associated with the user's email
        $batchQuery = $conn->prepare("SELECT * FROM batch WHERE email = ?");
        $batchQuery->bind_param("s", $userEmail);
        $batchQuery->execute();
        $batchResult = $batchQuery->get_result();
        $batches = $batchResult->fetch_all(MYSQLI_ASSOC);
    } else {
        // No user found with the given username
        $batches = [];
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../afterLogin/dashboard.css">
</head>
<body>
    <div class="content">
        <div class="container">
            <div class="video-wrapper">
                <video class="video-background" autoplay loop muted>
                    <source src="../res/learn.mp4" type="video/mp4">
                </video>
            </div>

            <h1>Find Batch Earner</h1>

            <form action="search.php" method="POST" enctype="multipart/form-data">
                <label for="name">Username:</label>
                <input type="text" id="name" name="name" required><br>
                <button type="submit" class="view-link">Search</button>
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
</body>
</html>