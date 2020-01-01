<?php
use Alura\Cursos\Infra\EntityManagerCreator;
use Doctrine\ORM\EntityManagerInterface;

$containerBuilder = new \DI\ContainerBuilder();

$containerBuilder->addDefinitions([
	EntityManagerInterface::class => function () {
		return (new EntityManagerCreator())->getEntityManager();
	},
]);

return $containerBuilder->build();

?>