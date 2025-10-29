<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../database/Connection.php';
require_once __DIR__ . '/../../database/QueryBuilder.php';

// La tua logica di connessione al database va qui.
$pdo = Connection::make($config['database']);   
function sendJsonResponse(int $httpCode, array $responseData) {
    http_response_code($httpCode);
    echo json_encode($responseData);
    exit;
}

$id_viaggio = $idViaggio;
$nome_paese = $paese;

try {
    $pdo->beginTransaction();

    $sql = "DELETE FROM viaggi_paesi WHERE viaggio_id = :id_viaggio AND paese_id = (SELECT id_paese FROM paesi WHERE nome_paese = :nome_paese)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_viaggio', $id_viaggio, PDO::PARAM_INT);
    $stmt->bindParam(':nome_paese', $nome_paese, PDO::PARAM_STR);
    $stmt->execute();

    $pdo->commit();
    $response = ['success' => true, 'message' => 'Paese eliminato con successo.'];
    sendJsonResponse(200, $response); // OK
} catch (PDOException $e) {
    $pdo->rollBack();
    $response = ['success' => false, 'message' => 'Si è verificato un errore durante l\'eliminazione del paese.'];
    sendJsonResponse(500, $response); // Internal Server Error
}