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
        'headers' => ['Authorization' => 'Bearer NjkwMWJiOTk1MTg2ZWRmMjM4ZWQ4MzQyNTU5NzI3ZWFiYjQ5ZjkxNWY2Yzc4YTdmMmI3NWE1NDY4MTM3NTQzNQ'],
        'exceptions' => false
    ]
]);
    //авторизация

   //$response = $client->get('oauth/v2/token?client_id=13_itp2b6b2rg0sksgkw4wo0kogk0o8csskkwcsk4g4kso0wgsg&client_secret=3p2yc18jflic8osgsogcwow0c8k884c00gs08c0wos8k8kk8gk&grant_type=password&username=gurezkiy&password=1234');
    //$response = $client->get('/api/groups/1');
    //регистрация
   // $req = $client->createRequest('POST', 'register', ['json' => ["name"=>"TEST","email"=>"TEST@gmail.com","password"=>"1234"]]);
    //$response = $client->send($req);
    //$response = $client->get('api/privileges/list/10');
    // $req = $client->createRequest('POST', 'users', ['json' => ['name' => 'gurezkiy',"email"=>"grezkiy@gmail.com","password"=>"12345678"]]);
    //$response = $client->send($req);
    //$response = $client->delete("api/tasklist/13");
    //$req = $client->createRequest('PUT', 'api/privileges', ['json' => ["taskListId"=>"10","level"=>"1","id"=>"1"]]);
    //$response = $client->send($req);
    //$req = $client->createRequest('PUT', 'api/groups/1', ['json' => ["userId"=>"1"]]);
    //$response = $client->send($req);
    $response = $client->delete('api/groups/4');
echo "<br>";
echo $response;
