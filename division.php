<?php
$class = $_GET['class'] ?? '';
$baseDir = "study-materials/$class";
$divisions = array_filter(scandir($baseDir), function($f) use ($baseDir) {
    return is_dir("$baseDir/$f") && !in_array($f, ['.', '..']);
});
?>
<!DOCTYPE html>
<html>
<head>
    <title>Divisions - Class <?= htmlspecialchars($class) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <h2 class="mb-4 text-center">📗 Divisions in Class <?= htmlspecialchars($class) ?></h2>
    <div class="row">
    <?php foreach($divisions as $div): ?>
        <div class="col-md-3 mb-3">
            <a href="subject.php?class=<?= urlencode($class) ?>&div=<?= urlencode($div) ?>" class="btn btn-outline-info w-100 py-3">Division <?= htmlspecialchars($div) ?></a>
        </div>
    <?php endforeach; ?>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>