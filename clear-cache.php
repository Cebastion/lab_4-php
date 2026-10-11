<?php
// Очищення файлового та сесійного кешу
session_start();
unset($_SESSION['rates_cache']);
$f = __DIR__ . '/cache/report.html';
if (file_exists($f)) unlink($f);
header('Content-Type: text/plain; charset=utf-8');
echo "Кеш (файл + сесія) очищено";
