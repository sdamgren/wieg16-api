<?php
/**
 * Created by PhpStorm.
 * User: sandradamgren
 * Date: 2017-11-17
 * Time: 11:17
 */

$host = 'localhost';
$db = 'customer';
$user = 'root';
$password = 'root';
$charset = 'utf8';
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false];

$pdo = new PDO($dsn, $user, $password, $options);

$id = $_GET ['customer_id'];

$sql = "SELECT * FROM `customers` WHERE id = $id";
$customers_stmt = $pdo->prepare($sql);
$customers_stmt->execute();
$customer = $customers_stmt->fetch(PDO::FETCH_ASSOC); //fetchAll



header("Content-Type: application/json");
if ($customer != null) {
    $sql = "SELECT * FROM address WHERE customer_id = " . $customer['id'];
    $address_stmt = $pdo->prepare($sql);
    $address_stmt->execute();
    $address = $address_stmt->fetch(PDO::FETCH_ASSOC);
    if ($address != null) {
        $customer['address'] = $address;
    }
    echo json_encode($customer);
}

    else {

    echo json_encode(["message" => "Customer not found"]);
}

header("HTTP/1.0 404 Not Found");
