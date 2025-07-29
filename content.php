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
</head>
<body>
    <h2>📚 Study Materials for <?= htmlspecialchars($sub) ?> (Class <?= htmlspecialchars($class) ?> - <?= htmlspecialchars($div) ?>)</h2>
    <ul>
        <?php foreach ($files as $file): ?>
            <li>
                <a href="<?= $dir . '/' . urlencode($file) ?>" target="_blank">
                    <?= htmlspecialchars($file) ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
