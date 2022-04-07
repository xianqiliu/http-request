<?php

declare(strict_types=1);

use Dotenv\Dotenv;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

require_once('../vendor/autoload.php');

$dotenv = Dotenv::createImmutable('../');
$dotenv->load();

$httpClient = new Client([
    'base_uri' => 'https://test.api.amadeus.com',
    'http_errors' => false,
    'verify' => false
]);

// Authorization POST
$path4Auth = "/v1/security/oauth2/token";

$apiId = $_ENV['API_ID'];
$apiSecret = $_ENV['API_SECRET'];

try {
    $response4Auth = $httpClient->post('/v1/security/oauth2/token', [
        'headers' => [
            'Content-Type' => 'application/x-www-form-urlencoded',
        ],
        'form_params' => [
            'grant_type' => 'client_credentials',
            'client_id' => $apiId,
            'client_secret' => $apiSecret
        ],
    ]);

    // Print Response Headers (Array)
    print_r($response4Auth->getHeaders());

    // Print Response Body (Array)
    $responseBody4AuthAsArray = json_decode($response4Auth->getBody()->__toString(), true);
    print_r($responseBody4AuthAsArray);

    // Print Access Token
    $apiAccessToken = $responseBody4AuthAsArray['access_token'];
    print($apiAccessToken."\n");

    // Example Airport Route API GET
    $response = $httpClient->get('/v1/airport/direct-destinations', [
        'headers' => [
            'Authorization' => 'Bearer ' . $apiAccessToken,
        ],
        'query' => [
            "departureAirportCode" => "MAD",
            "max" => 2
        ]
    ]);

    // Print response body as object
    $resultAsObject = json_decode($response->getBody()->__toString());
    print_r($resultAsObject);
} catch (GuzzleException $e) {
    echo $e;
}

