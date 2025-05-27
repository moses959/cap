<?php
//require __DIR__ . '/../vendor/autoload.php';

//use GuzzleHttp\Client;

if (!isset($_FILES['image'])) {
    die('請上傳圖片');
}

$tmpFile = $_FILES['image']['tmp_name'];
$imageData = file_get_contents($tmpFile);

$client = new Client();
$response = $client->request('POST', 'https://api-inference.huggingface.co/models/nlpconnect/vit-gpt2-image-captioning', [
    'headers' => [
        'Authorization' => 'Bearer ' . getenv('HUGGINGFACE_API_TOKEN'),
        'Content-Type' => 'application/octet-stream'
    ],
    'body' => $imageData
]);

$result = json_decode($response->getBody(), true);
$caption = $result[0]['generated_text'] ?? '未能產生描述';

header('Location: /?caption=' . urlencode($caption));
