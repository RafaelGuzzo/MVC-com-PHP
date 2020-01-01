<?php
namespace Alura\Cursos\Controller;

use Alura\Cursos\Entity\Usuario;
use Alura\Cursos\Helper\FlashMessageTrait;
use Doctrine\ORM\EntityManagerInterface;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RealizarLogin implements RequestHandlerInterface {
	use FlashMessageTrait;

	private $repositorioDeUsuarios;

	public function __construct(EntityManagerInterface $entityManager) {
		$entityManager = $entityManager;
		$this->repositorioDeUsuarios = $entityManager->getRepository(Usuario::class);
	}

	public function handle(ServerRequestInterface $request): ResponseInterface{
		$email = $request->getParsedBody()['email'];

		if (is_null($email) || $email === false) {
			$this->defineMessage('danger', "O e-mail digitado não é um e-mail válido.");
			return new Response(200, ['Location' => '/login']);

		}

		$senha = $request->getParsedBody()['senha'];

		$usuario = $this->repositorioDeUsuarios->findOneBy(['email' => $email]);

		if (is_null($usuario) || !$usuario->senhaEstaCorreta($senha)) {
			$this->defineMessage('danger', "E-mail ou senha inválidos");
			return new Response(200, ['Location' => '/login']);
		}
		$_SESSION['logado'] = true;

		return new Response(200, ['Location' => '/listar-cursos']);
	}
}
?>