<?php
error_reporting(E_ALL);

require __DIR__.'/vendor/autoload.php';

use CoffeeCode\Router\Router;

$router = new Router(API['root']);
$router->namespace("API\Controllers");

$router->group( null );
$router->get("/" , "Rest:home", "rest.home");
$router->get("/cadastrar" , "Rest:cadastrar", "rest.cadastrar");
$router->post("/inserir" , "Rest:cadastrarCidadao", "rest.cadastrarCidadao");
$router->post("/atualizar/{cpf}" , "Rest:atualizarCidadao", "rest.atualizarCidadao");
$router->delete("/excluir/{cpf}" , "Rest:excluirCidadao", "rest.excluirCidadao");
$router->get("/listar" , "Rest:listarCidadao", "rest.listarCidadao");
$router->get("/pesquisar/{cpf}" , "Rest:pesquisarCpf", "rest.pesquisarCpf");

$router->group('ops');
$router->get( "/{errcode}", "Rest:error", "rest.error");
$router->dispatch();

if($router->error()){
    $router->redirect( "rest.error", ["errcode" => $router->error()]);
}