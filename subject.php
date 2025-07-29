<?php
$class = $_GET['class'] ?? '';
$div = $_GET['div'] ?? '';
$baseDir = "study-materials/$class/$div";
$subjects = array_filter(scandir($baseDir), function($f) use ($baseDir) {
    return is_dir("$baseDir/$f") && !in_array($f, ['.', '..']);
});
?>
<!DOCTYPE html>
<html>
<head>
    <title>Subjects - Class <?= htmlspecialchars($class) ?> <?= htmlspecialchars($div) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <h2 class="mb-4 text-center">📒 Subjects in Class <?= htmlspecialchars($class) ?> Division <?= htmlspecialchars($div) ?></h2>
    <div class="row">
    <?php foreach($subjects as $sub): ?>
        <div class="col-md-3 mb-3">
            <a href="content.php?class=<?= urlencode($class) ?>&div=<?= urlencode($div) ?>&sub=<?= urlencode($sub) ?>" class="btn btn-outline-success w-100 py-3"><?= htmlspecialchars($sub) ?></a>
        </div>
    <?php endforeach; ?>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>