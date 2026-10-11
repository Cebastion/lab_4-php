<?php
// Серверне кешування через статичну властивість класу
class StaticCache
{
    private static array $store = [];

    public static function get(string $key)
    {
        return self::$store[$key] ?? null;
    }
    public static function set(string $key, $value): void
    {
        self::$store[$key] = $value;
    }
    public static function remember(string $key, callable $producer)
    {
        if (!array_key_exists($key, self::$store)) {
            self::$store[$key] = $producer();
            echo "[MISS] $key обчислено\n";
        } else {
            echo "[HIT]  $key взято з кешу\n";
        }
        return self::$store[$key];
    }
    public static function clear(): void
    {
        self::$store = [];
    }
}

header('Content-Type: text/plain; charset=utf-8');
header('Cache-Control: no-store');

$slow = function () { sleep(2); return ['USD' => 41.5, 'EUR' => 45.2]; };

for ($i = 1; $i <= 3; $i++) {
    $t = microtime(true);
    StaticCache::remember('rates', $slow);
    printf("Виклик %d: %.4f с\n\n", $i, microtime(true) - $t);
}
StaticCache::clear();
echo "Кеш очищено\n";
$t = microtime(true);
StaticCache::remember('rates', $slow);
printf("Після очищення: %.4f с\n\n", microtime(true) - $t);
echo "Примітка: статична властивість живе лише в межах одного запиту PHP.\n";
