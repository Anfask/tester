<?php
$class = $_GET['class'] ?? '';
$div = $_GET['div'] ?? '';
$sub = $_GET['sub'] ?? '';
$baseDir = "study-materials/$class/$div/$sub";
$files = [];

if (is_dir($baseDir)) {
    $files = array_filter(scandir($baseDir), function($f) use ($baseDir) {
        return is_file("$baseDir/$f") && !in_array($f, ['.', '..']);
    });
    sort($files);
}

function getFileIcon($filename) {
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    switch ($ext) {
        case 'pdf': return ['icon' => 'fa-file-pdf', 'class' => 'pdf'];
        case 'doc':
        case 'docx': return ['icon' => 'fa-file-word', 'class' => 'doc'];
        case 'jpg':
        case 'jpeg':
        case 'png':
        case 'gif': return ['icon' => 'fa-file-image', 'class' => 'image'];
        case 'mp4':
        case 'avi':
        case 'mov': return ['icon' => 'fa-file-video', 'class' => 'video'];
        case 'mp3':
        case 'wav': return ['icon' => 'fa-file-audio', 'class' => 'audio'];
        case 'zip':
        case 'rar': return ['icon' => 'fa-file-archive', 'class' => 'archive'];
        default: return ['icon' => 'fa-file', 'class' => 'default'];
    }
}

function formatFileSize($bytes) {
    if ($bytes >= 1073741824) {
        return number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        return number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        return number_format($bytes / 1024, 2) . ' KB';
    } else {
        return $bytes . ' bytes';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Study Materials - YES IQRA SCHOOL</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="../favicon.ico" type="image/x-icon">
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
      width: 80px;
      height: 80px;
      margin: 0 auto 1em;
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;
      object-fit: contain;
    }

    .header h1 {
      color: #333;
      font-size: 2.2em;
      font-weight: 600;
      margin-bottom: 0.5em;
    }

    .header p {
      color: #495057;
      font-size: 1.1em;
      font-weight: 400;
      letter-spacing: 0.5px;
    }

    @keyframes slideDown {
      from { transform: translateY(-100px); opacity: 0; }
      to { transform: translateY(0); opacity: 1; }
    }

    /* Main content */
    main {
      max-width: 1200px;
      margin: 2em auto;
      padding: 0 2em;
    }

    /* Search and filter section */
    .controls {
      display: flex;
      gap: 1em;
      margin-bottom: 2em;
      flex-wrap: wrap;
      align-items: center;
    }

    .search-box {
      flex: 1;
      min-width: 250px;
      background: rgba(255, 255, 255, 0.9);
      border: 2px solid rgba(0, 123, 255, 0.2);
      border-radius: 25px;
      padding: 0.8em 1.5em;
      font-size: 1em;
      outline: none;
      transition: all 0.3s ease;
    }

    .search-box:focus {
      border-color: #007bff;
      box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
    }

    .filter-btn {
      background: rgba(255, 255, 255, 0.9);
      border: 2px solid rgba(0, 123, 255, 0.2);
      border-radius: 25px;
      padding: 0.8em 1.5em;
      cursor: pointer;
      transition: all 0.3s ease;
      font-size: 0.9em;
      color: #495057;
    }

    .filter-btn.active,
    .filter-btn:hover {
      background: #007bff;
      color: white;
      border-color: #007bff;
    }

    /* File grid */
    .file-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
      gap: 1.5em;
      margin-top: 2em;
    }

    .file-card {
      background: rgba(255, 255, 255, 0.95);
      border-radius: 15px;
      border: 1px solid rgba(0, 123, 255, 0.1);
      padding: 1.5em;
      text-decoration: none;
      color: #333;
      transition: all 0.4s ease;
      position: relative;
      overflow: hidden;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
      animation: fadeInUp 0.6s ease-out forwards;
      opacity: 0;
      transform: translateY(30px);
      cursor: pointer;
    }

    .file-card:nth-child(n) {
      animation-delay: calc(0.1s * var(--i));
    }

    .file-card:hover {
      transform: translateY(-10px) scale(1.02);
      box-shadow: 0 15px 35px rgba(0, 123, 255, 0.15);
      background: rgba(255, 255, 255, 1);
    }

    .file-icon {
      font-size: 2.5em;
      margin-bottom: 1em;
      text-align: center;
      height: 60px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .file-icon.pdf { color: #dc3545; }
    .file-icon.doc { color: #0d6efd; }
    .file-icon.image { color: #198754; }
    .file-icon.video { color: #fd7e14; }
    .file-icon.audio { color: #6f42c1; }
    .file-icon.archive { color: #6c757d; }
    .file-icon.default { color: #495057; }

    .file-name {
      font-size: 1.1em;
      font-weight: 600;
      margin-bottom: 0.5em;
      word-break: break-word;
      line-height: 1.3;
    }

    .file-info {
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 0.85em;
      color: #6c757d;
      margin-bottom: 1em;
    }

    .file-size {
      background: rgba(0, 123, 255, 0.1);
      padding: 0.3em 0.8em;
      border-radius: 20px;
      font-size: 0.8em;
    }

    .file-actions {
      display: flex;
      gap: 0.5em;
      margin-top: 1em;
    }

    .action-btn {
      flex: 1;
      padding: 0.6em;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-size: 0.8em;
      transition: all 0.3s ease;
      text-decoration: none;
      text-align: center;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.3em;
    }

    .view-btn {
      background: #007bff;
      color: white;
    }

    .view-btn:hover {
      background: #0056b3;
      transform: translateY(-2px);
    }

    @keyframes fadeInUp {
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Empty state */
    .empty-state {
      text-align: center;
      padding: 4em 2em;
      color: #6c757d;
    }

    .empty-state i {
      font-size: 4em;
      margin-bottom: 1em;
      opacity: 0.5;
    }

    /* Responsive design */
    @media (max-width: 768px) {
      .controls {
        flex-direction: column;
        align-items: stretch;
      }

      .search-box {
        min-width: auto;
      }

      .file-grid {
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 1em;
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
      .file-grid {
        grid-template-columns: 1fr;
      }

      main {
        padding: 0 1em;
      }
    }

    /* Footer */
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
  </style>
</head>
<body>
  <div class="bg-animation">
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
  </div>

  <div class="header">
    <a href="subject.php?class=<?= urlencode($class) ?>&div=<?= urlencode($div) ?>" class="back-btn">
      <i class="fas fa-arrow-left"></i>
      Back to Subjects
    </a>
    
    <img src="../logo.png" alt="YES IQRA SCHOOL Logo" class="logo">
    <h1>Class <?= htmlspecialchars($class) ?> <?= htmlspecialchars($div) ?> - <?= htmlspecialchars($sub) ?></h1>
    <p>Study Materials & Resources</p>
  </div>

  <main>
    <!-- Search and Filter Controls -->
    <div class="controls">
      <input type="text" class="search-box" placeholder="Search files..." id="searchBox">
      <button class="filter-btn active" data-filter="all">All Files</button>
      <button class="filter-btn" data-filter="pdf">PDF</button>
      <button class="filter-btn" data-filter="doc">Documents</button>
      <button class="filter-btn" data-filter="image">Images</button>
      <button class="filter-btn" data-filter="video">Videos</button>
    </div>

    <!-- File Grid -->
    <div class="file-grid" id="fileGrid">
      <?php if (empty($files)): ?>
        <!-- Sample files when no real files exist -->
        <div class="file-card" style="--i:1" data-type="pdf">
          <div class="file-icon pdf">
            <i class="fas fa-file-pdf"></i>
          </div>
          <div class="file-name">Mathematics Workbook.pdf</div>
          <div class="file-info">
            <span>Added: Jan 15, 2025</span>
            <span class="file-size">2.4 MB</span>
          </div>
          <div class="file-actions">
            <a href="#" class="action-btn view-btn">
              <i class="fas fa-eye"></i> View
            </a>
          </div>
        </div>

        <div class="file-card" style="--i:2" data-type="doc">
          <div class="file-icon doc">
            <i class="fas fa-file-word"></i>
          </div>
          <div class="file-name">Study Guide.docx</div>
          <div class="file-info">
            <span>Added: Jan 12, 2025</span>
            <span class="file-size">1.8 MB</span>
          </div>
          <div class="file-actions">
            <a href="#" class="action-btn view-btn">
              <i class="fas fa-eye"></i> View
            </a>
          </div>
        </div>

        <div class="file-card" style="--i:3" data-type="image">
          <div class="file-icon image">
            <i class="fas fa-file-image"></i>
          </div>
          <div class="file-name">Lesson Diagrams.png</div>
          <div class="file-info">
            <span>Added: Jan 10, 2025</span>
            <span class="file-size">856 KB</span>
          </div>
          <div class="file-actions">
            <a href="#" class="action-btn view-btn">
              <i class="fas fa-eye"></i> View
            </a>
          </div>
        </div>

        <div class="file-card" style="--i:4" data-type="video">
          <div class="file-icon video">
            <i class="fas fa-file-video"></i>
          </div>
          <div class="file-name">Tutorial Video.mp4</div>
          <div class="file-info">
            <span>Added: Jan 8, 2025</span>
            <span class="file-size">25.3 MB</span>
          </div>
          <div class="file-actions">
            <a href="#" class="action-btn view-btn">
              <i class="fas fa-play"></i> Play
            </a>
          </div>
        </div>
      <?php else: ?>
        <!-- Real files from directory -->
        <?php foreach ($files as $index => $file): 
          $filePath = "$baseDir/$file";
          $fileSize = file_exists($filePath) ? filesize($filePath) : 0;
          $fileIcon = getFileIcon($file);
          $fileDate = file_exists($filePath) ? date('M j, Y', filemtime($filePath)) : 'Unknown';
        ?>
        <div class="file-card" style="--i:<?= $index + 1 ?>" data-type="<?= $fileIcon['class'] ?>">
          <div class="file-icon <?= $fileIcon['class'] ?>">
            <i class="fas <?= $fileIcon['icon'] ?>"></i>
          </div>
          <div class="file-name"><?= htmlspecialchars($file) ?></div>
          <div class="file-info">
            <span>Added: <?= $fileDate ?></span>
            <span class="file-size"><?= formatFileSize($fileSize) ?></span>
          </div>
          <div class="file-actions">
            <a href="<?= htmlspecialchars($filePath) ?>" class="action-btn view-btn" target="_blank">
              <i class="fas fa-eye"></i> View
            </a>
          </div>
        </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>

    <!-- Empty State (show when no files match search/filter) -->
    <div class="empty-state" id="emptyState" style="display: none;">
      <i class="fas fa-folder-open"></i>
      <h3>No files found</h3>
      <p>Try adjusting your search or filter criteria</p>
    </div>
  </main>

  <footer>
    &copy; 2025 YES IQRA SCHOOL Portal. All rights reserved.
  </footer>

  <script>
    // Search functionality
    document.getElementById('searchBox').addEventListener('input', function(e) {
      const searchTerm = e.target.value.toLowerCase();
      const fileCards = document.querySelectorAll('.file-card');
      
      fileCards.forEach(card => {
        const filename = card.querySelector('.file-name').textContent.toLowerCase();
        if (filename.includes(searchTerm)) {
          card.style.display = 'block';
        } else {
          card.style.display = 'none';
        }
      });
      
      updateFileDisplay();
    });

    // Filter functionality
    document.querySelectorAll('.filter-btn').forEach(btn => {
      btn.addEventListener('click', function() {
        // Update active filter button
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        
        const filter = this.getAttribute('data-filter');
        const fileCards = document.querySelectorAll('.file-card');
        
        fileCards.forEach(card => {
          const cardType = card.getAttribute('data-type');
          if (filter === 'all' || cardType === filter) {
            card.style.display = 'block';
          } else {
            card.style.display = 'none';
          }
        });
        
        updateFileDisplay();
      });
    });

    // Update file display and show/hide empty state
    function updateFileDisplay() {
      const visibleCards = document.querySelectorAll('.file-card[style*="display: block"], .file-card:not([style*="display: none"])');
      const emptyState = document.getElementById('emptyState');
      
      if (visibleCards.length === 0) {
        emptyState.style.display = 'block';
      } else {
        emptyState.style.display = 'none';
      }
    }
  </script>
</body>
</html>
