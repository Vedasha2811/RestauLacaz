<?php
header('Content-Type: application/json');
error_reporting(0); // Hide warnings to keep JSON clean

require 'vendor/autoload.php';
use Opis\JsonSchema\Validator;

$conn = new PDO("mysql:host=localhost;dbname=restaulakaz_database", "root", "");

$jsonInput = file_get_contents('php://input');
$dataObject = json_decode($jsonInput);

$schemaFile = __DIR__ . '/schemas/JSONSchema_Review.json';
$schemaData = file_get_contents($schemaFile);

$validator = new Validator();
$result = $validator->validate($dataObject, $schemaData);

if ($result->isValid()) {
    // SUCCESS: Insert into DB
    $stmt = $conn->prepare("INSERT INTO reviews (title, comment, rating, name, date) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([
        $dataObject->title,
        $dataObject->comment,
        (int)$dataObject->rating,
        $dataObject->name,
        date("Y-m-d")
    ]);
    echo json_encode(["status" => "success", "message" => "Review validated and saved!"]);
} else {
    // FAILURE
    $error = $result->error();
    echo json_encode(["status" => "error", "message" => "Schema Error: " . $error->keyword()]);
}
?>