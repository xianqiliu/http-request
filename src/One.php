<?php

declare(strict_types=1);

use Dotenv\Dotenv;

require_once('../vendor/autoload.php');

$dotenv = Dotenv::createImmutable('../');
$dotenv->load();

// Authorization POST
$auth_url = "https://test.api.amadeus.com/v1/security/oauth2/token";

$apiId = $_ENV['API_ID'];
$apiSecret = $_ENV['API_SECRET'];

// Prepare post body
$postData4Auth = http_build_query(
    array(
        "client_id" => $apiId,
        "client_secret" => $apiSecret,
        "grant_type" => "client_credentials"
    )
);

$opts = array(
    "http" => array(
        "header" => "Content-type: application/x-www-form-urlencoded",
        "method" => "POST",
        "content" => $postData4Auth
    )
);

$context = stream_context_create($opts);

// Print the response as Json string
$response4AuthAsJsonString = file_get_contents($auth_url, false, $context);
print($response4AuthAsJsonString);

// Print the response as array
$response4AuthAsArray = json_decode($response4AuthAsJsonString, true);
print_r($response4AuthAsArray);

// Print the Access token
print($response4AuthAsArray['access_token']."\n");

// Example - Airport route API GET
const BASE_URL = "https://test.api.amadeus.com/v1/airport/direct-destinations";

// Prepare query string
$queryString = http_build_query([
    "departureAirportCode" => "MAD",
    "max" => 2
]);

// Print the request url
$request_url =  BASE_URL.'?'.$queryString;
print($request_url."\n");

$opts = array(
    "http" => array(
        "header" => "Authorization: Bearer ".$response4AuthAsArray['access_token'],
    )
);

$context = stream_context_create($opts);

// Print response as string
$responseAsString = file_get_contents($request_url, false, $context);
print($responseAsString);

// Print response as array
$responseAsArray = json_decode($responseAsString, true);
print_r($responseAsArray);

// Print response["data"]
print_r($responseAsArray['data']);

// Print response as object
$responseAsObject = json_decode($responseAsString);
print_r($responseAsObject);

// Print responseObject {'data'}
print_r($responseAsObject->{'data'});