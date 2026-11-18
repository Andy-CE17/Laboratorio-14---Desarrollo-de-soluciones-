<?php

declare(strict_types=1);

use Lab14\SecureMediaService;

require dirname(__DIR__, 2) . '/config/bootstrap.php';

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

try {
    $status = (new SecureMediaService())->getStatus();
    echo json_encode(['ok' => true, 'data' => $status], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
} catch (Throwable $exception) {
    http_response_code(502);
    echo json_encode(['ok' => false, 'message' => $exception->getMessage()], JSON_UNESCAPED_UNICODE);
}

