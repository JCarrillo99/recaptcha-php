<?php
require __DIR__ . '/../vendor/autoload.php';

use LSX\Recaptcha\Recaptcha;

// Configurar CORS
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json');

// Manejar preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Para recibir datos JSON desde Postman
$input = json_decode(file_get_contents('php://input'), true);
$token = $input['token'] ?? '';
$version = $input['version'] ?? 'v2_checkbox';

$recaptcha = new Recaptcha();
try {
    $result = $recaptcha->verify($token, $version);
    echo json_encode(['success' => true, 'data' => $result]);
} catch (\Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
