<?php 

class CorretorModel
{
	public $cpf;
	public $creci;
	public $nome;
	public $ativo;

	private static Connection $cn;

	public static function setConnection (Connection $cn) 
	{
		self::$cn = $cn;
	}

	public static function get ()
	{
		try {
			$sql = "SELECT * FROM corretores WHERE ativo = :ativo ORDER BY id DESC";
			self::$cn->prepare($sql);
			self::$cn->execute([':ativo' => 'S']);
			return self::$cn->fetchAll();
		} catch(Exception $e) {
			return $e->getMessage();
		}
	}

	public static function show ($id)
	{
		try {
			$sql = "SELECT * FROM corretores WHERE id = :id";
			self::$cn->prepare($sql);
			self::$cn->execute([':id' => $id]);
			return self::$cn->fetch();
		} catch (Exception $e) {
			return $e->getMessage();
		}

	}

	public static function add ($values)
	{
		try {
			$sql = "INSERT INTO corretores SET nome = :nome, cpf = :cpf, creci = :creci, ativo = :ativo";
			self::$cn->prepare($sql);
			self::$cn->execute([
				':nome' => $values->nome,
				':cpf'  => $values->cpf,
				'creci' => $values->creci,
				'ativo' => $values->ativo
			]);
			return true;
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}

	public static function update ($values)
	{
		try {
			$sql = "UPDATE corretores SET nome = :nome, cpf = :cpf, creci = :creci, ativo = :ativo WHERE id = :id";
			self::$cn->prepare($sql);
			self::$cn->execute([
				':nome'  => $values->nome,
				':cpf'   => $values->cpf,
				':creci' => $values->creci,
				'ativo'  => $values->ativo,
				':id'    => $values->id
			]);

			return true;
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}

	public static function delete ($id)  
	{
		try {
			$sql = "UPDATE corretores SET ativo = 'N' WHERE id = :id";
			self::$cn->prepare($sql);
			self::$cn->execute([':id' => $id]);
			return true;
		} catch (Exception $e) {
			return $e->getMessage();
		}

	}

	protected static function cpfReadyExists ($cpf)
	{
		try {
			
			$sql = "SELECT id, cpf, nome FROM corretores WHERE cpf = :cpf AND ativo = 'S'";
			self::$cn->prepare($sql);
			self::$cn->execute([':cpf' => $cpf]);
			$res = self::$cn->fetchAll();

			if (count($res) > 0 && is_array($res) && !is_null($res) && !empty($res)) {
			 	return true;
			}

			return false;

		} catch (Exception $e) {
			return $e->getMessage();
		}
	}

}