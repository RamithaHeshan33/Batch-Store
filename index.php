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
  <title>Document</title>
  <style>
    .para {
      max-width: 1000px;
      padding: 20px;
    }

    .para h1 {
      font-size: 2.5rem;
      font-weight: 700;
      margin-bottom: 20px;
      color: #333;
    }

    .para p {
      font-size: 1.2rem;
      line-height: 1.6;
      margin-bottom: 20px;
    }

    .home {
      margin-top: 12%;
      display: flex;
      text-align: justify;
      justify-content: right;
      align-items: center;
      padding: 20px;
    }


  </style>
</head>
<body>
  <div class="home">
    <br><br><br><br>
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
</body>
</html>