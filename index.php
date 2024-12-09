<?php
  session_start();
  require 'connection.php';
  require 'nav/nav.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="index.css">
</head>
<body>
  <video class="video-background" autoplay loop muted>
      <source src="res/learn.mp4" type="video/mp4">
      Your browser does not support the video tag.
  </video>
  <div class="home">
    <div class="content">
      <div class="para">
          <h1>Batch Store – Your Digital Batch Repository</h1>
          <p class="items-justify">
              Welcome to <strong>Batch Store</strong>, BatchSaver is a powerful and user-friendly platform designed to help you securely 
              store, organize, and showcase your digital batches. Whether you’re tracking achievements, certifications, or professional 
              milestones, BatchSaver ensures your valuable records are always accessible and beautifully presented. Start building your
               personalized batch collection today and take pride in your accomplishments with BatchSaver!
          </p>
          <div class="social items-center space-x-4 mt-4">
              <a href="https://github.com/RamithaHeshan33" target="_blank"><i class='bx bxl-github'></i></a>
              <a href="https://www.linkedin.com/in/ramithaheshan/" target="_blank"><i class='bx bxl-linkedin'></i></a>
              <a href="https://www.youtube.com/@RamithaHeshan" target="_blank"><i class='bx bxl-youtube'></i></a>
          </div>
      </div>
    </div>
      
  </div>
</body>
</html>