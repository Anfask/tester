<?php
$baseDir = 'study-materials';
$classes = array_filter(scandir($baseDir), function($f) use ($baseDir) {
    return is_dir("$baseDir/$f") && !in_array($f, ['.', '..']);
});
?>

<!DOCTYPE html>
<html>
<head>
    <title>School Study Material Portal</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        .box { display: inline-block; padding: 20px; margin: 10px; background: #f0f0f0; border-radius: 10px; text-align: center; }
        a { text-decoration: none; color: black; }
    </style>
</head>
<body>
    <h2>📘 Select Your Class</h2>
    <?php foreach($classes as $class): ?>
        <div class="box">
            <a href="division.php?class=<?= urlencode($class) ?>">Class <?= htmlspecialchars($class) ?></a>
        </div>
    <?php endforeach; ?>
</body>
</html>
