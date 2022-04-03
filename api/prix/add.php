<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json/');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

require_once '../../config/Database.php';
require_once '../../models/Prix.php';

$db = (new Database())->getConnection();
$prix = new Prix($db);

if (isset($_POST['codeBarres']))
	$data = $_POST;
else
	$data = json_decode(file_get_contents("php://input"), true);

if (!$data['codeBarres'] || !$data['prix'] || !$data['datePrix'] || !$data['localisationId'])
	die('Missing argument');

$prix->setAttributes($data);
echo json_encode(['rows inserted' => $prix->insert()]);
?>