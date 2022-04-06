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
	$res = $api->getProduct(strval($produit->codeBarres))->getData();
	echo json_encode($res);
}
	

?>