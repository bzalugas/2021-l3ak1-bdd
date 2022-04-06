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
	$api = new OpenFoodFacts\Api('food', 'fr');
	$tmp = $api->getProduct($produit->codeBarres)->getData();
	if (empty($tmp))
	{
		$api = new OpenFoodFacts\Api('beauty', 'fr');
		$tmp = $api->getProduct($produit->codeBarres)->getData();
		echo json_encode($tmp);
	}
	$infos = [
		"marque" => $tmp['brands'],
		"nom" => $tmp['product_name_fr'],
		"contenu" => $tmp['quantity'] ?? "",
		"imagePath" => $tmp['image_url']
	];
	$produit->setAttributes($infos);
	$produit->insert();
	echo json_encode($produit->getAttributes());
}
	

?>