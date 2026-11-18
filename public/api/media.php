<?php

declare(strict_types=1);

use Lab14\SecureMediaService;

require dirname(__DIR__, 2) . '/config/bootstrap.php';

try {
    $media = (new SecureMediaService())->getMedia();
    header('Content-Type: ' . $media['contentType']);
    header('Cache-Control: private, max-age=60');
    header('ETag: "' . $media['etag'] . '"');
    header('X-Content-Type-Options: nosniff');
    echo $media['body'];
} catch (Throwable $exception) {
    http_response_code(502);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['ok' => false, 'message' => $exception->getMessage()], JSON_UNESCAPED_UNICODE);
}

