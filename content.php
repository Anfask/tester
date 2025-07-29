<?php
$class = $_GET['class'] ?? '';
$div = $_GET['div'] ?? '';
$sub = $_GET['sub'] ?? '';
$dir = "study-materials/$class/$div/$sub";
$files = array_diff(scandir($dir), ['.', '..']);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Contents - <?= htmlspecialchars($sub) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <h2 class="mb-4 text-center">📚 Materials for <?= htmlspecialchars($sub) ?> (Class <?= htmlspecialchars($class) ?> - <?= htmlspecialchars($div) ?>)</h2>
    <ul class="list-group">
        <?php foreach ($files as $file): ?>
            <li class="list-group-item">
                <a href="<?= $dir . '/' . urlencode($file) ?>" target="_blank">
                    <?= htmlspecialchars($file) ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>