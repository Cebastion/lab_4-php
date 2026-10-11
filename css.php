<?php
// Приклад 1 клієнтського кешування: Cache-Control + Expires (на 1 день)
header('Content-Type: text/css; charset=utf-8');
header('Cache-Control: public, max-age=86400');
header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 86400) . ' GMT');
?>
body { font-family: Arial, sans-serif; margin: 2rem auto; max-width: 900px; background: #f5f7fa; color: #222; }
h1, h2 { color: #1a4d8f; }
button, a.btn { background: #1a4d8f; color: #fff; border: 0; padding: .5rem 1rem; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block; margin: .2rem; }
table { border-collapse: collapse; width: 100%; background: #fff; }
th, td { border: 1px solid #ccc; padding: 4px 8px; text-align: left; }
pre { background: #222; color: #9f9; padding: 1rem; border-radius: 4px; white-space: pre-wrap; }
