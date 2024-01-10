<?php
//require_once "includes/utility_services.php";

if (true) {

    //build the headers
    $headers = ['alg' => 'HS256', 'typ' => 'JWT'];
    $headers_encoded = base64url_encode(json_encode($headers));

    //build the payload
    $payload = ['sub' => '1234567890', 'name' => 'John Doe', 'admin' => true];
    $payload_encoded = base64url_encode(json_encode($payload));
    //build the signature
    $key = 'secret';
    $signature = hash_hmac('sha256', "$headers_encoded.$payload_encoded", $key, true);
    $signature_encoded = base64url_encode($signature);

    //build and return the token
    $token = "$headers_encoded.$payload_encoded.$signature_encoded";

    $jsonResponse = array(
        'jwt' => $token,
        'key' => 'secret',
        'server' => 'hamgorooh',
    );
    echo json_encode($jsonResponse);
}
