<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once '../../models/Produit.php';
require_once '../../models/Prix.php';
require_once '../../models/Localisation.php';
require_once '../../config/Database.php';

$db = (new Database())->getConnection();

$produit = new Produit($db);
$loc = new Localisation($db);
$prix = new Prix($db);

if (!isset($_GET['codeBarres']) || !isset($_GET['localisation_id']))
{
	http_response_code(404);
	die('Missing barcode or localisation_id');
}
	
$produit->codeBarres = $_GET['codeBarres'];
$loc->id = $_GET['localisation_id'];

$infos = $produit->find();
if ($infos == false)
{
	http_response_code(404);
	die('Unknown barcode');
}

$prix->codeBarres = $produit->codeBarres;
$allPrices = $prix->findAllPrixLoc();
// $res = [];
// foreach ($allPrices as $singlePrice)
// 	array_push($res, $singlePrice);
echo json_encode($allPrices);
?>