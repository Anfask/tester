<?php
$class = $_GET['class'] ?? '';
$baseDir = "study-materials/$class";
$divisions = [];
if (is_dir($baseDir)) {
    $divisions = array_filter(scandir($baseDir), function($f) use ($baseDir) {
        return is_dir("$baseDir/$f") && !in_array($f, ['.', '..']);
    });
    sort($divisions);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>YES IQRA SCHOOL - Study Material Portal</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      min-height: 100vh;
      position: relative;
      overflow-x: hidden;
      color: #333;
    }

    /* Animated background particles */
    .bg-animation {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      pointer-events: none;
      z-index: -1;
    }

    .particle {
      position: absolute;
      background: rgba(0, 123, 255, 0.1);
      border-radius: 50%;
      animation: float 6s ease-in-out infinite;
    }

    .particle:nth-child(1) { width: 80px; height: 80px; top: 20%; left: 10%; animation-delay: 0s; }
    .particle:nth-child(2) { width: 120px; height: 120px; top: 60%; left: 85%; animation-delay: 2s; }
    .particle:nth-child(3) { width: 60px; height: 60px; top: 80%; left: 20%; animation-delay: 4s; }

    @keyframes float {
      0%, 100% { transform: translateY(0px) rotate(0deg); opacity: 0.3; }
      50% { transform: translateY(-20px) rotate(180deg); opacity: 0.6; }
    }

    /* Header */
    .header {
      text-align: center;
      padding: 2em 2em 1em;
      background: rgba(255, 255, 255, 0.9);
      backdrop-filter: blur(20px);
      border-bottom: 2px solid rgba(0, 123, 255, 0.1);
      box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
      animation: slideDown 1s ease-out;
    }

    .back-btn {
      position: absolute;
      left: 2em;
      top: 2em;
      background: rgba(108, 117, 125, 0.1);
      border: 1px solid rgba(108, 117, 125, 0.3);
      border-radius: 10px;
      padding: 0.8em 1.5em;
      color: #495057;
      text-decoration: none;
      font-size: 0.9em;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      gap: 0.5em;
    }

    .back-btn:hover {
      background: rgba(108, 117, 125, 0.2);
      transform: translateX(-5px);
    }

    .header .logo {
      width: 500px;
      height: 80px;
      margin: 0 auto 1em;
      border-radius: 15px;
      transition: transform 0.3s ease;
    }

    .header .logo:hover {
      transform: scale(1.05);
    }

    .header p {
      color: #495057;
      font-size: 1.2em;
      font-weight: 400;
      letter-spacing: 0.5px;
      margin-top: 1em;
    }

    .section-title {
      text-align: center;
      color: #333;
      font-size: 1.8em;
      font-weight: 600;
      margin-bottom: 2em;
      opacity: 0;
      animation: fadeInUp 1s ease-out 0.5s forwards;
    }

    @keyframes slideDown {
      from { transform: translateY(-100px); opacity: 0; }
      to { transform: translateY(0); opacity: 1; }
    }

    /* Main content */
    main {
      max-width: 1200px;
      margin: 4em auto 2em;
      padding: 0 2em;
    }

    .class-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
      gap: 2em;
      margin-top: 2em;
    }

    .card {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(20px);
      border-radius: 20px;
      border: 1px solid rgba(0, 123, 255, 0.1);
      padding: 2em;
      text-decoration: none;
      color: #333;
      transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      position: relative;
      overflow: hidden;
      animation: fadeInUp 0.8s ease-out forwards;
      opacity: 0;
      transform: translateY(50px);
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .card::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(0, 123, 255, 0.1), transparent);
      transition: left 0.6s;
    }

    .card:hover::before {
      left: 100%;
    }

    .card:nth-child(n) {
      animation-delay: calc(0.1s * var(--i));
    }

    .card:hover {
      transform: translateY(-15px) scale(1.05);
      background: rgba(255, 255, 255, 1);
      box-shadow: 0 20px 40px rgba(0, 123, 255, 0.2);
    }

    .card-icon {
      font-size: 3em;
      margin-bottom: 1em;
      background: linear-gradient(45deg, #007bff, #28a745);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      text-align: center;
    }

    .card-title {
      font-size: 1.4em;
      font-weight: 600;
      margin-bottom: 0.5em;
      text-align: center;
      color: #333;
    }

    .card-subtitle {
      color: #6c757d;
      font-size: 0.95em;
      text-align: center;
      margin-bottom: 1em;
    }

    .card-stats {
      display: flex;
      justify-content: space-between;
      font-size: 0.85em;
      color: #868e96;
    }

    @keyframes fadeInUp {
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    footer {
      text-align: center;
      padding: 2em;
      font-size: 0.9em;
      color: #6c757d;
      border-top: 2px solid rgba(0, 123, 255, 0.1);
      margin-top: 3em;
      background: rgba(255, 255, 255, 0.8);
      backdrop-filter: blur(10px);
    }

    /* Responsive design */
    @media (max-width: 768px) {
      .header .logo {
        width: 400px;
        height: 80px;
      }
      
      .class-grid {
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 1.5em;
      }

      .back-btn {
        position: static;
        margin-bottom: 1em;
        align-self: flex-start;
      }

      .header {
        padding-top: 1em;
      }
    }

    @media (max-width: 480px) {
      .header .logo {
        width: 300px;
        height: 60px;
      }
      
      .class-grid {
        grid-template-columns: 1fr;
      }
      
      main {
        padding: 0 1em;
      }
    }
  </style>
</head>
<body>
  <div class="bg-animation">
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
  </div>

  <div class="header">
    <a href="index.php" class="back-btn">
      <i class="fas fa-arrow-left"></i>
      Back to Classes
    </a>
    
    <img src="logo.png" alt="YES IQRA SCHOOL Logo" class="logo">
    <p>Your Gateway to Collaborative Learning & Study Materials</p>
  </div>

  <main>
    <h2 class="section-title">Select Your Division - Class <?= htmlspecialchars($class) ?></h2>
    <div class="class-grid">
      <?php 
      $divisionNames = ['A', 'B', 'C', 'D', 'E'];
      $divisionLabels = [
        'A' => "Foundation Learning",
        'B' => "Early Development",
        'C' => "Intermediate Learning",
        'D' => "Advanced Learning",
        'E' => "Excellence Track"
      ];
      
      for ($i = 0; $i < 3; $i++):
        $divName = $divisionNames[$i];
      ?>
      <a href="subject.php?class=<?= urlencode($class) ?>&div=<?= urlencode($divName) ?>" class="card" style="--i:<?= $i + 1 ?>">
        <div class="card-icon">
          <i class="fas fa-door-open"></i>
        </div>
        <div class="card-title"><?= htmlspecialchars($class) ?> <?= $divName ?></div>
        <div class="card-subtitle"><?= $divisionLabels[$divName] ?></div>
        <div class="card-stats"></div>
      </a>
      <?php endfor; ?>
    </div>
  </main>

  <footer>
    &copy; 2025 YES IQRA SCHOOL TV Portal. All rights reserved.
  </footer>
</body>
</html>
