<?php

declare(strict_types=1);

use Dotenv\Dotenv;

require_once('../vendor/autoload.php');

$dotenv = Dotenv::createImmutable('../');
$dotenv->load();

// Authorization POST
$url4Auth = "https://test.api.amadeus.com/v1/security/oauth2/token";

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

// Prepare headers for Auth POST
$headers4Auth = array(
    'Content-Type' => 'application/x-www-form-urlencoded'
);

// Init curl
$ch = curl_init();

// Set Url
curl_setopt($ch, CURLOPT_URL, $url4Auth);

// Set Header
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers4Auth);

// Transfer the return to string
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// For debug only
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

// Set Request Method and data
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postData4Auth);

// Execute then get result and info
$result4AuthAsArray = json_decode(curl_exec($ch), true); // Convert response json string to array
$info4Auth = curl_getinfo($ch);

// Close curl
curl_close($ch);

// Print Response Result as array
print_r($result4AuthAsArray);

// Print Curl info of this Request
print_r($info4Auth);

// Print AccessToken
$apiAccessToken = $result4AuthAsArray['access_token'];
print($apiAccessToken."\n");

// Example Airport Route API GET
$base_url = "https://test.api.amadeus.com/v1/airport/direct-destinations";

// Prepare query string
$queryString = http_build_query([
    "departureAirportCode" => "MAD",
    "max" => 2
]);

// Print http request url
$requestUrl = $base_url."?".$queryString;
print($requestUrl."\n");

// Prepare headers
$headers = array(
    'Authorization: Bearer '.$apiAccessToken
);

// Init curl
$ch = curl_init();

// Set Url
curl_setopt($ch, CURLOPT_URL, $requestUrl);

// Set Header
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

// Transfer the return to string
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

curl_setopt($ch, CURLOPT_HEADER, true);

// For debug only
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

// Execute then get result and info
$result = curl_exec($ch);
$info = curl_getinfo($ch);

$headerSize = curl_getinfo($ch , CURLINFO_HEADER_SIZE);
$headerStr = substr( $result , 0 , $headerSize );
$bodyStr = substr( $result , $headerSize );

// Close curl
curl_close($ch);

// Print response result as string
print($result);

// Print response data result as json object
print_r(json_decode($bodyStr));

// Print headers as array
print_r(headersToArray($headerStr));

// Function for converting headers from string to array
function headersToArray(string $str): array
{
    $headers = array();
    $headersTmpArray = explode( "\r\n" , $str );
    for ( $i = 0 ; $i < count( $headersTmpArray ) ; ++$i )
    {
        // we don't care about the two \r\n lines at the end of the headers
        if ( strlen( $headersTmpArray[$i] ) > 0 )
        {
            // the headers start with HTTP status codes, which do not contain a colon, so we can filter them out too
            if ( strpos( $headersTmpArray[$i] , ":" ) )
            {
                $headerName = substr( $headersTmpArray[$i] , 0 , strpos( $headersTmpArray[$i] , ":" ) );
                $headerValue = substr( $headersTmpArray[$i] , strpos( $headersTmpArray[$i] , ":" )+1 );
                $headers[$headerName] = $headerValue;
            }
        }
    }
    return $headers;
}











