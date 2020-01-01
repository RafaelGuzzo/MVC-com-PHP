<?php

namespace Alura\Cursos\Controller;

use Alura\Cursos\Entity\Curso;
use Alura\Cursos\Helper\FlashMessageTrait;
use Doctrine\ORM\EntityManagerInterface;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Persistencia implements RequestHandlerInterface {
	use FlashMessageTrait;

	private $entityManager;

	public function __construct(EntityManagerInterface $entityManager) {
		$this->entityManager = $entityManager;
	}

	public function handle(ServerRequestInterface $request): ResponseInterface{
		$descricao = $request->getParsedBody()['descricao'];

		$curso = new Curso();
		$curso->setDescricao($descricao);

		$id = isset($request->getQueryParams()['id']) ? $request->getQueryParams()['id'] : null;

		if (!is_null($id) && $id !== false) {
			$curso->setId($id);
			$this->entityManager->merge($curso);
			$this->defineMessage('success', 'Curso atualizado com sucesso');

		} else {
			$this->entityManager->persist($curso);
			$this->defineMessage('success', 'Curso inserido com sucesso');
		}

		$this->entityManager->flush();

		return new Response(302, ['Location' => '/listar-cursos']);
	}
}
