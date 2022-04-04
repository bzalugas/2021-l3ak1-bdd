<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once '../../models/Produit.php';
require_once '../../config/Database.php';

$db = (new Database())->getConnection();
$produit = new Produit($db);

if (!isset($_GET['codeBarres']))
	die('Missing barcode');
$produit->codeBarres = $_GET['codeBarres'];
$res = $produit->find();
if ($res != false)
	echo json_encode($res);

?>