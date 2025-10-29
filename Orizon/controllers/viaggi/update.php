<?php
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../database/Connection.php';
require_once __DIR__ . '/../../database/QueryBuilder.php';

// 1. Imposta l'header per la risposta JSON PRIMA DI QUALSIASI OUTPUT (inclusi errori!)
header('Content-Type: application/json');

function sendJsonResponse(int $httpCode, array $responseData) {
    http_response_code($httpCode);
    echo json_encode($responseData);
    exit;
}

$raw_json_input = file_get_contents('php://input');
$data = json_decode($raw_json_input, true);

// 2. Controllo del metodo HTTP (Opzionale ma Raccomandato per un vero endpoint REST)
if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
    $response = ['success' => false, 'message' => 'Metodo non consentito. Questo endpoint accetta solo richieste DELETE.'];
    sendJsonResponse(405, $response); // Method Not Allowed
}

$numeroPostiDisisponibili = $data['numero_posti_disponibili'];
$id_viaggio = $data['id_viaggio'];

try {

    $pdo = Connection::make($config['database']);

    // Inizia la transazione
    $pdo->beginTransaction();

    $sql = "UPDATE viaggi SET numero_posti_disponibili = :numero_posti_disponibili WHERE id_viaggio = :id_viaggio";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_viaggio', $id_viaggio, PDO::PARAM_INT);
    $stmt->bindParam(':numero_posti_disponibili', $numeroPostiDisisponibili, PDO::PARAM_INT);
    $stmt->execute();

    // Conferma la transazione
    $pdo->commit();

    $response = ['success' => true, 'message' => 'Numero posti disponibili aggiornato con successo.'];
    sendJsonResponse(200, $response); // OK

} catch (PDOException $e) {
    $response = ['success' => false, 'message' => 'Errore database: ' . $e->getMessage()];
    sendJsonResponse(500, $response); // Internal Server Error
}
