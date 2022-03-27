<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once '../../vendor/autoload.php';
require_once '../../models/Produit.php';
require_once '../../config/Database.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$db = (new Database())->getConnection();
$produit = new Produit($db);

if (!isset($_GET['codeBarres']))
	die('Missing barcode');
$produit->codeBarres = $_GET['codeBarres'];
echo json_encode($produit->find());

?>