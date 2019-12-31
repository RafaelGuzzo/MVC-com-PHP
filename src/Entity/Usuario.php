<?php
namespace Alura\Cursos\Entity;
/**
 * @Entity
 * @Table(name="usuarios")
 */
class Usuario {
	/**
	 * @Column(type="string")
	 */
	private $email;

	/**
	 * @Id
	 * @GeneratedValue
	 * @Column(type="integer")
	 */
	private $id;

	/**
	 * @Column(type="string")
	 */
	private $senha;

	public function senhaEstaCorreta(string $senhaPura): bool {
		return password_verify($senhaPura, $this->senha);
	}
}
