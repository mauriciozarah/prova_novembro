<?php 

// Aplicado o Design Pattern "Singleton" - Garantindo uma conexão única com o banco de dados
// Motivo: Não criar de uma conexão a cada acesso ao banco de dados

class Connection
{
	private static $instance;
	public static $cn;
	private static $stmt;
	private $resultSet;

	private function __construct () {
		self::$cn = new PDO("mysql:host=". DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS) or print(mysql_error());
	}

	public static function getInstance () 
	{
		if (!isset(self::$instance)) {
			self::$instance = new Connection();
		}

		return self::$instance;
	}

	public function prepare ($sql) 
	{
		self::$stmt = self::$cn->prepare($sql);
	}

	public function execute($vet) 
	{
		self::$stmt->execute($vet);
	}

	public function fetchAll () {
		return self::$stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function fetch () {
		return self::$stmt->fetch(PDO::FETCH_ASSOC);
	}
}