<?php 


class Validacoes
{

	public static function exists ($value) 
	{
		if (isset($value) && !empty($value)) {
			return true;
		}

		return false;
	}

	public static function cpf ($cpf) 
	{
		return self::validaCPF($cpf);
	}

	public static function nome ($nome) 
	{
		if (strlen($nome) < 2) {
			return false;
		}

		return true;
	}

	public static function creci ($creci) 
	{
		if (strlen($creci) < 2) {
			return false;
		}

		return true;
	}

	public static function id ($id) 
	{
		$nNullo  = $id ? true : false;
		$numero  = is_numeric($id) ? true : false;
		$natural = self::isNatural($id) ? true : false;

		if ($nNullo && $numero && $natural) {
			return true;
		}

		return false;
	}

	public static function acao ($acao) 
	{
		$action = ['get','show','add','update','delete'];
		if (in_array($acao, $action)) {
			return true;
		}

		return false;
	}

	// função standardClass
	public static function toObject ($request, $acao) 
	{
		$corretor = new stdClass;
		$corretor->nome  = $request['nome'];
		$corretor->creci = $request['creci'];
		$corretor->cpf   = $request['cpf'];
		$corretor->ativo = "S";
		if (
			isset($request['id']) && 
			($request['id'] !== "") && 
			($acao == 'update' || $acao == 'show')
		) {
			$corretor->id = $request['id'];
		}
	
		return $corretor;
	}

	// função de retorno para o front-end
	public static function retorno ($booleano, $message) 
	{
		echo json_encode(['error' => $booleano, 'message' => $message]);
	}


	private static function validaCPF ($cpf) 
	{
 
	    // Extrai somente os números
	    $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
	     
	    // Verifica se foi informado todos os digitos corretamente
	    if (strlen($cpf) != 11) {
	        return false;
	    }

	    // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
	    if (preg_match('/(\d)\1{10}/', $cpf)) {
	        return false;
	    }

	    // Faz o calculo para validar o CPF
	    for ($t = 9; $t < 11; $t++) {
	        for ($d = 0, $c = 0; $c < $t; $c++) {
	            $d += $cpf[$c] * (($t + 1) - $c);
	        }
	        $d = ((10 * $d) % 11) % 10;
	        if ($cpf[$c] != $d) {
	            return false;
	        }
	    }
	    return true;

	}

	private static function isNatural ($n)
	{
		if (!is_numeric($n)) {
			return false;
		}

		$parteInteira = (int) $n;

		if (($parteInteira - $n) != 0) {
			return false;
		}

		return true;

	}

}