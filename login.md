# RuntimeException - Internal Server Error

This password does not use the Bcrypt algorithm.

PHP 8.2.32
Laravel 12.62.0
localhost:8080

## Stack Trace

0 - vendor/laravel/framework/src/Illuminate/Hashing/BcryptHasher.php:89
1 - vendor/laravel/framework/src/Illuminate/Hashing/HashManager.php:76
2 - vendor/laravel/framework/src/Illuminate/Auth/EloquentUserProvider.php:158
3 - vendor/laravel/framework/src/Illuminate/Auth/SessionGuard.php:491
4 - vendor/laravel/framework/src/Illuminate/Auth/SessionGuard.php:429
5 - vendor/laravel/framework/src/Illuminate/Support/Timebox.php:34
6 - vendor/laravel/framework/src/Illuminate/Auth/SessionGuard.php:421
7 - vendor/laravel/framework/src/Illuminate/Auth/AuthManager.php:334
8 - vendor/laravel/framework/src/Illuminate/Support/Facades/Facade.php:363
9 - app/Http/Controllers/AuthController.php:98
10 - vendor/laravel/framework/src/Illuminate/Routing/ControllerDispatcher.php:46
11 - vendor/laravel/framework/src/Illuminate/Routing/Route.php:265
12 - vendor/laravel/framework/src/Illuminate/Routing/Route.php:211
13 - vendor/laravel/framework/src/Illuminate/Routing/Router.php:822
14 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:180
15 - vendor/laravel/framework/src/Illuminate/Auth/Middleware/RedirectIfAuthenticated.php:47
16 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
17 - vendor/laravel/framework/src/Illuminate/Routing/Middleware/SubstituteBindings.php:50
18 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
19 - vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/VerifyCsrfToken.php:87
20 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
21 - vendor/laravel/framework/src/Illuminate/View/Middleware/ShareErrorsFromSession.php:48
22 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
23 - vendor/laravel/framework/src/Illuminate/Session/Middleware/StartSession.php:120
24 - vendor/laravel/framework/src/Illuminate/Session/Middleware/StartSession.php:63
25 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
26 - vendor/laravel/framework/src/Illuminate/Cookie/Middleware/AddQueuedCookiesToResponse.php:36
27 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
28 - vendor/laravel/framework/src/Illuminate/Cookie/Middleware/EncryptCookies.php:74
29 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
30 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:137
31 - vendor/laravel/framework/src/Illuminate/Routing/Router.php:821
32 - vendor/laravel/framework/src/Illuminate/Routing/Router.php:800
33 - vendor/laravel/framework/src/Illuminate/Routing/Router.php:764
34 - vendor/laravel/framework/src/Illuminate/Routing/Router.php:753
35 - vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php:200
36 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:180
37 - vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php:21
38 - vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/ConvertEmptyStringsToNull.php:31
39 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
40 - vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php:21
41 - vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TrimStrings.php:51
42 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
43 - vendor/laravel/framework/src/Illuminate/Http/Middleware/ValidatePostSize.php:27
44 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
45 - vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/PreventRequestsDuringMaintenance.php:109
46 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
47 - vendor/laravel/framework/src/Illuminate/Http/Middleware/HandleCors.php:61
48 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
49 - vendor/laravel/framework/src/Illuminate/Http/Middleware/TrustProxies.php:58
50 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
51 - vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/InvokeDeferredCallbacks.php:22
52 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
53 - vendor/laravel/framework/src/Illuminate/Http/Middleware/ValidatePathEncoding.php:26
54 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
55 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:137
56 - vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php:175
57 - vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php:144
58 - vendor/laravel/framework/src/Illuminate/Foundation/Application.php:1220
59 - public/index.php:20

## Request

POST /login

## Headers

* **host**: localhost:8080
* **user-agent**: Mozilla/5.0 (X11; Linux x86_64; rv:147.0) Gecko/20100101 Firefox/147.0
* **accept**: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8
* **accept-language**: en-US,en;q=0.9
* **accept-encoding**: gzip, deflate, br, zstd
* **content-type**: application/x-www-form-urlencoded
* **content-length**: 89
* **origin**: http://localhost:8080
* **connection**: keep-alive
* **referer**: http://localhost:8080/login
* **cookie**: phpMyAdmin=238cf35686183cc6e599322268ca933a; pma_lang=en; XSRF-TOKEN=eyJpdiI6IkVPYmljWXZWYXJVTE80aDhvaWpFTFE9PSIsInZhbHVlIjoibXQ4dVNBZzRTSE9sR1BSVitDWWhsSFRsYmVJdS94M2o0cnVSZEUydC9wYTBsbEp4dWN2dVYreXA0TjRsTFRQdzg4cjh6bjJWVmV4QUhtNXNlRU1DVmxQc0tzN0VVV3J0ZVI3L0QrUWtrb1JYZFhydWViWUJKbEJLNXZjMktkU2IiLCJtYWMiOiJkMTYzMGRiMTQ2ZTIyYTljYjcyNmY0ZGUyNGYzNGY4MTQyNTMwZDMyZWEwZWE2ZWVmMDQyN2IwNWI2NmM2ZmVmIiwidGFnIjoiIn0%3D; laravel-session=eyJpdiI6IjdIL0crYTBjK1JYb2p5MHJyVG5pdHc9PSIsInZhbHVlIjoibW80K1ZzRU5seGE5cEgxV3FVbG84dkt5cFN3OHgxQnJGcy9ibEJmdHk3RTQ3a3B0c0tQcFJsMENjWW5JY1FXZnpOckNiR1RTcndTcXBZb1AralV0MjZPdGI2L2NqRW5jWCtES1ZqQW1ONTBYNkEvaFY4eEVmTzRUbnQ0ZDQvL3EiLCJtYWMiOiJhNDJhMTIyYzM5MTJmNjA4YTJlZGRiNjhhNzIyNTZhMjI0ZGNmMDliOWExMDcyMjlkZjJmMDM2NDUzYTFjMzgzIiwidGFnIjoiIn0%3D
* **upgrade-insecure-requests**: 1
* **sec-fetch-dest**: document
* **sec-fetch-mode**: navigate
* **sec-fetch-site**: same-origin
* **sec-fetch-user**: ?1
* **priority**: u=0, i

## Route Context

controller: App\Http\Controllers\AuthController@login
route name: login.attempt
middleware: web, guest

## Route Parameters

No route parameter data available.

## Database Queries

* mysql - select * from `sessions` where `id` = 'pNrQeZ00WZP9rnLZRLX9W7yVG9UxtnsWY53zTrX1' limit 1 (12.12 ms)
* mysql - select * from `users` where `email` = 'admin@gmail.com' limit 1 (1.22 ms)
