<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once '../../models/Produit.php';
require_once '../../config/Database.php';
require_once '../../vendor/autoload.php';

$db = (new Database())->getConnection();
$produit = new Produit($db);

if (!isset($_GET['codeBarres']))
	die('Missing barcode');
$produit->codeBarres = $_GET['codeBarres'];
$res = $produit->find();
if ($res != false)
	echo json_encode($res);
else
{
	$apiFood = new OpenFoodFacts\Api('food', 'fr');
	$apiBeauty = new OpenFoodFacts\Api('beauty', 'fr');
	$apiPet = new OpenFoodFacts\Api('pet', 'fr');
	try
	{
		$tmp = $apiFood->getProduct($produit->codeBarres)->getData();
	}
	catch(OpenFoodFacts\Exception\ProductNotFoundException)
	{
		try
		{
			$tmp = $apiBeauty->getProduct($produit->codeBarres)->getData();
		}
		catch(OpenFoodFacts\Exception\ProductNotFoundException)
		{
			try
			{
				$tmp = $apiPet->getProduct($produit->codeBarres)->getData();
			}
			catch(OpenFoodFacts\Exception\ProductNotFoundException)
			{
				http_response_code(404);
				die("Product not found");
			}
		}
	}
	
	$infos = [
		"marque" => $tmp['brands'] ?? "Unknown brand",
		"nom" => $tmp['product_name_fr'] ?? $tmp['product_name'],
		"contenu" => $tmp['quantity'] ?? "",
		"imagePath" => $tmp['image_url']
	];
	$produit->setAttributes($infos);
	$produit->insert();
	echo json_encode($produit->getAttributes());
}
	

?>