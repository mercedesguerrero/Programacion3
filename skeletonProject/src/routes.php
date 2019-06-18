<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\ORM\cd;//para poder usar la clase cd

include_once __DIR__ . '/../src/app/modelORM/cd.php';
//include_once __DIR__ . '/../src/app/modelORM/cdControler.php';

return function (App $app) {
    $container = $app->getContainer();

	$app->get('/[{name}]', function (Request $request, Response $response, array $args) use ($container) {
        // Sample log message
        $container->get('logger')->info("Slim-Skeleton '/' route");
        $container->get('errorLogger')->info("Slim-Skeleton '/' route");

        // Render index view
        return $container->get('renderer')->render($response, 'index.phtml', $args);
    });
    $app->get('/error/', function (Request $request, Response $response, array $args) use ($container) {
        // Sample log message
        $container->get('logger')->info("Slim-Skeleton '/' route");
        $container->get('errorLogger')->info("Slim-Skeleton '/' route");

        // Render index view
        return $container->get('renderer')->render($response, 'index.phtml', $args);
    });
    $app->post('/error/', function (Request $request, Response $response, array $args) use ($container) {
        // Sample log message
        $container->get('logger')->info("Slim-Skeleton '/' route");
        $container->get('errorLogger')->info("Slim-Skeleton '/' route");

        // Render index view
        return $container->get('renderer')->render($response, 'index.phtml', $args);
    });
    $app->put('/error/', function (Request $request, Response $response, array $args) use ($container) {
        // Sample log message
        $container->get('logger')->info("Slim-Skeleton '/' route");
        $container->get('errorLogger')->info("Slim-Skeleton '/' route");

        // Render index view
        return $container->get('renderer')->render($response, 'index.phtml', $args);
    });
    $app->delete('/error/', function (Request $request, Response $response, array $args) use ($container) {
        // Sample log message
        $container->get('logger')->info("Slim-Skeleton '/' route");
        $container->get('errorLogger')->info("Slim-Skeleton '/' route");

        // Render index view
        return $container->get('renderer')->render($response, 'index.phtml', $args);
    });

    $app->group('/cdORM', function () {   
         
        $this->get('/', function ($request, $response, $args) {
          //return cd::all()->toJson();
          $todosLosCds=cd::all();
          $newResponse = $response->withJson($todosLosCds, 200);  
          return $newResponse;
        });
    });


     $app->group('/cdORM2', function () {   

        $this->get('/',cdApi::class . ':traerTodos');
   
    });

};
