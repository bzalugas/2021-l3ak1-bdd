<?php

class Prix
{
	private $db = null;
	public $id;
	public $codeBarres;
	public $prix;
	public $datePrix;
	public $localisation_id;

	public function __construct($db)
	{
		$this->db = $db;
	}

	public function setAttributes($infos = [])
	{
		$this->id = $infos['id'] ?? null;
		$this->codeBarres = $infos['produit_codebarres'];
		$this->prix = $infos['prix'];
		$this->datePrix = $infos['dateprix'];
		$this->localisation_id = $infos['localisation_id'];
	}

	public function insert()
	{
		$sql = "INSERT INTO Prix VALUES (DEFAULT, :Produit_codeBarres, :prix, :datePrix, :localisation_id)";
		try{
			$res = $this->db->prepare($sql);
			$res->execute([
				'Produit_codeBarres' => $this->codeBarres,
				'prix' => $this->prix,
				'datePrix' => $this->datePrix,
				'localisation_id' => $this->localisation_id
			]);
			return $res->rowCount();
		} catch (Exception $e){
			die("Erreur dans Prix : " . $e->getMessage());
		}
	}

	public function find()
	{

	}

	public function getPrixProduit()
	{
		$sql = "SELECT * FROM Prix WHERE Produit_codeBarres = :codeBarres ORDER BY datePrix DESC";
		try{
			$statement = $this->db->prepare($sql);
			$statement->execute([
				'codeBarres' => $this->codeBarres
			]);
			$res = $statement->fetchAll(PDO::FETCH_ASSOC);
			return $res;
		} catch (Exception $e){
			die ('Erreur : ' . $e->getMessage());
		}
	}

	public function getPrixProduitLoc()
	{

	}
}
?>