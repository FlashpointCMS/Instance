<?php

require_once __DIR__ . '/../vendor/autoload.php';

(new Laravel\Lumen\Bootstrap\LoadEnvironmentVariables(
    dirname(__DIR__)
))->bootstrap();

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| Here we will load the environment and create the application instance
| that serves as the central piece of this framework. We'll use this
| application as an "IoC" container and router for this framework.
|
*/

$app = new Laravel\Lumen\Application(
    dirname(__DIR__)
);

/**
 * We need use the new auth package, and fix it to work with Lumen.
 * For the moment, we are using a 3rd party package to deal with oauth.
 * In order to do this, we need to enable facades
 */
$app->withFacades();

/*
|--------------------------------------------------------------------------
| Register Container Bindings
|--------------------------------------------------------------------------
|
| Now we will register a few bindings in the service container. We will
| register the exception handler and the console kernel. You may add
| your own bindings here if you like or you can make another file.
|
*/

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    Flashpoint\Oxidiser\Exceptions\LumenHandler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    Flashpoint\Oxidiser\Console\LumenKernel::class
);


/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
|
| Here we will register all of the application's service providers which
| are used to bind services into the container. Service providers are
| totally optional, so you are not required to uncomment this line.
|
*/

$app->register(Flashpoint\Oxidiser\Providers\ConfigServiceProvider::class);
$app->register(Flashpoint\Oxidiser\Providers\DatabaseServiceProvider::class);
$app->register(Flashpoint\Oxidiser\Providers\RouteServiceProvider::class);
$app->register(Flashpoint\Oxidiser\Providers\AuthServiceProvider::class);
$app->register(Flashpoint\Oxidiser\Providers\AppServiceProvider::class);

return $app;
