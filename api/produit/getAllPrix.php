<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once '../../vendor/autoload.php';
require_once '../../models/Produit.php';
require_once '../../models/Prix.php';
require_once '../../config/Database.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$db = (new Database())->getConnection();
$produit = new Produit($db);

if (!isset($_GET['codeBarres']))
	die('Missing barcode');
$produit->codeBarres = $_GET['codeBarres'];
$res = [
	'Produit' => $produit->find(),
];

// $prix = $produit->getAllPrix();
$prix = new Prix($db);
$prix->codeBarres = $produit->codeBarres;
$allPrices = $prix->getPrixProduit();
foreach ($allPrices as $singlePrice)
	array_push($res, $singlePrice);
echo json_encode($res);
?>