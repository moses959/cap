<?php
//require __DIR__ . '/../vendor/autoload.php';

//use GuzzleHttp\Client;

if (!isset($_FILES['image'])) {
    die('請上傳圖片');
}
$apiToken = $_ENV['HUGGINGFACE_API_TOKEN'];
//echo $apiToken;
$tmpFile = $_FILES['image']['tmp_name'];
$imageData = file_get_contents($tmpFile);

$ch = curl_init();

// 設定 cURL 選項
curl_setopt($ch, CURLOPT_URL, 'https://api-inference.huggingface.co/models/nlpconnect/vit-gpt2-image-captioning');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $apiToken,
    'Content-Type: application/octet-stream'
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, $imageData);

// 執行請求
$response = curl_exec($ch);

$result = json_decode($response, true);
$caption = $result[0]['generated_text'] ?? '未能產生描述';

header('Location: /?caption=' . urlencode($caption));
?>
