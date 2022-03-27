<?php

class Database
{
	private $dbConn = null;

	public function __construct()
	{
		$host = $_ENV['DB_HOST'];
		$port = $_ENV['DB_PORT'];
		$db = $_ENV['DB_DATABASE'];
		$user = $_ENV['DB_USERNAME'];
		$pass = $_ENV['DB_PASSWORD'];

		try
		{
			$this->dbConn = new PDO(
				"mysql:host=$host;port=$port;charset=utf8;dbname=$db",
				$user,
				$pass,
				[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION],
			);
		}
		catch (Exception $e)
		{
			die('Error in' . __CLASS__ . ' : '.$e->getMessage());
		}
	}

	public function getConnection()
	{
		return $this->dbConn;
	}

}

?>