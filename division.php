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
    <style>.box{display:inline-block;padding:20px;margin:10px;background:#d9edf7;border-radius:10px;text-align:center;}</style>
</head>
<body>
    <h2>📗 Divisions in Class <?= htmlspecialchars($class) ?></h2>
    <?php foreach($divisions as $div): ?>
        <div class="box">
            <a href="subject.php?class=<?= urlencode($class) ?>&div=<?= urlencode($div) ?>">Division <?= htmlspecialchars($div) ?></a>
        </div>
    <?php endforeach; ?>
</body>
</html>
