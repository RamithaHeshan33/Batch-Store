<?php
    require '../nav/afternav.php';

    // Redirect if the user is not logged in
    if (!isset($_SESSION['email'])) {
        header('Location: ../login.php');
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="about.css">
</head>
<body>
    <div class="about1">
        <img src="../res/about1.jpg" alt="about1">

        <div class="content">
            <h1>About the Platform</h1>
            <p>Batch Store is a dynamic and user-friendly platform designed to showcase your learning achievements and share them with a vibrant
             community. Whether you’ve earned a badge for completing a course, attending a workshop, or mastering a skill, Batch Store
              provides a dedicated space to organize and display your accomplishments. With intuitive features, seamless navigation, and a
               clean interface, the platform makes it easy for users to upload, categorize, and admire learning batches. Join us to celebrate
                your milestones and inspire others to embark on their learning journeys!</p>
        </div>
    </div>

    <div class="about2">
        <div class="content">
            <h1>Community and Sharing</h1>
            <p>At Batch Store, we believe in the power of connection and collaboration. Our platform is built to foster a supportive community
             where users can share their learning achievements and inspire one another. Whether you’re showcasing your hard-earned badges or
              exploring the accomplishments of others, Batch Store provides a space to celebrate collective growth. Engage with like-minded
               individuals, exchange ideas, and create meaningful connections that go beyond the digital badges. Together, we’re building a
                culture of learning, recognition, and encouragement.</p>
        </div>

        <img src="../res/about2.jpg" alt="about2">
    </div>
</body>
</html>