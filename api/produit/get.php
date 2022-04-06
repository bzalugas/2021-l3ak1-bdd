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
	// http_response_code(404);
	$api = new OpenFoodFacts\Api('food', 'fr');
	$tmp = $api->getProduct($produit->codeBarres)->getData();
	$infos = [
		"codeBarres" => $tmp['_id'],
		"marque" => $tmp['brands'],
		"nom" => $tmp['product_name_fr'],
		"contenu" => " ",
		"imagePath" => $tmp['image_url']
	];
	$produit->setAttributes($infos);
	$produit->insert();
	echo json_encode($produit->getAttributes());
}
	

?>