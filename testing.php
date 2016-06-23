<?php
/**
 * Created by PhpStorm.
 * User: gurez
 * Date: 10.06.2016
 * Time: 20:46
 */
require __DIR__.'/vendor/autoload.php';
use GuzzleHttp\Client;
$client = new Client([
    'base_url' => 'http://localhost:8000/',
    'defaults' => [
        'headers' => ['Authorization' => 'Bearer YmU4YjU2NDg0ZmEyM2M2MDhhOGFiNjg1NWE0ZTQ1NzhiNzQyZTI1NjIwNzUyYzljZDcxZTIyNmI5MzEzYmYyOA'],
        'exceptions' => false
    ]
]);
    //авторизация
    //$req = $client->createRequest('POST', 'oauth/v2/token', ['json' => ["client_id"=>"17_5u32ts0jgcso8c0ogkssg8kogogw8c8oc8skok0ckswkc000w8","client_secret"=>"43wbgjxck2g4ccg4o08gcgo4os8g8og0gsoscwgwckw4wk0840","grant_type"=>"password","username"=>"Николай Гурецкий","password"=>"y6J1Yl1dMp"]]);
    //$req = $client->createRequest('POST','resetpassord',['json' => ["email"=>"test3@gmail.com"]]);
    //$response = $client->send($req);

echo "<br>";
echo $response;
