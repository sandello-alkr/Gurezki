<html>
<head>
</head>
<body>
<!--Регистрация-->
<hr><div class="spoiler">

<div class="box">
<span>Регистрация</span>

<blockquote class="Untext">
<table>
<tr>
<td>
<h4>Метод</h4>
</td>
<td>
<h4>URL</h4>
</td>
<td>
<h4>Аргументы</h4>
</td>
<td>
<h4>Ответ</h4>
</td>
</tr>
<tr>
<td>
POST
</td>
<td>
/register
</td>
<td>
<pre>
name:string
email:string
password:string
</pre>
</td>
<td>
<pre>
client_id:string
client_secret:string
grant_type:string
username:string
password:string
</pre>
</td>
</tr>
</table>
<h2>Пример</h2>
<p>Запрос:</p>
<pre>
$req = $client->createRequest('POST', 'register', ['json' => ["name"=>"TEST","email"=>"TEST@gmail.com","password"=>"1234"]]);
$response = $client->send($req);
</pre>
<p>Ответ:</p>
<pre>
HTTP/1.1 200 OK Host: localhost:8000 Connection: close Cache-Control: no-cache Content-Type: application/json 
X-Debug-Token: 9389ca X-Debug-Token-Link: http://localhost:8000/_profiler/9389ca Date: Mon, 20 Jun 2016 06:35:38 GMT 
{"client_id":"14_1brdylbp2ftwsc4sow4ww4gggo8ookwcsck0csg4wwgk4koskc",
"client_secret":"26wzh2l1hmxwck8os8kc4c4owkok80c0kwk0gkscogsokssooo",
"grant_type":"password","username":"TEST","password":"1234"}
</pre>
<h2>Коды ошибок</h2>
<p>201 - пустое имя<br>202 - пустой email<br>203 - пустой пароль<br>204 - полльзователь с таким именем уже существует<br>205 - пользователь с таким email уже существует</p>
</blockquote>
</div>
</div>
</div>

<!--Авторизация-->
<hr><div class="spoiler">

<div class="box">
<span>Авторизация</span>

<blockquote class="Untext">
<table>
<tr>
<td>
<h4>Метод</h4>
</td>
<td>
<h4>URL</h4>
</td>
<td>
<h4>Аргументы</h4>
</td>
<td>
<h4>Ответ</h4>
</td>
</tr>
<tr>
<td>
POST
</td>
<td>
/oauth/v2/token
</td>
<td>
<pre>
client_id:string
client_secret:string
grant_type:string
username:string
password:string
</pre>
</td>
<td>
<pre>
access_token:string
expires_in:integer
grant_type:string
token_type:string
scope:string
refresh_token:string
</pre>
</td>
</tr>
</table>
<h2>Пример</h2>
<p>Запрос:</p>
<pre>
$req = $client->createRequest('POST', 'oauth/v2/token', ['json' => ["client_id"=>"17_5u32ts0jgcso8c0ogkssg8kogogw8c8oc8skok0ckswkc000w8",
"client_secret"=>"43wbgjxck2g4ccg4o08gcgo4os8g8og0gsoscwgwckw4wk0840",
"grant_type"=>"password",
"username"=>"Николай Гурецкий",
"password"=>"1234"]]);
$response = $client->send($req);
</pre>
<p>Ответ:</p>
<pre>
HTTP/1.1 200 OK Host: localhost:8000 Connection: close Content-Type: application/json
Cache-Control: no-store, private Pragma: no-cache X-Debug-Token: e56f0a
X-Debug-Token-Link: http://localhost:8000/_profiler/e56f0a Date: Mon, 20 Jun 2016 06:38:33 GMT
{"access_token":"NjM3YmI0M2JiNGVlY2EzMDRmNzk0YzEzZmNkYTA0OTNjN2YxODlhNWRmNDhkMDY0MTdhOTdjMTlhOGZmZWU4Yw",
"expires_in":3600,"token_type":"bearer","scope":null,
"refresh_token":"MGI4NDRiNDIyYWNhZDdmNmI3NTZiNzdkOTBkODY5NjI3ZTE5NjE0ODMwMWRmZGZjNGQ4Y2I2NmU1OTQzMzEyZA"}
</pre>
<p>Доступ запрещён или неверный токен:</p>
<pre>
HTTP/1.1 401 Unauthorized Host: localhost:8000 Connection: close 
WWW-Authenticate: Bearer realm="Service", error="invalid_grant", error_description="The access token provided is invalid." 
Content-Type: application/json Cache-Control: no-store, private Pragma: no-cache X-Debug-Token: 13466d X-Debug-Token-Link:
http://localhost:8000/_profiler/13466d Date: Mon, 20 Jun 2016 06:53:47 GMT 
{"error":"invalid_grant","error_description":"The access token provided is invalid."}
</pre>
</blockquote>
</div>
</div>
</div>

<!--Восстановить пароль по email-->
<hr><div class="spoiler">

<div class="box">
<span>Восстановить пароль по email</span>

<blockquote class="Untext">
<table>
<tr>
<td>
<h4>Метод</h4>
</td>
<td>
<h4>URL</h4>
</td>
<td>
<h4>Аргументы</h4>
</td>
<td>
<h4>Ответ</h4>
</td>
</tr>
<tr>
<td>
POST
</td>
<td>
/resetpassord
</td>
<td>
<pre>
email:string
</pre>
</td>
<td>
<pre>
-
</pre>
</td>
</tr>
</table>
<h2>Пример</h2>
<p>Запрос:</p>
<pre>
$req = $client->createRequest('POST','resetpassord',['json' => ["email"=>"test3@gmail.com"]]);
$response = $client->send($req);
</pre>
<p>Ответ:</p>
<pre>
HTTP/1.1 200 OK Host: localhost:8000 Connection: close Content-Type: application/json
Cache-Control: no-store, private Pragma: no-cache X-Debug-Token: e56f0a
X-Debug-Token-Link: http://localhost:8000/_profiler/e56f0a Date: Mon, 20 Jun 2016 06:38:33 GMT
</pre>
<p>На указанный email будет выслан новый пароль</p>
</blockquote>
</div>
</div>
</div>


<!--получить список пользователей-->
<hr><div class="spoiler">

<div class="box">
<span>Список пользователей</span>

<blockquote class="Untext">
<table>
<tr>
<td>
<h4>Метод</h4>
</td>
<td>
<h4>URL</h4>
</td>
<td>
<h4>Аргументы</h4>
</td>
<td>
<h4>Ответ</h4>
</td>
</tr>
<tr>
<td>
GET
</td>
<td>
/api/users
</td>
<td>
<pre>
-
</pre>
</td>
<td>
<pre>
[{
id:integer
name:string
email:string
}]
</pre>
</td>
</tr>
</table>
<h2>Пример</h2>
<p>Запрос:</p>
<pre>
use GuzzleHttp\Client;
$client = new Client([
'base_url' => 'http://localhost:8000/',
'defaults' => [
'headers' => ['Authorization' => 'Bearer NjM3YmI0M2JiNGVlY2EzMDRmNzk0YzEzZmNkYTA0OTNjN2YxODlhNWRmNDhkMDY0MTdhOTdjMTlhOGZmZWU4Yw'],
'exceptions' => false
]
]);
$response = $client->get('api/users');
</pre>
<p>Ответ:</p>
<pre>	
HTTP/1.1 200 OK Host: localhost:8000 Connection: close Cache-Control: no-cache Content-Type: application/json
X-Debug-Token: 4d8b05 X-Debug-Token-Link: http://localhost:8000/_profiler/4d8b05 Date: Mon, 20 Jun 2016 06:43:12 GMT 
[{"id":1,"name":"admin","email":"new@gmail.com"},{"id":8,"name":"gurezkiy","email":"gurezkiy@gmail.com"},
{"id":9,"name":"TEST","email":"TEST@gmail.com"}]
</pre>
</blockquote>
</div>
</div>
</div>

<!--обновить свои данные-->
<hr><div class="spoiler">

<div class="box">
<span>Обновить свои данные</span>

<blockquote class="Untext">
<table>
<tr>
<td>
<h4>Метод</h4>
</td>
<td>
<h4>URL</h4>
</td>
<td>
<h4>Аргументы</h4>
</td>
<td>
<h4>Ответ</h4>
</td>
</tr>
<tr>
<td>
PUT
</td>
<td>
/api/users
</td>
<td>
<pre>
name:string
email:string
password:string
</pre>
</td>
<td>
<pre>
name:string
email:string
password:string
</pre>
</td>
</tr>
</table>
<h2>Пример</h2>
<p>Запрос:</p>
<pre>
use GuzzleHttp\Client;
$client = new Client([
'base_url' => 'http://localhost:8000/',
'defaults' => [
'headers' => ['Authorization' => 'Bearer NjM3YmI0M2JiNGVlY2EzMDRmNzk0YzEzZmNkYTA0OTNjN2YxODlhNWRmNDhkMDY0MTdhOTdjMTlhOGZmZWU4Yw'],
'exceptions' => false
]
]);
$req = $client->createRequest('PUT', 'api/users', ['json' => ["name"=>"TEST2","email"=>"TEST@gmail.com","password"=>"1234"]]);
$response = $client->send($req);
</pre>
<p>Ответ:</p>
<pre>	
HTTP/1.1 200 OK Host: localhost:8000 Connection: close Cache-Control: no-cache Content-Type: application/json
X-Debug-Token: e93bb6 X-Debug-Token-Link: http://localhost:8000/_profiler/e93bb6 Date: Mon, 20 Jun 2016 06:51:02 GMT
{"name":"TEST2","email":"TEST@gmail.com","password":"1234"}
</pre>
</blockquote>
</div>
</div>
</div>

<!--Удалить аккаунт-->
<hr><div class="spoiler">

<div class="box">
<span>Удалить аккаунт</span>

<blockquote class="Untext">
<table>
<tr>
<td>
<h4>Метод</h4>
</td>
<td>
<h4>URL</h4>
</td>
<td>
<h4>Аргументы</h4>
</td>
<td>
<h4>Ответ</h4>
</td>
</tr>
<tr>
<td>
DELETE
</td>
<td>
/api/users
</td>
<td>
<pre>
-
</pre>
</td>
<td>
<pre>
-
</pre>
</td>
</tr>
</table>
<h2>Пример</h2>
<p>Запрос:</p>
<pre>
use GuzzleHttp\Client;
$client = new Client([
'base_url' => 'http://localhost:8000/',
'defaults' => [
'headers' => ['Authorization' => 'Bearer NjM3YmI0M2JiNGVlY2EzMDRmNzk0YzEzZmNkYTA0OTNjN2YxODlhNWRmNDhkMDY0MTdhOTdjMTlhOGZmZWU4Yw'],
'exceptions' => false
]
]);
$response = $client->delete('api/users');
</pre>
<p>Ответ:</p>
<pre>	
HTTP/1.1 200 OK Host: localhost:8000 Connection: close Cache-Control: no-cache Content-Type: application/json
X-Debug-Token: 08434f X-Debug-Token-Link: http://localhost:8000/_profiler/08434f Date: Mon, 20 Jun 2016 06:53:07 GMT
</pre>
</blockquote>
</div>
</div>
</div>

<!--Получить пользователя по ID-->
<hr><div class="spoiler">

<div class="box">
<span>Получить пользователя по ID</span>

<blockquote class="Untext">
<table>
<tr>
<td>
<h4>Метод</h4>
</td>
<td>
<h4>URL</h4>
</td>
<td>
<h4>Аргументы</h4>
</td>
<td>
<h4>Ответ</h4>
</td>
</tr>
<tr>
<td>
GET
</td>
<td>
/api/users/{id}
</td>
<td>
<pre>
-
</pre>
</td>
<td>
<pre>
id:integer
name:string
email:string
</pre>
</td>
</tr>
</table>
<h2>Пример</h2>
<p>Запрос:</p>
<pre>
use GuzzleHttp\Client;
$client = new Client([
'base_url' => 'http://localhost:8000/',
'defaults' => [
'headers' => ['Authorization' => 'Bearer NjM3YmI0M2JiNGVlY2EzMDRmNzk0YzEzZmNkYTA0OTNjN2YxODlhNWRmNDhkMDY0MTdhOTdjMTlhOGZmZWU4Yw'],
'exceptions' => false
]
]);
$response = $client->get('api/users/1');
</pre>
<p>Ответ:</p>
<pre>	
HTTP/1.1 200 OK Host: localhost:8000 Connection: close Cache-Control: no-cache Content-Type: application/json
X-Debug-Token: c570ef X-Debug-Token-Link: http://localhost:8000/_profiler/c570ef Date: Mon, 20 Jun 2016 07:02:19 GMT 
{"id":1,"name":"admin","email":"new@gmail.com"}
</pre>
</blockquote>
</div>
</div>
</div>

<!--Найти пользователя по имени-->
<hr><div class="spoiler">

<div class="box">
<span>Найти пользователя по имени</span>

<blockquote class="Untext">
<table>
<tr>
<td>
<h4>Метод</h4>
</td>
<td>
<h4>URL</h4>
</td>
<td>
<h4>Аргументы</h4>
</td>
<td>
<h4>Ответ</h4>
</td>
</tr>
<tr>
<td>
GET
</td>
<td>
/api/users
</td>
<td>
<pre>
name:string
</pre>
</td>
<td>
<pre>
[{
id:integer
name:string
email:string
}]

</pre>
</td>
</tr>
</table>
<h2>Пример</h2>
<p>Запрос:</p>
<pre>
use GuzzleHttp\Client;
$client = new Client([
'base_url' => 'http://localhost:8000/',
'defaults' => [
'headers' => ['Authorization' => 'Bearer NjM3YmI0M2JiNGVlY2EzMDRmNzk0YzEzZmNkYTA0OTNjN2YxODlhNWRmNDhkMDY0MTdhOTdjMTlhOGZmZWU4Yw'],
'exceptions' => false
]
]);
$response = $client->get('api/users?admin');
</pre>
<p>Ответ:</p>
<pre>	
HTTP/1.1 200 OK Host: localhost:8000 Connection: close Cache-Control: no-cache Content-Type: application/json
X-Debug-Token: c570ef X-Debug-Token-Link: http://localhost:8000/_profiler/c570ef Date: Mon, 20 Jun 2016 07:02:19 GMT 
[{"id":1,"name":"admin","email":"new@gmail.com"}]
</pre>
</blockquote>
</div>
</div>
</div>

<!--Получить все мои списки-->
<hr><div class="spoiler">

<div class="box">
<span>Получить все списки, к которым имею доступ</span>

<blockquote class="Untext">
<table>
<tr>
<td>
<h4>Метод</h4>
</td>
<td>
<h4>URL</h4>
</td>
<td>
<h4>Аргументы</h4>
</td>
<td>
<h4>Ответ</h4>
</td>
</tr>
<tr>
<td>
GET
</td>
<td>
/api/tasklist
</td>
<td>
<pre>
-
</pre>
</td>
<td>
<pre>
[{
id:integer
name:string
level:integer
}]

</pre>
</td>
</tr>
</table>
<p>level - уровень доступа от 0 до 3. 0 - только просмотр листа; 1 - просмотр листа и возможность отмечать выполнение задач; 2 - возможность добавлять свои задачи к листу и раздавать; 3 - создатель(полный доступ, раздача привилегий, удаление задач, удаление списка)</p>
<h2>Пример</h2>
<p>Запрос:</p>
<pre>
use GuzzleHttp\Client;
$client = new Client([
'base_url' => 'http://localhost:8000/',
'defaults' => [
'headers' => ['Authorization' => 'Bearer NjM3YmI0M2JiNGVlY2EzMDRmNzk0YzEzZmNkYTA0OTNjN2YxODlhNWRmNDhkMDY0MTdhOTdjMTlhOGZmZWU4Yw'],
'exceptions' => false
]
]);
$response = $client->get('api/tasklist');
</pre>
<p>Ответ:</p>
<pre>	
HTTP/1.1 200 OK Host: localhost:8000 Connection: close Cache-Control: no-cache Content-Type: application/json
X-Debug-Token: 77dbf5 X-Debug-Token-Link: http://localhost:8000/_profiler/77dbf5 Date: Mon, 20 Jun 2016 08:21:44 GMT
[{"id":12,"name":"3","level":3},{"id":10,"name":"1","level":2}]
</pre>
</blockquote>
</div>
</div>
</div>

<!--Создать новый сисок-->
<hr><div class="spoiler">

<div class="box">
<span>Создать новый сисок</span>

<blockquote class="Untext">
<table>
<tr>
<td>
<h4>Метод</h4>
</td>
<td>
<h4>URL</h4>
</td>
<td>
<h4>Аргументы</h4>
</td>
<td>
<h4>Ответ</h4>
</td>
</tr>
<tr>
<td>
POST
</td>
<td>
/api/tasklist
</td>
<td>
<pre>
name:string
</pre>
</td>
<td>
<pre>
id:integer
name:string
</pre>
</td>
</tr>
</table>
<h2>Пример</h2>
<p>Запрос:</p>
<pre>
use GuzzleHttp\Client;
$client = new Client([
'base_url' => 'http://localhost:8000/',
'defaults' => [
'headers' => ['Authorization' => 'Bearer NjM3YmI0M2JiNGVlY2EzMDRmNzk0YzEzZmNkYTA0OTNjN2YxODlhNWRmNDhkMDY0MTdhOTdjMTlhOGZmZWU4Yw'],
'exceptions' => false
]
]);
$req = $client->createRequest('POST', 'api/tasklist', ['json' => ["name"=>"MyNewList"]]);
$response = $client->send($req);
</pre>
<p>Ответ:</p>
<pre>	
HTTP/1.1 200 OK Host: localhost:8000 Connection: close Cache-Control: no-cache Content-Type: application/json
X-Debug-Token: 78028f X-Debug-Token-Link: http://localhost:8000/_profiler/78028f Date: Mon, 20 Jun 2016 08:24:39 GMT
{"id":13,"name":"MyNewList"}
</pre>
</blockquote>
</div>
</div>
</div>

<!--Показать список с задачами-->
<hr><div class="spoiler">

<div class="box">
<span>Показать список с задачами</span>

<blockquote class="Untext">
<table>
<tr>
<td>
<h4>Метод</h4>
</td>
<td>
<h4>URL</h4>
</td>
<td>
<h4>Аргументы</h4>
</td>
<td>
<h4>Ответ</h4>
</td>
</tr>
<tr>
<td>
GET
</td>
<td>
/api/tasklist/{id}
</td>
<td>
<pre>
-
</pre>
</td>
<td>
<pre>
[{
id:integer
name:string
checked:boolean
}]
</pre>
</td>
</tr>
</table>
<h2>Пример</h2>
<p>Запрос:</p>
<pre>
use GuzzleHttp\Client;
$client = new Client([
'base_url' => 'http://localhost:8000/',
'defaults' => [
'headers' => ['Authorization' => 'Bearer NjM3YmI0M2JiNGVlY2EzMDRmNzk0YzEzZmNkYTA0OTNjN2YxODlhNWRmNDhkMDY0MTdhOTdjMTlhOGZmZWU4Yw'],
'exceptions' => false
]
]);
$response = $client->get('api/tasklist/10');
</pre>
<p>Ответ:</p>
<pre>	
HTTP/1.1 200 OK Host: localhost:8000 Connection: close Cache-Control: no-cache Content-Type: application/json
X-Debug-Token: 78028f X-Debug-Token-Link: http://localhost:8000/_profiler/78028f Date: Mon, 20 Jun 2016 08:24:39 GMT
[{"id":3,"name":"\u0418\u043c\u044f 1","checked":false},{"id":5,"name":"\u0418\u043c\u044f 2","checked":false}]
</pre>
</blockquote>
</div>
</div>
</div>

<!--Удалить список-->
<hr><div class="spoiler">

<div class="box">
<span>Удалить список</span>

<blockquote class="Untext">
<table>
<tr>
<td>
<h4>Метод</h4>
</td>
<td>
<h4>URL</h4>
</td>
<td>
<h4>Аргументы</h4>
</td>
<td>
<h4>Ответ</h4>
</td>
</tr>
<tr>
<td>
DELETE
</td>
<td>
/api/tasklist/{id}
</td>
<td>
<pre>
-
</pre>
</td>
<td>
<pre>
-
</pre>
</td>
</tr>
</table>
<h2>Пример</h2>
<p>Запрос:</p>
<pre>
use GuzzleHttp\Client;
$client = new Client([
'base_url' => 'http://localhost:8000/',
'defaults' => [
'headers' => ['Authorization' => 'Bearer NjM3YmI0M2JiNGVlY2EzMDRmNzk0YzEzZmNkYTA0OTNjN2YxODlhNWRmNDhkMDY0MTdhOTdjMTlhOGZmZWU4Yw'],
'exceptions' => false
]
]);
$response = $client->get('api/tasklist/10');
</pre>
<p>Ответ:</p>
<pre>	
HTTP/1.1 200 OK Host: localhost:8000 Connection: close Cache-Control: no-cache Content-Type: application/json
X-Debug-Token: c1ebdc X-Debug-Token-Link: http://localhost:8000/_profiler/c1ebdc Date: Tue, 21 Jun 2016 10:36:39 GMT
</pre>
</blockquote>
</div>
</div>
</div>

<!--Получить привилегии пользователя на список-->
<hr><div class="spoiler">

<div class="box">
<span>Получить привилегии пользователя на список</span>

<blockquote class="Untext">
<table>
<tr>
<td>
<h4>Метод</h4>
</td>
<td>
<h4>URL</h4>
</td>
<td>
<h4>Аргументы</h4>
</td>
<td>
<h4>Ответ</h4>
</td>
</tr>
<tr>
<td>
GET
</td>
<td>
/api/privileges
</td>
<td>
<pre>
taskListId:integer
id:integer
</pre>
</td>
<td>
<pre>
level:integer
</pre>
</td>
</tr>
</table>
<h2>Пример</h2>
<p>Запрос:</p>
<pre>
use GuzzleHttp\Client;
$client = new Client([
'base_url' => 'http://localhost:8000/',
'defaults' => [
'headers' => ['Authorization' => 'Bearer NjM3YmI0M2JiNGVlY2EzMDRmNzk0YzEzZmNkYTA0OTNjN2YxODlhNWRmNDhkMDY0MTdhOTdjMTlhOGZmZWU4Yw'],
'exceptions' => false
]
]);
$response = $client->get('api/privileges?taskListId=10&id=8');
</pre>
<p>Ответ:</p>
<pre>		
HTTP/1.1 200 OK Host: localhost:8000 Connection: close Cache-Control: no-cache Content-Type: application/json
X-Debug-Token: 7a0008 X-Debug-Token-Link: http://localhost:8000/_profiler/7a0008 Date: Tue, 21 Jun 2016 10:42:46 GMT
{"level":3}
</pre>
</blockquote>
</div>
</div>
</div>

<!--Добавить привилегию-->
<hr><div class="spoiler">

<div class="box">
<span>Добавить привилегию</span>

<blockquote class="Untext">
<table>
<tr>
<td>
<h4>Метод</h4>
</td>
<td>
<h4>URL</h4>
</td>
<td>
<h4>Аргументы</h4>
</td>
<td>
<h4>Ответ</h4>
</td>
</tr>
<tr>
<td>
POST
</td>
<td>
/api/privileges
</td>
<td>
<pre>
taskListId:integer
level:integer
userid:integer
</pre>
</td>
<td>
<pre>
-
</pre>
</td>
</tr>
</table>
<p>Привилегии может добавлять только создатель списка, т.е. level=3</p>
<h2>Пример</h2>
<p>Запрос:</p>
<pre>
use GuzzleHttp\Client;
$client = new Client([
'base_url' => 'http://localhost:8000/',
'defaults' => [
'headers' => ['Authorization' => 'Bearer NjM3YmI0M2JiNGVlY2EzMDRmNzk0YzEzZmNkYTA0OTNjN2YxODlhNWRmNDhkMDY0MTdhOTdjMTlhOGZmZWU4Yw'],
'exceptions' => false
]
]);
$req = $client->createRequest('POST', 'api/privileges', ['json' => ["taskListId"=>"10","level"=>"2","id"=>"1"]]);
$response = $client->send($req);
</pre>
<p>Ответ:</p>
<pre>		
HTTP/1.1 200 OK Host: localhost:8000 Connection: close Cache-Control: no-cache Content-Type: application/json
X-Debug-Token: fe70ed X-Debug-Token-Link: http://localhost:8000/_profiler/fe70ed Date: Tue, 21 Jun 2016 10:47:21 GMT
</pre>
</blockquote>
</div>
</div>
</div>

<!--Редактировать привилегию-->
<hr><div class="spoiler">

<div class="box">
<span>Редактировать привилегию</span>

<blockquote class="Untext">
<table>
<tr>
<td>
<h4>Метод</h4>
</td>
<td>
<h4>URL</h4>
</td>
<td>
<h4>Аргументы</h4>
</td>
<td>
<h4>Ответ</h4>
</td>
</tr>
<tr>
<td>
PUT
</td>
<td>
/api/privileges
</td>
<td>
<pre>
taskListId:integer
level:integer
userid:integer
</pre>
</td>
<td>
<pre>
-
</pre>
</td>
</tr>
</table>
<p>Привилегии может редактировать только создатель списка, т.е. level=3</p>
<h2>Пример</h2>
<p>Запрос:</p>
<pre>
use GuzzleHttp\Client;
$client = new Client([
'base_url' => 'http://localhost:8000/',
'defaults' => [
'headers' => ['Authorization' => 'Bearer NjM3YmI0M2JiNGVlY2EzMDRmNzk0YzEzZmNkYTA0OTNjN2YxODlhNWRmNDhkMDY0MTdhOTdjMTlhOGZmZWU4Yw'],
'exceptions' => false
]
]);
$req = $client->createRequest('PUT', 'api/privileges', ['json' => ["taskListId"=>"10","level"=>"1","id"=>"1"]]);
$response = $client->send($req);
</pre>
<p>Ответ:</p>
<pre>			
HTTP/1.1 200 OK Host: localhost:8000 Connection: close Cache-Control: no-cache Content-Type: application/json
X-Debug-Token: 78b162 X-Debug-Token-Link: http://localhost:8000/_profiler/78b162 Date: Tue, 21 Jun 2016 10:49:53 GMT
</pre>
</blockquote>
</div>
</div>
</div>

<!--Удалить привилегию-->
<hr><div class="spoiler">

<div class="box">
<span>Удалить привилегию</span>

<blockquote class="Untext">
<table>
<tr>
<td>
<h4>Метод</h4>
</td>
<td>
<h4>URL</h4>
</td>
<td>
<h4>Аргументы</h4>
</td>
<td>
<h4>Ответ</h4>
</td>
</tr>
<tr>
<td>
DELETE
</td>
<td>
/api/privileges
</td>
<td>
<pre>
taskListId:integer
userid:integer
</pre>
</td>
<td>
<pre>
-
</pre>
</td>
</tr>
</table>
<p>Привилегии может удалять создатель списка, т.е. level=3 и тот, на кого направлена привилегия</p>
<h2>Пример</h2>
<p>Запрос:</p>
<pre>
use GuzzleHttp\Client;
$client = new Client([
'base_url' => 'http://localhost:8000/',
'defaults' => [
'headers' => ['Authorization' => 'Bearer NjM3YmI0M2JiNGVlY2EzMDRmNzk0YzEzZmNkYTA0OTNjN2YxODlhNWRmNDhkMDY0MTdhOTdjMTlhOGZmZWU4Yw'],
'exceptions' => false
]
]);
$req = $client->createRequest('DELETE', 'api/privileges', ['json' => ["taskListId"=>"10","id"=>"1"]]);
$response = $client->send($req);
</pre>
<p>Ответ:</p>
<pre>			
HTTP/1.1 200 OK Host: localhost:8000 Connection: close Cache-Control: no-cache Content-Type: application/json
X-Debug-Token: 78b162 X-Debug-Token-Link: http://localhost:8000/_profiler/78b162 Date: Tue, 21 Jun 2016 10:49:53 GMT
</pre>
</blockquote>
</div>
</div>
</div>

<!--Получить список пользователей листа с уровнями прав-->
<hr><div class="spoiler">

<div class="box">
<span>Получить список пользователей листа с уровнями прав</span>

<blockquote class="Untext">
<table>
<tr>
<td>
<h4>Метод</h4>
</td>
<td>
<h4>URL</h4>
</td>
<td>
<h4>Аргументы</h4>
</td>
<td>
<h4>Ответ</h4>
</td>
</tr>
<tr>
<td>
GET
</td>
<td>
/api/privilegies/list/{listid}
</td>
<td>
<pre>
-
</pre>
</td>
<td>
<pre>
[{
id:integer
username:string
email:string
level:integer
}]
</pre>
</td>
</tr>
</table>
<h2>Пример</h2>
<p>Запрос:</p>
<pre>
use GuzzleHttp\Client;
$client = new Client([
'base_url' => 'http://localhost:8000/',
'defaults' => [
'headers' => ['Authorization' => 'Bearer NjM3YmI0M2JiNGVlY2EzMDRmNzk0YzEzZmNkYTA0OTNjN2YxODlhNWRmNDhkMDY0MTdhOTdjMTlhOGZmZWU4Yw'],
'exceptions' => false
]
]);
$response = $client->get('api/privileges/list/10');
</pre>
<p>Ответ:</p>
<pre>			
HTTP/1.1 200 OK Host: localhost:8000 Connection: close Cache-Control: no-cache Content-Type: application/json
X-Debug-Token: ba1a07 X-Debug-Token-Link: http://localhost:8000/_profiler/ba1a07 Date: Tue, 21 Jun 2016 10:56:32 GMT
[{"id":"8","username":"gurezkiy","email":"gurezkiy@gmail.com","level":3},{"id":"1","username":"admin","email":"new@gmail.com","level":1}]
</pre>
</blockquote>
</div>
</div>
</div>

<!--Добавить задачу для списка-->
<hr><div class="spoiler">

<div class="box">
<span>Добавить задачу для списка</span>

<blockquote class="Untext">
<table>
<tr>
<td>
<h4>Метод</h4>
</td>
<td>
<h4>URL</h4>
</td>
<td>
<h4>Аргументы</h4>
</td>
<td>
<h4>Ответ</h4>
</td>
</tr>
<tr>
<td>
POST
</td>
<td>
/api/task
</td>
<td>
<pre>
taskListId:integer
name:string
</pre>
</td>
<td>
<pre>
-
</pre>
</td>
</tr>
</table>
<h2>Пример</h2>
<p>Запрос:</p>
<pre>
use GuzzleHttp\Client;
$client = new Client([
'base_url' => 'http://localhost:8000/',
'defaults' => [
'headers' => ['Authorization' => 'Bearer NjM3YmI0M2JiNGVlY2EzMDRmNzk0YzEzZmNkYTA0OTNjN2YxODlhNWRmNDhkMDY0MTdhOTdjMTlhOGZmZWU4Yw'],
'exceptions' => false
]
]);
$req = $client->createRequest('POST', 'api/task', ['json' => ["taskListId"=>10,"name"=>"MyNewTask"]]);
$response = $client->send($req);
</pre>
<p>Ответ:</p>
<pre>			
HTTP/1.1 200 OK Host: localhost:8000 Connection: close Cache-Control: no-cache Content-Type: application/json
X-Debug-Token: bc2233 X-Debug-Token-Link: http://localhost:8000/_profiler/bc2233 Date: Tue, 21 Jun 2016 11:10:01 GMT
</pre>
</blockquote>
</div>
</div>
</div>

<!--Обновить статут выполнения задачи-->
<hr><div class="spoiler">

<div class="box">
<span>Обновить статут выполнения задачи</span>

<blockquote class="Untext">
<table>
<tr>
<td>
<h4>Метод</h4>
</td>
<td>
<h4>URL</h4>
</td>
<td>
<h4>Аргументы</h4>
</td>
<td>
<h4>Ответ</h4>
</td>
</tr>
<tr>
<td>
PUT
</td>
<td>
/api/task
</td>
<td>
<pre>
taskListId:integer
id:integer
checked:boolean
</pre>
</td>
<td>
<pre>
-
</pre>
</td>
</tr>
</table>
<h2>Пример</h2>
<p>Запрос:</p>
<pre>
use GuzzleHttp\Client;
$client = new Client([
'base_url' => 'http://localhost:8000/',
'defaults' => [
'headers' => ['Authorization' => 'Bearer NjM3YmI0M2JiNGVlY2EzMDRmNzk0YzEzZmNkYTA0OTNjN2YxODlhNWRmNDhkMDY0MTdhOTdjMTlhOGZmZWU4Yw'],
'exceptions' => false
]
]);
$req = $client->createRequest('PUT', 'api/task', ['json' => ["taskListId"=>10,"id"=>6,"checked"=>true]]);
$response = $client->send($req);
</pre>
<p>Ответ:</p>
<pre>			
HTTP/1.1 200 OK Host: localhost:8000 Connection: close Cache-Control: no-cache Content-Type: application/json
X-Debug-Token: 78f543 X-Debug-Token-Link: http://localhost:8000/_profiler/78f543 Date: Tue, 21 Jun 2016 11:15:11 GMT
</pre>
</blockquote>
</div>
</div>
</div>

<!--Удалить задачу-->
<hr><div class="spoiler">

<div class="box">
<span>Удалить задачу</span>

<blockquote class="Untext">
<table>
<tr>
<td>
<h4>Метод</h4>
</td>
<td>
<h4>URL</h4>
</td>
<td>
<h4>Аргументы</h4>
</td>
<td>
<h4>Ответ</h4>
</td>
</tr>
<tr>
<td>
DELETE
</td>
<td>
/api/task
</td>
<td>
<pre>
taskListId:integer
id:integer
</pre>
</td>
<td>
<pre>
-
</pre>
</td>
</tr>
</table>
<p>Удалять задачи может только пользователь с уровнем прав 2 или 3</p>
<h2>Пример</h2>
<p>Запрос:</p>
<pre>
use GuzzleHttp\Client;
$client = new Client([
'base_url' => 'http://localhost:8000/',
'defaults' => [
'headers' => ['Authorization' => 'Bearer NjM3YmI0M2JiNGVlY2EzMDRmNzk0YzEzZmNkYTA0OTNjN2YxODlhNWRmNDhkMDY0MTdhOTdjMTlhOGZmZWU4Yw'],
'exceptions' => false
]
]);
$req = $client->createRequest('DELETE', 'api/task', ['json' => ["taskListId"=>10,"id"=>6]]);
$response = $client->send($req);
</pre>
<p>Ответ:</p>
<pre>			
HTTP/1.1 200 OK Host: localhost:8000 Connection: close Cache-Control: no-cache Content-Type: application/json
X-Debug-Token: f5548a X-Debug-Token-Link: http://localhost:8000/_profiler/f5548a Date: Tue, 21 Jun 2016 11:17:33 GMT
</pre>
</blockquote>
</div>
</div>
</div>

<!--Список логов для листа-->
<hr><div class="spoiler">

<div class="box">
<span>Список логов для листа</span>

<blockquote class="Untext">
<table>
<tr>
<td>
<h4>Метод</h4>
</td>
<td>
<h4>URL</h4>
</td>
<td>
<h4>Аргументы</h4>
</td>
<td>
<h4>Ответ</h4>
</td>
</tr>
<tr>
<td>
GET
</td>
<td>
/api/logs/{listid}
</td>
<td>
<pre>
-
</pre>
</td>
<td>
<pre>
[{
action:string
userId:integer
listId:integer
}]
</pre>
</td>
</tr>
</table>
<h2>Пример</h2>
<p>Запрос:</p>
<pre>
use GuzzleHttp\Client;
$client = new Client([
'base_url' => 'http://localhost:8000/',
'defaults' => [
'headers' => ['Authorization' => 'Bearer NjM3YmI0M2JiNGVlY2EzMDRmNzk0YzEzZmNkYTA0OTNjN2YxODlhNWRmNDhkMDY0MTdhOTdjMTlhOGZmZWU4Yw'],
'exceptions' => false
]
]);
$response = $client->get('/api/logs/10');
</pre>
<p>Ответ:</p>
<pre>			
HTTP/1.1 200 OK Host: localhost:8000 Connection: close Cache-Control: no-cache Content-Type: application/json
X-Debug-Token: 09af34 X-Debug-Token-Link: http://localhost:8000/_profiler/09af34 Date: Tue, 21 Jun 2016 11:20:58 GMT
[{"action":"\u041f\u043e\u043b\u0443\u0447\u0438\u0442\u044c \u0441\u043f\u0438\u0441\u043e\u043a","userId":8,"listId":10},
{"action":"\u0423\u0441\u0442\u0430\u043d\u043e\u0432\u0438\u043b \u043f\u0440\u0438\u0432\u0438\u043b\u0435\u0433\u0438\u044e \u0434\u043b\u044f 1 \u0443\u0440\u043e\u0432\u043d\u044f: 2","userId":8,"listId":10}]
</pre>
</blockquote>
</div>
</div>
</div>

<!--Список моих групп-->
<hr><div class="spoiler">

<div class="box">
<span>Список моих групп</span>

<blockquote class="Untext">
<table>
<tr>
<td>
<h4>Метод</h4>
</td>
<td>
<h4>URL</h4>
</td>
<td>
<h4>Аргументы</h4>
</td>
<td>
<h4>Ответ</h4>
</td>
</tr>
<tr>
<td>
GET
</td>
<td>
/api/groups
</td>
<td>
<pre>
-
</pre>
</td>
<td>
<pre>
[{
id:integer
name:string
}]
</pre>
</td>
</tr>
</table>
<h2>Пример</h2>
<p>Запрос:</p>
<pre>
use GuzzleHttp\Client;
$client = new Client([
'base_url' => 'http://localhost:8000/',
'defaults' => [
'headers' => ['Authorization' => 'Bearer NjM3YmI0M2JiNGVlY2EzMDRmNzk0YzEzZmNkYTA0OTNjN2YxODlhNWRmNDhkMDY0MTdhOTdjMTlhOGZmZWU4Yw'],
'exceptions' => false
]
]);
$response = $client->get('/api/groups');
</pre>
<p>Ответ:</p>
<pre>					
HTTP/1.1 200 OK Host: localhost:8000 Connection: close Cache-Control: no-cache Content-Type: application/json
X-Debug-Token: 7b2681 X-Debug-Token-Link: http://localhost:8000/_profiler/7b2681 Date: Tue, 21 Jun 2016 11:25:11 GMT
[{"id":1,"name":"\u0421\u0435\u043c\u044c\u044f"}]
</pre>
</blockquote>
</div>
</div>
</div>

<!--Создать группу-->
<hr><div class="spoiler">

<div class="box">
<span>Создать группу</span>

<blockquote class="Untext">
<table>
<tr>
<td>
<h4>Метод</h4>
</td>
<td>
<h4>URL</h4>
</td>
<td>
<h4>Аргументы</h4>
</td>
<td>
<h4>Ответ</h4>
</td>
</tr>
<tr>
<td>
POST
</td>
<td>
/api/groups
</td>
<td>
<pre>
name:string
</pre>
</td>
<td>
<pre>
-
</pre>
</td>
</tr>
</table>
<h2>Пример</h2>
<p>Запрос:</p>
<pre>
use GuzzleHttp\Client;
$client = new Client([
'base_url' => 'http://localhost:8000/',
'defaults' => [
'headers' => ['Authorization' => 'Bearer NjM3YmI0M2JiNGVlY2EzMDRmNzk0YzEzZmNkYTA0OTNjN2YxODlhNWRmNDhkMDY0MTdhOTdjMTlhOGZmZWU4Yw'],
'exceptions' => false
]
]);
$req = $client->createRequest('POST', 'api/groups', ['json' => ["name"=>"MyGroup"]]);
$response = $client->send($req);
</pre>
<p>Ответ:</p>
<pre>						
HTTP/1.1 200 OK Host: localhost:8000 Connection: close Cache-Control: no-cache Content-Type: application/json
X-Debug-Token: c71e4c X-Debug-Token-Link: http://localhost:8000/_profiler/c71e4c Date: Tue, 21 Jun 2016 11:28:41 GMT
</pre>
</blockquote>
</div>
</div>
</div>

<!--Список пользователей группы-->
<hr><div class="spoiler">

<div class="box">
<span>Список пользователей группы</span>

<blockquote class="Untext">
<table>
<tr>
<td>
<h4>Метод</h4>
</td>
<td>
<h4>URL</h4>
</td>
<td>
<h4>Аргументы</h4>
</td>
<td>
<h4>Ответ</h4>
</td>
</tr>
<tr>
<td>
GET
</td>
<td>
/api/groups/{id}
</td>
<td>
<pre>
-
</pre>
</td>
<td>
<pre>
[{
id:integer
username:string
}]
</pre>
</td>
</tr>
</table>
<h2>Пример</h2>
<p>Запрос:</p>
<pre>
use GuzzleHttp\Client;
$client = new Client([
'base_url' => 'http://localhost:8000/',
'defaults' => [
'headers' => ['Authorization' => 'Bearer NjM3YmI0M2JiNGVlY2EzMDRmNzk0YzEzZmNkYTA0OTNjN2YxODlhNWRmNDhkMDY0MTdhOTdjMTlhOGZmZWU4Yw'],
'exceptions' => false
]
]);
$response = $client->get('/api/groups/1');
</pre>
<p>Ответ:</p>
<pre>						
HTTP/1.1 200 OK Host: localhost:8000 Connection: close Cache-Control: no-cache Content-Type: application/json
X-Debug-Token: f679b0 X-Debug-Token-Link: http://localhost:8000/_profiler/f679b0 Date: Tue, 21 Jun 2016 11:32:08 GMT
[{"id":8,"username":"gurezkiy"},{"id":1,"username":"admin"}]
</pre>
</blockquote>
</div>
</div>
</div>

<!--Добавить пользователя в группу-->
<hr><div class="spoiler">

<div class="box">
<span>Добавить пользователя в группу</span>

<blockquote class="Untext">
<table>
<tr>
<td>
<h4>Метод</h4>
</td>
<td>
<h4>URL</h4>
</td>
<td>
<h4>Аргументы</h4>
</td>
<td>
<h4>Ответ</h4>
</td>
</tr>
<tr>
<td>
POST
</td>
<td>
/api/groups/{id}
</td>
<td>
<pre>
userId:integer
</pre>
</td>
<td>
<pre>
-
</pre>
</td>
</tr>
</table>
<h2>Пример</h2>
<p>Запрос:</p>
<pre>
use GuzzleHttp\Client;
$client = new Client([
'base_url' => 'http://localhost:8000/',
'defaults' => [
'headers' => ['Authorization' => 'Bearer NjM3YmI0M2JiNGVlY2EzMDRmNzk0YzEzZmNkYTA0OTNjN2YxODlhNWRmNDhkMDY0MTdhOTdjMTlhOGZmZWU4Yw'],
'exceptions' => false
]
]);
$req = $client->createRequest('POST', 'api/groups/1', ['json' => ["userId"=>"1"]]);
$response = $client->send($req);
</pre>
<p>Ответ:</p>
<pre>							
HTTP/1.1 200 OK Host: localhost:8000 Connection: close Cache-Control: no-cache Content-Type: application/json
X-Debug-Token: e766cd X-Debug-Token-Link: http://localhost:8000/_profiler/e766cd Date: Tue, 21 Jun 2016 11:36:06 GMT
</pre>
</blockquote>
</div>
</div>
</div>

<!--Удалить пользователя из группы-->
<hr><div class="spoiler">

<div class="box">
<span>Удалить пользователя из группы</span>

<blockquote class="Untext">
<table>
<tr>
<td>
<h4>Метод</h4>
</td>
<td>
<h4>URL</h4>
</td>
<td>
<h4>Аргументы</h4>
</td>
<td>
<h4>Ответ</h4>
</td>
</tr>
<tr>
<td>
PUT
</td>
<td>
/api/groups/{id}
</td>
<td>
<pre>
userId:integer
</pre>
</td>
<td>
<pre>
-
</pre>
</td>
</tr>
</table>
<h2>Пример</h2>
<p>Запрос:</p>
<pre>
use GuzzleHttp\Client;
$client = new Client([
'base_url' => 'http://localhost:8000/',
'defaults' => [
'headers' => ['Authorization' => 'Bearer NjM3YmI0M2JiNGVlY2EzMDRmNzk0YzEzZmNkYTA0OTNjN2YxODlhNWRmNDhkMDY0MTdhOTdjMTlhOGZmZWU4Yw'],
'exceptions' => false
]
]);
$req = $client->createRequest('PUT', 'api/groups/1', ['json' => ["userId"=>"1"]]);
$response = $client->send($req);
</pre>
<p>Ответ:</p>
<pre>							
HTTP/1.1 200 OK Host: localhost:8000 Connection: close Cache-Control: no-cache Content-Type: application/json
X-Debug-Token: e766cd X-Debug-Token-Link: http://localhost:8000/_profiler/e766cd Date: Tue, 21 Jun 2016 11:36:06 GMT
</pre>
</blockquote>
</div>
</div>
</div>

<!--Удалить группу-->
<hr><div class="spoiler">

<div class="box">
<span>Удалить группу</span>

<blockquote class="Untext">
<table>
<tr>
<td>
<h4>Метод</h4>
</td>
<td>
<h4>URL</h4>
</td>
<td>
<h4>Аргументы</h4>
</td>
<td>
<h4>Ответ</h4>
</td>
</tr>
<tr>
<td>
DELETE
</td>
<td>
/api/groups/{id}
</td>
<td>
<pre>
-
</pre>
</td>
<td>
<pre>
-
</pre>
</td>
</tr>
</table>
<h2>Пример</h2>
<p>Запрос:</p>
<pre>
use GuzzleHttp\Client;
$client = new Client([
'base_url' => 'http://localhost:8000/',
'defaults' => [
'headers' => ['Authorization' => 'Bearer NjM3YmI0M2JiNGVlY2EzMDRmNzk0YzEzZmNkYTA0OTNjN2YxODlhNWRmNDhkMDY0MTdhOTdjMTlhOGZmZWU4Yw'],
'exceptions' => false
]
]);
$response = $client->delete('api/groups/4');
</pre>
<p>Ответ:</p>
<pre>								
HTTP/1.1 200 OK Host: localhost:8000 Connection: close Cache-Control: no-cache Content-Type: application/json
X-Debug-Token: 2ffe0c X-Debug-Token-Link: http://localhost:8000/_profiler/2ffe0c Date: Tue, 21 Jun 2016 11:40:29 GMT
</pre>
</blockquote>
</div>
</div>
</div>

</body>
</html>