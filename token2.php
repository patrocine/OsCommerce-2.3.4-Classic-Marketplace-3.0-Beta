<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

$apiKey = "api9374ae215ce64d85038b324491510";

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo json_encode(array("error" => "Token ID no especificado"));
    exit;
}

$tokenId = $_GET['id'];
$type = isset($_GET['type']) ? $_GET['type'] : "token";

if ($type === "pools") {
    $url = "https://api.saucerswap.finance/tokens/associated-pools/" . urlencode($tokenId);
} else {
    $url = "https://api.saucerswap.finance/tokens/" . urlencode($tokenId);
}

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "x-api-key: " . $apiKey
));
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo json_encode(array("error" => curl_error($ch)));
    curl_close($ch);
    exit;
}

curl_close($ch);

echo $response;

