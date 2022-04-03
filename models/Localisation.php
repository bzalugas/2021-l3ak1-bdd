<?php

class Localisation
{
	private $db = null;
	public $id;
	//latitude
	public $lat;
	//longitude
	public $long;
	public $nom;

	public function __construct($db)
	{
		$this->db = $db;
	}

	public function setAttributes($infos = [])
	{
		$this->id = $infos['id'] ?? null;
		$this->lat = $infos['lat'];
		$this->long = $infos['long'];
		$this->nom = $infos['nom'];
	}

	public function insert()
	{
		$sql = "INSERT INTO Localisation VALUES (DEFAULT, :lat, :long, :nom)";
		try {
			$res = $this->db->prepare($sql);
			$res->execute([
				'lat' => $this->lat,
				'long' => $this->long,
				'nom' => $this->nom
			]);
			return $res->rowCount();
		} catch (Exception $e) {
			die ("Error in " . __CLASS__ . ' : ' . $e->getMessage());
		}
	}
}
?>