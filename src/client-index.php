<?php

use FastRoute\RouteCollector;
use Windwalker\Edge\Cache\EdgeFileCache;
use Windwalker\Edge\Edge;
use Windwalker\Edge\Loader\EdgeFileLoader;

// Edge setup
$paths = array(__DIR__ . '/views');
$edge = new Edge(new EdgeFileLoader($paths), null, new EdgeFileCache(__DIR__ . '/cache'));

// Helpers
$edge->addGlobal('helpers', new \Maksuco\Helpers\Helpers());

// Route handler function
function handleRoutes($dispatcher) {
    $httpMethod = $_SERVER['REQUEST_METHOD'];
    $uri = $_SERVER['REQUEST_URI'];
    if (false !== $pos = strpos($uri, '?')) $uri = substr($uri, 0, $pos);
    $uri = rawurldecode($uri);

    $routeInfo = $dispatcher->dispatch($httpMethod, $uri);

    global $edge;

    switch ($routeInfo[0]) {
        case FastRoute\Dispatcher::NOT_FOUND:
            http_response_code(404);
            echo $edge->render('includes/error');
            break;

        case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
            http_response_code(405);
            echo 'Method Not Allowed';
            break;

        case FastRoute\Dispatcher::FOUND:
            $handler = $routeInfo[1];
            $vars = $routeInfo[2];

            // Handle closures directly
            if ($handler instanceof Closure) {
                $handler();
                break;
            }

            if ($handler === 'catchall') {
                $slug = $vars['slug'];
                $filename = 'views/'.$slug.'.blade.php';

                if(file_exists($filename)) {
                    echo $edge->render($slug, ['nav' => '']);
                } else {
                    $ch = curl_init('https://api.webcms.dev/56.789890hjkhjk/page/'.$slug);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $page = json_decode(curl_exec($ch));

                    if(isset($page->success)) {
                        http_response_code(404);
                        echo $edge->render('includes/error');
                    } else {
                        echo $edge->render('content', ['nav' => '', 'slug' => $slug, 'page' => $page]);
                    }
                }
                break;
            }

            // Handle template rendering
            if (is_array($handler)) {
                $data = array_merge($handler, $vars);
                $template = $data['template'];
                unset($data['template']);
                echo $edge->render($template, $data);
            }
            break;
    }
}