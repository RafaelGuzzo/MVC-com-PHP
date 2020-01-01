<?php

namespace Alura\Cursos\Controller;
use Alura\Cursos\Entity\Curso;
use Alura\Cursos\Helper\FlashMessageTrait;
use Doctrine\ORM\EntityManagerInterface;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Exclusao implements RequestHandlerInterface {
	use FlashMessageTrait;

	private $entityManager;

	public function __construct(EntityManagerInterface $entityManager) {
		$this->entityManager = $entityManager;
	}

	public function handle(ServerRequestInterface $request): ResponseInterface{
		$id = $request->getQueryParams()['id'];

		if (is_null($id) || $id === false) {
			return new Response(200, ['Location' => '/listar-cursos']);
		}

		$curso = $this->entityManager->getReference(
			Curso::class,
			$id
		);
		$this->entityManager->remove($curso);
		$this->entityManager->flush();
		$this->defineMessage('success', 'Curso excluído com sucesso');

		return new Response(200, ['Location' => '/listar-cursos']);
	}
}
