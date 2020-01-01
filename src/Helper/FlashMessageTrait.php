<?php
namespace Alura\Cursos\Helper;

trait FlashMessageTrait {
	public function defineMessage(string $tipo, string $message): void{
		$_SESSION['tipo_mensagem'] = $tipo;
		$_SESSION['mensagem'] = $message;
	}
}

?>