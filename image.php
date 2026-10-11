<?php
// Приклад 2 клієнтського кешування: ETag + Last-Modified + умовні запити (304 Not Modified)
$lastModified = filemtime(__FILE__);                 // "версія" ресурсу = час зміни скрипта
$etag = '"' . md5($lastModified . 'logo-v1') . '"';

header('Content-Type: image/svg+xml');
header('Cache-Control: public, max-age=3600, must-revalidate');
header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 3600) . ' GMT');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $lastModified) . ' GMT');
header('ETag: ' . $etag);

$ifNoneMatch = $_SERVER['HTTP_IF_NONE_MATCH'] ?? '';
$ifModSince  = $_SERVER['HTTP_IF_MODIFIED_SINCE'] ?? '';

if ($ifNoneMatch === $etag || ($ifModSince && strtotime($ifModSince) >= $lastModified)) {
    http_response_code(304);   // тіло не передається — браузер бере копію з кешу
    exit;
}
?>
<svg xmlns="http://www.w3.org/2000/svg" width="300" height="120">
  <rect width="300" height="120" rx="12" fill="#1a4d8f"/>
  <circle cx="60" cy="60" r="32" fill="#ffd54f"/>
  <text x="110" y="68" font-size="26" fill="#fff" font-family="Arial">Lab 4 Cache</text>
</svg>
