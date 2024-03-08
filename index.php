<?php

require __DIR__."/vendor/autoload.php";
use CoffeeCode\Router\Router;

session_start();
$router = new Router(BASE_URL);
// Controllers path
$router->namespace("Source\Controllers");

// Routes
// ** Web 
$router->group(null);
$router->get("/", "WebController:index");
// errors
$router->group("ops");
$router->get("/{code}", "WebController:error");

// ** Auth
$router->group(null);
$router->post("/ajax/login", "AuthController:login");
$router->get("/logout", "AuthController:logout");

// ** Post
$router->group("posts");
$router->get("/", "PostController:index");
$router->get("/{id}/{title}", "PostController:show");
$router->get("/ajax/{status}", "PostController:indexAjax"); 
$router->post("/ajax/store", "PostController:store");
$router->get("/ajax/edit/{id}", "PostController:edit"); 
$router->post("/ajax/edit/{id}", "PostController:update");
$router->delete("/ajax/delete/{id}/{status}", "PostController:delete");

// execute 
$router->dispatch();
if ($router->error()) {
	$router->redirect("/ops/{$router->error()}");
}