<?php
// Серверне кешування у змінній сесії
session_start();
$start = microtime(true);
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

if (isset($_SESSION['rates_cache'])) {
    $status = 'HIT';
    $data = $_SESSION['rates_cache'];
} else {
    $status = 'MISS';
    sleep(2);                                    // «дорогі» обчислення
    $data = [
        'USD' => round(41 + mt_rand(0, 100) / 100, 2),
        'EUR' => round(45 + mt_rand(0, 100) / 100, 2),
        'PLN' => round(10 + mt_rand(0, 100) / 100, 2),
        'generated_at' => date('H:i:s'),
    ];
    $_SESSION['rates_cache'] = $data;
}
echo json_encode([
    'cache' => $status,
    'time_sec' => round(microtime(true) - $start, 4),
    'rates' => $data,
], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
