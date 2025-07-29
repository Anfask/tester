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
    <style>.box{display:inline-block;padding:20px;margin:10px;background:#dff0d8;border-radius:10px;text-align:center;}</style>
</head>
<body>
    <h2>📒 Subjects in Class <?= htmlspecialchars($class) ?> Division <?= htmlspecialchars($div) ?></h2>
    <?php foreach($subjects as $sub): ?>
        <div class="box">
            <a href="content.php?class=<?= urlencode($class) ?>&div=<?= urlencode($div) ?>&sub=<?= urlencode($sub) ?>">
                <?= htmlspecialchars($sub) ?>
            </a>
        </div>
    <?php endforeach; ?>
</body>
</html>
