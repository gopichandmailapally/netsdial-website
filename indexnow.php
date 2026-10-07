<?php
/**
 * NetsDial – IndexNow Automated Search Ingestion
 * Instantly alerts Bing, Microsoft Copilot, and ChatGPT Search of all live URLs
 */

$host = "netsdial.com";
$key  = "b8d7c9e2f4a148f395e21c6e4a8b72c9";
$keyLocation = "https://" . $host . "/" . $key . ".txt";

$coreUrls = [
    "https://" . $host . "/",
    "https://" . $host . "/about.php",
    "https://" . $host . "/about-netsdial.php",
    "https://" . $host . "/estimation.php",
    "https://" . $host . "/reviews.php",
    "https://" . $host . "/faq.php",
    "https://" . $host . "/contact.php",
    "https://" . $host . "/gallery.php",
    "https://" . $host . "/videos.php",
    "https://" . $host . "/blogs.php",
    "https://" . $host . "/sitemap.xml",
    "https://" . $host . "/llms.txt",
    "https://" . $host . "/services/hyderabad/",
    "https://" . $host . "/services/hyderabad/kukatpally/",
    "https://" . $host . "/services/hyderabad/gachibowli/",
    "https://" . $host . "/services/hyderabad/madhapur/",
    "https://" . $host . "/services/hyderabad/kondapur/",
    "https://" . $host . "/services/hyderabad/secunderabad/",
    "https://" . $host . "/services/visakhapatnam/",
    "https://" . $host . "/services/vijayawada/",
    "https://" . $host . "/services/bengaluru/",
    "https://" . $host . "/services/chennai/",
    "https://" . $host . "/services/mumbai/"
];

$payload = json_encode([
    "host"        => $host,
    "key"         => $key,
    "keyLocation" => $keyLocation,
    "urlList"     => $coreUrls
], JSON_UNESCAPED_SLASHES);

$ch = curl_init("https://api.indexnow.org/indexnow");
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json; charset=utf-8",
    "Content-Length: " . strlen($payload)
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

header("Content-Type: application/json");
if ($httpCode === 200 || $httpCode === 202) {
    echo json_encode([
        "ok" => true,
        "message" => "Successfully submitted " . count($coreUrls) . " URLs to IndexNow (Bing & ChatGPT Search)",
        "httpCode" => $httpCode
    ]);
} else {
    echo json_encode([
        "ok" => false,
        "message" => "IndexNow submission returned code: " . $httpCode,
        "response" => $response
    ]);
}
