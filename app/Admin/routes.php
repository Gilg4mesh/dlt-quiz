<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    $router->resource('users', UserController::class);
    $router->resource('tags', TagController::class);
    $router->get('/questions/create','QuestionController@create');
    $router->resource('questions', QuestionController::class);
    $router->post('tag_question/modify', 'TagQuestionController@modify');
    $router->resource('tag_question', TagQuestionController::class);
    $router->resource('textbooks', TextbookController::class);
    $router->resource('tests', TestController::class);

});
