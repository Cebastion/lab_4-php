<?php
// Серверне кешування у файл (TTL = 10 хвилин)
$start     = microtime(true);
$cacheDir  = __DIR__ . '/cache';
$cacheFile = $cacheDir . '/report.html';
$ttl       = 10 * 60;

if (!is_dir($cacheDir)) mkdir($cacheDir, 0777, true);

header('Content-Type: text/html; charset=utf-8');
header('Cache-Control: no-store');       // щоб браузер не плутав клієнтський кеш із серверним

if (file_exists($cacheFile) && (time() - filemtime($cacheFile)) < $ttl) {
    $status = 'HIT';
    $html = file_get_contents($cacheFile);
} else {
    $status = 'MISS';
    sleep(3);                            // імітація довгої обробки
    $names = ['Іван', 'Олена', 'Петро', 'Марія', 'Андрій', 'Наталія', 'Олег', 'Софія'];
    $html = "<table>\n<tr><th>#</th><th>Ім'я</th><th>Сума, грн</th><th>Дата</th></tr>\n";
    for ($i = 1; $i <= 1000; $i++) {
        $name = $names[array_rand($names)];
        $sum  = number_format(mt_rand(100, 100000) / 100, 2, '.', ' ');
        $date = date('Y-m-d', time() - mt_rand(0, 365) * 86400);
        $html .= "<tr><td>$i</td><td>$name</td><td>$sum</td><td>$date</td></tr>\n";
    }
    $html .= "</table>\n";
    $html .= '<!-- generated at ' . date('H:i:s') . ' -->';
    file_put_contents($cacheFile, $html, LOCK_EX);
}

$elapsed = round(microtime(true) - $start, 4);
header("X-Cache: $status");
header("X-Exec-Time: $elapsed");
error_log("[report] $status, $elapsed s");     // логування
echo "<p><b>Кеш: $status</b>, час виконання: {$elapsed} с</p>\n" . $html;
