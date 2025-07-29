<?php
$baseDir = 'study-materials';
$classes = array_filter(scandir($baseDir), function($f) use ($baseDir) {
    return is_dir("$baseDir/$f") && !in_array($f, ['.', '..']);
});
?>
<!DOCTYPE html>
<html>
<head>
    <title>Study Material Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <h2 class="mb-4 text-center">📘 Select Your Class</h2>
    <div class="row">
    <?php foreach($classes as $class): ?>
        <div class="col-md-2 mb-3">
            <a href="division.php?class=<?= urlencode($class) ?>" class="btn btn-outline-primary w-100 py-3">Class <?= htmlspecialchars($class) ?></a>
        </div>
    <?php endforeach; ?>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>