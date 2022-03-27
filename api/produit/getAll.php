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

echo json_encode($produit->findAll());
?>