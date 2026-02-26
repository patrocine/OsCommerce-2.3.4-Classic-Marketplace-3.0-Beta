<?php
// token.php

// Tu API key (solo aquí, nunca en el HTML)
$apiKey = "api9374ae215ce64d85038b324491510";

// Verificar que se envió ID del token
if (!isset($_GET['id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Token ID no especificado']);
    exit;
}

$tokenId = $_GET['id'];

// URL de SaucerSwap
$url = "https://api.saucerswap.finance/tokens/" . urlencode($tokenId);

// Inicializar cURL
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "x-api-key: $apiKey"
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if ($response === false || $httpCode != 200) {
    http_response_code(500);
    echo json_encode(['error' => 'Error al obtener token']);
    exit;
}

header('Content-Type: application/json');
echo $response;

