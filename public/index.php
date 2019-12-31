<?php
session_start();

require __DIR__ . '/../vendor/autoload.php';

$caminho = $_SERVER['PATH_INFO'];

$rotas = require __DIR__ . '/../config/routes.php';

if (!array_key_exists($caminho, $rotas)) {
	http_response_code(404);
	exit();
}

$rotaDeLogin = stripos($caminho, 'login');
if (!isset($_SESSION['logado']) && $rotaDeLogin === false) {
	header('location: /login');
	exit();
}

$classeControladora = $rotas[$caminho];
$controlador = new $classeControladora();
$controlador->processaRequisicao();

?>