<?php

class Prix
{
	private $db = null;
	public $id;
	public $codeBarres;
	public $prix;
	public $datePrix;
	public $localisationId;

	public function __construct($db)
	{
		$this->db = $db;
	}

	public function setAttributes($infos = [])
	{
		$this->id = $infos['id'] ?? null;
		$this->codeBarres = $infos['codeBarres'];
		$this->prix = $infos['prix'];
		$this->datePrix = $infos['datePrix'];
		$this->localisationId = $infos['localisationId'];
	}

	public function insert()
	{
		$sql = "INSERT INTO Prix VALUES (NULL, :Produit_codeBarres, :prix, :datePrix, :localisationId)";
		try{
			$res = $this->db->prepare($sql);
			$res->execute([
				'Produit_codeBarres' => $this->codeBarres,
				'prix' => $this->prix,
				'datePrix' => $this->datePrix,
				'localisationId' => $this->localisationId
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