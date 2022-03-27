<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json/');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

require_once '../../vendor/autoload.php';
require_once '../../config/Database.php';
require_once '../../models/Produit.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$db = (new Database())->getConnection();
$produit = new Produit($db);

if (isset($_POST['codeBarres']))
	// $data = [
	// 	'codeBarres' => $_POST['codeBarres'],
	// 	'marque' => $_POST['marque'],
	// 	'nom' => $_POST['nom'],
	// 	'contenu' => $_POST['contenu'] ?? null,
	// 	'imagePath' => $_POST['imagePath'] ?? null
	// ];
	$data = $_POST;
else
	$data = json_decode(file_get_contents("php://input"), true);

if (!$data['codeBarres'] || !$data['marque'] || !$data['nom'])
	die("Missing argument");

$produit->setAttributes($data);
echo json_encode(['rows inserted' => $produit->insert()]);
?>