<?php

include __DIR__ . '/../../vendor/autoload.php';

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use G\AngularPostRequestServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Gzaas\Message;

$app = new Application(['debug' => true]);
$app->register(new AngularPostRequestServiceProvider());
$app->register(new DoctrineServiceProvider(), [
    'db.options' => [
        'driver' => 'pdo_sqlite',
        'path'   => __DIR__ . '/../../db/gzaas.sqlite',
    ],
]);

$app->get("/gzaas/{id}", function (Application $app, $id) {
    $gzaas = new Message($app['db'], $id);

    if (!$gzaas->exists()) {
        throw new NotFoundHttpException("Gzaas not found");
    }

    return $app->json([
        'status'  => true,
        'text'    => $gzaas->getText(),
        'font'    => $gzaas->getFont(),
        'texture' => $gzaas->getTexture()
    ]);
});

$app->post("/gzaas", function (Application $app, Request $request) {

    $gzaas = new Message($app['db']);

    $gzaas->setText($request->get('gzaas')['text']);
    $gzaas->setFont($request->get('gzaas')['font']);
    $gzaas->setTexture($request->get('gzaas')['texture']);

    $id = $gzaas->persists();

    return $app->json([
        'status' => true,
        'id'     => $id,
    ]);
});

$app->run();