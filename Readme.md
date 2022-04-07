# 3 Different ways to make HTTP Requests in PHP

This repo use Amadeus Self-Service API as examples to show how to make HTTP Requests in PHP.

The APIs used in this repo are:
- **POST** [Access Granted Client Credentials](https://documenter.getpostman.com/view/2672636/RWEcPfuJ#f85a162b-a405-baed-cf93-d831bdde2342)
- **GET** [Airport Routes](https://documenter.getpostman.com/view/2672636/RWEcPfuJ#ce3cccf0-eed6-4998-8a47-f3058ecc705a)

The ways to make HTTP Requests used in this repo are:
- 1.[PHP’s HTTP/s stream wrapper](https://www.php.net/manual/en/wrappers.http.php)
- 2.[PHP’s cURL extension](https://www.php.net/manual/en/intro.curl.php)
- 3.[GuzzleHTTP](https://docs.guzzlephp.org/en/stable/)

### Before start
1. Use composer to install all the dependencies.
```
composer install
```
2. Edit ```.env``` file and Replace the ```API_ID``` AND ```API_SECRET``` by your Amadeus API ID and Secret.
```
API_ID = REPLACE_BY_YOUR_ID
API_SECRET = REPLACE_BY_YOUR_SECRET
```

### Pay attention to see try different outputs, have fun :)