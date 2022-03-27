<?php

class Produit
{
	private $db = null;
	public $codeBarres;
	public $marque;
	public $nom;
	public $contenu;
	public $imagePath;

	public function __construct($db)
	{
		$this->db = $db;
	}

	public function setAttributes($infos = [])
	{
		$this->codeBarres = $infos['codeBarres'];
		$this->marque = $infos['marque'];
		$this->nom = $infos['nom'];
		$this->contenu = $infos['contenu'] ?? null;
		$this->imagePath = $infos['imagePath'] ?? null;
	}

	public function insert()
	{
		$sql = "INSERT INTO Produit VALUES (:codeBarres, :marque, :nom, :contenu, :imagePath)";
		try{
			$res = $this->db->prepare($sql);
			$res->execute([
				'codeBarres' => $this->codeBarres,
				'marque' => $this->marque,
				'nom' => $this->nom,
				'contenu' => $this->contenu ?? null,
				'imagePath' => $this->imagePath ?? null
			]);
			return $res->rowCount();
		} catch (Exception $e){
			die ('Erreur : ' . $e->getMessage());
		}
	}

	public function findAll()
	{
		$sql = "SELECT * FROM Produit";
		try{
			$statement = $this->db->prepare($sql);
			$statement->execute();
			$res = $statement->fetchAll(PDO::FETCH_ASSOC);
			return $res;
		} catch(Exception $e) {
			die ('Erreur : ' . $e->getMessage());
		}
	}

	public function find()
	{
		$sql = "SELECT * FROM Produit WHERE codeBarres = :codeBarres";
		try{
			$statement = $this->db->prepare($sql);
			$statement->execute([
				'codeBarres' => $this->codeBarres
			]);
			$res = $statement->fetch(PDO::FETCH_ASSOC);
			$this->codeBarres = $res['codeBarres'];
			$this->marque = $res['marque'];
			$this->nom = $res['nom'];
			$this->contenu = $res['contenu'];
			$this->imagePath = $res['imagePath'];
			return $res;
		} catch (Exception $e){
			die ('Erreur : ' . $e->getMessage());
		}
	}

	public function update(Array $infos)
	{
		$sql = "UPDATE Produit
				SET marque = :marque, nom = :nom, contenu = :contenu, imagePath = :imagePath
				WHERE codeBarres = :codeBarres";
		try{
			$res = $this->db->prepare($sql);
			$res->execute([
				'codeBarres' => $this->codeBarres,
				'marque' => $infos['marque'],
				'nom' => $infos['nom'],
				'contenu' => $infos['contenu'] ?? null,
				'imagePath' => $infos['imagePath'] ?? null
			]);
			return $res->rowCount();
		} catch (Exception $e){
			die ('Erreur : ' . $e->getMessage());
		}
	}

	public function delete()
	{
		$sql = "DELETE FROM Produit WHERE codeBarres = :codeBarres";
		try {
			$res = $this->db->prepare($sql);
			$res->execute([
				'codeBarres' => $this->codeBarres
			]);
			return $res->rowCount();
		} catch (Exception $e){
			die ('Erreur : ' . $e->getMessage());
		}
	}

	public function getAllPrix()
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
}

?>