<?php
require 'connection.php';
require 'nav/nav.php';

$batches = []; // Initialize batches array
if (isset($_GET['username'])) {
    $username = $_GET['username'];

    // Fetch the user's email based on the given username
    $userQuery = $conn->prepare("SELECT email FROM user WHERE username = ?");
    $userQuery->bind_param("s", $username);
    $userQuery->execute();
    $userResult = $userQuery->get_result();

    if ($userResult->num_rows > 0) {
        $user = $userResult->fetch_assoc();
        $userEmail = $user['email'];

        // Fetch batches associated with the user's email
        $batchQuery = $conn->prepare("SELECT b.*, u.uname FROM batch b JOIN user u ON b.email = u.email WHERE b.email = ?");
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
                    <source src="res/learn.mp4" type="video/mp4">
                </video>
            </div>

            <h1 class="FBE">Find Batch Earner</h1>

            <form action="search.php" method="GET">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required><br>
                <button type="submit" class="view-link">Search</button>
            </form>
        </div>

        <div class="batchstore">
            <?php if (empty($batches)): ?>
                <p>No batches added yet.</p>
            <?php else: ?>
                <h2 class="searchtopic"><?php echo htmlspecialchars($batches[0]['uname']); ?>'s Batches</h2>
                <div class="card-container">
                    <?php foreach ($batches as $batch): ?>
                        <div class="batch-card">
                            <h3><?php echo htmlspecialchars($batch['name']); ?></h3>
                            <a href="<?php echo htmlspecialchars($batch['verify_url']); ?>" target="_blank">
                                <img src="<?php echo htmlspecialchars($batch['image_url']); ?>" alt="<?php echo htmlspecialchars($batch['name']); ?>" class="batch-image">
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

    </div>
</body>
</html>
